<?php

/**
 * Class m170821_093737_company
 */
class m170821_093737_company  extends \grozzzny\base_module\Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%gr_companies}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'phone' => $this->string(),
            'email' => $this->string(),
            'image_file' => $this->string(),
            'site' => $this->string(),
            'description' => $this->text(),
            'status' => $this->boolean()->defaultValue(1),
            'order_num' => $this->integer()->notNull(),
        ], $this->tableOptions);

        $this->createTable('{{%gr_relations_companies_users}}', [
            'company_id' => $this->integer(),
            'user_id' => $this->integer(),
        ], $this->tableOptions);

        $this->createIndex('unique_relations_companies_users', '{{%gr_relations_companies_users}}', ['company_id','user_id'], true);
        $this->addForeignKey('fk_relations_companies_users_company_id', '{{%gr_relations_companies_users}}', 'company_id', '{{%gr_companies}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_relations_companies_users_user_id', '{{%gr_relations_companies_users}}', 'user_id', '{{%user}}', 'id', 'CASCADE');

        $this->createTable('{{%relations_companies_admins}}', [
            'company_id' => $this->integer(),
            'user_id' => $this->integer(),
        ], $this->tableOptions);

        $this->createIndex('unique_relations_companies_admins', '{{%relations_companies_admins}}', ['company_id','user_id'], true);
        $this->addForeignKey('fk_relations_companies_admins_company_id', '{{%relations_companies_admins}}', 'company_id', '{{%gr_companies}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_relations_companies_admins_user_id', '{{%relations_companies_admins}}', 'user_id', '{{%user}}', 'id', 'CASCADE');

        $this->insert('{{%easyii_modules}}', [
            'name' => 'companies',
            'class' => 'grozzzny\companies\Module',
            'title' => 'Companies',
            'icon' => 'font',
            'status' => 1,
            'settings' => '[]',
            'notice' => 0,
            'order_num' => 120
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%relations_companies_admins}}');
        $this->dropTable('{{%gr_relations_companies_users}}');
        $this->dropTable('{{%gr_companies}}');
        $this->delete('{{%easyii_modules}}',['name' => 'companies']);

        echo "m170821_093737_company cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170821_093737_company cannot be reverted.\n";

        return false;
    }
    */
}
