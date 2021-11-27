<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "testimonials".
 *
 * @property integer $id
 * @property string $nama
 * @property string $jabatan
 * @property string $isi
 * @property string $gambar
 * @property string $aliasModel
 */
abstract class Testimonials extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'testimonials';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'jabatan', 'isi'], 'required'],
            [['isi'], 'string'],
            [['nama', 'jabatan', 'gambar'], 'string', 'max' => 255]
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
            'jabatan' => 'Email',
            'isi' => 'Isi',
            'gambar' => 'Gambar',
        ];
    }




}
