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
 * Form for editing Contact Form Block.
 *
 * @package   block_contact_form
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Form for editing Contact Form Block
 *
 * @package   block_contact_form
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_contact_form_edit_form extends block_edit_form {
    /**
     * Add field definition
     *
     * @param object $mform
     * @throws coding_exception
     */
    protected function specific_definition($mform) {
        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('configtitle', 'block_contact_form'));
        $mform->setType('config_title', PARAM_TEXT);
        $mform->setDefault('config_title', get_string('title', 'block_contact_form'));

        $mform->addElement('text', 'config_intro', get_string('configintro', 'block_contact_form'));
        $mform->setType('config_intro', PARAM_TEXT);
        $mform->setDefault('config_intro', get_string('intro', 'block_contact_form'));

        $mform->addElement('advcheckbox', 'config_mustlogin', get_string('configmustlogin', 'block_contact_form'));
        $mform->setType('config_mustlogin', PARAM_BOOL);
        $mform->setDefault('config_mustlogin', 0);
    }
}
