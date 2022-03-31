<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\controllers\base;

use Yii;
use app\models\Pembayaran;
use app\models\Notifikasi;
use app\models\search\PembayaranSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\Action;
use app\models\Setting;
use app\models\User;
use kartik\mpdf\Pdf;
use yii\web\UploadedFile;

/**
 * PembayaranController implements the CRUD actions for Pembayaran model.
 */
class PembayaranController extends Controller
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
     * Lists all Pembayaran models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new PembayaranSearch;
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
     * Displays a single Pembayaran model.
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
     * Creates a new Pembayaran model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pembayaran;

        try {
            if ($model->load($_POST)) {
                $model->user_id = \Yii::$app->user->identity->id;
                $model->status_id = 5;
                // $model->tanggal_pembayaran = date('Y-m-d');
                $bukti_transaksis = UploadedFile::getInstance($model, 'bukti_transaksi');
                if ($bukti_transaksis != NULL) {
                    # store the source bukti_transaksis name
                    $model->bukti_transaksi = $bukti_transaksis->name;
                    $arr = explode(".", $bukti_transaksis->name);
                    $extension = end($arr);

                    # generate a unique bukti_transaksis name
                    $model->bukti_transaksi = Yii::$app->security->generateRandomString() . ".{$extension}";

                    # the path to save bukti_transaksis
                    // unlink(Yii::getAlias("@app/web/uploads/pengajuan/") . $oldFile);
                    if (file_exists(Yii::getAlias("@app/web/uploads/pembayaran/bukti_transaksi/")) == false) {
                        mkdir(Yii::getAlias("@app/web/uploads/pembayaran/bukti_transaksi/"), 0777, true);
                    }
                    $path = Yii::getAlias("@app/web/uploads/pembayaran/bukti_transaksi/") . $model->bukti_transaksi;
                    $bukti_transaksis->saveAs($path);
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
    public function actionApprovePembayaran($id)
    {
        $model = $this->findModel($_GET['id']);
        //return print_r($model);
        if ($model) {
            $model->status_id = 6;
            $model->tanggal_konfirmasi = date('Y-m-d H:i:s');
            if ($model->save()) {
            $notifikasi = new Notifikasi;
            $notifikasi->message = "Pembayaran dana untuk Pendanaan ".$model->pendanaan->nama_pendanaan." Telah disetujui";
            $notifikasi->user_id = $model->user_id;
            $notifikasi->flag = 1;
            $notifikasi->date=date('Y-m-d H:i:s');
            $notifikasi->save();

                \Yii::$app->getSession()->setFlash(
                    'success',
                    'Pembayaran Telah Disetujui!'
                );
            } else {
                \Yii::$app->getSession()->setFlash(
                    'danger',
                    'Pembayaran Gagal Disetujui!'
                );
            }
            return $this->redirect(['index']);
        }
    }
    public function actionPembayaranTolak($id)
    {
        $model = $this->findModel($_GET['id']);
        //return print_r($model);
        if ($model) {
            $model->status_id = 8;
            if ($model->save()) {

                $model->tanggal_konfirmasi = date('Y-m-d H:i:s');
                $notifikasi = new Notifikasi;
                $notifikasi->message = "Pembayaran dana untuk Pendanaan ".$model->pendanaan->nama_pendanaan." Telah ditolak";
                $notifikasi->user_id = $model->user_id;
                $notifikasi->flag = 1;
                $notifikasi->date=date('Y-m-d H:i:s');
                $notifikasi->save();
                \Yii::$app->getSession()->setFlash(
                    'success',
                    'Pembayaran Telah Ditolak!'
                );
            } else {
                \Yii::$app->getSession()->setFlash(
                    'danger',
                    'Pembayaran Gagal Ditolak!'
                );
            }
            return $this->redirect(['index']);
        }
    }

    /**
     * Updates an existing Pembayaran model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldBukti = $model->bukti_transaksi;

        try {
            if ($model->load($_POST)) {
                $bukti_transaksis = UploadedFile::getInstance($model, 'bukti_transaksi');
                if ($bukti_transaksis != NULL) {
                    # store the source file name
                    $model->bukti_transaksi = $bukti_transaksis->name;
                    $arr = explode(".", $bukti_transaksis->name);
                    $extension = end($arr);
    
                    # generate a unique file name
                    $model->bukti_transaksi = Yii::$app->security->generateRandomString() . ".{$extension}";
    
                    # the path to save file
                    if (file_exists(Yii::getAlias("@app/web/uploads/pembayaran/bukti_transaksi/")) == false) {
                        mkdir(Yii::getAlias("@app/web/uploads/pembayaran/bukti_transaksi/"), 0777, true);
                    }
                    $path = Yii::getAlias("@app/web/uploads/pembayaran/bukti_transaksi/") . $model->bukti_transaksi;
                    if ($oldBukti != NULL) {
    
                        $bukti_transaksis->saveAs($path);
                        unlink(Yii::$app->basePath . '/web/uploads/pembayaran/bukti_transaksi/' . $oldBukti);
                    } else {
                        $bukti_transaksis->saveAs($path);
                    }
                } else {
                    $model->bukti_transaksi = $oldBukti;
                }
    
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            \Yii::$app->getSession()->addFlash('error', $msg);
            return $this->redirect(Url::previous());
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Pembayaran model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->findModel($id);
            $oldBukti = $model->bukti_transaksi;
            $model->delete();
            unlink(Yii::$app->basePath . '/web/uploads/pembayaran/bukti_transaksi/' . $oldBukti);
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
    public function actionCetak($id) {
        $formatter = \Yii::$app->formatter;
        $model = Pembayaran::findOne(['id' => $id]);
        $content = $this->renderPartial('view-print',[
            'model' => $model,
    ]);
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            //Name file
            'filename' => 'Akad Wakaf'."pdf",
            // LEGAL paper format
            'format' => Pdf::FORMAT_LEGAL, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            'marginHeader' => 0,
            'marginFooter' => 1,
            'marginTop' => 1,
            'marginBottom' => 5,
            'marginLeft' => 0,
            'marginRight' => 0,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            // 'cssInline' => '.kv-heading-1{font-size:25px}', 
            'cssInline' => 'body { font-family: irannastaliq; font-size: 17px; }.page-break {display: none;};
            .kv-heading-1{font-size:17px}table{width: 100%;line-height: inherit;text-align: left; border-collapse: collapse;}table, td, th {margin-left:50px;margin-right:50px;},fa { font-family: fontawesome;} @media print{
                .page-break{display: block;page-break-before: always;}
            }',
             // set mPDF properties on the fly
             'options' => [               
                'defaultheaderline' => 0,  //for header
                 'defaultfooterline' => 0,  //for footer
            ],
             // call mPDF methods on the fly
            'methods' => [
                'SetTitle'=>'Print', 
                'SetHeader' => $this->renderPartial('header_gambar'),
              //   // 'SetHeader'=>['AMONG TANI FOUNDATION'],
              //   'SetFooter'=>$this->renderPartial('footer_gambar'),
                
            ]
        ]);
        return $pdf->render(); 
    }
    /**
     * Finds the Pembayaran model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pembayaran the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pembayaran::findOne($id)) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }
}
