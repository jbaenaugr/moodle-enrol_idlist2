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
 * Capabilities for idlist2 enrolment plugin.
 *
 * @package    enrol
 * @subpackage idlist2
 * @copyright  2013 Javier Martinez Baena, Antonio Garrido Carrillo
 * @author     Javier Martinez Baena, Antonio Garrido Carrillo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// To be effective the changes made in this file, you must modify the version
// of the module (version.php) and go to "Administration->Notifications"
$capabilities = array(

    /* Add or edit enrol-idlist2 instance in course. */
    'enrol/idlist2:config' => array(

        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
        )
    ),

    /* Manage user self-enrolments. */
    /*'enrol/idlist2:manage' => array(

        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
        )
    ),*/

    /* Voluntarily unenrol self from course - watch out for data loss. */
    'enrol/idlist2:unenrolself' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'student' => CAP_ALLOW,
        )
    ),

    /* Unenrol anybody from course (including self) -  watch out for data loss. */
    'enrol/idlist2:unenrol' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
        )
    ),
/*  ???? para que en la lista de estudiantes de un curso se pueda eliminar el rol ?????
    'enrol/role:assign' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
        )
    ),
*/
);
