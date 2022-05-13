<?php

declare(strict_types=1);

namespace common\models;

use frontend\entity\log\behaviors\LogBehavior;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property int $created_at
 * @property int $updated_at
 */
class Post extends ActiveRecord
{
    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUS_DELETED = 2;

    public static array $statuses = [
        self::STATUS_INACTIVE => 'Hide',
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_DELETED => 'Deleted',
    ];

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%post}}';
    }

    /**
     * @return string[]
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['updated_at', 'created_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),

            ],
            'log' => [
                'class' => LogBehavior::class,
                'events' => [
                    self::EVENT_AFTER_INSERT => [$this, 'postCreate'],
                    self::EVENT_AFTER_UPDATE => [$this, 'postUpdate']
                ],
                'value' => $this,
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['user_id', 'title'], 'required'],
            ['title', 'string', 'length' => [3, 24]],
            ['description', 'string'],
            ['user_id', 'integer'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    public function getComments(): ActiveQuery
    {
        return $this->hasMany(Comment::class, ['post_id' => 'id']);
    }
}
