<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var app\models\search\BeritaSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="berita-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'kategori_berita_id') ?>

		<?= $form->field($model, 'user_id') ?>

		<?= $form->field($model, 'judul') ?>

		<?= $form->field($model, 'gambar') ?>

		<?php // echo $form->field($model, 'isi') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
