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


<?php \yii\widgets\Pjax::begin(['id' => 'pjax-main', 'enableReplaceState' => false, 'linkSelector' => '#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success' => 'function(){alert("yo")}']]) ?>

<div class="box box-info">
    <div class="box-body">
        <div class="table-responsive">
            <?= GridView::widget([
                'layout' => '{summary}{pager}{items}{pager}',
                'dataProvider' => $dataProvider,
                'pager'        => [
                    'class'          => yii\widgets\LinkPager::className(),
                    'firstPageLabel' => 'First',
                    'lastPageLabel'  => 'Last'
                ],
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
                'headerRowOptions' => ['class' => 'x'],
                'columns' => [

                    \app\components\ActionButton::getButtons(),

                    'nama',
                    [
                        'attribute' => 'nominal',
                        'label' => 'Nominal',
                        'format' => 'raw',
                        'filter' => false,
                        'value' => function ($model) {

                            return \app\components\Angka::toReadableHarga($model->nominal);
                        },
                    ],
                    // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
                    [
                        'attribute' => 'user_id',
                        'value' => function ($model) {
                            return $model->user->name;
                        }
                    ],
                    // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
                    // [
                    //     'attribute' => 'jenis_pembayaran_id',
                    //     'value' => function ($model) {
                    //         if($model->jenis_pembayaran_id != null){
                    //             return $model->jenisPembayaran->nama_jenis;
                    //         }else{
                    //             return "Belum Melakukan Pembayaran";
                    //         }
                    //     }
                    // ],
                    // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat

                    [
                        'attribute' => 'pendanaan_id',
                        'value' => function ($model) {
                            return $model->pendanaan->nama_pendanaan;
                        }
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'Tanggal Buat Pembayaran',
                        'format' => 'raw',
                        'filter' => false,
                        'value' => function ($model) {
                            return \app\components\Tanggal::toReadableDate($model->created_at);
                        }
                    ],
                    // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
                    [
                        'attribute' => 'status_id',
                        'value' => function ($model) {
                            return $model->status->name;
                        }
                    ],

                    \app\components\ActionApproveButton::getButtonsPembayaran(),
                    /*// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat

			/*'bukti_transaksi'*/
                ],
            ]); ?>
        </div>
    </div>
</div>

<?php \yii\widgets\Pjax::end() ?>