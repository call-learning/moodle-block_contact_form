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
 * Form for editing Contact Form block instances.
 *
 *
 * @package   block_contact_form
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use block_contact_form\form\contactform;

/**
 * Class block_contact_form
 *
 * @package   block_contact_form
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_contact_form extends block_base {

    /**
     * Init
     *
     * @throws coding_exception
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_contact_form');
    }

    /**
     * Has config
     *
     * @return bool
     */
    public function has_config() {
        return true;
    }

    /**
     * Default return is false - header will be shown
     *
     * @return boolean
     */
    public function hide_header() {
        return true;
    }

    /**
     * Get applicable formats
     *
     * @return array|bool[]
     */
    public function applicable_formats() {
        return array('all' => true);
    }

    /**
     * Update the block title from config values
     */
    public function specialization() {
        if (!empty($this->config->title)) {
            $this->title = $this->config->title;
        }
    }

    /**
     * Get the form and submission
     *
     * @return stdClass|null
     * @throws coding_exception
     */
    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }
        $filteropt = new stdClass;
        $filteropt->overflowdiv = true;
        $this->content = new stdClass;
        $this->content->footer = '';
        $form = new contactform(qualified_me());
        // If we require user to be logged in.
        if (!empty(get_config('block_contact_form', 'config_mustlogin'))) {
            // Log them in and then redirect them back to the form.
            if (!isloggedin()) {
                // Set message that session has timed out.
                require_login();
            }
            // Still guess user ?
            if (isguestuser()) {
                $this->content->text = get_string('mustbeloggedin', 'block_contact_form');
                return $this->content;
            }
        }
        if ($data = $form->get_data()) {
            $this->content->text = $this->process_form($data);
        } else {
            $intro = !empty($this->config->intro) ? $this->config->intro : '';
            $this->content->text = \html_writer::start_div('container');
            $this->content->text .= \html_writer::span($intro, 'intro m-y-2');
            $this->content->text .= $form->render();
            $this->content->text .= \html_writer::end_div('container');
        }

        return $this->content;
    }

    /**
     * Contact form
     *
     * @param stdClass $data
     * @return string
     * @throws coding_exception
     * @throws dml_exception
     * @throws moodle_exception
     * @throws require_login_exception
     */
    public function process_form($data) {
        $emailsender = new \block_contact_form\email_sender($data);
        $text = \html_writer::start_div('process-message-text');
        if ($emailsender->send_email()) {
            $text .= \html_writer::div(get_string('messagesuccess', 'block_contact_form'));
        } else {
            $text .= \html_writer::div(get_string('messagefailed', 'block_contact_form'));
        }
        $renderer = $this->page->get_renderer('core');
        $text .=
            \html_writer::div(
                $renderer->single_button(new moodle_url(qualified_me()), get_string('continue'), 'get')
                , 'm-5');
        $text .= \html_writer::end_div();
        return $text;
    }
}
