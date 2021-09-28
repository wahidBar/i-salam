<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "setting".
 *
 * @property integer $id
 * @property integer $pin
 * @property string $logo
 * @property string $bg_login
 * @property string $bg_pin
 * @property string $link_download_apk
 * @property string $nama_web
 * @property string $alamat
 * @property string $slogan_web
 * @property string $aliasModel
 */
abstract class Setting extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pin'], 'integer'],
            [['nama_web','judul_web', 'alamat', 'slogan_web'], 'required'],
            [['alamat', 'slogan_web','tentang_kami','visi','misi'], 'string'],
            [['logo', 'bg_login', 'bg_pin', 'link_download_apk', 'link_download_apk_marketing', 'nama_web','latitude','longitude','facebook','twitter','instagram'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pin' => 'PIN (nomor)',
            'logo' => 'Logo',
            'bg_login' => 'Background Login',
            'bg_pin' => 'Background PIN',
            'link_download_apk' => 'Link Download Apk',
            'link_download_apk_marketing' => 'Link Download Marketing',
            'nama_web' => 'Nama Web',
            'judul_web' => 'Judul Web',
            'alamat' => 'Alamat',
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'visi' => 'Visi',
            'misi' => 'Misi',
            'instagram' => 'Instagran',
            'tentang_kami' => 'Tentang Kami',
            'slogan_web' => 'Slogan Web',
        ];
    }




}
