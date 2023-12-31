<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "UserController".
 */

use app\components\UploadFile;

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
use yii\web\Response;

class UserController extends \yii\rest\ActiveController
{

    use UploadFile;
    public $modelClass = 'app\models\User';
    // public function behaviors()
    // {
    //     $parent = parent::behaviors();
    //     $parent['authentication'] = [
    //         "class" => "\app\components\CustomAuth",
    //         "only" => ["update-profile"],
    //     ];

    //     return $parent;
    // }
    protected function verbs()
    {
        return [
            'user-view' => ['GET'],
            'login' => ['POST'],
            'register' => ['POST'],
            'check-otp' => ['POST'],
            'refresh-otp' => ['POST'],
            'lupa-password' => ['POST'],
            'update-profile' => ['POST'],
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
        Yii::$app->response->format = Response::FORMAT_JSON;
        // $val = yii::$app->request->post();
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');
        $fcm_token = Yii::$app->request->post('fcm_token');
        // var_dump($fcm_token);
        // die;

        // $fcm_token = !empty($_POST['fcmToken']) ? $_POST['fcmToken'] : '';
        $result = [];
        // validasi jika kosong
        if (empty($username) || empty($password)) {
            $result = [
                'status' => 'error',
                'message' => 'Email & password tidak boleh kosong!',
                'data' => ["username" => $username, "password" => $password],
            ];
        } else {
            try {
                $user = User::findByUsername([
                    "username" => $username,
                    // "password" => $this->validatePassword($user->password,$_POST['password']),
                ]);
                if (isset($user)) {
                    if ($user->validatePassword($password)) {
                        if ($user->confirm == 0 && $user->status == 0) {

                            $result["success"] = true;
                            $result["message"] = "Akun anda belum aktif,Masukkan Kode OTP Anda terlebih dahulu untuk mengaktifkan";
                            unset($user->password); // remove password from response
                            $result["data"] = $user;
                        } else if (($user->confirm == 1 && $user->status == 1)) {
                            $generate_random_string = SSOToken::generateToken();
                            $user->fcm_token = $fcm_token;
                            $user->secret_token = $generate_random_string;
                            // $user->fcm_token = $generate_random_string;
                            $user->save();
                            if ($fcm_token !== null) {
                                $result['success'] = true;
                                $result['message'] = "Berhasil login";
                                unset($user->password); // remove password from response
                                $result["data"] = $user;
                            }
                        } else {
                            $result['success'] = false;
                            $result['message'] = "error";
                            // unset($user->password); // remove password from response
                            $result["data"] = null;
                        }
                    } else {
                        $result["success"] = false;
                        $result["message"] = "Password salah";
                        $result["data"] = null;
                    }
                } else {
                    $result["success"] = false;
                    $result["message"] = "Email salah";
                    $result["data"] = null;
                }
            } catch (\Exception $e) {
                $result["success"] = false;
                $result["message"] = "Email atau password salah";
                $result["data"] = $e->getMessage();
            }
        }

        return $result;
    }

    public function actionLogout()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
    }

