<?php
/**
 * Created by PhpStorm.
 * User: Stes
 * Date: 07.05.2019
 * Time: 21:41
 */

namespace frontend\controllers;


use common\models\Wallet;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\Controller;

class SearchController extends Controller
{
    public function actionIndex($word = null){
        $word = Html::encode($word);

        $dataProvider = new ActiveDataProvider([
            'query' => Wallet::find()->joinWith(['currency', 'user'])
                        ->where(['ILIKE', 'name', $word])
                        ->orWhere(['ILIKE','user.email', $word])
                        ->orWhere(['ILIKE', 'currency.short', $word]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider, 'word' => $word]);
    }
}