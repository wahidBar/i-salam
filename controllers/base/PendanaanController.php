<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\controllers\base;

use Yii;
use app\models\Pendanaan;
use app\models\Notifikasi;
use app\models\Pembayaran;
use app\models\Pencairan;
use app\models\Setting;
use app\models\search\PendanaanSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\Action;
use app\models\User;
use yii\web\UploadedFile;

/**
 * PendanaanController implements the CRUD actions for Pendanaan model.
 */
class PendanaanController extends Controller
{


   /**
    * @var boolean whether to enable CSRF validation for the actions in this controller.
    * CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
    */
   public $enableCsrfValidation = false;
   public function behaviors()
   {
      //NodeLogger::sendLog(Action::getAccess($this->id));
      //apply role_action table for privilege (doesn't apply to super admin)
      return Action::getAccess($this->id);
   }

   /**
    * Lists all Pendanaan models.
    * @return mixed
    */
   public function actionIndex()
   {
      $searchModel  = new PendanaanSearch;
      $dataProvider = $searchModel->search($_GET);


      Tabs::clearLocalStorage();

      Url::remember();
      \Yii::$app->session['__crudReturnUrl'] = null;

      return $this->render('index', [

         'dataProvider' => $dataProvider,
         'searchModel' => $searchModel,
      ]);
   }

   /**
    * Displays a single Pendanaan model.
    * @param integer $id
    *
    * @return mixed
    */
   public function actionView($id)
   {
      \Yii::$app->session['__crudReturnUrl'] = Url::previous();
      Url::remember();
      Tabs::rememberActiveState();

      return $this->render('view', [
         'model' => $this->findModel($id),
      ]);
   }

