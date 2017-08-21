<?php

use yii\db\Migration;

/**
 * Class m170821_192713_ref_relations
 */
class m170821_192713_ref_relations extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->renameTable('{{%relations_companies_admins}}', '{{%gr_relations_companies_admins}}');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->renameTable('{{%gr_relations_companies_admins}}', '{{%relations_companies_admins}}');
        echo "m170821_192713_ref_relations cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170821_192713_ref_relations cannot be reverted.\n";

        return false;
    }
    */
}
