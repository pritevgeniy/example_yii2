<?php
namespace frontend\tests\entity\post;

use common\fixtures\UserFixture;
use Yii;
use common\models\Post;
use frontend\entity\post\form\PostCreateForm;
use frontend\entity\post\service\PostSearch;
use frontend\entity\post\service\PostService;

class PostTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
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

    public function testCreate()
    {
        $form  = new PostCreateForm([
            'title' => 'title',
            'description' => 'description',
            'status' => Post::STATUS_ACTIVE
        ]);
        $userId = 1;

        $service = $this->getService();
        expect($form->validate())->equals(true);

        $search = $this->getSearch();
        expect($service->create($form->getAttributes(), $userId))->isInstanceOf(Post::class);
        $post = $search->findOne($form->getAttributes());
        expect($post)->isInstanceOf(Post::class);
        expect($post->title)->equals('title');
        $postUpdated = $service->update($post->id, ['title' => 'title1'], $userId);
        expect($postUpdated)->isInstanceOf(Post::class);
        expect($postUpdated->title)->equals('title1');

    }

    private function getService(): PostService
    {
        return Yii::createObject(PostService::class);
    }

    private function getSearch(): PostSearch
    {
        return Yii::createObject(PostSearch::class);
    }
}