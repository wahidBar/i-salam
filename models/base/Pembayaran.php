<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the base-model class for table "pembayaran".
 *
 * @property integer $id
 * @property string $nama
 * @property integer $nominal
 * @property string $bukti_transaksi
 * @property integer $user_id
 * @property string $bank
 * @property integer $pendanaan_id
 * @property string $tanggal_pembayaran
 * @property integer $status_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \app\models\Status $status
 * @property \app\models\User $user
 * @property \app\models\Pendanaan $pendanaan
 * @property string $aliasModel
 */
abstract class Pembayaran extends \yii\db\ActiveRecord
{

    public function fields()
    {
        $parent = parent::fields();

        


       

        if (isset($parent['pendanaan_id'])) {
            unset($parent['pendanaan_id']);
            
            $parent['pendanaan'] = function ($model) {
                return $model->pendanaan;
            };
        }

        if (isset($parent['status_id'])) {
            unset($parent['status_id']);
            
            $parent['status'] = function ($model) {
                return $model->status;
            };
        }
        if (isset($parent['jenis_pembayaran_id'])) {
            unset($parent['jenis_pembayaran_id']);
            
            $parent['jenis_pembayaran'] = function ($model) {
                return $model->jenisPembayaran;
            };
        }

        
        return $parent;
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pembayaran';
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
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'nominal', 'kode_transaksi', 'user_id', 'jenis_pembayaran_id', 'pendanaan_id', 'status_id'], 'required'],
            [['nominal', 'user_id', 'pendanaan_id', 'status_id'], 'integer'],
            [['tanggal_upload_bukti', 'tanggal_konfirmasi'], 'safe'],
            [['nama', 'bukti_transaksi'], 'string', 'max' => 255],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Status::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['pendanaan_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Pendanaan::className(), 'targetAttribute' => ['pendanaan_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_transaksi' => 'Kode Transaksi',
            'nama' => 'Nama',
            'nominal' => 'Nominal',
            'jenis_pembayaran_id' => 'Jenis Pembayaran',
            'bukti_transaksi' => 'Bukti Transaksi',
            'user_id' => 'Pewakaf',
            'pendanaan_id' => 'Pendanaan',
            'tanggal_upload_bukti' => 'Tanggal Upload Bukti',
            'tanggal_konfirmasi' => 'Tanggal Konfirmasi',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status_id' => 'Status',
        ];
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
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'user_id']);
    }

    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPendanaan()
    {
        return $this->hasOne(\app\models\Pendanaan::className(), ['id' => 'pendanaan_id']);
    }

    public function getJenisPembayaran()
    {
        return $this->hasOne(\app\models\JenisPembayaran::className(), ['id' => 'jenis_pembayaran_id']);
    }




}
