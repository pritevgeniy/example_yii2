<?php

declare(strict_types=1);

namespace frontend\controllers;

use Yii;
use RuntimeException;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use common\models\Post;
use common\exceptions\http\FormValidateHttpException;
use frontend\entity\post\form\PostCreateForm;
use frontend\entity\post\form\PostUpdateForm;
use frontend\entity\post\service\PostService;
use frontend\entity\post\service\PostSearch;
use common\exceptions\http\NotFoundException;

class PostController extends Controller
{
    private PostService $service;
    private PostSearch $search;

    public function __construct($id, $module, PostService $service, PostSearch $search, $config = [])
    {
        $this->service = $service;
        $this->search = $search;

        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create', 'update'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'create', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index', ['provider' => new ActiveDataProvider([
                'query' => $this->search->findQuery(),
            ])
        ]);
    }

    /**
     * @throws NotFoundHttpException|FormValidateHttpException
     */
    public function actionCreate()
    {
        $form = new PostCreateForm();
        if ($form->load(Yii::$app->request->post())) {
            if ($form->validate() === false) {
                throw new FormValidateHttpException($form);
            }

            try {
                $this->service->create($form->getAttributes(), $this->getUserIdentityId());
            } catch (NotFoundException $e) {
                throw new NotFoundHttpException($e->getMessage());
            }

            Yii::$app->session->setFlash('success', 'Yup!');

            return $this->redirect(Url::current());
        }

        return $this->render('create', ['model' => $form]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $form = new PostUpdateForm();
        $model = $this->getModel($id);

        if ($form->load(Yii::$app->request->post())) {
            if ($form->validate() === false) {
                throw new RuntimeException('Ошибка валидации');
            }
            try {
                $this->service->update($id, $form->getAttributes(), $this->getUserIdentityId());
            } catch (NotFoundException $e) {
                throw new NotFoundHttpException($e->getMessage());
            }
            Yii::$app->session->setFlash('success', 'Yup!');

            return $this->redirect(Url::current());
        }

        $form->setAttributes($model->getAttributes());

        return $this->render('update', ['model' => $form]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        $model = $this->search->findQuery()
            ->with(['comments' => function(ActiveQuery $query) {
                $query->with(['user'])->orderBy('created_at DESC');
            }])
            ->where(['id' => $id])
            ->one();
        //@todo получение комментов генератором?
        if ($model === null) {
            throw new NotFoundHttpException('Post not found id: ' . $id);
        }

        return $this->render('view', ['model' => $model]);
    }

    /**
     * @param int $id
     * @return Post
     * @throws NotFoundHttpException
     */
    private function getModel(int $id): Post
    {
        $model = $this->search->findOne(['id' => $id, 'user_id' => $this->getUserIdentityId()]);
        if ($model === null) {
            throw new NotFoundHttpException('Post not found id: ' . $id);
        }

        return $model;
    }

    private function getUserIdentityId(): int
    {
        return Yii::$app->user->identity->id;
    }
}
