<?php

declare(strict_types=1);

namespace frontend\entity\post\service;

use Yii;
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
     * @return Post
     * @todo вернуть DTO
     */
    public function create(array $attributes): Post
    {
        return $this->save($this->getModel(), array_merge($attributes, ['user_id' => $this->getIdentityId()]));
    }

    public function update(int $id, array $attributes): Post
    {
        return $this->save($this->getModel($id), array_merge($attributes, ['user_id' => $this->getIdentityId()]));
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

    /**
     * @return int
     */
    private function getIdentityId(): int
    {
        return Yii::$app->user->identity->id;
    }

    /**
     * @param int|null $id
     * @return Post
     */
    private function getModel(?int $id = null): Post
    {
        if ($id !== null) {
            $model = $this->search->findByIdAndUserIdentity($id);
            if ($model === null) {
                //@todo может сделаем адаптер ошибок из доменных в http?
                throw new NotFoundException('Not found Post id: ' . $id);
            }
        }

        return $model ?? new Post();
    }
}