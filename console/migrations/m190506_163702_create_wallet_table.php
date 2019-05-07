<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%wallet}}`.
 */
class m190506_163702_create_wallet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%wallet}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'name' => $this->string(),
            'currency_id' => $this->integer()
        ]);

        $this->addForeignKey('wallet_user_fk',
                            'wallet',
                            'user_id',
                            'user',
                            'id',
                            'CASCADE',
                            'CASCADE');
        $this->addForeignKey('wallet_currency_fk',
                            'wallet',
                            'currency_id',
                            'currency',
                            'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('wallet_user_fk', 'wallet');
        $this->dropForeignKey('wallet_currency_fk', 'wallet');
        $this->dropTable('{{%wallet}}');
    }
}
