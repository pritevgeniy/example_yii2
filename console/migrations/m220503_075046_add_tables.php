<?php

declare(strict_types=1);

use yii\db\Migration;
use common\models\Post;

/**
 * Class m220503_075046_add_tables
 */
class m220503_075046_add_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->char(255)->notNull(),
            'description' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(Post::STATUS_ACTIVE),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp(),
        ], $tableOptions);
        $this->createIndex('I_user_id', '{{%post}}', 'user_id');

        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'post_id' => $this->integer()->notNull(),
            'text' => $this->string(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
        ], $tableOptions);
        $this->createIndex('I_user_id', '{{%comment}}', 'user_id');
        $this->createIndex('I_post_id', '{{%comment}}', 'post_id');

        $this->createTable('{{%log}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'element_id' => $this->integer()->notNull(),
            'type' => $this->char(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
        ], $tableOptions);
        $this->createIndex('I_user_id', '{{%log}}', 'user_id');
        $this->createIndex('I_type', '{{%log}}', 'type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%log}}');
        $this->dropTable('{{%comment}}');
        $this->dropTable('{{%post}}');
    }
}
