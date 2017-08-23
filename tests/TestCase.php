<?php
namespace zacksleo\yii2\gitlab\behaviors\tests;

use Yii;
use yii\helpers\ArrayHelper;
use Faker\Factory;

/**
 * This is the base class for all yii framework unit tests.
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    protected $model;
    protected $faker;

    protected function setUp()
    {
        parent::setUp();
        $this->mockWebApplication();
        $this->faker=Factory::create('zh_CN');     //伪数据生成器
    }

    protected function tearDown()
    {
        $this->destroyApplication();
    }

    protected function mockWebApplication($config = [], $appClass = '\yii\web\Application')
    {
       return new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => $this->getVendorPath(),
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'mysql:host=localhost:3306;dbname=test',
                    'username'=> 'root',
                    'password'=> '206065',
                    'tablePrefix' => 'tb_'
                ],
                'i18n' => [
                    'translations' => [
                        '*' => [
                            'class' => 'yii\i18n\PhpMessageSource',
                        ]
                    ]
                ],
                'errorHandler' => [
                    'errorAction' => 'site/error',
                ]
            ],
            'modules' => [
                'behaviors' => [
                    'class' => 'zacksleo\yii2\gitlab\behaviors\Module',
                    'controllerNamespace' => 'zacksleo\yii2\gitlab\behaviors\tests\controllers'
                ]
            ]
        ], $config));
    }
    /**
     * @return string vendor path
     */
    protected function getVendorPath()
    {
        return dirname(__DIR__) . '/vendor';
    }
    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyApplication()
    {
        if (\Yii::$app && \Yii::$app->has('session', true)) {
            \Yii::$app->session->close();
        }
        \Yii::$app = null;
    }
}
