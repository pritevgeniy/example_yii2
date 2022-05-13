<?php

declare(strict_types=1);

use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/** @var yii\web\View $this */
/** @var ActiveDataProvider $provider */

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
                    <h2>Logs</h2>
                </div>

                <?= GridView::widget([
                    'dataProvider' => $provider,
                    'columns' => [
                     'id',
                     'type',
                     'created_at:datetime',
                ],
            ]) ?>
            </div>
        </div>
    </div>
</div>
