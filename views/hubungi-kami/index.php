<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\HubungiKamiSearch $searchModel
 */

$this->title = 'Hubungi Kami';
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
                    'nomor_hp',
                    // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
                    [
                        'class' => yii\grid\DataColumn::className(),
                        'attribute' => 'tema_hubungi_kami_id',
                        'value' => function ($model) {
                            if ($rel = $model->temaHubungiKami) {
                                return Html::a($rel->nama_tema, ['tema-hubungi-kami/view', 'id' => $rel->id,], ['data-pjax' => 0]);
                            } else {
                                return '';
                            }
                        },
                        'format' => 'raw',
                    ],
                    [
                        'class' => yii\grid\DataColumn::className(),
                        'attribute' => 'status',
                        'value' => function ($model) {
                            if ($model->status == 0) {
                                return "Baru";
                            }
                            if ($model->status == 1) {
                                return "Sudah Dihubungi";
                            }
                             else {
                                return '';
                            }
                        },
                        'format' => 'raw',
                    ],
                    \app\components\ActionHubungiButton::getButtons(),
                ],
            ]); ?>
        </div>
    </div>
</div>

<?php \yii\widgets\Pjax::end() ?>