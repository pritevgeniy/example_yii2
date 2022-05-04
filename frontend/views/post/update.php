<?php

declare(strict_types=1);

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
use common\models\Post;

/** @var View $this */
/** @var ActiveForm $form */
/** @var Post $model */


$this->title = 'Create post';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'create-post-form']); ?>

                <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'description')->textarea(['rows' => 10]) ?>

                <?= $form->field($model, 'status')->dropdownList(Post::$statuses) ?>

                <div class="form-group">
                    <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>

                    <?= Html::a('Cancel', Url::to('/post/index'), ['class' => 'btn btn-default', 'name' => 'create-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
