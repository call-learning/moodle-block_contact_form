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
use block_contact_form\form\contactform;

/**
 * Form for editing Contact Form block instances.
 *
 *
 * @package   block_contact_form
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_contact_form extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_contact_form');
    }

    public function has_config() {
        return true;
    }

    public function applicable_formats() {
        return array('all' => true);
    }

    public function specialization() {
        if (isset($this->config->title)) {
            $this->title = $this->title = format_string($this->config->title, true, ['context' => $this->context]);
        } else {
            $this->title = get_string('newcontactform', 'block_contact_form');
        }
    }

    public function instance_allow_multiple() {
        return true;
    }

    /**
     * Get the form and submission
     *
     * @return stdClass|null
     * @throws coding_exception
     */
    public function get_content() {
        global $FULLME;
        if ($this->content !== null) {
            return $this->content;
        }
        $filteropt = new stdClass;
        $filteropt->overflowdiv = true;
        $this->content = new stdClass;
        $this->content->footer = '';
        $form = new contactform(qualified_me());
        if ($data = $form->get_data()) {
            $this->content->text = $this->process_form($data);
        } else {
            $this->content->text = $form->render();
        }

        return $this->content;
    }

    /**
     * Contact form
     *
     * @param $data
     * @return string
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     * @throws require_login_exception
     */
    public function process_form($data) {
        $emailsender = new \block_contact_form\email_sender($data);
        if ($emailsender->send_email()) {
            return get_string('messagesuccess', 'block_contact_form');
        } else {
            return get_string('messagefailed', 'block_contact_form');
        }
    }
}
