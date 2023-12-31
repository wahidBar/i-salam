<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "PendanaanController".
 */

use Yii;
use app\models\Pendanaan;
use app\models\Pembayaran;
use app\models\Pencairan;
use app\models\PartnerPendanaan;
use app\models\AgendaPendanaan;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use app\components\Constant;
use app\components\SSOToken;
use app\models\KegiatanPendanaan;
use app\models\MarketingDataUser;
use DateTime;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\HttpException;

class PendanaanController extends \yii\rest\ActiveController
{

    use \app\components\UploadFile;
    public $modelClass = 'app\models\Pendanaan';

    public function behaviors()
    {
        $parent = parent::behaviors();
        $parent['authentication'] = [
            "class" => "\app\components\CustomAuth",
            "only" => ["add-pendanaan", "draf-pendanaan", "all", "pendanaan-diterima",],
        ];

        return $parent;
    }

    protected function verbs()
    {
        return [
            'all' => ['GET'],
            'show-pendanaan' => ['GET'],
            'pendanaan-diterima' => ['GET'],
            'prespekture' => ['GET'],
            'add-pendanaan' => ['POST'],
            'draf-pendanaan' => ['POST'],
            'approve-pendanaan' => ['POST'],
            'pendanaan-cair' => ['POST'],
            'pendanaan-selesai' => ['POST'],
            'pendanaan-tolak' => ['POST'],
            'pendanaan-wakaf' => ['GET'],
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

    public function actionTest1()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $pendanaans = Pendanaan::find()->all();

        $list_pendanaan = [];
        foreach ($pendanaans as $pendanaan) {
            $list_pendanaan[] = $pendanaan;
        }

        $jumlah_pendanaan = [];
        foreach ($pendanaans as $pendanaan) {
            $nominal = \app\models\Pembayaran::find()->where(['pendanaan_id' => $pendanaan->id, 'status_id' => 6])->sum('nominal');

            // $pewakaf = \app\models\Pembayaran::find()->where(['pendanaan_id' => $pendanaan->id, 'status_id' => 6])->count();
            // $datetime1 =  new DateTime($pendanaan->pendanaan_berakhir);
            // $datetime2 =  new Datetime(date("Y-m-d H:i:s"));
            // $interval = $datetime1->diff($datetime2)->days;
            $target = $pendanaan->nominal;
            $jumlah_pendanaan = ($nominal / $target) * 100;
        }
        return [
            "success" => true,
            "message" => "List Program Pendanaan",
            "data" => $list_pendanaan,
            // "jum" => $jumlah_pendanaan,
        ];
    }

    public function actionPDiterima($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $pendanaans = Pendanaan::find()->where(['status_id' => $id])->all();

        $list_pendanaan = [];
        foreach ($pendanaans as $pendanaan) {
            $list_pendanaan[] = $pendanaan;
        }

        return [
            "success" => true,
            "message" => "List Program Pendanaan",
            "data" => $list_pendanaan,

        ];
    }

    public function actionNewPendanaan()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // Menggunakan ActiveDataProvider untuk mengambil data pendanaan terbaru
        $dataProvider = new ActiveDataProvider([
            'query' => Pendanaan::find()->orderBy(['id' => SORT_DESC])->limit(3), // Mengambil 3 terbaru
            'pagination' => false, // Menonaktifkan paginasi
        ]);

        // Mengembalikan data pendanaan terbaru dalam respons
        return [
            "success" => true,
            "message" => "Pendanaan Terbaru",
            "data" => $dataProvider->getModels(),
        ];
    }
    public function actionOldPendanaan()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $dataProvider = new ActiveDataProvider([
            'query' => Pendanaan::find()->orderBy(['id' => SORT_ASC])->limit(3),
            'pagination' => false, // Menonaktifkan paginasi
        ]);

