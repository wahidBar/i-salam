<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use app\models\AgendaPendanaan;
use app\models\PartnerPendanaan;
use DateTime;

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

        if (isset($parent['nominal'])) {
            unset($parent['nominal']);
            // $parent['_user_id'] = function ($model) {
            //     return $model->user_id;
            // };
            $parent['nominal'] = function ($model) {
                $nom = $model->nominal;
                return (int)$nom;
            };
        }
        if (isset($parent['jumlah_lembaran'])) {
            unset($parent['jumlah_lembaran']);
            // $parent['_user_id'] = function ($model) {
            //     return $model->user_id;
            // };
            $parent['jumlah_lembaran'] = function ($model) {
                $nom = $model->jumlah_lembaran;
                return $nom." Lembar";
            };
        }

        if (!isset($parent['sisa_lembaran'])) {
            // unset($parent['sisa_lembaran']);
            // $parent['_user_id'] = function ($model) {
            //     return $model->user_id;
            // };
            $parent['sisa_lembaran'] = function ($model) {
                $byr = \app\models\Pembayaran::find()
                ->where(['pendanaan_id' => $model->id]) 
                ->andWhere(['status_id'=>6])               
                ->sum('jumlah_lembaran');
                $nom = (int)$model->jumlah_lembaran - (int)$byr;
                return $nom." Lembar";
            };
        }

        if (isset($parent['kategori_pendanaan_id'])) {
            unset($parent['kategori_pendanaan_id']);
            // $parent['_kategori_pendanaan_id'] = function ($model) {
            //     return $model->kategori_pendanaan_id;
            // };
            $parent['kategori_pendanaan'] = function ($model) {
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
                return $path = "http://i-salam.id/web/uploads/" . $file;
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
                return $path = "http://i-salam.id/web/uploads/" . $file;
            };
            
        }
        if (!isset($parent['total_pewakaf'])) {
            unset($parent['total_pewakaf']);
            // $parent['_total_pewakaf'] = function ($model) {
            //     return $model->total_pewakaf;
            // };
            $parent['total_pewakaf'] = function ($model) {
                $pembayar =  \app\models\Pembayaran::find()->where(['pendanaan_id'=>$model->id,'status_id'=>6])->count();
                return $pembayar;
            };
            
        }
        if (!isset($parent['jumlah_pewakaf'])) {
            unset($parent['jumlah_pewakaf']);
            // $parent['_jumlah_pewakaf'] = function ($model) {
            //     return $model->jumlah_pewakaf;
            // };
            $parent['jumlah_pewakaf'] = function ($model) {
                $pembayar =  \app\models\Pembayaran::find()->where(['pendanaan_id'=>$model->id,'status_id'=>6])->count();
                return $pembayar;
            };
            
        }
        if (!isset($parent['dana_terkumpul'])) {
            unset($parent['dana_terkumpul']);
            // $parent['_dana_terkumpul'] = function ($model) {
            //     return $model->dana_terkumpul;
            // };
            $parent['dana_terkumpul'] = function ($model) {
                $pembayar =  \app\models\Pembayaran::find()->where(['pendanaan_id'=>$model->id,'status_id'=>6])->sum('nominal');
                if($pembayar != null){
                    return $pembayar;
                }else{
                    return "0";
                }
            };
            
        }
        if(!isset($parent['berakhir_dalam'])){
            unset($parent['berakhir_dalam']);

            $parent['berakhir_dalam'] = function ($model){
            $datetime1 =  new DateTime($model->pendanaan_berakhir);
            $datetime2 =  new Datetime(date("Y-m-d H:i:s"));
            $interval = $datetime1->diff($datetime2)->days;
            return $interval." Hari";
            };
        }
        if(isset($parent['created_at'])){
            unset($parent['created_at']);

            $parent['created_at'] = function ($model){
               return \app\components\Tanggal::toReadableDate($model->created_at);
            };
        }
        if(isset($parent['is_zakat'])){
            unset($parent['is_zakat']);

            $parent['is_zakat'] = function ($model){
                if($model->is_zakat == 1){
                    return true;
                }else{
                    return false;
                }
            };
        }
        if(isset($parent['is_wakaf'])){
            unset($parent['is_wakaf']);

            $parent['is_wakaf'] = function ($model){
                if($model->is_wakaf == 1){
                    return true;
                }else{
                    return false;
                }
            };
        }
        if(isset($parent['is_infak'])){
            unset($parent['is_infak']);

            $parent['is_infak'] = function ($model){
                if($model->is_infak == 1){
                    return true;
                }else{
                    return false;
                }
            };
        }
        if(isset($parent['is_sedekah'])){
            unset($parent['is_sedekah']);

            $parent['is_sedekah'] = function ($model){
                if($model->is_sedekah == 1){
                    return true;
                }else{
                    return false;
                }
            };
        }
        if(!isset($parent['link'])){
            unset($parent['link']);

            $parent['link'] = function ($model){
                $link = "https://i-salam.id/web/home/detail-program/".$model->id;
            return $link;
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
            [['user_id', 'kategori_pendanaan_id', 'status_id','bank_id','noms','status_lembaran','status_tampil','is_wakaf','is_zakat','is_infak','is_sedekah','jumlah_lembaran'], 'integer'],
            [['pendanaan_berakhir','created_at'], 'safe'],
            [['user_id', 'kategori_pendanaan_id', 'status_id'], 'required'],
            [['nama_pendanaan', 'tempat', 'penerima_wakaf', 'foto','nama_nasabah','nama_perusahaan','foto_ktp','foto_kk','file_uraian','poster','nominal','nominal_lembaran','nomor_rekening'], 'string', 'max' => 255],
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
            'status_lembaran' => 'Status Lembaran(Aktif/Tidak)',
            'status_tampil' => 'Status Tampil(Aktif/Tidak)',
            'is_wakaf' => 'Wakaf(Aktif/Tidak)',
            'is_zakat' => 'Zakat(Aktif/Tidak)',
            'is_infak' => 'Infak(Aktif/Tidak)',
            'is_sedekah' => 'Sedekah(Aktif/Tidak)',
            'nominal_lembaran' => 'Nominal Lembaran',
            'jumlah_lembaran' => 'Jumlah Lembaran',
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
            'created_at' => 'Dibuat Pada Tanggal',
            'tempat' => 'Tempat',
            'penerima_wakaf' => 'Penerima Wakaf',
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
    public function getAmanahs()
    {
        return $this->hasMany(\app\models\AmanahPendanaan::className(), ['pendanaan_id' => 'id']);
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
