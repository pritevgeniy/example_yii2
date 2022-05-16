<?php

declare(strict_types=1);

namespace frontend\entity\log\service;

use common\models\Log;

class LogService
{
    /**
     * @param array $attributes
     * @return Log
     * @todo вернуть DTO
     */
    public function create(array $attributes): Log
    {
        return $this->save(new Log(), $attributes);
    }

    /**
     * @param Log $model
     * @param array $attributes
     * @return Log
     */
    private function save(Log $model, array $attributes): Log
    {
        $model->setAttributes($attributes);
        $model->save();

        return $model;
    }
}