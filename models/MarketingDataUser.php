<?php

namespace app\models;

use Yii;
use \app\models\base\MarketingDataUser as BaseMarketingDataUser;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "marketing_data_user".
 */
class MarketingDataUser extends BaseMarketingDataUser
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
