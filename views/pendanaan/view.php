<?php

use dmstr\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
// var_dump("Tes");die;
/**
 * @var yii\web\View $this
 * @var app\models\Pendanaan $model
 */

$this->title = 'Pendanaan ' . $model->nama_pendanaan;
?>
<div class="giiant-crud pendanaan-view">

    <!-- menu buttons -->
    <p class='pull-left'>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
        <!-- <?= Html::a("<i class='fa fa-download'></i>" . ' Akad/Ikrar Wakaf', ['cetak'],[
                                "class"=>"btn btn-primary",
                                "title"=>"Unduh File",
                                'target' => '_blank',
                                "data-confirm" => "Apakah Anda akan mengunduh File ini ?",
                            ]); ?> -->
    </p>
    <p class="pull-right">
        <?= Html::a('<span class="glyphicon glyphicon-list"></span> ' . 'Daftar Pendanaan', ['index'], ['class' => 'btn btn-default']) ?>
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
                    'tempat',
                    'penerima_wakaf',
                    [
                        'attribute' => 'deskripsi',
                        'format' => 'html',
                    ],
                    [
                        'attribute' => 'nominal',
                        'label' => 'Nominal',
                        'format' => 'raw',
                        'filter' => false,
                        'value' => function ($model) {

                            return \app\components\Angka::toReadableHarga($model->nominal);
                        },
                    ],
                    [
                        'attribute' => 'nominal_lembaran',
                        'label' => 'Nominal per Lembar',
                        'format' => 'raw',
                        'filter' => false,
                        'value' => function ($model) {

                            return \app\components\Angka::toReadableHarga($model->nominal_lembaran);
                        },
                    ],
                    [
                        'attribute' => 'jumlah_lembaran',
                        'format' => 'raw',
                        'filter' => false,
                        'value' => function ($model) {

                            return $model->jumlah_lembaran." Lembar";
                        },
                    ],
                    [
                        'attribute' => 'bank_id',
                        'value' => function ($model) {
                            return $model->bank->name;
                        }
                    ],
                    'nomor_rekening',
                    'nama_nasabah',
                    'nama_perusahaan',
                    [
                        'attribute' => 'pendanaan_berakhir',
                        'format' => 'raw',
                        'filter' => false,
                        'value' => function ($model) {
                            return \app\components\Tanggal::toReadableDate($model->pendanaan_berakhir);
                        }
                    ],
                    // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::attributeFormat

                    [
                        'attribute' => 'user_id',
                        'value' => function ($model) {
                            return $model->user->name;
                        }
                    ],
                    // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::attributeFormat

                    [
                        'attribute' => 'kategori_pendanaan_id',
                        'value' => function ($model) {
                            return $model->kategoriPendanaan->name;
                        }
                    ],
                    // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::attributeFormat
                    // [
                    //     'attribute' => 'status_id',
                    //     'value' => function ($model) {
                    //         return $model->status->name;
                    //     }
                    // ],
                    [
                        'class' => yii\grid\DataColumn::className(),
                        'attribute' => 'status_id',
                        'format' => 'raw',
                        'header' => 'Expired',
                        'value' => function ($model) {
                            return '<span class="label label-success">'.$model->status->name.'</span>';
                            // if ($model->status_lembaran == 1) {

                            // } else {
                            //     return '<span class="label label-danger">Lembaran Tidak Aktif</span>';
                            // }
                        }
                    ],
                    [
                        'class' => yii\grid\DataColumn::className(),
                        'attribute' => 'status_lembaran',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->status_lembaran == 1) {

                                return '<span class="label label-success">Lembaran Aktif</span>';
                            } else {
                                return '<span class="label label-danger">Lembaran Tidak Aktif</span>';
                            }
                        }
                    ],
                    [
                        'class' => yii\grid\DataColumn::className(),
                        'attribute' => 'is_wakaf',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->is_wakaf == 1) {

                                return '<span class="label label-success">Wakaf Aktif</span>';
                            } else {
                                return '<span class="label label-danger">Wakaf Tidak Aktif</span>';
                            }
                        }
                    ],
                    [
                        'class' => yii\grid\DataColumn::className(),
                        'attribute' => 'is_zakat',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->is_zakat == 1) {

                                return '<span class="label label-success">Zakat Aktif</span>';
                            } else {
                                return '<span class="label label-danger">Zakat Tidak Aktif</span>';
                            }
                        }
                    ],
                    [
                        'class' => yii\grid\DataColumn::className(),
                        'attribute' => 'is_infak',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->is_infak == 1) {

                                return '<span class="label label-success">Infak Aktif</span>';
                            } else {
                                return '<span class="label label-danger">Infak Tidak Aktif</span>';
                            }
                        }
                    ],
                    [
                        'class' => yii\grid\DataColumn::className(),
                        'attribute' => 'is_sedekah',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->is_sedekah == 1) {

                                return '<span class="label label-success">Sedekah Aktif</span>';
                            } else {
                                return '<span class="label label-danger">Sedekah Tidak Aktif</span>';
                            }
                        }
                    ],
                    [
                        'attribute' => 'foto',
                        'format' => 'html',
                        'value' => function ($model) {
                            return Html::img(\Yii::$app->request->BaseUrl . '/uploads/' . $model->foto, ['width' => 100]);
                        },
                    ],
                    [
                        'attribute' => 'foto_ktp',
                        'format' => 'html',
                        'value' => function ($model) {
                            return Html::img(\Yii::$app->request->BaseUrl . '/uploads/' . $model->foto_ktp, ['width' => 100]);
                        },
                    ],
                    [
                        'attribute' => 'foto_kk',
                        'format' => 'html',
                        'value' => function ($model) {
                            return Html::img(\Yii::$app->request->BaseUrl . '/uploads/' . $model->foto_kk, ['width' => 100]);
                        },
                    ],
                    [
                        'attribute' => 'poster',
                        'format' => 'html',
                        'value' => function ($model) {
                            return Html::img(\Yii::$app->request->BaseUrl . '/uploads/' . $model->poster, ['width' => 100]);
                        },
                    ],
                    [
                        'attribute' => 'File Uraian',
                        'header'=> 'Download File Uraian',
                        'format' =>'raw',
                        'value' => function($model){
                            if($model->file_uraian != null){
                               return Html::a("<i class='fa fa-download'></i>" . ' Download File Unduhan', ['unduh-file-uraian', 'id' => $model->id],[
                                "class"=>"btn btn-primary",
                                "title"=>"Unduh File",
                                "data-confirm" => "Apakah Anda akan mengunduh File ini ?",
                            ]);
                            }else{
                                return "Belum Upload File";
                            }
                        }
                    ],
                ],
            ]); ?>

            <hr />

            <?= Html::a(
                '<span class="glyphicon glyphicon-trash"></span> ' . 'Delete',
                ['delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'data-confirm' => '' . 'Are you sure to delete this item?' . '',
                    'data-method' => 'post',
                ]
            ); ?>
            <?php $this->endBlock(); ?>



            <?php $this->beginBlock('Pembayarans'); ?>
            <div style='position: relative'>
                <div style='position:absolute; right: 0px; top :0px;'>

                </div>
            </div><?php Pjax::begin(['id' => 'pjax-Pembayarans', 'enableReplaceState' => false, 'linkSelector' => '#pjax-Pembayarans ul.pagination a, th a', 'clientOptions' => ['pjax:success' => 'function(){alert("yo")}']]) ?>
            <?= '<div class="table-responsive">'
                . \yii\grid\GridView::widget([
                    'layout' => '{summary}{pager}<br/>{items}{pager}',
                    'dataProvider' => new \yii\data\ActiveDataProvider([
                        'query' => $model->getPembayarans(),
                        'pagination' => [
                            'pageSize' => 20,
                            'pageParam' => 'page-pembayarans',
                        ]
                    ]),
                    'pager'        => [
                        'class'          => yii\widgets\LinkPager::className(),
                        'firstPageLabel' => 'First',
                        'lastPageLabel'  => 'Last'
                    ],
                    'columns' => [
                        // [
                        //     'class'      => 'yii\grid\ActionColumn',
                        //     'template'   => '{view} {update}',
                        //     'contentOptions' => ['nowrap' => 'nowrap'],
                        //     'urlCreator' => function ($action, $model, $key, $index) {
                        //         // using the column name as key, not mapping to 'id' like the standard generator
                        //         $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                        //         $params[0] = 'pembayaran' . '/' . $action;
                        //         $params['Pembayaran'] = ['pendanaan_id' => $model->primaryKey()[0]];
                        //         return $params;
                        //     },
                        //     'buttons'    => [],
                        //     'controller' => 'pembayaran'
                        // ],
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
                        [
                            'attribute' => 'bukti_transaksi',
                            'format' => 'html',
                            'value' => function ($model) {
                                return Html::img(\Yii::$app->request->BaseUrl . '/uploads/pembayaran/bukti_transaksi/' . $model->bukti_transaksi, ['width' => 100]);
                            },
                        ],
                        
                        // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
                        [
                            'class' => yii\grid\DataColumn::className(),
                            'attribute' => 'user_id',
                            'label' => 'User',
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
                        // [
                        //     'class' => yii\grid\DataColumn::className(),
                        //     'attribute' => 'marketing_id',
                        //     'value' => function ($model) {
                        //         if ($rel = $model->marketing) {
                        //             return Html::a($rel->name, ['user/view', 'id' => $rel->id,], ['data-pjax' => 0]);
                        //         } else {
                        //             return '';
                        //         }
                        //     },
                        //     'format' => 'raw',
                        // ],
                        // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
                        // 'bank',
                        // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
                        [
                            'class' => yii\grid\DataColumn::className(),
                            'attribute' => 'status_id',
                            'value' => function ($model) {
                                if ($rel = $model->status) {
                                    // return Html::a($rel->name, ['status/view', 'id' => $rel->id,], ['data-pjax' => 0]);
                                    return $rel->name;
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
            <?php $this->beginBlock('Amanahs'); ?>
            <div style='position: relative'>
                <div style='position:absolute; right: 0px; top :0px;'>
                <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . 'Tambah Baru' . ' Amanah Pendanaan',
            ['amanah-pendanaan/create', 'Amanahs' => ['pendanaan_id' => $model->id]],
            ['class'=>'btn btn-success btn-xs']
        ); ?>
                </div>
            </div><?php Pjax::begin(['id' => 'pjax-Amanahs', 'enableReplaceState' => false, 'linkSelector' => '#pjax-Amanahs ul.pagination a, th a', 'clientOptions' => ['pjax:success' => 'function(){alert("yo")}']]) ?>
            <?= '<div class="table-responsive">'
                . \yii\grid\GridView::widget([
                    'layout' => '{summary}{pager}<br/>{items}{pager}',
                    'dataProvider' => new \yii\data\ActiveDataProvider([
                        'query' => $model->getAmanahs(),
                        'pagination' => [
                            'pageSize' => 20,
                            'pageParam' => 'page-Amanahs',
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
                            'template'   => '{update} {delete}',
                            'contentOptions' => ['nowrap' => 'nowrap'],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                // using the column name as key, not mapping to 'id' like the standard generator
                                $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                                $params[0] = 'amanah-pendanaan' . '/' . $action;
                                $params['AmanahPendanaan'] = ['pendanaan_id' => $model->primaryKey()[0]];
                                return $params;
                            },
                            'buttons'    => [],
                            'controller' => 'amanah-pendanaan'
                        ],
                        'amanah:ntext',
                    ]
                ])
                . '</div>' ?>
            <?php Pjax::end() ?>
            <?php $this->endBlock() ?>

            <?= Tabs::widget(
                [
                    'id' => 'relation-tabs',
                    'encodeLabels' => false,
                    'items' => [[
                        'label'   => '<b class=""># ' . $model->nama_pendanaan . '</b>',
                        'content' => $this->blocks['app\models\Pendanaan'],
                        'active'  => true,
                    ], [
                        'content' => $this->blocks['Pembayarans'],
                        'label'   => '<small>Pembayarans <span class="badge badge-default">' . count($model->getPembayarans()->asArray()->all()) . '</span></small>',
                        'active'  => false,
                    ],[
                        'content' => $this->blocks['Amanahs'],
                        'label'   => '<small>Amanah Pendanaan <span class="badge badge-default">' . count($model->getAmanahs()->asArray()->all()) . '</span></small>',
                        'active'  => false,
                    ],]
                ]
            );
            ?>
        </div>
    </div>
</div>