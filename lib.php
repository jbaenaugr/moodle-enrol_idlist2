<?php
/*
 *  Copyright (C) 2013 Javier Martinez Baena
 *                     Antonio Garrido Carrillo
 *
 *  This file is part of enrol/idlist2.
 *   
 *  enrol/idlist2 is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  enrol/idlist2 is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

/**
 * IDList2 enrolments plugin
 * 
 * @package    enrol
 * @subpackage idlist2
 * @copyright  2013 Javier Martinez Baena, Antonio Garrido Carrillo
 * @author     Javier Martinez Baena, Antonio Garrido Carrillo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This is to prevent execution of php from direct URL request
// Should be in every php file
defined('MOODLE_INTERNAL') || die();

require_once ($CFG->dirroot.'/group/lib.php');
require_once ($CFG->dirroot.'/enrol/idlist2/locallib.php');
//require_once (dirname (__FILE__) . '/lib.php');

require_once($CFG->dirroot.'/user/lib.php');
require_once($CFG->dirroot.'/user/profile/lib.php');

/**
 * enrolment_plugin_idlist allows user enrolments to be checked against an
 * allowed id list given by the course manager.
 */
class enrol_idlist2_plugin  extends enrol_plugin
{
  var $errormsg;

  // To show the plugin in dropdown list of enrollment plugins and add as a enrol method to course
  public function get_newinstance_link($courseid) {
    global $DB;

    $context = get_context_instance(CONTEXT_COURSE, $courseid, MUST_EXIST);

    if (!has_capability('moodle/course:enrolconfig', $context) or !has_capability('enrol/idlist2:config', $context)) {
      return NULL;
    }

    // Se permite sólo una instancia por curso
    if ($DB->record_exists('enrol', array('courseid'=>$courseid, 'enrol'=>'idlist2'))) {
      return NULL;
    }

    return new moodle_url('/enrol/idlist2/edit.php', array('courseid'=>$courseid));
  }


  // Next 3 methods: allow_unenrol, allow_manage, get_user_enrolment_actions
  // When listing enrolled users show icons to edit or unenrol a student (by the teacher)
  // Capabilities needed: unenrol and manage
  public function allow_unenrol(stdClass $instance) {
    // Users with unenrol cap may unenrol other users manually manually.
    return true;
  }
  /*public function allow_manage(stdClass $instance) {
    // Users with manage cap may tweak period and status.
    return true;
  }*/
  public function get_user_enrolment_actions(course_enrolment_manager $manager, $ue) {
    $actions = array();
    $context = $manager->get_context();
    $instance = $ue->enrolmentinstance;
    $params = $manager->get_moodlepage()->url->params();
    $params['ue'] = $ue->id;
    if ($this->allow_unenrol($instance) && has_capability("enrol/idlist2:unenrol", $context)) {
      $url = new moodle_url('/enrol/unenroluser.php', $params);
      $actions[] = new user_enrolment_action(new pix_icon('t/delete', ''), get_string('unenrol', 'enrol'), $url, array('class'=>'unenrollink', 'rel'=>$ue->id));
    }
    if ($this->allow_manage($instance) && has_capability("enrol/idlist2:manage", $context)) {
      $url = new moodle_url('/enrol/idlist2/editenrolment.php', $params);
      $actions[] = new user_enrolment_action(new pix_icon('t/edit', ''), get_string('edit'), $url, array('class'=>'editenrollink', 'rel'=>$ue->id));
    }
    return $actions;
  }

  // Listing enrol plugins instances for a course: show edit icon
  public function get_action_icons(stdClass $instance) {
    global $OUTPUT;

    if ($instance->enrol !== 'idlist2') {
      throw new coding_exception('invalid enrol instance!');
    }
    $context = context_course::instance($instance->courseid);

    $icons = array();

    if (has_capability('enrol/idlist2:config', $context)) {
      $editlink = new moodle_url("/enrol/idlist2/edit.php", array('courseid'=>$instance->courseid, 'id'=>$instance->id));
      $icons[] = $OUTPUT->action_icon($editlink, new pix_icon('i/edit', get_string('edit'), 'core', array('class'=>'icon')));
    }

    return $icons;
  }

  // Executed when a student try to enter a course and it is not enrolled
  public function try_autoenrol(stdClass $instance) {
    global $CFG, $USER, $SESSION   /*, $THEME*/;

    // Get the value of the user field to check
    $valorusu = enrol_idlist2_userid($instance->customchar1,$USER);

    // Get list of authorized values
    $listaids = enrol_idlist2_authlist($instance->customchar2,$instance->customtext1);

    // Check if student is authorized
    $result = enrol_idlist2_authorized($valorusu,$listaids,$instance->customchar2,$instance->customint1);

    if ($result !== false) {
      if (isguestuser()) { // only real user guest, do not use this for users with guest role
        $USER->enrolkey[$instance->courseid] = true;
        add_to_log($instance->courseid, 'course', 'guest', 'view.php?id='.$instance->courseid, getremoteaddr());
      } else {
        $context = context_course::instance($instance->courseid, MUST_EXIST);
        $studentroles = array_keys(get_archetype_roles('student'));
        // Para usar logs hay que crear tablas
        //add_to_log($instance->courseid, 'course', 'enrol', '/enrol/users.php?id='.$instance->courseid, $USER->id);
        //add_to_log(SITEID, "user", "enrol", '/enrol/users.php?id='.$instance->courseid, $USER->id);
        //add_to_log(SITEID, "user", "logout", "view.php?id=$USER->id&course=".SITEID, $USER->id, 0, $USER->id);
        $this->enrol_user($instance, $USER->id, $studentroles[0]);
      }
      return 1;
    } else {
      $this->errormsg = $result;
    }
    return false;
  }

  // ¿useful?
  public function get_instance_defaults() {
    $expirynotify = $this->get_config('expirynotify');
    if ($expirynotify == 2) {
      $expirynotify = 1;
      $notifyall = 1;
    } else {
      $notifyall = 0;
    }

    $fields = array();
    $fields['status']       = $this->get_config('status');
    $fields['name']         = $this->get_config('name');
    $fields['customchar1']  = $this->get_config('customchar1');
    $fields['customchar2']  = $this->get_config('customchar2');
    $fields['customint1']   = $this->get_config('customint1');
    $fields['customtext1']  = $this->get_config('customtext1');

    return $fields;
  }

/*
  function cron()
  {
  }
*/
} /// end of class

?>
