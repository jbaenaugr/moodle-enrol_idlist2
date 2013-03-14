<?php
/*
 *  Copyright (C) 2013 Javier Martinez Baena
 *                     Antonio Garrido Carrillo
 *                     - University of Granada -
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
 * Adds new instance of enrol_idlist2 to specified course
 * or edits current instance.
 *
 * @package    enrol
 * @subpackage idlist2
 * @copyright  2013 Javier Martinez Baena, Antonio Garrido Carrillo
 * @author     Javier Martinez Baena, Antonio Garrido Carrillo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->dirroot.'/user/lib.php');
require_once($CFG->dirroot.'/user/profile/lib.php');

class enrol_idlist2_edit_form extends moodleform {

    function definition() {
        global $DB, $USER;

        $mform = $this->_form;

        list($instance, $plugin, $context) = $this->_customdata;

        $mform->addElement('header', 'header', get_string('pluginname', 'enrol_idlist2'));

        $mform->addElement('text', 'name', get_string('custominstancename', 'enrol'));
        $mform->setDefault('name',get_string('enrol_idlist2_authorized', 'enrol_idlist2'));
        $mform->addHelpButton('name', 'enrol_idlist2_authorized', 'enrol_idlist2');

        $campos = enrol_idlist2_get_fieldlist();
        $mform->addElement('select', 'customchar1', get_string('enrol_idlist2_campo', 'enrol_idlist2'), $campos);
        $mform->setDefault('customchar1',enrol_idlist2_preferred_field($campos));
        $mform->addHelpButton('customchar1', 'enrol_idlist2_campo', 'enrol_idlist2');

        $mform->addElement('text', 'customchar2', get_string('enrol_idlist2_regexp', 'enrol_idlist2'));
        $mform->setDefault('customchar2','[0-9][0-9][0-9][0-9]+');
        $mform->addHelpButton('customchar2', 'enrol_idlist2_regexp', 'enrol_idlist2');

        $mform->addElement('advcheckbox', 'customint1', get_string('enrol_idlist2_userregexp', 'enrol_idlist2'));
        $mform->addHelpButton('customint1', 'enrol_idlist2_userregexp', 'enrol_idlist2');
        $mform->setDefault('customint1',1);

        $mform->addElement('textarea', 'customtext1', get_string('enrol_idlist2_listadeid', 'enrol_idlist2'), array('cols'=>'60', 'rows'=>'20'));
        $mform->setDefault('customtext1','');
        $mform->addHelpButton('customtext1', 'enrol_idlist2_listadeid', 'enrol_idlist2');

        $mform->addElement('hidden', 'status', ENROL_INSTANCE_ENABLED);

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

        // If the plugin has values previously ...
        if (isset($instance->customchar1)) {
          // List of authorized ID's
          $listaids = enrol_idlist2_authlist($instance->customchar2,$instance->customtext1);

          // List of UNauthorized ID's (enrolled but not present in $listaids)
          $unautids = enrol_idlist2_unauthorized($context,$listaids,$instance->customchar1);

          // Convert $unautids to HTML table
          $tabla = enrol_idlist2_usertable($unautids,$instance->customchar1,$instance->courseid);

          //$matriculados = enrol_idlist2_unauthorized($context,$listaids);
          //$cadena = implode(" , &nbsp&nbsp&nbsp",$matriculados);
          $mform->addElement('static', 'infounauthorized', get_string('enrol_idlist2_unauthorized', 'enrol_idlist2'), $tabla);
          $mform->addHelpButton('infounauthorized', 'enrol_idlist2_unauthorized', 'enrol_idlist2');

          // Show authorized ID's (this is to assert that regular expression is working)
          $cadena = implode(" , &nbsp&nbsp&nbsp",$listaids);
          $mform->addElement('static', 'infoauth', get_string('enrol_idlist2_authlist', 'enrol_idlist2'), $cadena);
          $mform->addHelpButton('infoauth', 'enrol_idlist2_authlist', 'enrol_idlist2');
        }

        $this->add_action_buttons(true, ($instance->id ? null : get_string('addinstance', 'enrol')));

        $this->set_data($instance);
    }

    function validation($data, $files) {
        global $DB, $CFG;
        $errors = parent::validation($data, $files);

        list($instance, $plugin, $context) = $this->_customdata;

        if ($data['status'] == ENROL_INSTANCE_ENABLED) {
            if (!empty($data['enrolenddate']) and $data['enrolenddate'] < $data['enrolstartdate']) {
                $errors['enrolenddate'] = get_string('enrolenddaterror', 'enrol_self');
            }
        }

        return $errors;
    }

    /**
    * Gets a list of roles that this user can assign for the course as the default for self-enrolment.
    *
    * @param context $context the context.
    * @param integer $defaultrole the id of the role that is set as the default for self-enrolment
    * @return array index is the role id, value is the role name
    */
    function extend_assignable_roles($context, $defaultrole) {
        global $DB;

        $roles = get_assignable_roles($context, ROLENAME_BOTH);
        if (!isset($roles[$defaultrole])) {
            if ($role = $DB->get_record('role', array('id'=>$defaultrole))) {
                $roles[$defaultrole] = role_get_name($role, $context, ROLENAME_BOTH);
            }
        }
        return $roles;
    }
}
