<?php
/**
 * Created by PhpStorm.
 * User: Stes
 * Date: 06.05.2019
 * Time: 22:08
 */

namespace frontend\controllers;


use common\models\Currency;
use frontend\components\CurrencyComponent;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CurrencyController extends Controller
{
    public function actionUpdate()
    {
        /**
         * @var CurrencyComponent $currencyComponent
         */
        $errors = false;
        $ratesData = Currency::find()->indexBy('short')->all();
        $currencyComponent = \Yii::$app->get('currencies');
        $rates = $currencyComponent->getCurrencies();
        foreach ($rates as $key => $rate){
            if (!empty($ratesData[$key]) and !$ratesData[$key]->blocked){
                $ratesData[$key]->rate = $rate;
                if ($ratesData[$key]->save()){
                  $errors = true;
                }
            }else{
                $model = new Currency();
                $model->short = $key;
                $model->rate = $rate;
                if ($model->save()){
                    $errors = true;
                }
            }
        }
        if ($errors){
            \Yii::$app->session->setFlash('success', 'Something wrong');
        }else{
            \Yii::$app->session->setFlash('success', 'Success Update');
        }
        return $this->goBack();
    }

    public function actionChangeStatus($id)
    {
        $model = Currency::findOne($id);

        if ($model->blocked){
            $model->blocked = false;
        }else{
            $model->blocked = true;
        }
        if ($model->save()){
            \Yii::$app->session->setFlash('success', 'The crypt '.$model->short.' change');
            return $this->goBack();
        }
    }
}