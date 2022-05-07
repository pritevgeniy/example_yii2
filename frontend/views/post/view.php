<?php

declare(strict_types=1);

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\Url;
use common\models\Post;
use frontend\entity\comment\form\CommentCreateForm;

/** @var yii\web\View $this */
/** @var Post $model */

$this->title = 'Posts';
$comment = new CommentCreateForm();
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Congratulations!</h1>

    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <h2>All Posts</h2>
                    <a class="btn btn-info ml-auto"  href="/post">List</a>
                </div>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'title',
                        'description:html',
                        [
                            'label' => 'Status',
                            'value' => static fn($model) => Post::$statuses[$model->status] ?? 'undefined'
                        ],
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ]); ?>

                <hr>
                <?php if (Yii::$app->user->identity) { ?>
                    <?php $form = ActiveForm::begin(['id' => 'create-post-form', 'action' => Url::to('/comment/create')]); ?>
                        <?= $form->field($comment, 'post_id')->hiddenInput(['value' => $model->id]) ?>
                        <?= $form->field($comment, 'text')->textInput(['autofocus' => true]) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Create', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
                        </div>
                    <?php ActiveForm::end(); ?>
                <?php } ?>

                <?php foreach ($model->comments as $iComment) { ?>
                    <p><?= "(" . $iComment->user->username . ": " . $iComment->created_at . ") " . $iComment->text?></p>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
