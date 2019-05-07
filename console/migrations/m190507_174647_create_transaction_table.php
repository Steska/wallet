<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transaction}}`.
 */
class m190507_174647_create_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transaction}}', [
            'id' => $this->primaryKey(),
            'wallet_sender' => $this->integer(),
            'wallet_receiver' => $this->integer(),
            'message' => $this->text(),
            'amount' => $this->float(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        $this->addForeignKey('transaction_receiver_fk',
                            'transaction',
                            'wallet_receiver',
                            'wallet',
                            'id',
                            'CASCADE',
                            'CASCADE');
        $this->addForeignKey('transaction_sender_fk',
            'transaction',
            'wallet_sender',
            'wallet',
            'id',
            'CASCADE',
            'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('transaction_receiver_fk', 'transaction');
        $this->dropForeignKey('transaction_sender_fk', 'transaction');

        $this->dropTable('{{%transaction}}');
    }
}
