<?php

namespace app\models;

use Yii;
use \app\models\base\KategoriPendanaan as BaseKategoriPendanaan;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "kategori_pendanaan".
 */
class KategoriPendanaan extends BaseKategoriPendanaan
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
}
