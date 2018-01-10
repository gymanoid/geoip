<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\base\DynamicModel;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return 'Hello world!';
    }

    /**
     * Action geo ip
     *
     * @return string
     */
    public function actionGeoip($ip)
    {
        $model = DynamicModel::validateData(
            compact('ip'),
            [
                [['ip'], 'required'],
                [['ip'], 'ip'],
            ]
        );

        $response = [
            'success' => false,
            'data'    => [],
            'errors'  => [],
        ];

        if ($model->hasErrors()) {
            Yii::$app->response->statusCode = 400;
            $response['errors'] = $model->getErrors();
        } else {
            $city = Yii::$app->cache->getOrSet('ip_' . $model->ip, function () use ($model) {
                return Yii::$app->sypexGeo->getCity($model->ip);
            }, 1800);

            if (empty($city)) {
                Yii::$app->response->statusCode = 404;
                $response['errors'] = ['Not Found!'];
            } else {
                $response['success'] = true;
                $response['data'] = $city;
            }
        }

        return $this->asJson($response);
    }
}
