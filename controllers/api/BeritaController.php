<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "BeritaController".
*/

use app\components\ActionSendFcm;
use app\models\Berita;
use app\models\Notifikasi;
use app\models\Pembayaran;
use app\models\Pendanaan;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class BeritaController extends \yii\rest\ActiveController
{
    public function behaviors()
    {
        $parent = parent::behaviors();
        $parent['authentication'] = [
            "class" => "\app\components\CustomAuth",
            "only" => ["create", "update", "delete","index"],
        ];

        return $parent;
    }
public $modelClass = 'app\models\Berita';
protected function verbs()
    {
        return [
            'all' => ['GET'],
            'detail-berita' => ['GET'],
        ];
    }
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    public function actionAll()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $beritas = Berita::find()->all();
        return [
            "success" => true,
            "message" => "List Berita",
            "data" => $beritas,
        ];       
    }
    public function actionDetailBerita($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $beritas = Berita::findOne(['id' => $id]);

        return [
            "success" => true,
            "message" => "Detail Berita",
            "data" => $beritas,
        ];
    }
    public function actionTest(){

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $user = User::findOne(['id'=>30]);
        $beritas = Berita::findOne(['id' => 12]);
        $model = new Notifikasi();
        $model->message =" Berita Baru ";
        $model->date=date('Y-m-d H:i:s');
        $model->flag = 1;
        $model->user_id = 30;
        $pembayaran = Pembayaran::find()->where(['id'=>98])->one();
        if($model->save()){
            return ActionSendFcm::getMessage($user->fcm_token,"pembayaran",$pembayaran->id,"Pembayaran",$pembayaran->nama);

        }
        
    }
    

}
