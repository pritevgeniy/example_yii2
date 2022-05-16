<?php

declare(strict_types=1);

namespace  frontend\entity\log\dto;

class LogDto
{
    private int $userId;

    private string $type;

    private ?int $elementId;

    public function __construct(int $userId, string $type, ?int $elementId = null)
    {
        $this->userId = $userId;
        $this->type = $type;
        $this->elementId = $elementId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getElementId(): int
    {
        return $this->elementId;
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'type' => $this->type,
            'element_id' => $this->elementId
        ];
    }
}