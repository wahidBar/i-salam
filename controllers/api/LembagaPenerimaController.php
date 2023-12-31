<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "LembagaPenerimaController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class LembagaPenerimaController extends \yii\rest\ActiveController
{
    public function behaviors()
    {
        $parent = parent::behaviors();
        $parent['authentication'] = [
            "class" => "\app\components\CustomAuth",
            "only" => ["create", "update", "delete","index"],
        ];

        return $parent;
    }
public $modelClass = 'app\models\LembagaPenerima';
}
