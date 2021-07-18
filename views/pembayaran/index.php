<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
* @var app\models\search\PembayaranSearch $searchModel
*/

$this->title = 'Pembayaran';
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <?= Html::a('<i class="fa fa-plus"></i> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
</p>


    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <div class="box box-info">
        <div class="box-body">
            <div class="table-responsive">
                <?= GridView::widget([
                'layout' => '{summary}{pager}{items}{pager}',
                'dataProvider' => $dataProvider,
                'pager'        => [
                'class'          => yii\widgets\LinkPager::className(),
                'firstPageLabel' => 'First',
                'lastPageLabel'  => 'Last'                ],
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
                'headerRowOptions' => ['class'=>'x'],
                'columns' => [

                \app\components\ActionButton::getButtons(),

			'nominal',
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
    'pendanaan',
			// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
// [
//     'class' => yii\grid\DataColumn::className(),
//     'attribute' => ,
//     'value' => function ($model) {
//         if ($rel = $model->pendanaan) {
//             return Html::a($rel->id, ['pendanaan/view', 'id' => $rel->id,], ['data-pjax' => 0]);
//         } else {
//             return '';
//         }
//     },
//     'format' => 'raw',
// ],
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
			'nama',
			/*'bukti_transaksi'*/
                ],
                ]); ?>
            </div>
        </div>
    </div>

    <?php \yii\widgets\Pjax::end() ?>

