<?php

use app\models\KategoriPendanaan;
use app\models\Status;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\web\View;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
* @var app\models\search\PendanaanSearch $searchModel
*/

$this->title = 'Pendanaan';
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
    'id' => 'modal-export',
    'header' => '<h2 id="modal_title" class="text-center">Export Data</h2>',
]);

echo $this->render('_export');

Modal::end();

$this->registerCss(".modal-content{border-radius: 10px}");
?>

<p>
    <?= Html::a('<i class="fa fa-plus"></i> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
    <?=Html::button('Export Data', ['class' => 'btn btn-success','onclick' => new JsExpression("
	$('#modal-export').modal({show: true});
								")])?>
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
                
                'nama_pendanaan',
                // 'uraian:ntext',
                [
                    'attribute' => 'nominal',
                    'label' => 'Nominal',
                    'format' => 'raw',
                    'filter' => false,
                    'value' =>function ($model) {
            
                        return \app\components\Angka::toReadableHarga($model->nominal);
                
                    },
                ],
			// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
            [
                'attribute'=>'user_id',

                'filter'    => false,
                'value' => function($model){
                    return $model->user->name;
                }
            ],
			// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
            [
                'attribute'=>'kategori_pendanaan_id',
                'filter'    => ArrayHelper::map(KategoriPendanaan::find()->all(), 'id', 'name'),
                'value' => function($model){
                    return $model->kategoriPendanaan->name;
                }
            ],
            
            // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::attributeFormat
            [
                'attribute'=>'status_id',
                'format' => 'html',
                'filter'    => ArrayHelper::map(Status::find()->where(['like', 'name', 'pendanaan'])->all(), 'id', 'name'),
                'value' => function($model){
                    if($model->status == 1){
                        return '<span class="label label-warning">'.$model->status->name.'</span>';    
                    }
                    elseif($model->status == 2){
                        return '<span class="label label-success">'.$model->status->name.'</span>';    
                    }
                    elseif($model->status == 3){
                        return '<span class="label label-success">'.$model->status->name.'</span>';    
                    }
                    elseif($model->status == 4){
                        return '<span class="label label-success">'.$model->status->name.'</span>';    
                    }
                    elseif($model->status == 7){
                        return '<span class="label label-danger">'.$model->status->name.'</span>';    
                    }
                    elseif($model->status == 9){
                        return '<span class="label label-warning">'.$model->status->name.'</span>';    
                    }
                    elseif($model->status == 11){
                        return '<span class="label label-success">'.$model->status->name.'</span>';    
                    }
                }
            ],
            [
                'attribute' => 'pendanaan_berakhir',
                'format' => 'raw',
                'filter' => false,
                'value' => function ($model) {
                    return \app\components\Tanggal::toReadableDate($model->pendanaan_berakhir);
                }
            ],
            
            \app\components\ActionApproveButton::getButtons(),
            \app\components\ActionApproveButton::getButtonsTampil(),
			/*'foto'*/
                ],
                ]); ?>
            </div>
        </div>
    </div>

    <?php \yii\widgets\Pjax::end() ?>