    public function actionUserView($id)
    {
        $result = [];
        try {
            $user = User::findOne([
                'id' => $id
            ]);
            $marketing = MarketingDataUser::findOne(['user_id' => \Yii::$app->user->identity->id]);

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

        $rolee =  2;
        if ($val['role'] == "pewakaf") {
            $rolee = 5;
        }

        $user = new User();
        // $user->name = $val['name'];
        $user->username = $val['username'];
        $user->password = $val['confirm_password'];
        $user->name = $val['name'];
        $user->role_id = $rolee;
        $user->confirm = 1;
        $user->status = 1;
        // $user->pin = $val['pin'];
        $user->photo_url = 'default.png';
        $user->nomor_handphone = ($val['no_hp']) ?? '';
        // $user->address = $val['address'];

        if ($val['confirm_password'] != $val['password']) {
            return ['success' => false, 'message' => 'Password tidak sama', 'data' => null];
        }
        if ($user->nomor_handphone == '') {
            return ['success' => false, 'message' => 'No Telepon tidak boleh kosong', 'data' => null];
        }
        if (strlen($val['password']) < 6) {
            return ['success' => false, 'message' => 'Password minimal 6 karakter', 'data' => null];
        }
        if (filter_var($user->username, FILTER_VALIDATE_EMAIL) == false) {
            return ['success' => false, 'message' => 'email anda tidak valid', 'data' => null];
        }

        $check = User::findOne(['nomor_handphone' => $user->nomor_handphone]);
        if ($check != null) {
            return ['success' => false, 'message' => 'No Teleponn telah digunakan', 'data' => null];
        }

        if ($user->username) {
            $cek = User::find()->where(['username' => $user->username])->asArray()->one();
            if (isset($cek)) {
                return ['success' => false, 'message' => 'Email telah digunakan', 'data' => null];
            }
        }
        if ($user->validate()) {
            $user->password = \Yii::$app->security->generatePasswordHash($user->password);
            $generate_random_string = SSOToken::generateToken();
            $user->secret_token = $generate_random_string;
            $user->save();
            return ['success' => true, 'message' => 'Berhasil Mendaftar', 'token' => $user->secret_token];
        } else {
            throw new HttpException(400, Constant::flattenError($user->getErrors()));
        }
        // if ($user->validate()) {
        //     $user->save();
        //     $otp = new Otp();

        //     $otp->id_user = $user->id;
        //     $otp->kode_otp = (string) random_int(1000, 9999);
        //     $otp->created_at = date('Y-m-d H:i:s');
        //     $otp->is_used = 0;
        //     $otp->save();
        //     $text = "
        //     Hay,\nini adalah kode OTP untuk Login anda.\n
        //     {$otp->kode_otp}
        //     \nJangan bagikan kode ini dengan siapapun.
        //     \nKode akan Kadaluarsa dalam 5 Menit
        //     ";
        //     Yii::$app->mailer->compose()
        //         ->setTo($user->username)
        //         ->setFrom(['Inisiatorsalam@gmail.com'])
        //         ->setSubject('Kode OTP')
        //         ->setTextBody($text)
        //         ->send();



        //     unset($user->password);
        //     return ['success' => true, 'message' => 'success', 'data' => $user];
        // } else {
        //     $user->rollback();
        //     return ['success' => false, 'message' => 'gagal', 'data' => $user->getErrors()];
        // }
    }
    public function actionCheckEmail()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $val = \yii::$app->request->post();
        $cek = User::find()->where(['username' => $val['username']])->one();
        if (isset($cek)) {
            $user_id = $cek->id;
            $otp = Otp::findOne(['id_user' => $user_id, 'is_used' => 0]);


            if ($otp) {

                $now = time();
                $validasi = strtotime($otp->created_at) + 60;
                if ($now > $validasi) {
                    $otp->kode_otp = (string) random_int(1000, 9999);
                    $otp->save();
                    $text = "
                Hay,\nini adalah kode OTP untuk Login anda.\n
                {$otp->kode_otp}
                \nJangan bagikan kode ini dengan siapapun.
                \nKode akan Kadaluarsa dalam 5 Menit
                ";
                    $user = User::findOne(['id' => $user_id]);
                    Yii::$app->mailer->compose()
                        ->setTo($user->username)
                        ->setFrom(['adminIsalam@gmail.com' => 'Isalam'])
                        ->setSubject('Kode OTP')
                        ->setTextBody($text)
                        ->send();

                    return [
                        "success" => true,
                        "message" => "OTP Berhasil Terkirim",
                        "data" => $otp->kode_otp
                    ];
                } else {
                    return [
                        "success" => false,
                        "message" => "OTP gagal terkirim,Mohon Tunggu 1 menit",
                        "data" => [],
                    ];
                }
                // return ['success' => true, 'message' => 'Otp Berhasil Terkirim', 'data' => $cek];
            } else {
                $otp = new Otp();

                $otp->id_user = $user_id;
                $otp->kode_otp = (string) random_int(1000, 9999);
                $otp->created_at = date('Y-m-d H:i:s');
                $otp->is_used = 0;
                $otp->save();
                $text = "
            Hay,\nini adalah kode OTP untuk Login anda.\n
            {$otp->kode_otp}
            \nJangan bagikan kode ini dengan siapapun.
            \nKode akan Kadaluarsa dalam 5 Menit
            ";
                $user = User::findOne(['id' => $user_id]);
                Yii::$app->mailer->compose()
                    ->setTo($user->username)
                    ->setFrom(['Inisiatorsalam@gmail.com'])
                    ->setSubject('Kode OTP')
                    ->setTextBody($text)
                    ->send();


                return ['success' => true, 'message' => 'Otp Berhasil Terkirim', 'data' => $otp->kode_otp];
            }
        } else {

            return ['success' => false, 'message' => 'Email Tidak Terdaftar', 'data' => []];
        }
    }
    public function actionLupaPassword()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $val = \yii::$app->request->post();

