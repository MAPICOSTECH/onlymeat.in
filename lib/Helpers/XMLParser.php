<?php
namespace Helpers;

/**
 * Description of Helpers_XMLParser
 *
 * @author Krishna Srikanth
 */
class XMLParser {

    protected $xmlFile;
    protected $xmlData;

    public function __construct($file = false) {
        if ($file)
            $this->xmlFile = $file;
    }

    public function parse() {
        if (!$this->xmlFile) {
            $this->error = 'No file specified';
            return;
        }
        $fp = fopen($this->xmlFile, 'r');
        $this->xmlData = fread($fp, filesize($this->xmlFile));
        fclose($fp);
        $this->data = $this->parseAsSimpleXMLElement();
    }

    public function parseAsSimpleXMLElement() {
        $this->data = new \SimpleXMLElement($this->xmlData);
    }

    public static function parseXMLString($xmlString) {

        if (!is_string($xmlString))
            return new \stdClass ();
        else
            return new \SimpleXMLElement($xmlString);
    }

    public static function parseFile($fileName) {
        if (file_exists($fileName)) {
            $fp = fopen($fileName, 'r');
            $xmlData = fread($fp, filesize($fileName));
            fclose($fp);
            return new \SimpleXMLElement($xmlData);
        }
    }

    public static function array2XML($data, $rootNodeName = 'root', $xml = null) {

        // turn off compatibility mode as simple xml throws a wobbly if you don't.
        if (ini_get('zend.ze1_compatibility_mode') == 1) {
            ini_set('zend.ze1_compatibility_mode', 0);
        }

        if ($xml == null) {
            $xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
        }

        // loop through the data passed in.
        foreach ($data as $key => $value) {
            // no numeric keys in our xml please!
            if (is_numeric($key)) {
                // make string key...
                $key = "unknownNode_" . (string) $key;
            }

            // replace anything not alpha numeric
            $key = preg_replace('/[^a-z_0-9]/i', '', $key);

            // if there is another array found recrusively call this function
            if (is_array($value)) {
                $node = $xml->addChild($key);
                // recrusive call.
                self::array2XML($value, $rootNodeName, $node);
            } else {
                // add single node.
                $value = htmlentities($value);
                $xml->addChild($key, $value);
            }
        }
        // pass back as string. or simple xml object if you want!
        return $xml->asXML();
    }

}
