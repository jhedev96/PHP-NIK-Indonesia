<?php
require_once (__DIR__ . '/vendor/autoload.php');

error_reporting(0);

// https://api.jhe.id/v2/nik/3215102103920004.json

$app = new Silex\Application();

$app->get('/api@2.0/{nik}.{format}', function ($nik, $format) use ($app) {
    if (strlen($nik) !== 16) {
        $app->error(function (\Exception $e, $code) use ($app) {
            return $app->json([
                'message' => $e->getMessage()
            ], 404);
        });
        
    }

    return \JheID\NIK\API::getInstance()->Execute($nik, $format);
});

$app->get('/api@2.0/{nik}', function ($nik) use ($app) {
    if (strlen($nik) !== 16) {
        $app->error(function (\Exception $e, $code) use ($app) {
            return $app->json([
                'message' => $e->getMessage()
            ], 404);
        });
        
    }

    return \JheID\NIK\API::getInstance()->Execute($nik);
});

$app->run();