<?php
/**
 * Created by PhpStorm.
 * User: graychen
 * Date: 2017/8/11
 * Time: 上午11:15
 */
namespace zacksleo\yii2\gitlab\behaviors\tests;

use yii\base\ErrorException;
use zacksleo\yii2\gitlab\behaviors\tests\TestCase as TestCase;
use yii\web\NotFoundHttpException;
use Yii;

class ErrorBehaviorTest extends TestCase
{
    public function testIndex(){
        $response = Yii::$app->runAction('behaviors/errorbehavior/index');
        $this->assertEquals(200,$response->statusCode);
    }


    public function testNotfound(){
        $expection=Yii::$app->getErrorHandler()->exception=null;
        $expection->statusCode=404;
      //  $this->setExpectedException(NotFoundHttpException::class);
        $response = Yii::$app->runAction('behaviors/errorbehavior/index');
        throw new NotFoundHttpException("Page not found.",404);
       // var_dump($response);
        //
        //var_dump($response);
        //$this->expectExpection(NotFoundHttpException::class);
        //$this->assertInstanceOf($response,ErrorException::class);
    }

}
