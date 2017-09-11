<?php

use yii\db\Migration;

/**
 * Class m170911_131146_ref_company
 */
class m170911_131146_ref_company extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%gr_companies}}', 'country', $this->string());
        $this->addColumn('{{%gr_companies}}', 'city', $this->string());
        $this->addColumn('{{%gr_companies}}', 'address', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%gr_companies}}', 'country');
        $this->dropColumn('{{%gr_companies}}', 'city');
        $this->dropColumn('{{%gr_companies}}', 'address');

        echo "m170911_131146_ref_company cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170911_131146_ref_company cannot be reverted.\n";

        return false;
    }
    */
}
