<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "UserController".
 */
use yii\base\Security;
use app\models\User;
use app\models\Otp;
use app\models\MarketingDataUser;
use Dompdf\Exception;
use Yii;
use yii\web\UploadedFile;
use app\components\Constant;
use app\components\SSOToken;
use yii\web\HttpException;

class UserController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\User';
    public function behaviors(){
        $parent = parent::behaviors();
        $parent['authentication'] = [
            "class" => "\app\components\CustomAuth",
            "only" => ["user-view",],
        ];
    
        return $parent;
    }
    protected function verbs()
    {
       return [
        'user-view' => ['GET'],
           'login' => ['POST'],
           'register' => ['POST'],
           'check-otp' => ['POST'],
           'refresh-otp' => ['POST'],
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
    
    public function actionLogin()
    {
        $username = !empty($_POST['username'])?$_POST['username']:'';
        $password = !empty($_POST['password'])?$_POST['password']:'';
        $result = [];
        // validasi jika kosong
        if(empty($username) || empty($password)){
          $result = [
            'status' => 'error',
            'message' => 'username & password tidak boleh kosong!',
            'data' => '',
          ];
        }else{
            try {
                $user= User::findByUsername([
                    "username" => $username,
                    // "password" => $this->validatePassword($user->password,$_POST['password']),
                ]);
                if (isset($user)) {
                    if($user->validatePassword($password)){
                        $generate_random_string = SSOToken::generateToken();
                        $user->secret_token = $generate_random_string;
                        $user->save();
                    $result['success'] = true;
                    $result['message'] = "success login";
                    unset($user->password); // remove password from response
                    $result["data"] = $user;
                    }else{
                        $result["success"] = false;
                        $result["message"] = "password salah";
                        $result["data"] = null;
                    }
                } else {
                    $result["success"] = false;
                    $result["message"] = "username tidak ada";
                    $result["data"] = null;
                }
            } catch (\Exception $e) {
                $result["success"] = false;
                $result["message"] = "username atau password salah";
                $result["data"] = null;
            }
        }
    
        return $result;
    }

    public function actionUserView()
    {
        $result = [];
        try {
            $user = User::findOne(['id' => \Yii::$app->user->identity->id
            ]);
            $marketing=MarketingDataUser::findOne(['user_id' => \Yii::$app->user->identity->id]);
            
            if (isset($user)) {
                $result['success'] = true;
                $result['message'] = "success";
                // unset($user->fcm_token);
                unset($user->password); // remove password from response
                $result["data"] = $user;
                $result["data-marketing"] = $marketing;
            } else {
                $result["success"] = false;
                $result["message"] = "gagal";
                $result["data"] = "data kosong";
                $result["data-marketing"] = null;
            }
        } catch (\Exception $e) {
            $result["success"] = false;
            $result["message"] = "gagal";
            $result["data"] = "error";
            $result["data-marketing"] = null;
        }
        return $result;
    }

    public function actionRegister()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $val = \yii::$app->request->post();
        if($val['role'] == "admin_pendanaan"){
            $rolee = 2;
        }else{
         $rolee =  5;   
        }
        
        $user = new User();
        // $user->name = $val['name'];
        $user->username = $val['username'];
        $user->password =Yii::$app->security->generatePasswordHash($val['confirm_password']);
        $user->name = $val['name'];
        $user->role_id = $rolee;
        $user->confirm = 0;
        $user->confirm = 0;
        $user->photo_url = 'default.png';
        $user->nomor_handphone = ($val['no_hp']) ?? '';
        // $user->address = $val['address'];

        if ( $val['confirm_password'] != $val['password']) {
            return ['success' => false, 'message' => 'gagal', 'result' => "Password tidak sama"];
                        }
        if ($user->nomor_handphone == '') {
            return ['success' => false, 'message' => 'gagal', 'data' => 'No Telp tidak boleh kosong'];
        }

        // if ($user->username == '') {
        //     return ['success' => false, 'message' => 'gagal', 'data' => 'Email tidak boleh kosong'];
        // }

        if (strlen($val['password']) < 3) {
            return ['success' => false, 'message' => 'gagal', 'data' => 'Password minimal 4 karakter'];
        }

        if (filter_var($user->username, FILTER_VALIDATE_EMAIL) == false) {
            return ['success' => false, 'message' => 'gagal', 'data' => 'Username anda tidak valid'];
        }

        $check = User::findOne(['nomor_handphone' => $user->nomor_handphone]);
        if ($check != null) {
            return ['success' => false, 'message' => 'gagal', 'data' => 'No Telp telah digunakan'];
        }

        // $check = User::findOne(['email' => $user->email]);
        // if ($check) {
        //     return ['success' => false, 'message' => 'gagal', 'data' => 'Email telah digunakan'];
        // }

        // check username
        if ($user->username) {
            $cek = User::find()->where(['username' => $user->username])->asArray()->one();
            if (isset($cek)) {
                return ['success' => false, 'message' => 'gagal', 'data' => 'Username telah digunakan'];
            }
        }

        if ($user->validate()) {
            $user->save();
            $otp = new Otp();

            $otp->id_user = $user->id;
            $otp->kode_otp = (string) random_int(1000, 9999);
            $otp->created_at = date('Y-m-d H:i:s');
            $otp->is_used = 0;
            $otp->save();
            $text = "
            Hay,\nini adalah kode OTP untuk reset password anda.\n
            {$otp->kode_otp}
            \nJangan bagikan kode ini dengan siapapun.
            \nKode akan Kadaluarsa dalam 5 Menit
            ";
            Yii::$app->mailer->compose()
             ->setTo($user->username)
                     ->setFrom(['adminIsalam@gmail.com'=>'Isalam'])
                     ->setSubject('Kode OTP')
                     ->setTextBody($text)
                     ->send();



            unset($user->password);
            return ['success' => true, 'message' => 'success', 'data' => $user];
        } else {
            return ['success' => false, 'message' => 'gagal', 'data' => $user->getErrors()];
        }
    }
    
    public function actionCheckOtp()
    {
        $kode_otp = $_POST['kode_otp'];
        $user_id = $_POST['user_id'];
        $otp = Otp::findOne(['kode_otp' => $kode_otp,'id_user'=>$user_id, 'is_used' => 0]);
        if ($otp) {
            $now = time();
            $validasi = strtotime($otp->created_at) + (60 * 5);

            if ($now < $validasi) {
                $otp->is_used = 1;
                $otp->save();
                $user = User::findOne(['id'=>$otp->id_user]);
                $user->confirm = 1;
                $user->status = 1;
                $user->save();

                return [
                    "success" => true,
                    "message" => "Otp Valid",
                    "data" => [
                        "user" => $otp->user->name,
                        "kode_otp" => $otp->kode_otp,
                    ],
                ];
            }

        }

        return [
            "success" => false,
            "message" => "OTP yang anda masukan tidak valid",
        ];
    }
    public function actionRefreshOtp()
    {
        $user_id = $_POST['user_id'];
        $otp = Otp::findOne(['id_user'=>$user_id, 'is_used' => 0]);
        

        if ($otp) {
            
        $now = time();
        $validasi = strtotime($otp->created_at) + 60;
        if($now > $validasi){
            $otp->kode_otp = (string) random_int(1000, 9999);
            $otp->save();
            $text = "
        Hay,\nini adalah kode OTP untuk reset password anda.\n
        {$otp->kode_otp}
        \nJangan bagikan kode ini dengan siapapun.
        \nKode akan Kadaluarsa dalam 5 Menit
        ";
        $user = User::findOne(['id'=>$user_id]);
        Yii::$app->mailer->compose()
         ->setTo($user->username)
                 ->setFrom(['adminIsalam@gmail.com'=>'Isalam'])
                 ->setSubject('Kode OTP')
                 ->setTextBody($text)
                 ->send();

            return [
                "success" => true,
                "message" => "OTP Berhasil Terkirim",
                "data" => [
                    "user" => $otp->user->name,
                    "kode_otp" => $otp->kode_otp,
                ],
            ];
        
        }else{
            return [
                "success" => false,
                "message" => "OTP gagal terkirim",
                "data"=>"Mohon Tunggu 1 menit",
            ];
        }
                

        }

        return [
            "success" => false,
            "message" => "OTP gagal terkirim",
            "data"=>[],
        ];
    }
   
    
}
