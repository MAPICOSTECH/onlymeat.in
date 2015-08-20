<?php

namespace Helpers;

class EventsCalendar {

    public function __construct() {
    }

    public function addEvent($date, $title, $eventLink) {
        
    }

    public function clearEvents() {
        $this->_eventsList = array();
    }

    public function renderCalendar($year, $month, $eventsArray = null) {
        $calendar = new \Helpers\Calendar();

        /* get the dates in this month */
        $firstDateInMonth = $calendar->getFirstDateInMonth($month, $year);
        $lastDateInMonth = $calendar->getLastDateInMonth($month, $year);

        $datesArray = $calendar->getDatesInMonth($month, $year, 'weekwise');
        ?>

        <table width="100%" border="1" cellpadding="0" cellspacing="0" class="coloredTable">
            <tr>
                <th width="14%"><div align="center"><strong>Sunday</strong></div></th>
        <th width="15%"><div align="center"><strong>Monday</strong></div></th>
        <th width="15%"><div align="center"><strong>Tuesday</strong></div></th>
        <th width="14%"><div align="center"><strong>Wednesday</strong></div></th>
        <th width="14%"><div align="center"><strong>Thursday</strong></div></th>
        <th width="14%"><div align="center"><strong>Friday</strong></div></th>
        <th width="14%"><div align="center"><strong>Saturday</strong></div></th>
        </tr>
        <?php
        for ($i = 1; $i < count($datesArray); $i++) {
            echo '	<tr>';

            for ($j = 0; $j <= 6; $j++) {
                echo '<td valign="top">';
                if ($datesArray[$i][$j] != '') {
                    /* display the date */
                    echo '<div class="calendarDate">' . (int) substr($datesArray[$i][$j], strlen($datesArray[$i][$j]) - 2, 2) . '</div>';

                    /* display the notes */
                    echo '<div class="dateContent">';
                    //if(is_array($this->calendarNotes[$datesArray[$i][$j]]))
                    //{
                    for ($k = 0; $k < count($this->calendarNotes[$datesArray[$i][$j]]); $k++) {
                        echo '<div class="dateContentNotes">';
                        echo '<a href="' . $viewBaseUrl . '/User/Calendar/index/delete/' . $this->calendarNotes[$datesArray[$i][$j]][$k]['id'] . '"><span class="ui-icon ui-icon-close" style="float:right; display:inline-block; text-align:right; vertical-align:text-top"></span></a>';
                        echo substr($this->calendarNotes[$datesArray[$i][$j]][$k]['time'], 0, 5) . ' ';
                        echo $this->calendarNotes[$datesArray[$i][$j]][$k]['notes'];

                        echo '</div>';
                    }



                    //}

                    echo '</div>';
                } else
                    echo '&nbsp;';
                echo '</td>';
            }
            echo '	</tr>';
        }
        ?>

        </table>
        <?php
    }

    public function renderCalendarWithEvents() {
        
    }

}
