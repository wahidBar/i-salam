<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "RekeningController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class RekeningController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\Rekening';
}
