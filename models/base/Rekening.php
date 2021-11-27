<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "rekening".
 *
 * @property integer $id
 * @property string $jenis_bank
 * @property string $nomor_rekening
 * @property string $nama_rekening
 * @property string $jenis_rekening
 * @property integer $flag
 * @property string $aliasModel
 */
abstract class Rekening extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rekening';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jenis_bank', 'nomor_rekening', 'nama_rekening', 'jenis_rekening'], 'required'],
            [['flag'], 'integer'],
            [['jenis_bank'], 'string', 'max' => 255],
            [['nomor_rekening'], 'string', 'max' => 20],
            [['nama_rekening', 'jenis_rekening'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenis_bank' => 'Bank Rekening',
            'nomor_rekening' => 'Nomor Rekening',
            'nama_rekening' => 'Nama Rekening',
            'jenis_rekening' => 'Jenis Rekening',
            'flag' => 'Status',
        ];
    }




}
