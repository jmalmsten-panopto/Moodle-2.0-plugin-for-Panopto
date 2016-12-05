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
 * the provision course class for panopto
 *
 * @package block_panopto
 * @copyright Panopto 2009 - 2016 /With contributions from Spenser Jones (sjones@ambrose.edu),
 * Skylar Kelty <S.Kelty@kent.ac.uk>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Text input that trims any extra whitespace. Also supports maxlength
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class admin_setting_configtext_trimmed extends admin_setting_configtext_with_maxlength {

    /** @var int maximum number of chars allowed. */
    protected $maxlength;

    /**
     * Config text constructor
     *
     * @param string $name unique ascii name, either 'mysetting' for settings that in config,
     *                     or 'myplugin/mysetting' for ones in config_plugins.
     * @param string $visiblename localised
     * @param string $description long localised info
     * @param string $defaultsetting
     * @param mixed $paramtype int means PARAM_XXX type, string is a allowed format in regex
     * @param int $size default field size
     * @param mixed $maxlength int maxlength allowed, 0 for infinite.
     */
    public function __construct($name, $visiblename, $description, $defaultsetting, $paramtype=PARAM_RAW,
                                $size=null, $maxlength = 0) {
        $this->maxlength = $maxlength;
        parent::__construct($name, $visiblename, $description, $defaultsetting, $paramtype, $size, $maxlength);
    }

    /**
     * write data to storage
     * @param string data
     */
    public function write_setting($data) {
        if ($this->paramtype === PARAM_INT and $data === '') {
        // do not complain if '' used instead of 0
            $data = 0;
        }
        // $data is a string
        $trimmeddata = trim($data);
        $validated = $this->validate($trimmeddata);
        if ($validated !== true) {
            return $validated;
        }
        return ($this->config_write($this->name, $trimmeddata) ? '' : get_string('errorsetting', 'admin'));
    }
}