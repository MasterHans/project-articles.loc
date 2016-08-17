<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */

// Некрасивый код. Делал быстро!!!
$sections = new \app\models\Sections();
$hrefPrintPage = '<a href="#" onClick="window.print();">Распечатать</a>';
// ---

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
//            'section_id',
            [
                'label' => 'Раздел',
                'value' => $sections->findOne($model->section_id)->name,
            ],
            'name',
            'rating',
            'text:ntext',
            'date_post',
//            'img',
//            'user_id',
            [
                'label'=>'Версия для печати',
                'format'=>'raw',
//                'value'=>Html::a('link text', '#'),
            'value'=>Html::button('Открыть', [ 'class' => 'btn btn-primary', 'onclick' => '(function ( $event ) { window.print(); })();' ]),
            ],
        ],
    ]) ?>

</div>
