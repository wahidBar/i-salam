<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use kartik\file\FileInput;

/**
 * @var yii\web\View $this
 * @var app\models\PartnerPendanaan $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="box box-info">
    <div class="box-body">
        <?php $form = ActiveForm::begin(
            [
                'id' => 'PartnerPendanaan',
                'layout' => 'horizontal',
                'enableClientValidation' => true,
                'errorSummaryCssClass' => 'error-summary alert alert-error'
            ]
        );
        ?>
        <?= $form->field($model, 'nama_partner')->textInput(['maxlength' => true]) ?>
        <?= // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::activeField
        $form->field($model, 'pendanaan_id')->widget(\kartik\select2\Select2::classname(), [
            'name' => 'class_name',
            'model' => $model,
            'data' => \yii\helpers\ArrayHelper::map(app\models\Pendanaan::find()->where(['status_id'=>2])->all(), 'id', 'nama_pendanaan'),
            'options' => [
                'placeholder' => $model->getAttributeLabel('pendanaan_id'),
                'multiple' => false,
                'disabled' => (isset($relAttributes) && isset($relAttributes['pendanaan_id'])),
            ]
        ]); ?>
        <?= $form->field($model, 'foto_ktp_partner')
        ->widget(FileInput::classname(), [
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