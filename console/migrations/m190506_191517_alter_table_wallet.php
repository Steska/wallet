<?php

use yii\db\Migration;

/**
 * Class m190506_191517_alter_table_wallet
 */
class m190506_191517_alter_table_wallet extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('wallet', 'amount', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190506_191517_alter_table_wallet cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190506_191517_alter_table_wallet cannot be reverted.\n";

        return false;
    }
    */
}
