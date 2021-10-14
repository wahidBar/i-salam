<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use kartik\file\FileInput;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;

/**
 * @var yii\web\View $this
 * @var app\models\Pendanaan $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="box box-info">
    <div class="box-body">
        <?php $form = ActiveForm::begin(
            [
                'id' => 'Pendanaan',
                'layout' => 'horizontal',
                'enableClientValidation' => true,
                'errorSummaryCssClass' => 'error-summary alert alert-error'
            ]
        );
        ?>

        <div class="row">
            <div class="col-lg-12">
                <?= $form->field($model, 'nama_pendanaan', [
                    'template' => '
                    {label}
                    {input}
                    {error}
                    ',
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                    'labelOptions' => [
                        'class' => 'control-label'
                    ],
                    'options' => ['tag' => false]
                ])->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
            <?= $form->field($model, 'uraian', [
                    'template' => '
                    {label}
                    {input}
                    {error}
                    ',
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                    'labelOptions' => [
                        'class' => 'control-label'
                    ],
                    'options' => ['tag' => false]
                ])->textarea(['rows' => 6]) ?>
            </div>
            <div class="col-lg-6">
            <?= $form->field($model, 'deskripsi', [
                    'template' => '
                    {label}
                    {input}
                    {error}
                    ',
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                    'labelOptions' => [
                        'class' => 'control-label'
                    ],
                    'options' => ['tag' => false]
                ])->textarea(['rows' => 6]) ?>
            </div>
        </div>
            <div class="row">
            <div class="col-lg-3">
                <?= $form->field($model, 'bank_id', [
                    'template' => '
                    {label}
                    {input}
                    {error}
                    ',
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                    'labelOptions' => [
                        'class' => 'control-label'
                    ],
                    'options' => ['tag' => false]
                ])->dropDownList(
                    \yii\helpers\ArrayHelper::map(app\models\Bank::find()->all(), 'id', 'name'),
                    [
                        'prompt' => 'Select',
                        'disabled' => (isset($relAttributes) && isset($relAttributes['bank_id'])),
                    ]
                ); ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'nomor_rekening', [
                    'template' => '
                    {label}
                    {input}
                    {error}
                    ',
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                    'labelOptions' => [
                        'class' => 'control-label'
                    ],
                    'options' => ['tag' => false]
                ])->textInput(['maxlength' => true,'type'=>'number']) ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'nama_nasabah', [
                    'template' => '
                    {label}
                    {input}
                    {error}
                    ',
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                    'labelOptions' => [
                        'class' => 'control-label'
                    ],
                    'options' => ['tag' => false]
                ])->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'nama_perusahaan', [
                    'template' => '
                    {label}
                    {input}
                    {error}
                    ',
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                    'labelOptions' => [
                        'class' => 'control-label'
                    ],
                    'options' => ['tag' => false]
                ])->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <?= $form->field($model, 'nominal', [
                    'template' => '
                    {label}
                    {input}
                    {error}
                    ',
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                    'labelOptions' => [
                        'class' => 'control-label'
                    ],
                    'options' => ['tag' => false]
                ])->textInput(['type' => 'number']) ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'pendanaan_berakhir', [
                    'template' => '
                    {label}
                    {input}
                    {error}
                    ',
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                    'labelOptions' => [
                        'class' => 'control-label'
                    ],
                    'options' => ['tag' => false]
                ])->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => 'Pilih Tanggal Pendanaan Berakhir'],
                    'name' => 'event_time',
                    'readonly' => true,
                    'pluginOptions' => [
                        'format' => 'yyyy-m-d H:i:s',
                        'autocomplete' => "off",
                        'autoclose' => true,
                    ],
                ]); ?>
            </div>
            <div class="col-lg-4">
                <?= // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::activeField
                $form->field($model, 'kategori_pendanaan_id', [
                    'template' => '
                    {label}
                    {input}
                    {error}
                    ',
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                    'labelOptions' => [
                        'class' => 'control-label'
                    ],
                    'options' => ['tag' => false]
                ])->dropDownList(
                    \yii\helpers\ArrayHelper::map(app\models\KategoriPendanaan::find()->all(), 'id', 'name'),
                    [
                        'prompt' => 'Select',
                        'disabled' => (isset($relAttributes) && isset($relAttributes['kategori_pendanaan_id'])),
                    ]
                ); ?>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <?= $form->field($model, 'foto', [
                    'template' => '
                    {label}
                    {input}
                    {error}
                    ',
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                    'labelOptions' => [
                        'class' => 'control-label'
                    ],
                    'options' => ['tag' => false]
                ])->widget(FileInput::classname(), [
                    'options' => ['accept' => 'file/*'],
                    'pluginOptions' => [
                        'allowedFileExtensions' => ['png', 'jpg', 'jpeg'],
                        'maxFileSize' => 6500,
                        'showRemove' => false,
                        'showUpload' => false,
                        'showCaption' => true,
                        'dropZoneEnabled' => false,
                        'browseLabel' => 'Upload File',
                    ],
                ]); ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'foto_ktp', [
                    'template' => '
                    {label}
                    {input}
                    {error}
                    ',
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                    'labelOptions' => [
                        'class' => 'control-label'
                    ],
                    'options' => ['tag' => false]
                ])->widget(FileInput::classname(), [
                    'options' => ['accept' => 'file/*'],
                    'pluginOptions' => [
                        'allowedFileExtensions' => ['png', 'jpg', 'jpeg'],
                        'maxFileSize' => 6500,
                        'showRemove' => false,
                        'showUpload' => false,
                        'showCaption' => true,
                        'dropZoneEnabled' => false,
                        'browseLabel' => 'Upload File',
                    ],
                ]); ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'foto_kk', [
                    'template' => '
                    {label}
                    {input}
                    {error}
                    ',
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                    'labelOptions' => [
                        'class' => 'control-label'
                    ],
                    'options' => ['tag' => false]
                ])->widget(FileInput::classname(), [
                    'options' => ['accept' => 'file/*'],
                    'pluginOptions' => [
                        'allowedFileExtensions' => ['png', 'jpg', 'jpeg'],
                        'maxFileSize' => 6500,
                        'showRemove' => false,
                        'showUpload' => false,
                        'showCaption' => true,
                        'dropZoneEnabled' => false,
                        'browseLabel' => 'Upload File',
                    ],
                ]); ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'file_uraian', [
                    'template' => '
                    {label}
                    {input}
                    {error}
                    ',
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                    'labelOptions' => [
                        'class' => 'control-label'
                    ],
                    'options' => ['tag' => false]
                ])->widget(FileInput::classname(), [
                    'options' => ['accept' => 'file/*'],
                    'pluginOptions' => [
                        'allowedFileExtensions' => ['doc', 'pdf', 'docx'],
                        'maxFileSize' => 6500,
                        'showRemove' => false,
                        'showUpload' => false,
                        'showCaption' => true,
                        'dropZoneEnabled' => false,
                        'browseLabel' => 'Upload File',
                    ],
                ]); ?>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <?= $form->field($model, 'poster', [
                    'template' => '
                    {label}
                    {input}
                    {error}
                    ',
                    'inputOptions' => [
                        'class' => 'form-control'
                    ],
                    'labelOptions' => [
                        'class' => 'control-label'
                    ],
                    'options' => ['tag' => false]
                ])->widget(FileInput::classname(), [
                    'options' => ['accept' => 'file/*'],
                    'pluginOptions' => [
                        'allowedFileExtensions' => ['png', 'jpg', 'jpeg'],
                        'maxFileSize' => 6500,
                        // 'showRemove' => false,
                        // 'showUpload' => false,
                        // 'showCaption' => true,
                        // 'dropZoneEnabled' => false,
                        'browseLabel' => 'Upload File',
                    ],
                ]); ?>
            </div>
           
           
        </div>

        <hr />
        <?php echo $form->errorSummary($model); ?>
        <div class="row">
            <div class="col-md-offset-3 col-md-10">
                <?= Html::submitButton('<i class="fa fa-save"></i> Simpan', ['class' => 'btn btn-success']); ?>
                <?= Html::a('<i class="fa fa-chevron-left"></i> Kembali', ['index'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>