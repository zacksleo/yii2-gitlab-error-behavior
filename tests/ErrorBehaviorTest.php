<?php
/**
 * Created by PhpStorm.
 * User: graychen
 * Date: 2017/8/11
 * Time: 上午11:15
 */
namespace tests;

use Yii;
use zacksleo\yii2\gitlab\behaviors\ErrorBehavior;

class ErrorBehaviorTest extends TestCase
{
    /**
     * @expectedException   yii\web\NotFoundHttpException
     */
    public function testNotfound()
    {
        $response = Yii::$app->runAction('site/notfound');
    }
    /**
     * @expectedException   yii\web\ServerErrorHttpException
     */
    public function testServererror()
    {
        $response = Yii::$app->runAction('site/servererror');
    }
/*
    public function testGetProjectId(){
        $behavior = new ErrorBehavior();
        $behavior->apiRoot = '';
        Yii::$app->errorHandler->exception = '';
        $behavior->beforeAction($event);
        $this->invokeMethod($behavior,'getProjectId');
        $this->assertEquals(3,$behavior->getProjectId());

    }
*/
}
