<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "lembaga_penerima".
 *
 * @property integer $id
 * @property string $nama
 * @property string $foto
 * @property integer $flag
 * @property string $deskripsi
 * @property string $aliasModel
 */
abstract class LembagaPenerima extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lembaga_penerima';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'flag'], 'required'],
            [['flag'], 'integer'],
            [['deskripsi'], 'string'],
            [['nama', 'foto'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama Lembaga',
            'foto' => 'Foto',
            'flag' => 'Status',
            'deskripsi' => 'Deskripsi',
        ];
    }




}
