<?php
/**
 * Created by PhpStorm.
 * User: graychen
 * Date: 2017/8/11
 * Time: 上午11:15
 */
namespace zacksleo\yii2\gitlab\behaviors\tests;

use zacksleo\yii2\gitlab\behaviors\tests\TestCase as TestCase;
use zacksleo\yii2\gitlab\behaviors\tests\controllers;
use Yii;

class ErrorBehaviorTest extends TestCase
{
    public function testNotfound(){
        $response = Yii::$app->runAction('behaviors/errorbehavior/index');
        var_dump($response);
    }
}
