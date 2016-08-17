<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */
/* @var $form yii\widgets\ActiveForm */

// очень некрасивый код!!! Не хватало времени разобраться, как прокинуть из контроллера модель в _form
$sections = \app\models\Sections::find()->all();
// формируем массив, с ключем равным полю 'id' и значением равным полю 'name'
$items = \yii\helpers\ArrayHelper::map($sections,'id','name');
$params = [ 'prompt' => 'Выберите раздел...'];

?>

<div class="articles-form">

<!--    --><?php //$form = ActiveForm::begin(); ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

<!--    --><?//= $form->field($model, 'img')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'img')->fileInput() ?>

    <?= $form->field($model, 'date_post')->hiddenInput(['value' => date("Y-m-d")])->label(false) ?>

    <?= $form->field($model, 'section_id')->label('Раздел')->dropDownList($items,$params); ?>

    <?= $form->field($model, 'rating')->textInput() ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
