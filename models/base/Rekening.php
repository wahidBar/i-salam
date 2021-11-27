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
 * @property string $nomor_rekenig
 * @property string $nama_rekening
 * @property string $jenis_rekeing
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
            [['jenis_bank', 'nomor_rekenig', 'nama_rekening', 'jenis_rekeing'], 'required'],
            [['flag'], 'integer'],
            [['jenis_bank'], 'string', 'max' => 255],
            [['nomor_rekenig'], 'string', 'max' => 20],
            [['nama_rekening', 'jenis_rekeing'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenis_bank' => 'Jenis Bank',
            'nomor_rekenig' => 'Nomor Rekenig',
            'nama_rekening' => 'Nama Rekening',
            'jenis_rekeing' => 'Jenis Rekeing',
            'flag' => 'Flag',
        ];
    }




}
