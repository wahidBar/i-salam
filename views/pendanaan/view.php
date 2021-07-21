<?php

use dmstr\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var app\models\Pendanaan $model
*/

$this->title = 'Pendanaan ' . $model->nama_pendanaan;
?>
<div class="giiant-crud pendanaan-view">

    <!-- menu buttons -->
    <p class='pull-left'>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit', ['update', 'id' => $model->id],['class' => 'btn btn-info']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p class="pull-right">
        <?= Html::a('<span class="glyphicon glyphicon-list"></span> ' . 'Daftar Pendanaan', ['index'], ['class'=>'btn btn-default']) ?>
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
            <?php $this->beginBlock('app\models\Pendanaan'); ?>

            <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
        'nama_pendanaan',
        [
            'attribute' =>'foto',
            'format' =>'html',
            'value' =>function($model) {
               return Html::img(\Yii::$app->request->BaseUrl.'/uploads/pendanaan/'.$model->foto,['width'=>100]);
             },
         ],
        'uraian:ntext',
        'nominal',
        'pendanaan_berakhir',
// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::attributeFormat

[
    'attribute'=>'user_id',
    'value' => function($model){
        return $model->user->name;
    }
],
// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::attributeFormat

[
    'attribute'=>'kategori_pendanaan_id',
    'value' => function($model){
        return $model->kategoriPendanaan->name;
    }
],
// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::attributeFormat
[
    'attribute'=>'status_id',
    'value' => function($model){
        return $model->status->name;
    }
],
            ],
            ]); ?>

            <hr/>

            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'id' => $model->id],
            [
            'class' => 'btn btn-danger',
            'data-confirm' => '' . 'Are you sure to delete this item?' . '',
            'data-method' => 'post',
            ]); ?>
            <?php $this->endBlock(); ?>


            
<?php $this->beginBlock('Pembayarans'); ?>
<div style='position: relative'><div style='position:absolute; right: 0px; top 0px;'>

</div></div><?php Pjax::begin(['id'=>'pjax-Pembayarans', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-Pembayarans ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>
<?= '<div class="table-responsive">'
 . \yii\grid\GridView::widget([
    'layout' => '{summary}{pager}<br/>{items}{pager}',
    'dataProvider' => new \yii\data\ActiveDataProvider([
        'query' => $model->getPembayarans(),
        'pagination' => [
            'pageSize' => 20,
            'pageParam'=>'page-pembayarans',
        ]
    ]),
    'pager'        => [
        'class'          => yii\widgets\LinkPager::className(),
        'firstPageLabel' => 'First',
        'lastPageLabel'  => 'Last'
    ],
    'columns' => [
 [
    'class'      => 'yii\grid\ActionColumn',
    'template'   => '{view} {update}',
    'contentOptions' => ['nowrap'=>'nowrap'],
    'urlCreator' => function ($action, $model, $key, $index) {
        // using the column name as key, not mapping to 'id' like the standard generator
        $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
        $params[0] = 'pembayaran' . '/' . $action;
        $params['Pembayaran'] = ['pendanaan_id' => $model->primaryKey()[0]];
        return $params;
    },
    'buttons'    => [
        
    ],
    'controller' => 'pembayaran'
],
        'nama',
        'nominal',
        [
            'attribute' =>'bukti_transaksi',
            'format' =>'html',
            'value' =>function($model) {
               return Html::img(\Yii::$app->request->BaseUrl.'/uploads/pembayaran/bukti_transaksi/'.$model->bukti_transaksi,['width'=>100]);
             },
         ],
         [
            'attribute' =>'foto_ktp',
            'format' =>'html',
            'value' =>function($model) {
               return Html::img(\Yii::$app->request->BaseUrl.'/uploads/pembayaran/foto_ktp/'.$model->foto_ktp,['width'=>100]);
             },
         ],
         [
            'attribute' =>'foto_kk',
            'format' =>'html',
            'value' =>function($model) {
               return Html::img(\Yii::$app->request->BaseUrl.'/uploads/pembayaran/foto_kk/'.$model->foto_kk,['width'=>100]);
             },
         ],
// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
[
    'class' => yii\grid\DataColumn::className(),
    'attribute' => 'user_id',
    'value' => function ($model) {
        if ($rel = $model->user) {
            return Html::a($rel->name, ['user/view', 'id' => $rel->id,], ['data-pjax' => 0]);
        } else {
            return '';
        }
    },
    'format' => 'raw',
],
// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
[
    'class' => yii\grid\DataColumn::className(),
    'attribute' => 'marketing_id',
    'value' => function ($model) {
        if ($rel = $model->marketing) {
            return Html::a($rel->name, ['user/view', 'id' => $rel->id,], ['data-pjax' => 0]);
        } else {
            return '';
        }
    },
    'format' => 'raw',
],
// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
'bank',
// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
[
    'class' => yii\grid\DataColumn::className(),
    'attribute' => 'status_id',
    'value' => function ($model) {
        if ($rel = $model->status) {
            return Html::a($rel->name, ['status/view', 'id' => $rel->id,], ['data-pjax' => 0]);
        } else {
            return '';
        }
    },
    'format' => 'raw',
],
]
])
 . '</div>' ?>
<?php Pjax::end() ?>
<?php $this->endBlock() ?>


            <?= Tabs::widget(
                 [
                     'id' => 'relation-tabs',
                     'encodeLabels' => false,
                     'items' => [ [
    'label'   => '<b class=""># '.$model->nama_pendanaan.'</b>',
    'content' => $this->blocks['app\models\Pendanaan'],
    'active'  => true,
],[
    'content' => $this->blocks['Pembayarans'],
    'label'   => '<small>Pembayarans <span class="badge badge-default">'.count($model->getPembayarans()->asArray()->all()).'</span></small>',
    'active'  => false,
], ]
                 ]
    );
    ?>
        </div>
    </div>
</div>
