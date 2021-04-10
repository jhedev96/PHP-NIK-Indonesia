<?php
require_once('vendor/autoload.php');

// Simple example :)

$encode = \JheID\Encode\JSON::getInstance();

\JheID\NIK::getInstance()->Parse([
    "3215102103920004",
    //"3215101608960004",
    //"3204110609970004"
], function($response) use($encode) {
    $encode->Build($response, function($data) {
        echo !is_array($response) ? $data : [];
    });
});




