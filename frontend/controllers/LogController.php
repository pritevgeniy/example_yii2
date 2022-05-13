<?php

declare(strict_types=1);

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use frontend\entity\log\service\LogSearch;
class LogController extends Controller
{
    private LogSearch $search;

    public function __construct($id, $module, LogSearch $search, $config = [])
    {
        $this->search = $search;

        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
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
                'pagination' => [
                    'pageSize' => 20,
                ],
                'sort'=> ['defaultOrder' => ['id' => SORT_DESC]],
            ])
        ]);
    }
}
