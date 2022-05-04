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
     * @param int $id
     * @return Post|null
     */
    public function findByIdAndUserIdentity(int $id): ?Post
    {
        return Post::findOne(['id' => $id, 'user_id' => $this->getIdentityId()]);
    }

    /**
     * @return int
     */
    private function getIdentityId(): int
    {
        return Yii::$app->user->identity->id;
    }
}