   /**
    * Creates a new Pendanaan model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
   public function actionCreate()
   {
      $model = new Pendanaan;

      try {
         if ($model->load($_POST)) {
            $model->status_id = 1;
            $model->user_id = \Yii::$app->user->identity->id;
            $fotos = UploadedFile::getInstance($model, 'foto');
            if ($fotos != NULL) {
               # store the source fotos name
               $model->foto = $fotos->name;
               $arr = explode(".", $fotos->name);
               $extension = end($arr);

               # generate a unique fotos name
               $model->foto = Yii::$app->security->generateRandomString() . ".{$extension}";

               # the path to save fotos
               // unlink(Yii::getAlias("@app/web/uploads/pengajuan/") . $oldFile);
               if (file_exists(Yii::getAlias("@app/web/uploads/pendanaan/foto/")) == false) {
                  mkdir(Yii::getAlias("@app/web/uploads/pendanaan/foto/"), 0777, true);
               }
               $path = Yii::getAlias("@app/web/uploads/pendanaan/foto/") . $model->foto;
               $fotos->saveAs($path);
            }
            $fotos_ktp = UploadedFile::getInstance($model, 'foto_ktp');
            if ($fotos_ktp != NULL) {
               # store the source fotos_ktp name
               $model->foto_ktp = $fotos_ktp->name;
               $arr = explode(".", $fotos_ktp->name);
               $extension = end($arr);

               # generate a unique fotos_ktp name
               $model->foto_ktp = Yii::$app->security->generateRandomString() . ".{$extension}";

               # the path to save fotos_ktp
               // unlink(Yii::getAlias("@app/web/uploads/pengajuan/") . $oldFile);
               if (file_exists(Yii::getAlias("@app/web/uploads/pendanaan/foto_ktp/")) == false) {
                  mkdir(Yii::getAlias("@app/web/uploads/pendanaan/foto_ktp/"), 0777, true);
               }
               $path = Yii::getAlias("@app/web/uploads/pendanaan/foto_ktp/") . $model->foto_ktp;
               $fotos_ktp->saveAs($path);
            }
            $fotos_kk = UploadedFile::getInstance($model, 'foto_kk');
            if ($fotos_kk != NULL) {
               # store the source fotos_kk name
               $model->foto_kk = $fotos_kk->name;
               $arr = explode(".", $fotos_kk->name);
               $extension = end($arr);

               # generate a unique fotos_kk name
               $model->foto_kk = Yii::$app->security->generateRandomString() . ".{$extension}";

               # the path to save fotos_kk
               // unlink(Yii::getAlias("@app/web/uploads/pengajuan/") . $oldFile);
               if (file_exists(Yii::getAlias("@app/web/uploads/pendanaan/foto_kk/")) == false) {
                  mkdir(Yii::getAlias("@app/web/uploads/pendanaan/foto_kk/"), 0777, true);
               }
               $path = Yii::getAlias("@app/web/uploads/pendanaan/foto_kk/") . $model->foto_kk;
               $fotos_kk->saveAs($path);
            }
            if ($model->save()) {
               return $this->redirect(['view', 'id' => $model->id]);
            }
         } elseif (!\Yii::$app->request->isPost) {
            $model->load($_GET);
         }
      } catch (\Exception $e) {
         $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
         $model->addError('_exception', $msg);
      }

      $setting = Setting::find()->one();
      $bg = $setting->bg_pin;
      $user = Yii::$app->user->id;
      $pin = User::find()->where(['id' => $user])->one();
      $bg = $setting->bg_pin;


      if (yii::$app->request->post('display') == $pin->pin) {
         return $this->render('create', ['model' => $model]);
      } else {
         Yii::$app->session->setFlash('Pin Salah');
      }
      $this->layout = 'front';
      return $this->render('security', ['bg' => $bg,]);
   }

   public function actionApprovePendanaan($id)
   {
      $model = $this->findModel($_GET['id']);
      //return print_r($model);
      if ($model) {
         $model->status_id = 2;
         if ($model->save()) {
            $notifikasi = new Notifikasi;
            $notifikasi->message = "Pendanaan ".$model->nama_pendanaan." Telah di Setujui";
            $notifikasi->user_id = $model->user_id;
            $notifikasi->flag = 1;
            $notifikasi->date=date('Y-m-d H:i:s');
            $notifikasi->save();
            \Yii::$app->getSession()->setFlash(
               'success',
               'Pendanaan Telah Disetujui!'
            );
         } else {
            \Yii::$app->getSession()->setFlash(
               'danger',
               'Pendanaan Gagal Disetujui!'
            );
         }
         return $this->redirect(['index']);
      }
   }

   public function actionPendanaanCair($id)
   {
      $model = $this->findModel($id);
      $cair = new Pencairan;
      // $model->tanggal_received=date('Y-m-d H:i:s');
      if ($model->load($_POST)) {
         $model->status_id = 3;
         $cair->pendanaan_id = $model->id;
         if ($model->nominal < $model->noms) {
            \Yii::$app->getSession()->setFlash(
               'danger',
               'Nominal Pencairan Melebihi Nominal Pendanaan !'
            );
            $pembayar = Pembayaran::find()->where(['pendanaan_id'=>$model->id,'status_id'=>6])->all();
            foreach($pembayar as $value){
               $notifikasi = new Notifikasi;
               $notifikasi->message = "Pendanaan ".$model->nama_pendanaan." Telah di cairkan";
               $notifikasi->user_id = $value->user_id;
               $notifikasi->flag = 1;
               $notifikasi->date=date('Y-m-d H:i:s');
               $notifikasi->save();
            }
            return $this->render('pendanaan-cair', [
               'model' => $model,
               'cair' => $cair,
            ]);
         } else {
            $cair->nominal = $model->noms;
            $cair->tanggal = date('Y-m-d');
            $cair->save();
            if ($model->save()) {
               $notifikasi2 = new Notifikasi;
            $notifikasi2->message = "Pendanaan ".$model->nama_pendanaan." Telah Anda Cairkan";
            $notifikasi2->user_id = $model->user_id;
            $notifikasi2->flag = 1;
            $notifikasi2->date=date('Y-m-d H:i:s');
            $notifikasi2->save();
               \Yii::$app->getSession()->setFlash(
                  'success',
                  'Pendanaan Telah Dicairkan!'
               );

               return $this->redirect(['view', 'id' => $model->id]);
            }
         }

         // return $this->redirect(Url::previous());
      } else {
         return $this->render('pendanaan-cair', [
            'model' => $model,
            'cair' => $cair,
         ]);
      }
   }

   public function actionPendanaanSelesai($id)
   {
      $model = $this->findModel($_GET['id']);
      //return print_r($model);
      if ($model) {
         $model->status_id = 4;
         $pembayar = Pembayaran::find()->where(['pendanaan_id'=>$model->id,'status_id'=>6])->all();
         foreach($pembayar as $value){
            $notifikasi = new Notifikasi;
            $notifikasi->message = "Pendanaan ".$model->nama_pendanaan." Telah selesai";
            $notifikasi->user_id = $value->user_id;
            $notifikasi->flag = 1;
            $notifikasi->date=date('Y-m-d H:i:s');
            $notifikasi->save();
         }
         
         if ($model->save()) {
            $notifikasi2 = new Notifikasi;
            $notifikasi2->message = "Pendanaan ".$model->nama_pendanaan." Telah selesai";
            $notifikasi2->user_id = $model->user_id;
            $notifikasi2->flag = 1;
            $notifikasi2->date=date('Y-m-d H:i:s');
            $notifikasi2->save(); 
            
            \Yii::$app->getSession()->setFlash(
               'success',
               'Pendanaan Telah Selesai!'
            );
         } else {
            \Yii::$app->getSession()->setFlash(
               'danger',
               'Pendanaan Gagal Selesai!'
            );
         }
         return $this->redirect(['index']);
      }
   }

   public function actionPendanaanTolak($id)
   {
      $model = $this->findModel($_GET['id']);
      //return print_r($model);
      if ($model) {
         $model->status_id = 7;
         if ($model->save()) {
            $notifikasi = new Notifikasi;
            $notifikasi->message = "Pendanaan ".$model->nama_pendanaan." Telah Ditolak Oleh pihak Admin";
            $notifikasi->user_id = $model->user_id;
            $notifikasi->flag = 1;
            $notifikasi->date=date('Y-m-d H:i:s');
            $notifikasi->save();
            \Yii::$app->getSession()->setFlash(
               'success',
               'Pendanaan Telah Ditolak!'
            );
         } else {
            \Yii::$app->getSession()->setFlash(
               'danger',
               'Pendanaan Gagal Ditolak!'
            );
         }
         return $this->redirect(['index']);
      }
   }

   /**
    * Updates an existing Pendanaan model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id
    * @return mixed
    */
   public function actionUpdate($id)
   {
      $model = $this->findModel($id);
      $oldBuktiFts = $model->foto;
      $oldBukti = $model->foto_ktp;
      $oldBuktiKk = $model->foto_kk;
      if ($model->load($_POST)) {
         $fts = UploadedFile::getInstance($model, 'foto');
         if ($fts != NULL) {
            # store the source file name
            $model->foto = $fts->name;
            $arr = explode(".", $fts->name);
            $extension = end($arr);

            # generate a unique file name
            $model->foto = Yii::$app->security->generateRandomString() . ".{$extension}";

            # the path to save file
            if (file_exists(Yii::getAlias("@app/web/uploads/pendanaan/foto/")) == false) {
               mkdir(Yii::getAlias("@app/web/uploads/pendanaan/foto/"), 0777, true);
            }
            $path = Yii::getAlias("@app/web/uploads/pendanaan/foto/") . $model->foto;
            if ($oldBukti != NULL) {

               $fts->saveAs($path);
               unlink(Yii::$app->basePath . '/web/uploads/pendanaan/foto/' . $oldBuktiFts);
            } else {
               $fts->saveAs($path);
            }
         } else {
            $model->foto_ktp = $oldBukti;
         }
         $fotos = UploadedFile::getInstance($model, 'foto_ktp');
         if ($fotos != NULL) {
            # store the source file name
            $model->foto_ktp = $fotos->name;
            $arr = explode(".", $fotos->name);
            $extension = end($arr);

            # generate a unique file name
            $model->foto_ktp = Yii::$app->security->generateRandomString() . ".{$extension}";

            # the path to save file
            if (file_exists(Yii::getAlias("@app/web/uploads/pendanaan/foto_ktp/")) == false) {
               mkdir(Yii::getAlias("@app/web/uploads/pendanaan/foto_ktp/"), 0777, true);
            }
            $path = Yii::getAlias("@app/web/uploads/pendanaan/foto_ktp/") . $model->foto_ktp;
            if ($oldBukti != NULL) {

               $fotos->saveAs($path);
               unlink(Yii::$app->basePath . '/web/uploads/pendanaan/foto_ktp/' . $oldBukti);
            } else {
               $fotos->saveAs($path);
            }
         } else {
            $model->foto_ktp = $oldBukti;
         }
         $fotos_kk = UploadedFile::getInstance($model, 'foto_kk');
         if ($fotos_kk != NULL) {
            # store the source file name
            $model->foto_kk = $fotos_kk->name;
            $arr = explode(".", $fotos_kk->name);
            $extension = end($arr);

            # generate a unique file name
            $model->foto_kk = Yii::$app->security->generateRandomString() . ".{$extension}";

            # the path to save file
            if (file_exists(Yii::getAlias("@app/web/uploads/pendanaan/foto_kk/")) == false) {
               mkdir(Yii::getAlias("@app/web/uploads/pendanaan/foto_kk/"), 0777, true);
            }
            $path = Yii::getAlias("@app/web/uploads/pendanaan/foto_kk/") . $model->foto_kk;
            if ($oldBukti != NULL) {

               $fotos_kk->saveAs($path);
               unlink(Yii::$app->basePath . '/web/uploads/pendanaan/foto_kk/' . $oldBukti);
            } else {
               $fotos_kk->saveAs($path);
            }
         } else {
            $model->foto_kk = $oldBuktiKk;
         }

         if ($model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
         }
      } else {
         return $this->render('update', [
            'model' => $model,
         ]);
      }
   }

