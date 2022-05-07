<?php

declare(strict_types=1);

namespace frontend\entity\post\service;

use Yii;
use yii\db\ActiveQuery;
use common\models\Post;

final class PostSearch
{
    public function findQuery(): ActiveQuery
    {
        return Post::find();
    }

    /**
     * @param array $condition
     * @return Post[]
     */
    public function findAll(array $condition): array
    {
        return Post::findAll($condition);
    }

    /**
     * @param array $condition
     * @return Post|null
     */
    public function findOne(array $condition): ?Post
    {
        return Post::findOne($condition);
    }
}