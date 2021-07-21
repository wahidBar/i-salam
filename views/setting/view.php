<?php

use dmstr\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\Setting $model
*/

$this->title = 'Setting ' . $model->nama_web;
?>
<div class="giiant-crud setting-view">

    <!-- menu buttons -->
    <p class='pull-left'>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit', ['update', 'id' => $model->id],['class' => 'btn btn-info']) ?>
        
    </p>

    <div class="clearfix"></div>

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <div class="box box-info">
        <div class="box-body">
            <?php $this->beginBlock('app\models\Setting'); ?>

            <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
        'pin',
        [
            'attribute' =>'logo',
            'format' =>'html',
            'value' =>function($model) {
               return Html::img(\Yii::$app->request->BaseUrl.'/uploads/setting/'.$model->logo,['width'=>100]);
             },
         ],
         [
            'attribute' =>'bg_login',
            'format' =>'html',
            'value' =>function($model) {
               return Html::img(\Yii::$app->request->BaseUrl.'/uploads/setting/'.$model->bg_login,['width'=>100]);
             },
         ],
         [
            'attribute' =>'bg_pin',
            'format' =>'html',
            'value' =>function($model) {
               return Html::img(\Yii::$app->request->BaseUrl.'/uploads/setting/'.$model->bg_pin,['width'=>100]);
             },
         ],
        'link_download_apk',
        'link_download_apk_marketing',
        'nama_web',
        'judul_web',
        'alamat:ntext',
        'slogan_web:ntext',
            ],
            ]); ?>

            <hr/>

            <!-- <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'id' => $model->id],
            [
            'class' => 'btn btn-danger',
            'data-confirm' => '' . 'Are you sure to delete this item?' . '',
            'data-method' => 'post',
            ]); ?> -->
            <?php $this->endBlock(); ?>


            
            <?= Tabs::widget(
                 [
                     'id' => 'relation-tabs',
                     'encodeLabels' => false,
                     'items' => [ [
    'label'   => '<b class=""># '.$model->nama_web.'</b>',
    'content' => $this->blocks['app\models\Setting'],
    'active'  => true,
], ]
                 ]
    );
    ?>
        </div>
    </div>
</div>
