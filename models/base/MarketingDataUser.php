<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "marketing_data_user".
 *
 * @property integer $id
 * @property string $nama
 * @property string $alamat
 * @property string $domisili
 * @property integer $no_rekening
 * @property integer $bank_id
 * @property integer $user_id
 *
 * @property \app\models\Bank $bank
 * @property \app\models\User $user
 * @property string $aliasModel
 */
abstract class MarketingDataUser extends \yii\db\ActiveRecord
{

    public function fields()
    {
        $parent = parent::fields();

        


        if (isset($parent['bank_id'])) {
            unset($parent['bank_id']);
            $parent['_bank_id'] = function ($model) {
                return $model->bank_id;
            };
            $parent['bank'] = function ($model) {
                return $model->bank;
            };
        }


        return $parent;
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'marketing_data_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_rekening', 'bank_id', 'user_id'], 'integer'],
            [['bank_id', 'user_id'], 'required'],
            [['nama', 'alamat', 'domisili','no_identitas','referensi_kerja'], 'string', 'max' => 255],
            [['bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Bank::className(), 'targetAttribute' => ['bank_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\User::className(), 'targetAttribute' => ['user_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'no_identitas' => 'No Identitas',
            'referensi_kerja' => 'Referensi Kerja',
            'domisili' => 'Domisili',
            'no_rekening' => 'No Rekening',
            'bank_id' => 'Bank',
            'user_id' => 'User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBank()
    {
        return $this->hasOne(\app\models\Bank::className(), ['id' => 'bank_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'user_id']);
    }




}
