<?php

declare(strict_types=1);

namespace frontend\entity\log\service;

use frontend\entity\log\dto\LogDto;
use yii\db\ActiveQuery;
use common\models\Log;

final class LogSearch
{
    public function findQuery(): ActiveQuery
    {
        return Log::find();
    }

    /**
     * @param array $condition
     * @return Log[]
     */
    public function findAll(array $condition): array
    {
        return Log::findAll($condition);
    }

    /**
     * @param array $condition
     * @return Log|null
     */
    public function findOne(array $condition): ?Log
    {
        return Log::findOne($condition);
    }

    /**
     * @param LogDto $dto
     * @return array
     */
    public function findByDto(LogDto $dto): array
    {
        return Log::findAll($dto->toArray());
    }
}