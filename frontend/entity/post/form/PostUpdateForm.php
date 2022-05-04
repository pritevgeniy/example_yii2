<?php

declare(strict_types=1);

namespace frontend\entity\post\form;

use yii\base\Model;
use common\models\Post;

class PostUpdateForm extends Model
{
    public ?string $title = null;
    public ?string $description = null;
    public ?string $status = null;

    public function rules(): array
    {
        return [
            [['title'], 'required'],
            ['title', 'string', 'length' => [3, 24]],
            ['description', 'string'],
            ['status', 'default', 'value' => Post::STATUS_INACTIVE],
            ['status', 'in', 'range' => [Post::STATUS_ACTIVE, Post::STATUS_INACTIVE, Post::STATUS_DELETED]],
        ];
    }
}
