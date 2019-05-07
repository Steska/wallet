<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property int $wallet_sender
 * @property int $wallet_receiver
 * @property int $message
 * @property int $created_at
 * @property int $updated_at
 * @property int $amount
 *
 * @property Wallet $walletSender
 * @property Wallet $walletReceiver
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    public function behaviors()
    {
        return [
          'timestamp' => [
              'class' => TimestampBehavior::className()
          ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['amount', 'double'],
            ['message' , 'string'],
            [['wallet_sender', 'wallet_receiver', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['wallet_sender', 'wallet_receiver', 'created_at', 'updated_at'], 'integer'],
            [['wallet_sender'], 'exist', 'skipOnError' => true, 'targetClass' => Wallet::className(), 'targetAttribute' => ['wallet_sender' => 'id']],
            [['wallet_receiver'], 'exist', 'skipOnError' => true, 'targetClass' => Wallet::className(), 'targetAttribute' => ['wallet_receiver' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wallet_sender' => 'Wallet Sender',
            'wallet_receiver' => 'Wallet Receiver',
            'message' => 'Message',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWalletSender()
    {
        return $this->hasOne(Wallet::className(), ['id' => 'wallet_sender']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWalletReceiver()
    {
        return $this->hasOne(Wallet::className(), ['id' => 'wallet_receiver']);
    }
}
