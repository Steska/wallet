<?php
/**
 * Created by PhpStorm.
 * User: Stes
 * Date: 06.05.2019
 * Time: 23:38
 */

namespace frontend\models;


use common\models\Transaction;
use common\models\Wallet;
use yii\base\Model;
use yii\db\Exception;

class ExchangeModel extends Model
{
    public $walletReceiver;

    public $walletSender;

    public $amount;

    public function rules()
    {
        return [
          [
              ['walletReceiver', 'walletSender', 'amount'], 'required',

          ],
            [
                ['walletReceiver'], 'exist', 'skipOnError' => true, 'targetClass' => Wallet::className(), 'targetAttribute' => ['walletReceiver' => 'id'],
            ],
            [
                ['walletSender'], 'exist', 'skipOnError' => true, 'targetClass' => Wallet::className(), 'targetAttribute' => ['walletSender' => 'id'],
            ],
            [
                'walletReceiver', 'compare', 'compareAttribute' => 'walletSender', 'operator' => '!='
            ],
            [
                'amount', 'double'
            ],
            ['amount', 'validateAmount']
        ];
    }

    public function validateAmount($attribute, $params)
    {
        if (!empty($this->walletSender)){
            $wallet = Wallet::findOne($this->walletSender);
            if (($wallet->amount - $this->$attribute) < 0){
                $this->addError($attribute,'You cannot send this amount');
            }
        }

    }

    public function setTransaction()
    {
        /**
         * @var Wallet $walletReceiver
         * @var Wallet $walletSender
         */
        $walletReceiver = Wallet::find()->with('currency')->where(['id' => $this->walletReceiver])->one();
        $walletSender = Wallet::find()->with('currency')->where(['id' => $this->walletSender])->one();
        $result = $this->amount * $walletSender->currency->rate / $walletReceiver->currency->rate;

        $walletSender->amount -= $this->amount;
        $walletReceiver->amount += $result;

        $dbTransaction = \Yii::$app->db->beginTransaction();
        try{
            $walletSender->save();
            $walletReceiver->save();
                $transaction = new Transaction();
                $transaction->wallet_sender = $this->walletSender;
                $transaction->wallet_receiver = $this->walletReceiver;
                $transaction->amount = $this->amount;
                $transaction->message = 'Send from '.$walletSender->name.' '.$walletSender->currency->short.' to '.$walletReceiver->name.' '.$walletReceiver->currency->short.' Amount: '.$this->amount.'. Result of Convert '.$result;
                $transaction->save();
                $dbTransaction->commit();
            return true;
        }catch (\Exception $e){
            $dbTransaction->rollBack();
            var_dump($e); die();
            return false;
        }

    }
}