<?php

use yii\db\Migration;

/**
 * Class m190506_191257_insert_data_into_wallet
 */
class m190506_191257_insert_data_into_wallet extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \Yii::$app->db->createCommand('insert into currency (short, rate, created_at, updated_at) values (\'USD\', 1 , '.time().','.time().')')->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190506_191257_insert_data_into_wallet cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190506_191257_insert_data_into_wallet cannot be reverted.\n";

        return false;
    }
    */
}
