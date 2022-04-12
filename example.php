<?php
require_once('vendor/autoload.php');

// Simple example :)

$encode = \JheID\Encode\JSON::getInstance();

\JheID\NIK::getInstance()->Parse([
    "3215102103xxxxxx",
    "3215101608xxxxxx",
    "3204110609xxxxxx"
], function($response) use($encode) {
    $encode->Build($response, function($data) {
        echo !is_array($response) ? $data : [];
    });
});




