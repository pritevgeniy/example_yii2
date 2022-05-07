<?php

declare(strict_types=1);

namespace frontend\entity\comment\service;

use yii\db\ActiveQuery;
use common\models\Comment;

final class CommentSearch
{
    public function findQuery(): ActiveQuery
    {
        return Comment::find();
    }

    /**
     * @param array $condition
     * @return Comment[]
     */
    public function findAll(array $condition): array
    {
        return Comment::findAll($condition);
    }

    /**
     * @param array $condition
     * @return Comment|null
     */
    public function findOne(array $condition): ?Comment
    {
        return Comment::findOne($condition);
    }

    /**
     * @param int $postId
     * @return array
     */
    public function findByPos(int $postId): array
    {
        return Comment::findAll(['post_id' => $postId]);
    }
}