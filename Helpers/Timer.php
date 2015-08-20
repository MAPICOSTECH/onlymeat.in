<?php

namespace Helpers;

class Timer {

    private $_times;

    public function clear() {
        $this->_times = null;
    }

    public function getMicrotime() {
        return strstr(microtime(), ' ');
    }

    public function mark($markerText = false) {
        if ($markerText)
            $this->_times[] = $markerText . ': ' . strstr(microtime(), ' ');
        else
            $this->_times[] = strstr(microtime(), ' ');
    }

    public function getStack() {
        $string = "Timings:\n";
        foreach ($this->_times as $timer) {
            $string.=$timer . "\n";
        }
        return $string;
    }

    public function printStack() {
        echo '<pre>';
        echo $this->getStack() . '</pre>';
    }

    public static function convertSecondsToHours($seconds) {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $init % 60;

        return "$hours:$minutes";
    }

    public static function convertHoursToSeconds($hours = 1, $minutes = 60, $seconds = 60) {
        return ($hours * 60 * 60) + ($minutes * 60) + $seconds;
    }

}
