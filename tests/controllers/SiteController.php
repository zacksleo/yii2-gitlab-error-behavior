<?php
namespace tests\controllers;

use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use zacksleo\yii2\gitlab\behaviors\ErrorBehavior;
use yii\web\Controller;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'behaviors' => [
                'class' => ErrorBehavior::className(),
                //'apiRoot' => 'http://gitlab.com/api/v3/',
                'apiRoot' => 'https://mops-gitlab.lianluo.com/',
                'privateToken' => 'f_maz-tyyTE2UJi6sm1d',
                'projectName' => 'test/errorbehavior'
            ]
        ];
    }


    public function actionNotfound(){
        throw new NotFoundHttpException('NOT FOUND');
    }

    public function actionServererror(){
        throw new ServerErrorHttpException('server error');
    }
}
