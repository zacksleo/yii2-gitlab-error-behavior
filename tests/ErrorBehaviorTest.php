<?php
/**
 * Created by PhpStorm.
 * User: graychen
 * Date: 2017/8/11
 * Time: 上午11:15
 */
namespace tests;

use Yii;
use yii\base\Event;
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


    public function testBeforeaction()
    {
        $behavior = new ErrorBehavior();
        $behavior->apiRoot = 'https://gitlab.com/api/v4';
        $behavior->privateToken='99jBxzicQ-cv-qNq7_zs';
        $behavior->projectName='Graychen1/project';
       // $issue_num_before=$this->getIssueNum($behavior->apiRoot,$behavior->privateToken);
        Yii::$app->request->setUrl('https://www.baidu.com');
        Yii::$app->errorHandler->exception = new yii\web\ServerErrorHttpException('500的错误'.rand(1, 100000));
        $value=$behavior->beforeAction(new Event());
        //$issue_num_after=$this->getIssueNum($behavior->apiRoot,$behavior->privateToken);
        //$this->assertEquals($issue_num_after,$issue_num_before+1);
        $this->assertTrue($value);
    }

    public function testGetProjectId()
    {
        $behavior = new ErrorBehavior();
        $behavior->apiRoot = 'https://gitlab.com/api/v4';
        $behavior->privateToken='99jBxzicQ-cv-qNq7_zs';
        $behavior->projectName='Graychen1/project';
        $value = $this->invokeMethod($behavior, 'getProjectId');
        $this->assertEquals(3987856, $value);
    }

    private function getIssueNum($apiRoot, $privateToken)
    {
        $url = $apiRoot . '/projects/3987856/issues';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'PRIVATE-TOKEN: ' . $privateToken,
        ));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        $data = curl_exec($ch);
        $array_data = json_decode($data, true);
        // $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $array_data[0]["iid"];
    }
}
