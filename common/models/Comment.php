<?php

declare(strict_types=1);

namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property string $text
 * @property int $created_at
 * @property int $updated_at
 */
class Comment extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%comment}}';
    }

    /**
     * @return string[]
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['user_id', 'post_id'], 'required'],
            ['title', 'string', 'max' => 255, 'min' => 1],
            [['user_id', 'post_id'], 'integer'],
        ];
    }
}
