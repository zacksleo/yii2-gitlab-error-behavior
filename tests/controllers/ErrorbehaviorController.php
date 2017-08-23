<?php
namespace zacksleo\yii2\gitlab\behaviors\tests\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use zacksleo\yii2\gitlab\behaviors\ErrorBehavior;
use yii\web\Controller;

class ErrorbehaviorController extends Controller
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


    public function actionIndex(){
        return Yii::$app->response;
    }

}
