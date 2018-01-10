<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

class UpdateController extends Controller
{
    public function actionIndex()
    {
        echo ":-)\n";

        return ExitCode::OK;
    }

    /**
     * Update geoIp database
     */
    public function actionGeoipData()
    {
        $url = 'https://sypexgeo.net/files/SxGeoCity_utf8.zip';
        $archName = \Yii::getAlias('@runtime' . '/SxGeoCity_utf8.zip');
        $fileName = \Yii::getAlias('@app' . '/data/SxGeoCity.dat');
        file_put_contents($archName, file_get_contents($url));

        if (file_exists($archName)) {
            $zip = new \ZipArchive;
            $zip->open($archName);
            $zip->extractTo(\Yii::getAlias('@runtime'));
            $zip->close();
            $tmpName = \Yii::getAlias('@runtime' . '/SxGeoCity.dat');
            if (file_exists($tmpName)) {
                copy($tmpName, $fileName);
            }
        }

        return ExitCode::OK;
    }
}
