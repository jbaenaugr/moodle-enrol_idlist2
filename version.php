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
 * IDList2 enrolment plugin version specification.
 *
 * @package    enrol
 * @subpackage idlist2
 * @copyright  2013 Javier Martinez Baena
 * @author     Javier Martinez Baena
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2013011404;         // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2012112900;         // Requires this Moodle version
$plugin->component = 'enrol_idlist2';    // Full name of the plugin (used for diagnostics)
//$plugin->cron      = 60;
$plugin->release   = '0.1';
$plugin->maturity = MATURITY_ALPHA;