        // $otp = Otp::findOne(['kode_otp' => $val['kode_otp'], 'is_used' => 0]);
        // if($otp){
        $user = User::findOne([
            'visible_token' => $val['token']
        ]);
        if ($user) {
            if ($val['confirm_password'] != $val['password']) {
                return ['success' => false, 'message' => 'Password tidak sama', 'data' => null];
            }
            // $user->name = $val['name'];
            // $user->username = $val['username'];
            $pass = $val['confirm_password'];
            $user->password = Yii::$app->security->generatePasswordHash($pass);
            // $user->address = $val['address'];
            if ($user->save()) {
                // $user->save();
                unset($user->password);

                //             $text = "
                // Hay,\nini adalah kode OTP untuk Login anda.\n
                // {$otp->kode_otp}
                // \nJangan bagikan kode ini dengan siapapun.
                // \nKode akan Kadaluarsa dalam 5 Menit
                // ";

                //         Yii::$app->mailer->compose()
                //             ->setTo($user->username)
                //             ->setFrom(['adminIsalam@gmail.com' => 'Isalam'])
                //             ->setSubject('Kode OTP')
                //             ->setTextBody($text)
                //             ->send();
                return ['success' => true, 'message' => 'success', 'data' => $user];
            } else {
                // $user->rollback();
                return ['success' => false, 'message' => 'gagal', 'data' => $user->getErrors()];
            }
        } else {

            return ['success' => false, 'message' => 'Data tidak ditemukan', 'data' => []];
        }
        // }else{

