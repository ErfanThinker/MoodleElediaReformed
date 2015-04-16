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
 *
 *
 * @package block
 * @category eledia_multikeys
 * @copyright 2013 eLeDia GmbH {@link http://www.eledia.de}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_eledia_multikeys extends block_base {

    public function init() {
        $this->title   = get_string('title', 'block_eledia_multikeys');
        $this->version = 20101118;// Format yyyymmddvv.
    }

    public function applicable_formats() {
        return array('site' => true, 'my' => true);
    }

    /**
     * Global Config?
     *
     * @return boolean
     **/
    public function has_config() {
        return false;
    }

    /**
     * More than one instance per page?
     *
     * @return boolean
     **/
    public function instance_allow_multiple() {
        return false;
    }

    public function get_content() {
        global $CFG;
        global $DB;
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content =  new object();
        $this->content->text = '';
        $this->content->footer = '';
        $sql = " SELECT `code` FROM `mdl_block_eledia_multikeys` WHERE `user` IS NULL ORDER BY `code` " ;
        $rows = $DB->get_records_sql($sql);

        if (has_capability('block/eledia_multikeys:view', context_block::instance($this->instance->id))) {
            $this->content->text .= '<ul>';
            $this->content->text .= '<li>';
            $this->content->text .= '<a href="'.$CFG->wwwroot.'/blocks/eledia_multikeys/generate_keys.php?instance='.
                    $this->instance->id.'" >';
            $this->content->text .= get_string('generate_keys', 'block_eledia_multikeys');
            $this->content->text .= '</a>';
            $this->content->text .= '</li>';
            $this->content->text .= '</ul>';

            $this->content->text .= '<ul>';
            $this->content->text .= '<li>';

            $this->content->text .= 'Existing Keys';

            $this->content->text .= '</li>';
            $this->content->text .= '</ul>';

            $this->content->text .= '<ul>';
            $this->content->text .="<table border='1'>";
            foreach($rows as $row){

                $this->content->text .='<tr><td>';
                
                $this->content->text .= $row -> code ;
                $this->content->text .='</td></tr>';
            }
            $this->content->text .="</table></br>";
            $this->content->text .= '</ul>';
        }
        return $this->content;
    }
}
