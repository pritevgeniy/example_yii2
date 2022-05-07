<?php

declare(strict_types=1);

namespace frontend\tests\entity\comment;

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

        $service = $this->getService();
        $this->assertEquals(true, $form->validate());
        $comment = $service->create($form->attributes, 1);
        $this->assertEquals('text', $comment->text);
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
    private function getSearch(): CommentSearch
    {
        return Yii::createObject(CommentSearch::class);
    }
}