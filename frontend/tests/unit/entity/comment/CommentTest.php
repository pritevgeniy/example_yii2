<?php

declare(strict_types=1);

namespace frontend\tests\entity\comment;

use common\models\Log;
use frontend\entity\log\dto\LogDto;
use frontend\entity\log\service\LogSearch;
use frontend\entity\log\service\LogService;
use Yii;
use Codeception\Test\Unit;
use common\models\Comment;
use frontend\entity\comment\form\CommentCreateForm;
use frontend\entity\comment\service\CommentSearch;
use frontend\entity\comment\service\CommentService;
use yii\base\InvalidConfigException;
use common\fixtures\UserFixture;
use frontend\tests\UnitTester;

class CommentTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    protected function _after()
    {
    }

    /**
     * @throws InvalidConfigException
     */
    public function testCreate(): void
    {
        $form  = new CommentCreateForm([
            'post_id' => 1,
            'text' => 'text'
        ]);
        $userId = 1;

        $service = $this->getService();
        $this->assertEquals(true, $form->validate());
        $comment = $service->create($form->attributes, $userId);
        $this->assertEquals('text', $comment->text);
        //Проверка записи истории действий пользователя
        $this->assertNotNull($this->getSearchLog()->findByDto(new LogDto($userId, Log::COMMENT_CREATE, $comment->id)));
    }

    /**
     * @throws InvalidConfigException
     */
    private function getService(): CommentService
    {
        return Yii::createObject(CommentService::class);
    }

    /**
     * @throws InvalidConfigException
     */
    private function getSearchLog(): LogSearch
    {
        return Yii::createObject(LogSearch::class);
    }
}