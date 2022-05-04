<?php

declare(strict_types=1);

namespace common\exceptions\http;

use RuntimeException;

class NotFoundException extends RuntimeException
{
    /**
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = '', int $code = 0)
    {
        parent::__construct($message, $code);
    }

}