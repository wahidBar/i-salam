<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "agenda_pendanaan".
 *
 * @property integer $id
 * @property integer $pendanaan_id
 * @property string $nama_agenda
 * @property string $tanggal
 *
 * @property \app\models\Pendanaan $pendanaan
 * @property string $aliasModel
 */
abstract class AgendaPendanaan extends \yii\db\ActiveRecord
{

    public function fields()
    {
        $parent = parent::fields();




        if (isset($parent['pendanaan_id'])) {
            unset($parent['pendanaan_id']);
            // $parent['_user_id'] = function ($model) {
            //     return $model->user_id;
            // };
            $parent['pendanaan'] = function ($model) {
                return $model->pendanaan;
            };
        }



        return $parent;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agenda_pendanaan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pendanaan_id', 'nama_agenda', 'tanggal'], 'required'],
            [['pendanaan_id'], 'integer'],
            [['tanggal'], 'safe'],
            [['nama_agenda'], 'string', 'max' => 255],
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
            'pendanaan_id' => 'Pendanaan',
            'nama_agenda' => 'Nama Agenda',
            'tanggal' => 'Tanggal',
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
