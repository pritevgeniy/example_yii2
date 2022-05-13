<?php

declare(strict_types=1);

namespace frontend\entity\log\factory\types;

use frontend\entity\log\dto\LogDto;

interface LogInterface
{
    public static function toDto($value): LogDto;
}