<?php
/*
 *  Copyright (C) 2013 Javier Martinez Baena
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
 *  ENGLISH UTF-8 translation strings for enrol_idlist2.
 *
 * @package    enrol
 * @subpackage idlist2
 * @copyright  2013 Javier Martinez Baena
 * @author     Javier Martinez Baena
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['enrol_idlist2_idattr'] = 'Student attribute to use as ID';
$string['enrol_idlist2_regexp'] = 'Regular expression to extract the ID from the file.';
$string['enrolment_id_error'] = 'You seem to not be a valid member of this course. Please contact your teacher in case you are a legitimate participant of this course.';


$string['pluginname'] = 'IDList2';
$string['pluginname_desc'] = 'With this enrollment method students are enrolled from an ID list.';

$string['enrol_idlist2_listadeid'] = 'Authorized users';
$string['enrol_idlist2_listadeid_help'] = 'Paste here the list of values to compare with.

Example: Copy/Paste the list of users that are allowed to access this course (id, name, ...)';
$string['enrol_idlist2_campo'] = 'Field';
$string['enrol_idlist2_campo_help'] = 'This is the name of the field used to validate user';
$string['enrol_idlist2_regexp'] = 'Regular expression';
$string['enrol_idlist2_regexp_help'] = 'Regular expression used to validate user.

Defaults to [0-9][0-9][0-9][0-9]+';
$string['enrol_idlist2_authorized'] = 'Authorized users';
$string['enrol_idlist2_authorized_help'] = 'This is the name of this instance of the enrollment plugin';

$string['enrol_idlist2_settinghead'] = 'IDList2 enrol plugin';
$string['enrol_idlist2_settinginfo'] = 'This enrollment plugin no needs global configuration';

$string['enrol_idlist2_authlist'] = 'List of authorized values';
$string['enrol_idlist2_authlist_help'] = 'This is the list of authorized values.
Is obtained by extracting the data from the previous field by applying the regular expression.';

$string['enrol_idlist2_unauthorized'] = 'List of unauthorized users';
$string['enrol_idlist2_unauthorized_help'] = 'This is the list of unauthorized users';

$string['enrol_idlist2_userregexp'] = 'Filter user field';
$string['enrol_idlist2_userregexp_help'] = 'Filter user field with regular expression';

$string['enrol_idlist2_userpicture'] = 'Picture';


?>
