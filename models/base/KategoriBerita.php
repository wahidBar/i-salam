<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "kategori_berita".
 *
 * @property integer $id
 * @property string $nama
 *
 * @property \app\models\Berita[] $beritas
 * @property string $aliasModel
 */
abstract class KategoriBerita extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kategori_berita';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 255]
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeritas()
    {
        return $this->hasMany(\app\models\Berita::className(), ['kategori_berita_id' => 'id']);
    }
}
