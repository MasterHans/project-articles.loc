<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticlesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить статью', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'user_id',
            [
                'header' => 'Раздел',
                'value' => function($data) {
                    return \app\models\User::findByFirstName($data['user_id'])->firstName;
                }
            ],
            'name',
            'text:ntext',
            'date_post',
            'rating',
            [
                'attribute' => 'img',
                'format' => 'html',
                'label' => 'img',
                'value' => function ($data) {
                    return Html::img('/uploads/' . $data['img'],
                        ['width' => '60px']);
                },
            ],
            // 'section_id',



            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
