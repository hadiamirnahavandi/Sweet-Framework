<?php

namespace core\CoreClasses\html;
use core\CoreClasses\services\FieldInfo;
use core\CoreClasses\services\FieldType;
use core\CoreClasses\SweetDate;

/**
 *
 * @author nahavandi
 *        
 */
class DatePicker extends TextBox
{

    private $Hour,$Minute;

    /**
     * @param mixed $Hour
     */
    public function setHour($Hour)
    {
        $this->Hour = $Hour;
    }

    /**
     * @param mixed $Minute
     */
    public function setMinute($Minute)
    {
        $this->Minute = $Minute;
    }
    public function __construct($Name, $Text = null, $Visible = true, $ID = null, $Class = "datepicker", $ReadOnly = true)
    {
        parent::__construct($Name, $Text, $Visible, $ID, $Class, $ReadOnly);
        $this->Hour="11";
        $this->Minute="48";
    }

    public function getHTML()
    {
        $HTML = parent::getHTML();
        $HTML .= "<script language='javascript'>addToDatePickers('" . $this->getId() . "')</script>";
        return $HTML;
    }

    public function getTime()
    {
        return DatePicker::getTimeFromText($this->getValue(),$this->Hour,$this->Minute);
    }

    public function setTime($time)
    {
        date_default_timezone_set("Asia/Tehran");
        $sweetDate = new SweetDate(false, true, 'Asia/Tehran');
        $dt = $sweetDate->date("Y/m/d", $time);
        $this->setValue($dt);
    }

    public static function getTimeFromText($Date,$Hour="11",$Minute="48")
    {

        date_default_timezone_set("Asia/Tehran");
        $sweetDate = new SweetDate(true, true, 'Asia/Tehran');
//        $sweetDate = new SweetDate();
        $Date = trim($Date);
        $day = null;
        $year = null;
        $month = null;
        if (substr($Date, 4, 1) == "/" && substr($Date, 7, 1) == "/") {
            $year = substr($Date, 0, 4);
            $month = substr($Date, 5, 2);
            $day = substr($Date, 8, 2);
        }
        if ($day==null)
            $time=0;
        else
            $time = $sweetDate->mktime($Hour, $Minute, "0", $month, $day, $year);
        return $time;
    }
}

?>