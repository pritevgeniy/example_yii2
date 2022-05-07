<?php

declare(strict_types=1);

namespace frontend\entity\comment\service;

use common\models\Comment;

final class CommentService
{
    /**
     * @param array $attributes
     * @param int $userId
     * @return Comment
     * @todo вернуть DTO
     */
    public function create(array $attributes, int $userId): Comment
    {
        return $this->save(new Comment(), array_merge($attributes, ['user_id' => $userId]));
    }

    /**
     * @param Comment $model
     * @param array $attributes
     * @return Comment
     */
    private function save(Comment $model, array $attributes): Comment
    {
        $model->setAttributes($attributes);
        $model->save();

        return $model;
    }
}