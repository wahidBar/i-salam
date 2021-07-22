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
 * @property integer $marketing_id
 * @property string $bank
 * @property integer $pendanaan_id
 * @property string $tanggal_pembayaran
 * @property integer $status_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \app\models\Status $status
 * @property \app\models\User $user
 * @property \app\models\User $marketing
 * @property \app\models\Pendanaan $pendanaan
 * @property string $aliasModel
 */
abstract class Pembayaran extends \yii\db\ActiveRecord
{

    public function fields()
    {
        $parent = parent::fields();

        


        if (isset($parent['marketing_id'])) {
            unset($parent['marketing_id']);
            
            $parent['marketing'] = function ($model) {
                return $model->marketing;
            };
        }

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
            [['nama', 'nominal', 'user_id', 'bank', 'pendanaan_id', 'tanggal_pembayaran', 'status_id'], 'required'],
            [['nominal', 'user_id', 'marketing_id', 'pendanaan_id', 'status_id'], 'integer'],
            [['tanggal_pembayaran'], 'safe'],
            [['nama', 'bukti_transaksi', 'bank'], 'string', 'max' => 255],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Status::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['marketing_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\User::className(), 'targetAttribute' => ['marketing_id' => 'id']],
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
            'nama' => 'Nama',
            'nominal' => 'Nominal',
            'bukti_transaksi' => 'Bukti Transaksi',
            'user_id' => 'Pewakaf',
            'marketing_id' => 'Marketing',
            'bank' => 'Bank',
            'pendanaan_id' => 'Pendanaan',
            'tanggal_pembayaran' => 'Tanggal Pembayaran',
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
    public function getMarketing()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'marketing_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPendanaan()
    {
        return $this->hasOne(\app\models\Pendanaan::className(), ['id' => 'pendanaan_id']);
    }




}
