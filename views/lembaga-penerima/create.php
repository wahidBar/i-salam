<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\LembagaPenerima $model
*/

$this->title = 'Tambah Baru';
$this->params['breadcrumbs'][] = ['label' => 'Lembaga Penerima', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <?= Html::a('Kembali', \yii\helpers\Url::previous(), ['class' => 'btn btn-default']) ?>
</p>

<?= $this->render('_form', [
'model' => $model,
]); ?>
