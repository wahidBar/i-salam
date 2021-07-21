<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "partner_pendanaan".
 *
 * @property integer $id
 * @property string $nama_partner
 * @property integer $pendanaan_id
 * @property string $foto_ktp_partner
 *
 * @property \app\models\Pendanaan $pendanaan
 * @property string $aliasModel
 */
abstract class PartnerPendanaan extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partner_pendanaan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_partner', 'pendanaan_id'], 'required'],
            [['pendanaan_id'], 'integer'],
            [['nama_partner', 'foto_ktp_partner'], 'string', 'max' => 255],
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
            'nama_partner' => 'Nama Partner',
            'pendanaan_id' => 'Pendanaan ID',
            'foto_ktp_partner' => 'Foto Ktp Partner',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPendanaan()
    {
        return $this->hasOne(\app\models\Pendanaan::className(), ['id' => 'pendanaan_id']);
    }




}
