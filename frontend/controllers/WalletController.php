<?php
/**
 * Created by PhpStorm.
 * User: Stes
 * Date: 06.05.2019
 * Time: 22:41
 */

namespace frontend\controllers;


use common\models\Currency;
use common\models\Wallet;
use frontend\components\CurrencyComponent;
use frontend\models\ExchangeModel;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class WalletController extends Controller
{
    public function actionCreate()
    {
        $currencies = Currency::find()->all();
        $model = new Wallet(['user_id' => \Yii::$app->user->getId()]);
        if ($model->load(\Yii::$app->request->post()) and $model->save()){
            \Yii::$app->session->setFlash('success', 'You wallet create');
            return $this->redirect(['site/index']);
        }
        return $this->render('create', [
            'currencies' => $currencies,
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Wallet::findOne($id);
        if (empty($model)){
            throw new NotFoundHttpException();
        }
        if ($model->load(\Yii::$app->request->post()) and $model->save()){
            \Yii::$app->session->setFlash('success', 'You wallet update');
            return $this->redirect(['site/index']);
        }
        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionExchange()
    {
        $myWallets = Wallet::find()->with('currency')->where(['user_id' => \Yii::$app->user->getId()])->all();
        $model = new ExchangeModel();
        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if (!\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())){
            if ($model->validate()){
                if ($model->setTransaction()){
                    return $this->redirect(['site/index']);
                }
            }
        }
        return $this->render('exchange', ['myWallets' => $myWallets, 'model' => $model]);
    }

    public function actionShowRates()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new ExchangeModel();
        /* @var CurrencyComponent $currencyComponent*/
        $currencyComponent = \Yii::$app->get('currencies');
        if ($model->load(\Yii::$app->request->post()) and $model->validate()){
            $walletReceiver = Wallet::find()->with('currency')->where(['id' => $model->walletReceiver])->one();
            $walletSender = Wallet::find()->with('currency')->where(['id' => $model->walletSender])->one();
            if (!empty($walletSender) and !empty($walletReceiver)){
                $result = $model->amount * $walletSender->currency->rate / $walletReceiver->currency->rate;
                return $this->renderPartial('_convert', [
                   'result' => $result
                ]);
            }
        }

    }

    public function actionList($q = null)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $out = [
            'results' => [
                'id' => '',
                'text' => '',
            ],
        ];
        if (!is_null($q)) {
            $out['results'] = Wallet::find()
                ->select(
                    [
                        'wallet.id as id',
                        new Expression('name||\' \'||currency.short as text')
                    ]
                )
                ->where(
                    [
                        'ilike',
                        'name',
                        $q,
                    ]
                )
                ->joinWith('currency')
                ->limit(20)
                ->asArray()
                ->all();
        }
        return $out;
    }


}