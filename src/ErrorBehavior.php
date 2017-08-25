<?php
namespace zacksleo\yii2\gitlab\behaviors;

use yii;
use yii\base\Behavior;
use yii\base\Exception;
use yii\base\UserException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\VarDumper;

/**
 * Class ErrorBehavior
 * @package zacksleo\yii2\gitlab\behaviors\ErrorBehavior
 * @property string $apiRoot
 * @property string $privateToken
 * @property string $projectName
 * @property string $defaultMessage
 */
class ErrorBehavior extends Behavior
{
    public $apiRoot;
    public $privateToken;
    public $projectName;
    public $defaultMessage = 'Error';
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction'
        ];
    }
    /**
     * @param $event
     * @return boolean
     */
    public function beforeAction($event)
    {
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            $exception = new HttpException(404, Yii::t('yii', 'Page not found.'));
        }
        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }
        if ($exception instanceof Exception) {
            $name = $exception->getName();
        } else {
            $name = $this->defaultMessage ?: Yii::t('yii', 'Error');
        }
        if ($code) {
            $name .= " (#$code)";
        }
        if ($exception instanceof UserException) {
            $message = $exception->getMessage();
        } else {
            $message = $this->defaultMessage ?: Yii::t('yii', 'An internal server error occurred.');
        }
        if ($code > 499 && $code < 600) {
            $projectId = $this->getProjectId();
            if (empty($projectId)) {
                return true;
            }
            $url = $this->apiRoot . '/projects/' . $projectId . '/issues';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'PRIVATE-TOKEN: ' . $this->privateToken,
            ));
            $description = '';
            if (!empty(Yii::$app->request->userIP)) {
                $description .= '<blockquote>IP: ' . Yii::$app->request->userIP . '</blockquote>';
            }
            if (!empty(Yii::$app->request->getReferrer())) {
                $description .= '<blockquote>Refer:' . Yii::$app->request->getReferrer() . '</blockquote>';
            }
            if (YII_DEBUG) {
                $description .= '<blockquote>X-Debug-Tag:' . Yii::$app->log->targets['debug']->tag . '</blockquote>';
            }
            $content = htmlspecialchars(
                VarDumper::dumpAsString($_REQUEST),
                ENT_QUOTES | ENT_SUBSTITUTE,
                Yii::$app->charset,
                true
            );
            $description .= '<blockquote>' . $content . '</blockquote>';
            $description .= '<blockquote>URL: ' . Yii::$app->request->absoluteUrl;
            $description .= '</blockquote><br/><pre>' . $exception . '</pre>';
            curl_setopt(
                $ch,
                CURLOPT_POSTFIELDS,
                [
                    'title' => $message,
                    'description' => $description,
                    'labels' => 'bug',
                ]
            );
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_VERBOSE, false);
            curl_exec($ch);
            curl_close($ch);
        }
        return true;
    }
    /**
     * @return bool|integer
     */
    private function getProjectId()
    {
        $url = $this->apiRoot . '/projects/' . urlencode($this->projectName);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'PRIVATE-TOKEN: ' . $this->privateToken,
        ));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode >= 200 && $httpCode < 300) {
            $project = json_decode($data, true);
            return isset($project['id']) ? $project['id'] : false;
        }
        return false;
    }
}
