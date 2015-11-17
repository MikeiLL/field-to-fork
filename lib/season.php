<?php

# based on http://stackoverflow.com/questions/33686093/between-late-month-and-early-month-without-regards-to-specific-year/33686411#33686411

current_time( 'timestamp' );

class Season {

    public $startMonth;
    public $startDay;
    public $endMonth;
    public $endDay;

    public function setStart($month, $day) {
        $this->startMonth = (int) $month;
        $this->startDay   = (int) $day;
    }

    public function setEnd($month, $day) {
        $this->endMonth = (int) $month;
        $this->endDay   = (int) $day;
    }

    function isActiveForDate(DateTime $date) {

        $seasonStartDate = new DateTime(sprintf('%d-%d-%d', $date->format('Y'), $this->startMonth, $this->startDay));
        $seasonEndDate   = new DateTime(sprintf('%d-%d-%d', $date->format('Y'), $this->endMonth, $this->endDay));

        // Edge case
        if ($this->startMonth > $this->endMonth) {
            $seasonStartDate->modify('-1 year');

            // This line is only useful if you wish to calculate inclusively
            if ($date == $seasonStartDate || $date == $seasonEndDate) return true;

            // If this condition is true, no need to calculate anything
            if ($date->format('n') < $this->startMonth && $date->format('n') >= $this->endMonth) {
                return false;
            }

            $seasonEndDate->modify('+1 year');
        }

        return ($date->getTimestamp() >= $seasonStartDate->getTimestamp() 
            && $date->getTimestamp() <= $seasonEndDate->getTimestamp());
    }
}