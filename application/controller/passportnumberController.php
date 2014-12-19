<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Gregory
 * Date: 21.03.13
 * Time: 05:54
 * To change this template use File | Settings | File Templates.
 */

namespace controller;


class PassportnumberController
{
    const MIN_AGENCY_NUMBER = 1000;
    const MAX_AGENCY_NUMBER = 9999;
    const MIN_SERIAL_NUMBER = 10000;
    const MAX_SERIAL_NUMBER = 99999;
    const NATIONALITY = 'D';
    const OLDEST_AGE_DIFF_YEARS_TO_TODAY = -80;
    const YOUNGEST_AGE_DIFF_YEARS_TO_TODAY = -16;
    const MIN_YEARS_DIFF_TODAY_TO_EXPIRATION_DATE = 0;
    const MAX_YEARS_DIFF_TODAY_TO_EXPIRATION_DATE = 10;

    private $agencyNumber;
    private $serialNumber;
    private $nationality;
    private $birthday;
    private $birthdayForForm;
    private $birthdayOutput;
    private $expirationDate;
    private $expirationDateForForm;
    private $expirationDateOutput;
    private $error_msg;

    public function __construct()
    {
        $this->error_msg = '';
        $this->setAgencyNumber();
        $this->setSerialNumber();
        $this->setNationality();
        $this->setBirthday();
        $this->setExpirationDate();

    }

    public function setAgencyNumber()
    {
        if (isset($_POST['agencyNumber']) and $_POST['agencyNumber'] != '') {
            $this->agencyNumber = htmlentities($_POST['agencyNumber']);

            if (is_numeric($this->agencyNumber)) {
                $this->agencyNumber = (int)$this->agencyNumber;

                if ((self::MIN_AGENCY_NUMBER >= $this->agencyNumber) or ($this->agencyNumber >= self::MAX_AGENCY_NUMBER)) {
                    $this->error_msg .= 'Die Behördenkennzahl muss zwischen 1000 und 9999 liegen.' . '<br />';
                }
            } else {
                $this->error_msg .= 'Die Behördenkennzahl muss numerisch sein' . '<br />';
            }
        } else {
            $this->error_msg .= 'Die Behördenkennzahl ist ein Pflichtfeld' . '<br />';
        }
    }

    public function getAgencyNumber()
    {
        return $this->agencyNumber;
    }

    public function setSerialNumber()
    {
        if (is_null($this->serialNumber)){
            $this->serialNumber = rand(self::MIN_SERIAL_NUMBER, self::MAX_SERIAL_NUMBER);

            if(is_numeric($this->serialNumber)){

                if ((self::MIN_SERIAL_NUMBER >= $this->serialNumber) or ($this->serialNumber >= self::MAX_SERIAL_NUMBER)) {
                    $this->error_msg .= 'Es ist ein interner Fehler beim generieren der Seriennummer aufgetreten.';
                }
            }
        }
    }

    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    public function setNationality()
    {
        $this->nationality = self::NATIONALITY;
    }

    public function getNationality()
    {
        return $this->nationality;
    }

    public function setBirthday()
    {
        if (isset($_POST['birthday']) and $_POST['birthday'] != '') {
            $birthday = htmlentities($_POST['birthday']);
            $this->birthday = new \helper\date($birthday,
                self::OLDEST_AGE_DIFF_YEARS_TO_TODAY,
                self::YOUNGEST_AGE_DIFF_YEARS_TO_TODAY);

            if ($this->birthday->checkFormat()) {

                if ($this->birthday->checkDateRange()) {

                    $this->birthdayForForm = $this->birthday->getDateIn('d.m.Y');
                    $this->birthdayOutput = $this->birthday->getDateIn('ymd');

                } else {
                    $this->error_msg .= 'Das Alter muss zwischen ' . abs(self::YOUNGEST_AGE_DIFF_YEARS_TO_TODAY) .
                        ' und ' . abs(self::OLDEST_AGE_DIFF_YEARS_TO_TODAY) . ' Jahren liegen.' . '<br />';
                }
            } else {
                $this->error_msg .= 'Das Geburtsdatum muss gültig und im Format TT.MM.JJJJ oder TT/MM/JJJJ sein.' . '<br />';
            }
        } else {
            $this->error_msg .= 'Das Geburtsdatum ist ein Pflichtfeld.' . '<br />';
        }
    }

    public function getBirthdayForForm()
    {
        return $this->birthdayForForm;
    }

    public function getBirthdayOutput()
    {
        return $this->birthdayOutput;
    }

    public function setExpirationDate()
    {

        if (isset($_POST['expirationDate']) and $_POST['expirationDate'] != '') {
            $expirationDate = htmlentities($_POST['expirationDate']);
            $this->expirationDate = new \helper\date($expirationDate,
                self::MIN_YEARS_DIFF_TODAY_TO_EXPIRATION_DATE,
                self::MAX_YEARS_DIFF_TODAY_TO_EXPIRATION_DATE);

            if ($this->expirationDate->checkFormat()) {

                if ($this->expirationDate->checkDateRange()) {

                    $this->expirationDateForForm = $this->expirationDate->getDateIn('d.m.Y');
                    $this->expirationDateOutput = $this->expirationDate->getDateIn('ymd');

                } else {
                    $this->error_msg .= 'Das Ablaufdatum muss zwischen ' .
                        abs(self::MIN_YEARS_DIFF_TODAY_TO_EXPIRATION_DATE) .
                        ' und ' . abs(self::MAX_YEARS_DIFF_TODAY_TO_EXPIRATION_DATE) . ' Jahren liegen.' . '<br />';
                }
            } else {
                $this->error_msg .= 'Das Ablaufdatum muss gültig und im Format TT.MM.JJJJ oder TT/MM/JJJJ sein.' . '<br />';
            }
        } else {
            $this->error_msg .= 'Das Ablaufdatum ist ein Pflichtfeld.' . '<br />';
        }

    }

    public function getExpirationDateForForm()
    {
        return $this->expirationDateForForm;
    }

    public function getExpirationDateOutput()
    {
        return $this->expirationDateOutput;
    }


    public function getChecksum($value)
    {
        $multi = 7;
        $checkSum = 0;
        $idLength = strlen($value);

        for ($i = 0; $i < $idLength; $i++) {

            $sign = (integer)substr($value, $i, 1);
            $checkSum += ($sign * $multi);

            switch ($multi) {
                case 7:
                    $multi = 3;
                    break;
                case 3:
                    $multi = 1;
                    break;
                case 1:
                    $multi = 7;
                    break;
            }
        }
        return substr($checkSum, - 1);
    }

    public function getErrorMsg()
    {
        if ($this->error_msg != '') {
            return $this->error_msg;
        }else{
            return false;
        }
    }


}