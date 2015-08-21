<?php
namespace Helpers;

class Numbwordter {

    private $discrete = array('1' => 'one', '2' => 'two', '3' => "three", '4' => "four", '5' => "five", '6' => 'six', '7' => 'seven',
        '8' => 'eight', '9' => 'nine', '10' => 'ten', '11' => 'eleven', "12" => 'twelve', '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen', '18' => 'eighteen', '19' => 'nineteen', '-' => 'minus');
    private $tenDigitPrefix = array('2' => 'twenty', '3' => 'thirty', '4' => 'forty', '5' => 'fifty', '6' => 'sixty',
        '7' => 'seventy', '8' => 'eighty', '9' => 'ninty');
    private $mool_array = array('', "thousand,", "million,", "billion,", "trillion,", "quadrillion,", "quintillion,", "sextillion,",
        "septillion,", "octillion,", "nonillion,", "decillion,", "unidecillion,", "duodecillion,", "tredecillion,", "quattuordecillion,");
    private $sentence; //final sentence
    private $error; //error if generated
    public $number; //number to change

    //methods

    private function twoDigits(&$num) {
        //displays from 1 to 99
        $num = (int) $num;
        if (((int) $num) == '0')
            return;
        if ($num < 20)
            return $this->discrete[$num];
        else
            return $this->tenDigitPrefix[substr($num, 0, 1)] . ' ' . $this->discrete[substr($num, 1, 1)];
        return $this->tenDigitPrefix[substr($num, 0, 1)] . ' ' . $this->discrete[substr($num, 1, 1)];
    }

    //displays three digit numbers
    private function threeDigits(&$num) {
        return
                ((int) substr($num, 0, 1) ? $this->discrete[substr($num, 0, 1)] . ' hundred ' : '') .
                ((int) substr($num, 1, 2) ? ' and ' . $this->twoDigits(substr($num, 1, 2)) : '');
    }

    private function decider(&$num) {
        if (strlen($num) <= 2)
            return $this->twoDigits($num);
        else
            return $this->threeDigits($num);
    }

    private function validate() {
        $this->number = preg_replace('/[\$,]/', '', $this->number); //remove commas if any
        //check if numeric
        if (!is_numeric($this->number)) {
            $this->error = "Not a number";
            return $this->error;
        }
        //return if more than 48 digits
        if (strlen($this->number) > 48) {
            $this->error = "Number out of bounds";
            return $this->error;
        }

        //check if minus value
        if (substr($this->number, 0, 1) == "-") {
            $this->sentence.='minus ';
            $this->num = substr($this->num, 1, strlen($this->num) - 1);
        }
        $this->num = (int) $this->num;
    }

    public static function convert($num = false) {
        if ($num)
            $this->number = $num;
        $this->validate();

        if (strlen($this->number) <= 3) {
            $this->sentence.=$this->decider($this->number);
        } else {
            //prepare an array with three digits in each element
            $k = strrev($num);
            for ($i = 0; $i < strlen($k); $i = $i + 3) {
                $arro[] = (int) strrev(substr($k, $i, 3));
            }
            //reverse again
            $arro = array_reverse($arro);
            //print_r($arro);
            $mool = ceil(strlen($num) / 3);
            if ((strlen(num) % 3) == 0) {
                $mool--;
            }
            $this->sentence.=$this->decider($arro[0]) . ' ' . $this->mool_array[$mool];
            $mool--;
            //leave the first one and prepare string of others
            $arrlen = count($arro);
            for ($i = 1; $i < $arrlen; $i++) {
                $this->sentence.=' ' . $this->decider($arro[$i]);
                if ($mool != 0) {
                    $this->sentence = ' ' . $this->sentence . ' ' . $this->mool_array[$mool];
                }
                $mool--;
            }
        }
        return ucfirst(trim($this->sentence));
    }

}

?>