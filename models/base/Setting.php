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

    public function fields()
    {
        $parent = parent::fields();

        if (isset($parent['logo'])) {
            unset($parent['logo']);
            // $parent['_gambar'] = function ($model) {
            //     return $model->gambar;
            // };
            $parent['logo'] = function ($model) {
                // $file = $model->gambar;
                // // $model->tanggal_received=date('Y-m-d H:i:s');
                // return $path = "http://192.168.228.215/isalam/web/uploads/berita/" . $file;
                // return $path = $file;
                return Yii::getAlias("@file/setting/$model->logo");
            };
        }

        if (!isset($parent['website'])) {
            unset($parent['website']);
            // $parent['_website'] = function ($model) {
            //     return $model->website;
            // };
            $parent['website'] = function ($model) {

                // $model->tanggal_received=date('Y-m-d H:i:s');
                return $path = "http://i-salam.id/web/";
            };
        }

        return $parent;
    }

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
            [['nama_web', 'judul_web', 'alamat', 'slogan_web'], 'required'],
            [['alamat', 'slogan_web', 'banner', 'tentang_kami', 'visi', 'misi', 'ikut_wakaf', 'youtube_link', 'judul_video', 'deskripsi_video', 'latar_belakang', 'fiqih_wakaf', 'regulasi_wakaf', 'aturan_wakaf', 'pesan', 'text_apk'], 'string'],
            [['logo', 'bg_login', 'bg_pin', 'link_download_apk', 'link_download_apk_marketing', 'nama_web', 'phone', 'email', 'latitude', 'longitude', 'facebook', 'twitter', 'instagram', 'telegram', 'daftar_wakaf'], 'string', 'max' => 255]
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
            'ikut_wakaf' => 'Cara Ikut Wakaf',
            'bg_login' => 'Background Login',
            'bg_pin' => 'Background PIN',
            'link_download_apk' => 'Link Download Apk',
            'link_download_apk_marketing' => 'Link Download Marketing',
            'nama_web' => 'Nama Web',
            'phone' => 'Telephone',
            'email' => 'Email',
            'judul_web' => 'Judul Web',
            'alamat' => 'Alamat',
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'telegram' => 'Telegram',
            'visi' => 'Visi',
            'misi' => 'Misi',
            'instagram' => 'Instagran',
            'banner' => 'Banner',
            'tentang_kami' => 'Tentang Kami',
            'slogan_web' => 'Slogan Web',
            'youtube_link' => 'Link Youtube',
            'judul_video' => 'Judul Video',
            'deskripsi_video' => 'Deskripsi Video',
            'text_apk' => 'Text Aplikasi Wakaf',
        ];
    }
}
