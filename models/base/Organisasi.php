<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "organisasi".
 *
 * @property integer $id
 * @property string $nama
 * @property string $jabatan
 * @property string $quotes
 * @property integer $flag
 * @property string $aliasModel
 */
abstract class Organisasi extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organisasi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'jabatan'], 'required'],
            [['quotes'], 'string'],
            [['flag'], 'integer'],
            [['nama', 'jabatan','foto'], 'string', 'max' => 255]
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
            'jabatan' => 'Jabatan',
            'foto' => "Foto",
            'quotes' => 'Quotes',
            'flag' => 'Status',
        ];
    }




}