        //     return ['success' => false, 'message' => 'Kode Otp tidak terdeteksi', 'data' => []];
        // }



    }

    // public function actionUpdateProfile()
    // {
    //     \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //     $val = \yii::$app->request->post();

    //     $user = User::findOne([
    //         'id' => \Yii::$app->user->identity->id
    //     ]);
    //     $old = $user->password;
    //     $old_phone = $user->nomor_handphone;
    //     $old_name = $user->name;
    //     // $new = Yii::$app->security->generatePasswordHash($val['old_password']);
    //     $password = $val['old_password'];
    //     if ($password != null) {
    //         $password = $user->validatePassword($password);
    //     }
    //     // var_dump($old_name);die;
    //     $photo_url = $user->photo_url;
    //     $image = UploadedFile::getInstanceByName("photo_url");
    //     if ($image) {
    //         $user->photo_url = $image->name;
    //         $arr = explode(".", $image->name);
    //         $extension = end($arr);

    //         # generate a unique file name
    //         $user->photo_url = Yii::$app->security->generateRandomString() . ".{$extension}";
    //         // if (file_exists(Yii::getAlias("@app/web/uploads/user_image")) == false) {
    //         //     mkdir(Yii::getAlias("@app/web/uploads/user_image"), 0777, true);
    //         //  }
    //         # the path to save file
    //         $path = Yii::getAlias("@app/web/uploads/user_image") . $user->photo_url;
    //         $image->saveAs($path);
    //         // $response = $this->uploadImage($image, "user");
    //         // if ($response->success == false) {
    //         //     throw new HttpException(419, "Gambar gagal diunggah");
    //         // }
    //         // $user->photo_url = $response->filename;
    //     } else {
    //         $user->photo_url = $photo_url;
    //     }
    //     if ($val['name'] == null) {
    //         $user->name = $old_name;
    //     } else {
    //         $user->name = $val['name'];
    //     }
    //     // var_dump($user->name);die;
    //     if ($val['confirm_password'] == "" && $val['new_password'] == "" && $password == "") {
    //         $user->password = $old;
    //     } else {
    //         $user->password = Yii::$app->security->generatePasswordHash($val['confirm_password']);
    //     }
    //     // $user->name = $val['name'];
    //     if ($val['no_hp'] != null) {
    //         $check = User::findOne(['nomor_handphone' => $val['no_hp']]);
    //         if ($check != null) {
    //             if ($check->id != $user->id) {
    //                 return ['success' => false, 'message' => 'No Telp telah digunakan', 'data' => null];
    //             }
    //         }
    //         $user->nomor_handphone = $val['no_hp'];
    //     } else {

    //         $user->nomor_handphone = $old_phone;
    //     }
    //     // $user->address = $val['address'];

    //     if ($val['confirm_password'] != null || $val['new_password'] != null) {
    //         if ($p == false) {

    //             return ['success' => false, 'message' => 'Password lama yang anda masukkan tidak sama', 'data' => null];
    //         }
    //         if ($val['confirm_password'] != $val['new_password']) {
    //             return ['success' => false, 'message' => 'Password tidak sama', 'data' => null];
    //         }
    //         if (strlen($val['new_password']) < 3 || strlen($val['confirm_password']) < 3) {
    //             return ['success' => false, 'message' => 'Password minimal 4 karakter', 'data' => null];
    //         }
    //     }
    //     if ($user->validate()) {
    //         $user->save();

    //         return ['success' => true, 'message' => 'Berhasil Update  Profile', 'data' => $user];
    //     } else {
    //         return ['success' => false, 'message' => 'Gagal Update Profile', 'data' => $user->getErrors()];
    //     }
    // }
    // use yii\web\UploadedFile;

    public function actionUpdateProfile($id)
    {
        // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // $val = \yii::$app->request->post();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $val = Yii::$app->request->post();


        $user = User::findOne(['id' => $id]);
        $user->name = Yii::$app->request->post('name');
        // var_dump($user->name);
        // die;
        $old = $user->password;
        $old_phone = $user->nomor_handphone;
        $old_name = $user->name;

        $photo_url = $user->photo_url;
        $image = UploadedFile::getInstanceByName("photo_url");

        if ($image) {
            $arr = explode(".", $image->name);
            $extension = end($arr);

            $user->photo_url = Yii::$app->security->generateRandomString() . ".{$extension}";

            $path = Yii::getAlias("@app/web/uploads/user_image") . '/' . $user->photo_url;
            $image->saveAs($path);
        } else {
            $user->photo_url;
        }

        // $user->name = $val['name'];
        // $user->name = Yii::$app->request->post('name');
        // var_dump($user->name);
        // die;
        if (!empty($val['confirm_password']) || !empty($val['new_password'])) {
            if (empty($val['old_password']) || !$user->validatePassword($val['old_password'])) {
                return ['success' => false, 'message' => 'Password lama yang Anda masukkan tidak sesuai', 'data' => null];
            }

            if ($val['confirm_password'] !== $val['new_password']) {
                return ['success' => false, 'message' => 'Password tidak sama', 'data' => null];
            }

            if (strlen($val['new_password']) < 6 || strlen($val['confirm_password']) < 4) {
                return ['success' => false, 'message' => 'Password minimal 6 karakter', 'data' => null];
            }

            $user->password = Yii::$app->security->generatePasswordHash($val['confirm_password']);
        } else {
            $user->password = $old;
        }

        if (!empty($val['no_hp'])) {
            $check = User::findOne(['nomor_handphone' => $val['no_hp']]);
            if ($check !== null && $check->id !== $user->id) {
                return ['success' => false, 'message' => 'Nomor telepon telah digunakan', 'data' => null];
            }

            $user->nomor_handphone = $val['no_hp'];
        } else {
            $user->nomor_handphone = $old_phone;
        }

        if ($user->save()) {
            return ['success' => true, 'message' => 'Berhasil Update Profile', 'data' => $user];
        } else {
            return ['success' => false, 'message' => 'Gagal Update Profile', 'data' => $user->getErrors()];
        }
    }


    public function actionOtpPassword()
    {
        $kode_otp = $_POST['kode_otp'];

        $email = $_POST['username'];
        $data_user = User::findOne(['username' => $email]);
        if ($data_user == null) {
            return [
                "success" => false,
                "message" => "Data user tidak ditemukan",
                "data" => [],
            ];
        } else {
            $otp = Otp::findOne(['kode_otp' => $kode_otp, 'id_user' => $data_user->id, 'is_used' => 0]);
            if ($otp) {
                $now = time();
                $validasi = strtotime($otp->created_at) + (60 * 5);

                if ($now < $validasi) {
                    $otp->is_used = 1;
                    $otp->save();
                    $user = User::findOne(['id' => $otp->id_user]);
                    $generate_random_string = SSOToken::generateToken();
                    $user->visible_token = $generate_random_string;
                    $user->confirm = 1;
                    $user->status = 1;
                    $user->save();

                    return [
                        "success" => true,
                        "message" => "Otp Valid",
                        "data" => $generate_random_string
                    ];
                } else {
                    return [
                        "success" => false,
                        "message" => "Kode Otp Sudah Kadaluarsa",
                        "data" => [],
                    ];
                }
            }

            return [
                "success" => false,
                "message" => "OTP yang anda masukan tidak valid",
            ];
        }
    }
    public function actionCheckOtp()
    {
        $kode_otp = $_POST['kode_otp'];
        $user_id = $_POST['user_id'];
        $otp = Otp::findOne(['kode_otp' => $kode_otp, 'id_user' => $user_id, 'is_used' => 0]);
        if ($otp) {
            $now = time();
            $validasi = strtotime($otp->created_at) + (60 * 5);

            if ($now < $validasi) {
                $otp->is_used = 1;
                $otp->save();
                $user = User::findOne(['id' => $otp->id_user]);
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
        $otp = Otp::findOne(['id_user' => $user_id, 'is_used' => 0]);


        if ($otp) {

            $now = time();
            $validasi = strtotime($otp->created_at) + 60;
            if ($now > $validasi) {
                $otp->kode_otp = (string) random_int(1000, 9999);
                $otp->save();
                $text = "
        Hay,\nini adalah kode OTP untuk Login anda.\n
        {$otp->kode_otp}
        \nJangan bagikan kode ini dengan siapapun.
        \nKode akan Kadaluarsa dalam 5 Menit
        ";
                $user = User::findOne(['id' => $user_id]);
                Yii::$app->mailer->compose()
                    ->setTo($user->username)
                    ->setFrom(['adminIsalam@gmail.com' => 'Isalam'])
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
            } else {
                return [
                    "success" => false,
                    "message" => "OTP gagal terkirim,Mohon Tunggu 1 menit",
                    "data" => "Mohon Tunggu 1 menit",
                ];
            }
        }

        return [
            "success" => false,
            "message" => "OTP gagal terkirim",
            "data" => [],
        ];
    }
}
