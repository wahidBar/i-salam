<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "berita".
 *
 * @property integer $id
 * @property integer $kategori_berita_id
 * @property integer $user_id
 * @property string $judul
 * @property string $gambar
 * @property string $isi
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \app\models\KategoriBerita $kategoriBerita
 * @property \app\models\User $user
 * @property string $aliasModel
 */
abstract class Berita extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'berita';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => date("Y-m-d H:i:s"),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kategori_berita_id', 'user_id', 'judul', 'slug','gambar', 'isi'], 'required'],
            [['kategori_berita_id', 'user_id'], 'integer'],
            [['isi'], 'string'],
            [['judul', 'gambar'], 'string', 'max' => 255],
            [['kategori_berita_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\KategoriBerita::className(), 'targetAttribute' => ['kategori_berita_id' => 'id']],
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
            'kategori_berita_id' => 'Kategori Berita ID',
            'user_id' => 'User ID',
            'judul' => 'Judul',
            'gambar' => 'Gambar',
            'isi' => 'Isi',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKategoriBerita()
    {
        return $this->hasOne(\app\models\KategoriBerita::className(), ['id' => 'kategori_berita_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'user_id']);
    }




}
