<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Settings for the Contact Form Block
 *
 * @package   block_contact_form
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    global $CFG;
    $settings->add(new admin_setting_configtext('block_contact_form/sendtoemail',
        get_string('sendtoemail', 'block_contact_form'),
        get_string('sendtoemail_desc', 'block_contact_form'),
        $CFG->supportemail));
    $settings->add(new admin_setting_configtext('block_contact_form/sendtoname',
        get_string('sendtoname', 'block_contact_form'),
        get_string('sendtoname_desc', 'block_contact_form'),
        $CFG->supportname));
}


