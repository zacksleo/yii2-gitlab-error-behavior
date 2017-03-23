<?php
namespace app\helpers\web;

use yii;
use yii\base\Action;
use yii\base\Exception;
use yii\base\UserException;
use yii\web\HttpException;
use yii\helpers\VarDumper;
use yii\web\Response;

class ErrorAction extends \yii\web\ErrorAction
{
    const URL = '139.198.9.208:10080/api/v3/projects/16/issues';
    const PRIVATE_TOKEN = 'qC8Wf-ycQRkKyAGL8-ax';
    const ASSIGNEE_ID = 15;

    public function run()
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
            $name = $this->defaultName ?: Yii::t('yii', 'Error');
        }
        $preCode = $code;
        if ($code) {
            $name .= " (#$code)";
        }

        if ($exception instanceof UserException) {
            $message = $exception->getMessage();
        } else {
            $message = $this->defaultMessage ?: Yii::t('yii', 'An internal server error occurred.');
        }
        if (!in_array($code, ['404', '400'])) {
            //自动向GitLab提交Bug
            $url = self::URL;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'PRIVATE-TOKEN: ' . self::PRIVATE_TOKEN,
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
                    'assignee_id' => self::ASSIGNEE_ID,
                    'labels' => '捕虫器,' . $name,
                ]
            );
            curl_setopt($ch, CURLOPT_HEADER, false);
            // Pass TRUE or 1 if you want to wait for and catch the response against the request made
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // For Debug mode; shows up any error encountered during the operation
            curl_setopt($ch, CURLOPT_VERBOSE, false);
            $response = curl_exec($ch);
            curl_close($ch);
        }
        if (Yii::$app->getRequest()->getIsAjax() || strpos($_SERVER['REQUEST_URI'], '/api/') > -1) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'message' => $message
            ];
        } else {
            return $this->controller->render($this->view ?: $this->id, [
                'name' => $name,
                'message' => $message,
                'exception' => $exception,
            ]);
        }
    }
}