   /**
    * Deletes an existing Pendanaan model.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @param integer $id
    * @return mixed
    */
   public function actionDelete($id)
   {
      try {
         $model = $this->findModel($id);
         $oldFtss = $model->foto;
         $oldBukti = $model->foto_ktp;
         $oldBuktiKk = $model->foto_kk;
         $model->delete();
         unlink(Yii::$app->basePath . '/web/uploads/pendanaan/foto/' . $oldFtss);
         unlink(Yii::$app->basePath . '/web/uploads/pendanaan/foto_ktp/' . $oldBukti);
         unlink(Yii::$app->basePath . '/web/uploads/pendanaan/foto_kk/' . $oldBuktiKk);
      } catch (\Exception $e) {
         $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
         \Yii::$app->getSession()->addFlash('error', $msg);
         return $this->redirect(Url::previous());
      }

      // TODO: improve detection
      $isPivot = strstr('$id', ',');
      if ($isPivot == true) {
         return $this->redirect(Url::previous());
      } elseif (isset(\Yii::$app->session['__crudReturnUrl']) && \Yii::$app->session['__crudReturnUrl'] != '/') {
         Url::remember(null);
         $url = \Yii::$app->session['__crudReturnUrl'];
         \Yii::$app->session['__crudReturnUrl'] = null;

         return $this->redirect($url);
      } else {
         return $this->redirect(['index']);
      }
   }

   /**
    * Finds the Pendanaan model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return Pendanaan the loaded model
    * @throws HttpException if the model cannot be found
    */
   protected function findModel($id)
   {
      if (($model = Pendanaan::findOne($id)) !== null) {
         return $model;
      } else {
         throw new HttpException(404, 'The requested page does not exist.');
      }
   }
}
