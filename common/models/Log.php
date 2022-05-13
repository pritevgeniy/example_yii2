<?php

declare(strict_types=1);

namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * @property int $id
 * @property int $user_id
 * @property int $element_id
 * @property string $type
 * @property int $created_at
 */
class Log extends ActiveRecord
{
    public const USER_LOGIN = 'userLogin';
    public const USER_LOGOUT = 'userLogout';
    public const POST_CREATE = 'postCreate';
    public const POST_UPDATE = 'postUpdate';
    public const COMMENT_CREATE = 'commentCreate';

    /**
     * @var array|string[]
     */
    public static array $typeNames = [
        self::USER_LOGIN => 'User Login',
        self::USER_LOGOUT => 'User Logout',
        self::POST_CREATE => 'Post Create',
        self::POST_UPDATE => 'Post Update',
        self::COMMENT_CREATE => 'Comment Create',
    ];

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%log}}';
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
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['user_id', 'type', 'element_id'], 'required'],
            ['type', 'in', 'range' => array_keys(self::$typeNames)],
            [['user_id', 'element_id'], 'integer'],
        ];
    }
}
