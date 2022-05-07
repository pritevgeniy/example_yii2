<?php
namespace frontend\tests\entity\post;

use common\fixtures\UserFixture;
use Yii;
use common\models\Post;
use frontend\entity\post\form\PostCreateForm;
use frontend\entity\post\service\PostSearch;
use frontend\entity\post\service\PostService;
use yii\base\InvalidConfigException;
use frontend\tests\UnitTester;

class PostTest extends \Codeception\Test\Unit
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
        $form  = new PostCreateForm([
            'title' => 'title',
            'description' => 'description',
            'status' => Post::STATUS_ACTIVE
        ]);
        $userId = 1;

        $service = $this->getService();
        $this->assertEquals(true, $form->validate());

        $search = $this->getSearch();
        $post = $search->findOne($form->getAttributes());
        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals('title', $post->title);
        $postUpdated = $service->update($post->id, ['title' => 'title1'], $userId);
        $this->assertNotNull($postUpdated);
        $this->assertEquals('title1', $postUpdated->title);
    }

    /**
     * @throws InvalidConfigException
     */
    private function getService(): PostService
    {
        return Yii::createObject(PostService::class);
    }

    /**
     * @throws InvalidConfigException
     */
    private function getSearch(): PostSearch
    {
        return Yii::createObject(PostSearch::class);
    }
}