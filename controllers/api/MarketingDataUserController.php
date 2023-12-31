<?php

namespace app\controllers\api;

/**
* This is the class for REST controller "MarketingDataUserController".
*/
use YIi;
use app\models\MarketingDataUser;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class MarketingDataUserController extends \yii\rest\ActiveController
{
public $modelClass = 'app\models\MarketingDataUser';
public function behaviors(){
    $parent = parent::behaviors();
    $parent['authentication'] = [
        "class" => "\app\components\CustomAuth",
        "only" => ["add","validate-pendanaan",],
    ];

    return $parent;
}
protected function verbs()
    {
       return [
        'add' => ['POST'],
           'all' => ['GET'],
           'validate-pendanaan' => ['GET'],
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
        $marketings = MarketingDataUser::find()->all();

        $list_marketing = [];
        foreach ($marketings as $marketing) {
            $list_marketing[] = $marketing;
        }

        return [
            "success" => true,
            "message" => "List Marketing",
            "data" => $list_marketing,
        ];
    }

    public function actionValidatePendanaan()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $marketings = MarketingDataUser::find()->where(['user_id'=>\Yii::$app->user->identity->id])->asArray()->one();
        if($marketings != NULL){

           
    
            return [
                "success" => true,
                "message" => "Marketing Anda",
                "data" => $marketings,
            ];
        }else{
            return [
                "success" => false,
                "message" => "Mohon Lengkapi Data Anda",
                "data" => null,
            ];
        }
    }
    public function actionAdd()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $val = \yii::$app->request->post();
        $marketing_data = MarketingDataUser::find()->where(['user_id'=>\Yii::$app->user->identity->id])->one();
        if($marketing_data ==  NULL){
            $model = new MarketingDataUser;
            
                    // var_dump($image);
                    // die;
            $model->nama = $val['nama'];
            // $model->foto =$fotos;
            $model->alamat = $val['alamat'] ?? '';
            $model->domisili = $val['domisili'] ?? '';
            $model->no_rekening = $val['no_rekening'] ?? '';
            $model->no_identitas = $val['no_identitas'] ?? '';
            $model->referensi_kerja = $val['referensi_kerja'] ?? '';
            $model->bank_id = $val['bank'] ?? '';
            $model->user_id = \Yii::$app->user->identity->id;
            
            
    
            if ($model->validate()) {
                $model->save();
                
                // unset($model->password);
                return ['success' => true, 'message' => 'success', 'data' => $model];
            } else {
                $msg= $model->getErrors();

                return ['success' => false, 'message' => "Gagal,Data harus terisi dengan lengkap" ];
            }
    
            
            // throw new HttpException(419, "Data Anda Belum dilengkapi");
        }else{
            return ['success' => false, 'message' => 'Data Anda Telah dilengkapi', 'data' => $marketing_data];
        }
            }


}
