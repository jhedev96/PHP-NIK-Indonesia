<?php
namespace JheID\NIK;

use JheID\NIK;
use JheID\Encode\JSON;

final class API
{
    
    private static $_instance; // singleton instance

    private function __construct() {} // disallow creating a new object of the class with new API()

    private function __clone() {} // disallow cloning the class

    /**
      * Get the singleton instance
      *
      * @return API
    */
    public static function getInstance()
    {
        if (static::$_instance === NULL) {
            static::$_instance = new API();
        }

        return static::$_instance;
    }

    public static function Execute ($nik, $format = 'json')
    {
        $_GET = array_map('trim', $_GET);
        $_GET = array_map('htmlspecialchars', $_GET);
        $_GET = array_map('strip_tags', $_GET);
        $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

        $response = NIK::getInstance()->Parse($nik);

        $format = strtolower($format);

        if (isset($format) && $format == 'json') {

            $result = JSON::Build($response);

        } else if (empty($format)) {

            $result = JSON::Build($response);

        } else {
            header($_SERVER['SERVER_PROTOCOL'] . 'Method Not Allowed 405', true, 405);

            $result = JSON::Build(['Method Not Allowed 405']);
        }

        return $result;
    }
    
}


