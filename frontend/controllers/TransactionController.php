<?php
/**
 * Created by PhpStorm.
 * User: Stes
 * Date: 07.05.2019
 * Time: 21:06
 */

namespace frontend\controllers;


use common\models\Transaction;
use common\models\Wallet;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class TransactionController extends Controller
{
    public function actionIndex($walletId)
    {
        $wallet = Wallet::find()->with('currency')->where(['id' => $walletId])->one();

        $dataProvider = new ActiveDataProvider([
            'query' => Transaction::find()->where(['wallet_receiver' => $walletId])
                ->orWhere(['wallet_sender' => $walletId])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'wallet' => $wallet,
            'dataProvider' => $dataProvider
        ]);
    }
}