<?php

declare(strict_types=1);

namespace frontend\entity\log\factory\types;

use common\models\Comment;
use common\models\Log;
use frontend\entity\log\dto\LogDto;

class LogCreateComment implements LogInterface
{
    /** @var Comment $value */
    public static function toDto($value): LogDto
    {
        return new LogDto($value->user_id, Log::COMMENT_CREATE, $value->id);
    }
}