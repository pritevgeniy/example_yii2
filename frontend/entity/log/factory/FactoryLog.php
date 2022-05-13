<?php

declare(strict_types=1);

namespace frontend\entity\log\factory;

use common\exceptions\http\NotFoundException;
use common\models\Log;
use frontend\entity\log\factory\types\LogCreateComment;
use frontend\entity\log\factory\types\LogInterface;

class FactoryLog
{
    private array $map = [
        Log::COMMENT_CREATE => LogCreateComment::class
    ];

    public function create(string $type): LogInterface
    {
        $class = $this->map[$type] ?? null;

        if ($class === null) {
            throw new NotFoundException('Log class not found by type: ' . $type);
        }

        return new $class();
    }
}