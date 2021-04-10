<?php
namespace JheID;

use JheID\NIK\Data;

final class NIK
{

    private static $_instance; // singleton instance

    private function __construct() {} // disallow creating a new object of the class with new NIK()

    private function __clone() {} // disallow cloning the class

    /**
      * Get the singleton instance
      *
      * @return NIK
    */
    public static function getInstance()
    {
        if (static::$_instance === NULL) {
            static::$_instance = new NIK();
        }

        return static::$_instance;
    }

    public static function Parse ($nik, \Closure $callback = null)
    {
        $data = Data::Get();

        $response = [];
        $response["result"] = [];
        if (is_array($nik)) {
            for ($i = 0; $i <= count($nik) - 1; $i++) {
                if (strlen($nik[$i]) === 16) {
                    $year = substr(date('Y'), -2);
                    $nik_year = substr($nik[$i], 10, 2);
                    $nik_date = substr($nik[$i], 6, -8);

                    $result['nik'] = $nik[$i];
                    $result['wilayah'] = [
                        "provinsi" => ($data['provinsi'][substr($nik[$i], 0, 2)] != '' ? $data['provinsi'][substr($nik[$i], 0, 2)] : null),
                        "kotakab" => ($data['kabkot'][substr($nik[$i], 0, 4)] != '' ? $data['kabkot'][substr($nik[$i], 0, 4)] : null),
                        "kecamatan" => ($data['kecamatan'][substr($nik[$i], 0, 6)] != '' ? strtoupper($data['kecamatan'][substr($nik[$i], 0, 6)]) : null)
                    ];
                    $result['kelamin'] = ($nik_date > 40 ? "PEREMPUAN" : "LAKI-LAKI");
                    $result['lahir'] = [
                        "tanggal" => ($nik_date > 40 ? (strlen($nik_date - 40) > 1 ? ($nik_date - 40) : "0{($nik_date - 40)}") : $nik_date),
                        "bulan" => substr($nik[$i], 8, 2),
                        "tahun" => ($nik_year < $year ? "20{$nik_year}" : "19{$nik_year}")
                    ];
                    $result['uniqcode'] = substr($nik[$i], 12, 16);
                } else {
                    $result = [
                        "error-" . ($i + 1) => "Nomor NIK harus 16 digit"
                    ];
                }

                array_push($response["result"], $result);

            }
            if ($callback instanceof \Closure) {
                $callback($response);
            } else {
                return $response;
            }

        } else {

            if (strlen($nik) == 16) {
                $year = substr(date('Y'), -2);
                $nik_year = substr($nik, 10, 2);
                $nik_date = substr($nik, 6, -8);
               $result = [
                   "result" => [
                        "nik" => $nik,
                        "wilayah" => [
                            "provinsi" => ($data['provinsi'][substr($nik, 0, 2)] != null ? $data['provinsi'][substr($nik, 0, 2)] : null),
                            "kotakab" => ($data['kabkot'][substr($nik, 0, 4)] != null ? $data['kabkot'][substr($nik, 0, 4)] : null),
                            "kecamatan" => ($data['kecamatan'][substr($nik, 0, 6)] != null ? strtoupper($data['kecamatan'][substr($nik, 0, 6)]) : null)
                        ],
                        "kelamin" => ($nik_date > 40 ? "PEREMPUAN" : "LAKI-LAKI"),
                        "lahir" => [
                            "tanggal" => ($nik_date > 40 ? (strlen($nik_date - 40) > 1 ? ($nik_date - 40) : "0{($nik_date - 40)}") : $nik_date),
                            "bulan" => substr($nik, 8, 2),
                            "tahun" => ($nik_year < $year ? "20{$nik_year}" : "19{$nik_year}")
                        ],
                        "uniqcode" => substr($nik, 12, 16)
                    ]
                ];
            } else {
                $result = [
                    "error" => "Nomor NIK harus 16 digit"
                ];
            }
            
            if ($callback instanceof \Closure) {
                $callback($result);
            } else {
                return $result;
            }

        }

    }

}


