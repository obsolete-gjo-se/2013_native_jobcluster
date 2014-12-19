<?php

namespace helper;

class date
{
    const BEGIN_UNIX_EPOCHE = 1902;
    const END_UNIX_EPOCHE = 2037;

    private $date;
    private $startRange;
    private $endRange;
    private $day;
    private $month;
    private $year;
    private $separator;

    public function __construct($date, $startRange, $endRange)
    {
        $this->setDate($date);
        $this->setStartRange($startRange);
        $this->setEndRange($endRange);
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setStartRange($startRange)
    {
        $this->startRange = $startRange;
    }

    public function setEndRange($endRange)
    {
        $this->endRange = $endRange;
    }

    public function checkFormat()
    {
        $this->separator = '';

        if (preg_match('/^(\d{2})\.(\d{2})\.(\d{4})$/', $this->date)) {
            $this->setSeparator('.');
        }
        if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $this->date)) {
            $this->setSeparator('/');
        }
        if ($this->separator != '') {
            $this->explodeDate();
            if (is_numeric($this->month) && is_numeric($this->day) && is_numeric($this->year)) {
                if (checkdate($this->month, $this->day, $this->year)) {
                    return true;
                }
            }
        }
        return false;
    }

    private function setSeparator($sep)
    {
        $this->separator = $sep;
    }

    private function explodeDate()
    {
        list($this->day, $this->month, $this->year) = explode($this->separator, $this->date);
    }

    public function checkDateRange()
    {

        if (self::BEGIN_UNIX_EPOCHE <= $this->year and $this->year <= self::END_UNIX_EPOCHE) {

            $oldestDate = new \DateTime(date('Y-m-d', strtotime($this->startRange .'year')));
            $youngestDate = new \DateTime(date('Y-m-d', strtotime($this->endRange . 'year')));
            $customDate = new \DateTime(date('Y-m-d', strtotime($this->year.'-'.$this->month.'-'.$this->day)));

            if ($oldestDate < $customDate and $customDate < $youngestDate) {
                return true;
            }
        }
        return false;
    }

    public function getDateIn($format)
    {
        $dateString = $this->month . '-' . $this->day . '-' . $this->year;
        $dateTime = \DateTime::createFromFormat('m-d-Y', $dateString);
        return $dateTime->format($format);
    }
}
