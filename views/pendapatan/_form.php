<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;

/**
 * @var yii\web\View $this
 * @var app\models\Pendapatan $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="box box-info">
    <div class="box-body">
        <?php $form = ActiveForm::begin(
            [
                'id' => 'Pendapatan',
                'layout' => 'horizontal',
                'enableClientValidation' => true,
                'errorSummaryCssClass' => 'error-summary alert alert-error'
            ]
        );
        ?>

        <!-- <?= $form->field($model, 'id')->textInput() ?> -->
        <?= // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::activeField
        $form->field($model, 'id_pendanaan')->dropDownList(
            \yii\helpers\ArrayHelper::map(app\models\Pendanaan::find()->where(['status_lembaran' => 1])->all(), 'id', 'nama_pendanaan'),
            [
                'prompt' => 'Select',
                'disabled' => (isset($relAttributes) && isset($relAttributes['id_pendanaan'])),
            ]
        ); ?>
        <?= $form->field($model, 'nominal', [])->widget(\yii\widgets\MaskedInput::className(), [
            'name' => 'input-33',
            'clientOptions' => [
                'alias' =>  'decimal',
                'groupSeparator' => ',',
                'autoGroup' => true
            ],

        ])->label('Nominal Pendapatan'); ?>
        <!-- <?= $form->field($model, 'nominal')->textInput(['maxlength' => true]) ?> -->
        <!-- <?= $form->field($model, 'created_at')->textInput() ?> -->
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