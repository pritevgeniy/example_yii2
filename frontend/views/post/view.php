<?php

declare(strict_types=1);

use yii\widgets\DetailView;
use common\models\Post;

/** @var yii\web\View $this */
/** @var Post $model */

$this->title = 'Posts';
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
            </div>
        </div>
    </div>
</div>
