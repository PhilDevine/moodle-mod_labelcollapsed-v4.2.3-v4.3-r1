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
 * Labelcollapsed module
 *
 * @package mod_labelcollapsed
 * @copyright  2011 Thomas Alsén
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__, 3) . '/config.php');

$id = optional_param('id', 0, PARAM_INT);    // Course Module ID, or.
$l = optional_param('l', 0, PARAM_INT);     // Labelcollapsed ID.

if ($id) {
    $PAGE->set_url('/mod/labelcollapsed/index.php', ['id' => $id]);
    if (! $cm = get_coursemodule_from_id('labelcollapsed', $id)) {
        new moodle_exception('invalidcoursemodule');
    }

    if (! $course = $DB->get_record("course", ["id" => $cm->course])) {
        new moodle_exception('coursemisconf');
    }

    if (! $labelcollapsed = $DB->get_record("labelcollapsed", ["id" => $cm->instance])) {
        new moodle_exception('invalidcoursemodule');
    }

} else {
    $PAGE->set_url('/mod/labelcollapsed/index.php', ['l' => $l]);
    if (! $labelcollapsed = $DB->get_record("labelcollapsed", ["id" => $l])) {
        new moodle_exception('invalidcoursemodule');
    }
    if (! $course = $DB->get_record("course", ["id" => $labelcollapsed->course]) ) {
        new moodle_exception('coursemisconf');
    }
    if (! $cm = get_coursemodule_from_instance("labelcollapsed", $labelcollapsed->id, $course->id)) {
        new moodle_exception('invalidcoursemodule');
    }
}

require_login($course, true, $cm);

redirect("$CFG->wwwroot/course/view.php?id=$course->id");