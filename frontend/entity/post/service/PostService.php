<?php

declare(strict_types=1);

namespace frontend\entity\post\service;

use common\models\Post;
use common\exceptions\http\NotFoundException;

final class PostService
{
    private PostSearch $search;

    public function __construct(PostSearch $search)
    {
        $this->search = $search;
    }

    /**
     * @param array $attributes
     * @param int $userId
     * @return Post
     * @todo вернуть DTO
     */
    public function create(array $attributes, int $userId): Post
    {
        return $this->save(new Post(), array_merge($attributes, ['user_id' => $userId]));
    }

    /**
     * @param int $id
     * @param array $attributes
     * @param int $userId
     * @return Post
     */
    public function update(int $id, array $attributes, int $userId): Post
    {
        $model = $this->search->findOne(['id' => $id, 'user_id' => $userId]);
        if ($model === null) {
            //@todo может сделаем адаптер ошибок из доменных в http?
            throw new NotFoundException('Not found Post id: ' . $id);
        }

        return $this->save($model, array_merge($attributes, ['user_id' => $userId]));
    }

    /**
     * @param Post $model
     * @param array $attributes
     * @return Post
     */
    private function save(Post $model, array $attributes): Post
    {
        $model->setAttributes($attributes);
        $model->save();

        return $model;
    }
}