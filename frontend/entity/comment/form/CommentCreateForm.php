<?php

declare(strict_types=1);

namespace frontend\entity\comment\form;

use yii\base\Model;
use common\models\Post;

class CommentCreateForm extends Model
{
    public ?int $post_id = null;
    public ?string $text = null;

    public function rules(): array
    {
        return [
            [['post_id', 'text'], 'required'],
            ['post_id', 'integer'],
            ['text', 'string', 'length' => [1, 255]],
            ['post_id', 'exist', 'targetClass' => Post::class, 'targetAttribute' => ['post_id' => 'id']],
        ];
    }
}
