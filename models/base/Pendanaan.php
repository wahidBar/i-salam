<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use app\models\AgendaPendanaan;
use app\models\PartnerPendanaan;
/**
 * This is the base-model class for table "pendanaan".
 *
 * @property integer $id
 * @property string $nama_pendanaan
 * @property string $foto
 * @property string $uraian
 * @property integer $nominal
 * @property string $pendanaan_berakhir
 * @property integer $user_id
 * @property integer $kategori_pendanaan_id
 * @property integer $status_id
 *
 * @property \app\models\Pembayaran[] $pembayarans
 * @property \app\models\KategoriPendanaan $kategoriPendanaan
 * @property \app\models\User $user
 * @property \app\models\Status $status
 * @property string $aliasModel
 */
abstract class Pendanaan extends \yii\db\ActiveRecord
{

    public $noms;
    public function fields()
    {
        $parent = parent::fields();

        

        if (isset($parent['foto'])) {
            unset($parent['foto']);
            $parent['foto'] = function ($model) {
                return Yii::getAlias("@file/$model->foto");
            };
        }
        if (isset($parent['user_id'])) {
            unset($parent['user_id']);
            // $parent['_user_id'] = function ($model) {
            //     return $model->user_id;
            // };
            $parent['user'] = function ($model) {
                return $model->user->name;
            };
        }

        if (isset($parent['kategori_pendanaan_id'])) {
            unset($parent['kategori_pendanaan_id']);
            // $parent['_kategori_pendanaan_id'] = function ($model) {
            //     return $model->kategori_pendanaan_id;
            // };
            $parent['kategori_pendanaaan'] = function ($model) {
                return $model->kategoriPendanaan;
            };
        }

        if (isset($parent['status_id'])) {
            unset($parent['status_id']);
            // $parent['_status_id'] = function ($model) {
            //     return $model->status_id;
            // };
            $parent['status'] = function ($model) {
                return $model->status;
            };
            
        }

        if (isset($parent['bank_id'])) {
            unset($parent['bank_id']);
            // $parent['_bank_id'] = function ($model) {
            //     return $model->bank_id;
            // };
            $parent['bank'] = function ($model) {
                return $model->bank;
            };
            
        }
        if (isset($parent['file_uraian'])) {
            unset($parent['file_uraian']);
            // $parent['_file_uraian'] = function ($model) {
            //     return $model->file_uraian;
            // };
            $parent['file_uraian'] = function ($model) {
                $file = $model->file_uraian;
                // $model->tanggal_received=date('Y-m-d H:i:s');
                return $path = Yii::getAlias("@app/web/uploads/uraian/") . $file;
            };
            
        }
        if (isset($parent['poster'])) {
            unset($parent['poster']);
            // $parent['_poster'] = function ($model) {
            //     return $model->poster;
            // };
            $parent['poster'] = function ($model) {
                $file = $model->poster;
                // $model->tanggal_received=date('Y-m-d H:i:s');
                return $path = Yii::getAlias("@app/web/uploads/poster/") . $file;
            };
            
        }
        // $file = $model->file_uraian;
        // // $model->tanggal_received=date('Y-m-d H:i:s');
        // $path = Yii::getAlias("@app/web/uploads/uraian/") . $file;
        // $arr = explode(".", $file);
        // $extension = end($arr);
        // $nama_file= "File Uraian  ".$model->nama_pendanaan.".".$extension;
        // $agenda =[];
        //     $parent['agenda'] = function($model){
        //         $list_agenda = AgendaPendanaan::find()->where(['pendanaan_id'=>$model->id])->all();
        //         return $agenda = $list_agenda;
        //     };

        //     $partner =[];
        //     $parent['partner'] = function($model){
        //         $list_partner = PartnerPendanaan::find()->where(['pendanaan_id'=>$model->id])->all();
        //         return $partner = $list_partner;
        //     };

        return $parent;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pendanaan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uraian','deskripsi'], 'string'],
            [['nominal', 'user_id', 'kategori_pendanaan_id', 'status_id','bank_id','noms','nomor_rekening'], 'integer'],
            [['pendanaan_berakhir'], 'safe'],
            [['user_id', 'kategori_pendanaan_id', 'status_id'], 'required'],
            [['nama_pendanaan', 'foto','nama_nasabah','nama_perusahaan','foto_ktp','foto_kk','file_uraian','poster'], 'string', 'max' => 255],
            [['kategori_pendanaan_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\KategoriPendanaan::className(), 'targetAttribute' => ['kategori_pendanaan_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Status::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Bank::className(), 'targetAttribute' => ['bank_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_pendanaan' => 'Nama Pendanaan',
            'foto' => 'Foto Pendanaan',
            'uraian' => 'Uraian',
            'nominal' => 'Nominal',
            'pendanaan_berakhir' => 'Pendanaan Berakhir',
            'bank_id' => 'Bank',
            'nama_nasabah' => 'Nama Nasabah',
            'nama_perusahaan' => 'Nama Perusahaan',
            'nomor_rekening' => 'Nomor Rekening',
            'noms' => 'Nominal Pencairan',
            'deskripsi' => 'Deskripsi',
            'foto_ktp' => 'Foto Ktp',
            'foto_kk' => 'Foto Kk',
            'file_uraian' => 'File Uraian',
            'user_id' => 'Pembuat',
            'kategori_pendanaan_id' => 'Kategori Pendanaan',
            'status_id' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPembayarans()
    {
        return $this->hasMany(\app\models\Pembayaran::className(), ['pendanaan_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKategoriPendanaan()
    {
        return $this->hasOne(\app\models\KategoriPendanaan::className(), ['id' => 'kategori_pendanaan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(\app\models\Status::className(), ['id' => 'status_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBank()
    {
        return $this->hasOne(\app\models\Bank::className(), ['id' => 'bank_id']);
    }




}
