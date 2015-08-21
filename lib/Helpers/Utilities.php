<?php

namespace Helpers;

/**
 * General functions used
 *
 * @author Krishna Srikanth
 */
class Utilities {

    //opposite to nl2br() - taken from php.net/nl2br
    public static function br2nl($text) {
        $text = str_replace("<br />", "", $text);
        $text = str_replace("<br>", "", $text);
        return $text;
    }

    //________STRING ESCAPING FUNCTIONS
    public static function addSlashesInArray(&$arr) {
        if (is_array($arr)) { //if array is passed
            foreach ($arr as $col => $value) {
                $arr[$col] = addslashes($value);
            }
        }
    }

    //escape slashes and new lines
    public static function escapeString($text, $escapeHtml = true, $allowBasicFormatTags = false, $allowedTagsArray = null) {
        if (!is_string($text))
            return $text;

        $text = trim($text);

        if ($escapeHtml) {

            if (!is_array($allowedTagsArray))
                $allowedTagsArray = array();

            /* if asking to allow basic formating tags */
            if ($allowBasicFormatTags) {
                $customArray = array('<p>', '<span>', '<strong>', '<br>', '<br />', '<hr>', '<hr />', '<em>', '<a>',
                    '<u>', '<ul>', '<ol>', '<li>', '<table>', '<tr>', '<td>', '<tbody>',
                    '<caption>', '<h1>', '<h2>', '<h3>', '<h4>', '<h5>', '<h6>', '<blockquote>', '<pre>', '<address>', '<div>');
                $allowedTagsArray = array_merge($allowedTagsArray, $customArray);
            }


            /* if any tags are to be allowed */
            if (is_array($allowedTagsArray))
                $allowedTags = implode('', $allowedTagsArray);


            /* custom filters */
            if (strstr(strtolower($text), '"-->'))
                $text = stripos($text, '"-->');
            $text = str_replace("<p>
	&nbsp;</p>", '', $text); //text coming from ck editor if any. 

            /* strip tags */
            if ($allowedTags != '') {

                $text = addslashes(strip_tags($text, $allowedTags));
            } else
                $text = nl2br(htmlspecialchars($text, ENT_QUOTES));

            return $text;
        } else
            return addslashes(nl2br($text));
    }

    //_______STRING REPLACING FUNCTIONS
    //replace html tags and others from entities
    public static function stripSlashesInArray(&$arr) {
        if (is_array($arr)) { //if array is passed
            foreach ($arr as $col => $value) {
                $arr[$col] = stripslashes($value);
            }
        }
    }

    public static function replaceString($text, $replaceHtml = false, $preserveBreakTags = false) {
        if(!is_string($text))
            return '';

        if ($replaceHtml && $preserveBreakTags)
            return stripslashes(html_entity_decode($text, ENT_QUOTES));
        else if ($replaceHtml && !$preserveBreakTags)
            return stripslashes(self::br2nl(html_entity_decode($text, ENT_QUOTES)));
        else
            return stripslashes(self::br2nl($text));
    }

    //redirect to some page
    public static function redirect($page) {
        header('location:' . $page);
        exit; //just to be sure to stop further execution 
    }

    /*
     * function that outputs javascript to restore form values during postbacks
     */

    public static function restoreForm($formName) {

        echo '<script language="javascript" type="text/javascript">' . "\n";

        /*
         * If specific fields are asked
         */
        if (func_num_args() > 1) { //if specific fields are asked.
            for ($i = 1; $i < func_num_args(); $i++) {
                $valsToDisplay[func_get_arg($i)] = $_POST[func_get_arg($i)];
            }
        } else { //display all
            $valsToDisplay = $_POST;
        }

        foreach ($valsToDisplay as $field => $value) {
            //$value = $this::escapeString($value, true);
            //remove xss

            $value = strip_tags($value);
            $value = str_replace("\'", '"', $value);
            $value = str_replace('"', '\"', $value);
            $value = str_replace("\r\n", "\n", $value);
            $value = str_replace("\n", '\\n"+' . "\n" . '"', $value);



            $value = str_replace(array('";alert(', 'alert(', ')//', '"//', '//'), '', $value);

            //*/
            if ($field != 'PHPSESSID' and $value != '' and ! is_int($field))
                echo 'document.' . $formName . '.' . $field . '.value="' . self::escapeString($value) . '"' . ";\n";
        }
        echo '</script>';
    }

    public static function restoreFormFromArray($formName, $dataArray) {
        if (!is_array($dataArray) || count($dataArray) == 0)
            return;

        echo '<script language="javascript" type="text/javascript">' . "\n";

        foreach ($dataArray as $field => $value) {
            $value = self::replaceString($value, true, true);

            // $value =str_replace(array("\\r", "&#8217;", "%u2019", "%u00E9", "&#8220;", "&#8221;", "%u201C", "%u201D", "%u2013", "%u2026"), '', $value);
            $value = str_replace("\'", '"', $value);
            $value = str_replace('"', '\"', $value);
            $value = str_replace("\r\n", "\n", $value);
            $value = str_replace('�', '', $value);
            $value = str_replace("\n", '\\n"+' . "\n" . '"', $value);


            echo 'document.' . $formName . '.' . $field . '.value="' . $value . '"' . ";\n";
        }
        echo '</script>';
    }

    //extract one array into another array
    public static function extractInto($source, &$dest) {
        foreach ($source as $key => $val)
            $dest[$key] = $val;
    }

    public static function formatMemorySize($sizeInBytes) {
        if ($sizeInBytes < 1024) {
            return $sizeInBytes . " B";
        } else if ($sizeInBytes < (1024 * 1024)) {
            $sizeInBytes = round($sizeInBytes / 1024, 1);
            return $sizeInBytes . " KB";
        } else if ($sizeInBytes < (1024 * 1024 * 1024)) {
            $sizeInBytes = round($sizeInBytes / (1024 * 1024), 1);
            return $sizeInBytes . " MB";
        } else {
            $sizeInBytes = round($sizeInBytes / (1024 * 1024 * 1024), 1);
            return $sizeInBytes . " GB";
        }
    }

    public static function preview($data) {

        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public static function toString($content) {
        return (string) $content;
    }

    /*
     * Validation functions
     */

    public static function isEmail($emailID) {
        $valid = filter_var($emailID, FILTER_VALIDATE_EMAIL);
        return !empty($valid);
        //    return preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9._-]+)+$/", $email);
    }

    public static function isNull(&$value) {
        return is_null($value);
    }

    public static function isString($text, $onlyAlphabets = false) {
        if ($onlyAlphabets)
            return preg_match("/^([a-zA-Z ]+)+$/", $text);
        else
            return preg_match("/^([a-zA-Z0-9.,_;: -]+)+$/", $text);
    }

    public static function isNumber(&$number, $checkIntFloat = false) {
        if ($checkIntFloat)
            return is_numeric($number);
        else
            return (preg_match("^[0-9]+^", $number) && $number > 0);
    }

    public static function zendviewMessageError($message = null, $error = null, $displayAlert = true) {
        /*
         * Display alert box
         */
        if ($displayAlert) {
            if (!empty($message))
                echo \Helpers\HTMLUtilities::jsAlert('Message: ' . $message);
            if (!empty($error))
                echo \Helpers\HTMLUtilities::jsAlert('Error: ' . $error);
        }
        /*
         * Display normal text
         */
        if (!empty($message))
            echo '<p>' . \Helpers\HTMLUtilities::coloredText('Message: ' . $message, '#0F8796') . '</p>';
        if (!empty($error))
            echo '<p>' . \Helpers\HTMLUtilities::redText('Error: ' . $error) . '</p>';
    }

    public static function convertDateFormatPHPToJcal($date) {
        return date('d-M-Y', strtotime($date));
    }

    public static function convertDateFormatJcalToPHP($date) {
        return date('Y-m-d', strtotime($date));
    }

    public static function emailPreview($from, $to, $subject, $message) {

        return '<table width="100%" border="1">' .
                '<tr><td colspan="2">e-Mail Preview</td></tr>' .
                '<tr><td>From: </td><td>' . $from . '</td></tr>' .
                '<tr><td>To: </td><td>' . $to . '</td></tr>' .
                '<tr><td>Subject: </td><td>' . $subject . '</td></tr>' .
                '<tr><td valign="top">Message: </td><td>' . $message . '</td></tr>' .
                '</table>';
    }

    public static function generateGUID() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public static function strposArray($haystack, $needles) {
        if (is_array($needles)) {
            foreach ($needles as $str) {
                if (is_array($str)) {
                    $pos = strpos_array($haystack, $str);
                } else {
                    $pos = strpos($haystack, $str);
                }
                if ($pos !== FALSE) {
                    return $pos;
                }
            }
            return FALSE;
        } else {
            return strpos($haystack, $needles);
        }
    }
    
    
    //check login
    public static function preventDirectPageAccess($autoRedirect = true) {

        if (!defined('GEOMETRY_APP_INITIALIZED')) { //from scripts.php
            header('Location:' . GEOMETRY_BASE_URL . '/');
            exit;
        }
    }

}