        return [
            "success" => true,
            "message" => "Pendanaan Lama",
            "data" => $dataProvider->getModels(),
        ];
    }
    public function actionDPendanaan($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $kegiatanpendanaan = KegiatanPendanaan::find()->where(['pendanaan_id' => $id])->all();
        $patnerpendanaan = PartnerPendanaan::find()->where(['pendanaan_id' => $id])->all();
        $waqif = Pembayaran::find()->where(['pendanaan_id' => $id, 'status_id' => 6])->all();

        return [
            "success" => true,
            "kegiatanpendanaan" => $kegiatanpendanaan,
            "patnerpendanaan" => $patnerpendanaan,
            "waqif" => $waqif,

        ];
    }

    public function actionAll()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (\Yii::$app->user->identity->role_id == 2) {
            $pendanaans = Pendanaan::find()->where(['user_id' => \Yii::$app->user->identity->id])->all();

            //     $not = Pendanaaan::find()
            //    ->where(['movie_id'=>$id])
            //    ->andWhere(['location_id'=>$loc_id])
            //    ->andWhere(['<>','cancel_date', $date])
            //    ->all();
            return [
                "success" => true,
                "message" => "List Pendanaan",
                "data" => $pendanaans,
            ];
        } else {
            $pendanaans = Pendanaan::find()->where(['status_tampil' => 1])->all();
            return [
                "success" => true,
                "message" => "List Pendanaan All",
                "data" => $pendanaans,
            ];
        }

        return [
            "success" => true,
            "message" => "Data Tidak ditemukan",

        ];
    }

    public function actionShowPendanaan($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $pendanaans = Pendanaan::findOne(['id' => $id]);

        return [
            "success" => true,
            "message" => "List Pendanaan",
            "data" => $pendanaans,
        ];
    }

    public function actionPendanaanDiterima()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $pendanaans = Pendanaan::find(['status_id' => 2])->all();


        return [
            "success" => true,
            "message" => "List Pendanaan",
            "data" => $pendanaans,
        ];
    }

    public function actionDrafPendanaan()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $val = \yii::$app->request->post();
        $marketing_data = MarketingDataUser::find()->where(['user_id' => \Yii::$app->user->identity->id])->all();
        if ($marketing_data ==  NULL) {
            return ['success' => false, 'message' => 'gagal', 'data' => "Data Anda Belum dilengkapi"];
            // throw new HttpException(419, "Data Anda Belum dilengkapi");
        } else {
            $model = new Pendanaan;
            // $model->name = $val['name'];
            $image = UploadedFile::getInstanceByName("foto");
            if ($image) {
                $response = $this->uploadImage($image, "pendanaan");
                if ($response->success == false) {
                    throw new HttpException(419, "Gambar gagal diunggah");
                }
                $model->foto = $response->filename;
            }
            // var_dump($image);
            // die;
            $model->nama_pendanaan = $val['nama_pendanaan'];
            // $model->foto =$fotos;
            $model->uraian = $val['uraian'] ?? '';
            $model->deskripsi = $val['deskripsi'] ?? '';
            $model->nama_nasabah = $val['nama_nasabah'] ?? '';
            $model->nama_perusahaan = $val['nama_perusahaan'] ?? '';
            $model->bank_id = $val['bank'] ?? '';
            $model->nomor_rekening = $val['nomor_rekening'] ?? '';
            $model->nominal = $val['nominal'];
            $model->pendanaan_berakhir = $val['pendanaan_berakhir'];
            $model->user_id = \Yii::$app->user->identity->id;
            $model->kategori_pendanaan_id = $val['kategori_pendanaan'];
            $model->status_id = 9;

            $check = Pendanaan::findOne(['nomor_rekening' => $model->nomor_rekening]);
            if ($check != null) {
                return ['success' => false, 'message' => 'Nomor Rekening telah digunakan'];
            }
            if (strlen($val['nomor_rekening']) >= 16) {
                return ['success' => false, 'message' => 'Nomor Rekening Tidak Valid', 'data' => null];
            }

            if ($model->validate()) {
                $model->save();

                // unset($model->password);
                return ['success' => true, 'message' => 'success', 'data' => $model];
            } else {
                return ['success' => false, 'message' => 'gagal', 'data' => $model->getErrors()];
            }
        }
    }


    public function actionAddPendanaan()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $val = \yii::$app->request->post();

        $model = Pendanaan::findOne(['id' => $val["id"], 'status_id' => 9]);
        // $model->name = $val['name'];
        if ($model != null) {
            $image = UploadedFile::getInstanceByName("foto");
            if ($image) {
                $response = $this->uploadImage($image, "pendanaan/foto");
                if ($response->success == false) {
                    throw new HttpException(419, "Gambar gagal diunggah");
                }
                $model->foto = $response->filename;
            }
            $image_ktp = UploadedFile::getInstanceByName("foto_ktp_nasabah");
            if ($image_ktp) {
                $response_ktp = $this->uploadImage($image_ktp, "pendanaan/foto_ktp");
                if ($response_ktp->success == false) {
                    throw new HttpException(419, "Foto KTP gagal diunggah");
                }
                $model->foto_ktp = $response_ktp->filename;
            }
            $uraians = UploadedFile::getInstanceByName("file_uraian");
            if ($uraians) {
                $response_uraian = $this->uploadImage($uraians, "uraian/");
                if ($response_uraian->success == false) {
                    throw new HttpException(419, "File uraian gagal diunggah");
                }
                $model->file_uraian = $response_uraian->filename;
            }
            $posters = UploadedFile::getInstanceByName("poster");
            if ($posters) {
                $response_poster = $this->uploadImage($posters, "poster/");
                if ($response_poster->success == false) {
                    throw new HttpException(419, "File poster gagal diunggah");
                }
                $model->poster = $response_poster->filename;
            }
            $image_kk = UploadedFile::getInstanceByName("foto_kk");
            if ($image_kk) {
                $response_kk = $this->uploadImage($image_kk, "pendanaan/foto_kk");
                if ($response_kk->success == false) {
                    throw new HttpException(419, "Foto KK gagal diunggah");
                }
                $model->foto_kk = $response_kk->filename;
                $model->status_id = 1;


                if ($model->validate()) {
                    $model->save();
                    // gunakan ini jika ada gambar yang gagal di upload
                    $images_success_uploaded = [];

                    $date = date("Y-m-d");
                    $images_title = $_POST['nama_partner'];

                    foreach ($images_title as $index => $title) {
                        $file = UploadedFile::getInstanceByName("foto_ktp_partner[$index]");
                        $response = $this->uploadImage($file, "partner-pendanaan/$date");

                        if ($response->success == false) {
                            foreach ($images_success_uploaded as $img) {
                                $this->deleteOne($img);
                            }

                            return [
                                "success" => false,
                                "message" => "Gagal menambahkan gambar",
                            ];
                        }

                        array_push($images_success_uploaded, $response->filename);

                        $new_image = new PartnerPendanaan();
                        $new_image->nama_partner = $title;
                        $new_image->pendanaan_id = $model->id; // set default

                        $new_image->foto_ktp_partner = $response->filename;

                        if ($new_image->validate() == false) {

                            foreach ($images_success_uploaded as $img) {
                                $this->deleteOne($img);
                            }

                            return [
                                "success" => false,
                                "message" => "Validasi gagal",
                            ];
                        }

                        $new_image->save();
                    }



                    foreach ($_POST['nama_agenda'] as $index => $value) {
                        $agendas = new AgendaPendanaan(); // creating new instance of agendas 
                        $agendas->nama_agenda = $value;
                        $agendas->tanggal = $_POST['tanggal_agenda'][$index];
                        $agendas->pendanaan_id = $model->id;
                        $agendas->save();
                    }

                    // unset($model->password);
                    return ['success' => true, 'message' => 'success', 'data' => $model];
                } else {
                    return ['success' => false, 'message' => 'gagal', 'data' => $model->getErrors()];
                }
            }
        } else {
            return ['success' => false, 'message' => 'Data Pendanaan Tidak ditemukan'];
        }
    }

    public function actionApprovePendanaan()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $val = \yii::$app->request->post();
        $model = Pendanaan::findOne(['id' => $val['id_pendanaan'], 'status_id' => 1]);
        //return print_r($model);
        if ($model) {
            $model->status_id = 2;
            if ($model->save()) {

                return ['success' => true, 'message' => 'success', 'data' => $model];
            } else {

                return ['success' => false, 'message' => 'gagal', 'data' => $model->getErrors()];
            }
        }
    }

    public function actionPendanaanCair()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $val = \yii::$app->request->post();
        $model = Pendanaan::findOne(['id' => $val["id_pendanaan"], 'status_id' => 4]);
        $bayar = Pembayaran::find()->where(['pendanaan_id' => $val["id_pendanaan"]])->sum('nominal');
        $cair = new Pencairan;
        // $model->tanggal_received=date('Y-m-d H:i:s');
        if ($model != null) {
            $model->status_id = 3;
            $cair->pendanaan_id = $val['id_pendanaan'];
            if ($bayar < $val['nominal']) {
                return ['success' => false, 'message' => 'Nominal Melebihi Jumlah yang didapat'];
            } else {
                if ($val['nominal'] == null) {
                    $cair->nominal = $bayar;
                } else {
                    $cair->nominal = $val['nominal'];
                }
                $cair->tanggal = date('Y-m-d');
                $cair->save();
                if ($model->save()) {
                    return ['success' => true, 'message' => 'success', 'data' => $model];
                }
            }

            // return $this->redirect(Url::previous());
        } else {
            return ['success' => false, 'message' => 'Data Tidak Ditemukan'];
        }
    }

    public function actionPendanaanSelesai()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $val = \yii::$app->request->post();
        $model = Pendanaan::findOne(['id' => $val['id_pendanaan'], 'status_id' => 2]);
        //return print_r($model);
        if ($model) {
            $model->status_id = 4;
            if ($model->save()) {

                return ['success' => true, 'message' => 'success', 'data' => $model];
            } else {
                return ['success' => false, 'message' => 'gagal', 'data' => $model->getErrors()];
            }
        } else {
            return ['success' => false, 'message' => 'Data Tidak Ditemukan'];
        }
    }

    public function actionPendanaanTolak()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $val = \yii::$app->request->post();
        $model = Pendanaan::findOne(['id' => $val['id_pendanaan'], 'status_id' => 1]);
        //return print_r($model);
        if ($model) {
            $model->status_id = 7;
            if ($model->save()) {

                return ['success' => true, 'message' => 'success', 'data' => $model];
            } else {
                return ['success' => false, 'message' => 'gagal', 'data' => $model->getErrors()];
            }
        } else {
            return ['success' => false, 'message' => 'Data Tidak Ditemukan'];
        }
    }
    public function actionPendanaanBatal()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $val = \yii::$app->request->post();
        $model = Pendanaan::findOne(['id' => $val['id_pendanaan'], 'status_id' => 1]);
        //return print_r($model);
        if ($model) {
            if ($model->delete()) {

                return ['success' => true, 'message' => 'success membatalkan pendanaan', 'data' => $model];
            } else {
                return ['success' => false, 'message' => 'gagal', 'data' => $model->getErrors()];
            }
        } else {
            return ['success' => false, 'message' => 'Data Tidak Ditemukan'];
        }
    }
    public function actionPendanaanWakaf($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $wf = Pendanaan::find()->where(['id' => $id])->one();
        if ($wf != null) {
            $wa = Pembayaran::find()->where(['pendanaan_id' => $wf->id, 'status_id' => 6])->all();

            if ($wa != null) {

                return [
                    "success" => true,
                    "message" => "Data Wakaf All ",
                    "data" => $wa,
                ];
            } else {

                return [
                    "success" => false,
                    "message" => "Belum Ada yang Wakaf ",
                    "data" => null,
                ];
            }
        } else {
            return [
                "success" => false,
                "message" => "Data Pendanaan Tidak Ditemukan",
                "data" => null,
            ];
        }
    }
    public function actionPrespekture($pendanaan_id)
    {
        $models = $this->findModels($pendanaan_id);
        $model = $this->findModel($models->pendanaan_id);
        $file = $model->file_uraian;
        // $model->tanggal_received=date('Y-m-d H:i:s');
        $path = Yii::getAlias("@app/web/uploads/uraian/") . $file;
        $arr = explode(".", $file);
        $extension = end($arr);
        $nama_file = "File Uraian " . $model->nama_pendanaan . "." . $extension;

        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path, $nama_file);
        } else {
            throw new \yii\web\NotFoundHttpException("{$path} is not found!");
        }
    }

    protected function findModel($id)
    {
        if (($model = Pendanaan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }

    protected function findModels($pendanaan_id)
    {
        if (($model = Pencairan::findOne(['pendanaan_id' => $pendanaan_id])) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }
}
