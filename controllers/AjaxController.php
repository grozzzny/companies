<?php
namespace grozzzny\companies\controllers;

use Yii;
use yii\base\ErrorException;

class AjaxController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionGetUsers()
    {
        if (!Yii::$app->request->isAjax) throw new ErrorException();

        $model = Yii::createObject(Yii::$app->user->identityClass);

        $query = $model->find();

        $query->filterWhere(['LIKE', 'email', Yii::$app->request->get('q')]);

        $data = [];
        foreach($query->limit(10)->all() AS $item){
            $data['results'][] = [
                'id' => $item->id,
                'text' => $item->email
            ];
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE);

    }
}