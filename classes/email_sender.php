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
 * Email sender
 *
 * @package    block_contact_form
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_contact_form;
defined('MOODLE_INTERNAL') || die();

/**
 * Class email_sender
 *
 * Send a given message to the support user. For now the copy of the message is not
 * sent to the real user as we need to make sure this is not used to send unwanted messages through the site.
 *
 * @package    block_contact_form
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class email_sender {

    protected $supportuser;
    protected $fromemail;
    protected $fromname;
    protected $subject;
    protected $message;

    /**
     * email_sender constructor.
     *
     * @param $formdata
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function __construct($formdata) {
        global $CFG;
        $config = get_config('block_contact_form');
        $supportuser = \core_user::get_support_user();
        $supportuser->firstname = trim($CFG->supportname);
        $supportuser->email = trim($CFG->supportemail);
        if ($config->sendfromemail) {
            $supportuser->email = $config->sendfromemail;
        }
        if ($config->sendfromname) {
            $supportuser->firstname = $config->sendfromname;
        }
        $this->subject = clean_param($formdata->subject, PARAM_TEXT);
        $this->message = clean_param($formdata->message, PARAM_TEXT);
        $this->fromemail = clean_param($formdata->email, PARAM_EMAIL);
        $this->fromname = clean_param($formdata->name, PARAM_TEXT);
        $this->supportuser = $supportuser;

    }

    /**
     * Send the email with additional content for explanation
     *
     * @return bool
     * @throws \coding_exception
     */
    public function send_email() {
        global $CFG, $SITE;
        // A couple of tags in the message.
        $tags = array('[sendername]', '[senderemail]', '[supportname]', '[supportemail]',
            '[subject]', '[lang]', '[userip]', '[sitefullname]', '[siteshortname]', '[siteurl]',
            '[http_user_agent]', '[http_referer]'
        );
        $info = array($this->fromname,
            $this->fromemail,
            $this->supportuser->firstname,
            $this->supportuser->email,
            $this->subject,
            current_language(), getremoteaddr(), $SITE->fullname, $SITE->shortname, $CFG->wwwroot,
            $_SERVER['HTTP_USER_AGENT'], $_SERVER['HTTP_REFERER']
        );

        // Create the footer - Add some system information.
        $headermessage = get_string('emailcontentsupport', 'block_contact_form');
        $headermessage = format_text($headermessage, FORMAT_HTML, array('trusted' => true, 'noclean' => true, 'para' => false));
        $headermessage = str_replace($tags, $info, $headermessage);

        $fullmessage = $headermessage . '<br>' . $this->message;

        $subject = get_string('emailcontentsupportsubject', 'block_contact_form');
        $subject = str_replace($tags, $info, $subject);
        return email_to_user($this->supportuser, $this->supportuser,
            $subject,
            html_to_text($fullmessage),
            $fullmessage,
            '',
            '',
            true);
    }
}