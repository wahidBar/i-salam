<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "slides".
 *
 * @property integer $id
 * @property string $judul
 * @property string $sub_judul
 * @property string $gambar
 * @property integer $status
 * @property string $aliasModel
 */
abstract class Slides extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slides';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['judul', 'sub_judul', 'gambar'], 'required'],
            [['status'], 'integer'],
            [['judul', 'sub_judul', 'gambar'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'judul' => 'Judul',
            'sub_judul' => 'Sub Judul',
            'gambar' => 'Gambar',
            'status' => 'Status',
        ];
    }




}
