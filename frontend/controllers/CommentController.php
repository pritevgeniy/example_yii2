<?php

declare(strict_types=1);

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\exceptions\http\FormValidateHttpException;
use frontend\entity\comment\form\CommentCreateForm;
use frontend\entity\comment\service\CommentService;
use common\exceptions\http\NotFoundException;

class CommentController extends Controller
{
    private CommentService $service;

    public function __construct($id, $module, CommentService $service, $config = [])
    {
        $this->service = $service;

        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ]
        ];
    }

    /**
     * @throws NotFoundHttpException|FormValidateHttpException
     */
    public function actionCreate(): Response
    {
        $form = new CommentCreateForm();
        if ($form->load(Yii::$app->request->post())) {
            if ($form->validate() === false) {
                throw new FormValidateHttpException($form);
            }

            try {
                $this->service->create($form->getAttributes(), $this->getUserIdentityId());
            } catch (NotFoundException $e) {
                throw new NotFoundHttpException($e->getMessage());
            }

            Yii::$app->session->setFlash('success', 'Comment created!');
        }

        return $this->redirect(Url::to('/post/view/' . $form->post_id));
    }

    private function getUserIdentityId(): int
    {
        return Yii::$app->user->identity->id;
    }
}
