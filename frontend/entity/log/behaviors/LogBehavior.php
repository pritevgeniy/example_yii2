<?php

declare(strict_types=1);

namespace frontend\entity\log\behaviors;

use common\models\Log;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use frontend\entity\log\service\LogService;

class LogBehavior extends Behavior
{
    public ActiveRecord $value;

    public array $events;

    private LogService $log;

    public function __construct(LogService $log, $config = [])
    {
        $this->log = $log;

        parent::__construct($config);
    }

    public function events(): array
    {
        return $this->events;
    }

    public function commentCreate(): void
    {
        $this->log->create($this->fillByAR(Log::COMMENT_CREATE, $this->value));
    }

    public function postCreate(): void
    {
        $this->log->create($this->fillByAR(Log::POST_CREATE, $this->value));
    }

    public function postUpdate(): void
    {
        $this->log->create($this->fillByAR(Log::POST_UPDATE, $this->value));
    }

    private function fillByAR(string $type, ActiveRecord $model): array
    {
        return [
            'type' => $type,
            'element_id' => $model->id,
            'user_id' => $model->user_id
        ];
    }
}