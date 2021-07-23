<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "notifikasi".
 *
 * @property integer $id
 * @property string $message
 * @property string $date
 * @property integer $flag
 * @property integer $user_id
 *
 * @property \app\models\User $user
 * @property string $aliasModel
 */
abstract class Notifikasi extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notifikasi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message', 'date', 'flag', 'user_id'], 'required'],
            [['message'], 'string'],
            [['date'], 'safe'],
            [['flag', 'user_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\User::className(), 'targetAttribute' => ['user_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'date' => 'Date',
            'flag' => 'Flag',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\User::className(), ['id' => 'user_id']);
    }




}