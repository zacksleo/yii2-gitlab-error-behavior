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
                'apiRoot' => 'https://gitlab.com/api/v4',
                'privateToken' => '99jBxzicQ-cv-qNq7_zs',
                'projectName' => 'Graychen1/project'
            ]
        ];
    }


    public function actionNotfound()
    {
        throw new NotFoundHttpException('NOT FOUND');
    }

    public function actionServererror()
    {
        throw new ServerErrorHttpException('server error');
    }

    public function actionIndex()
    {

    }
}
