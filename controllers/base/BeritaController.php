<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\controllers\base;

use app\components\ActionSendFcm;
use app\components\UploadFile;
use app\models\Berita;
use app\models\search\BeritaSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\Action;
use app\models\User;
use Yii;
use yii\web\UploadedFile;

/**
 * BeritaController implements the CRUD actions for Berita model.
 */
class BeritaController extends Controller
{
use UploadFile;

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
     * Lists all Berita models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new BeritaSearch;
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
     * Displays a single Berita model.
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
     * Creates a new Berita model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // var_dump(ActionSendFcm::getMessage("ExponentPushToken[dvs18uMElj10c0yIBKLDFl]","Berita","23","Berita Baru","Tes var_dump"));die;
        $model = new Berita;

        try {
            $model->user_id = Yii::$app->user->id;
            if ($model->load($_POST)) {
                $slug = str_replace(' ', '-', $model->judul);
                $model->slug = $slug.date('Y-m-d');
                $gambar = UploadedFile::getInstance($model, 'gambar');
                $response = $this->uploadFile($gambar,'berita');
                if ($response->success == false) {
                    Yii::$app->session->setFlash('danger', 'Gagal Upload Foto');
                    // goto end;
                    return $this->render('create', ['model' => $model]);
                }
                $model->gambar = $response->filename;
                // if ($gambar != NULL) {
                //     # store the source gambars name
                //     $model->gambar = $gambar->name;
                //     $arr = explode(".", $gambar->name);
                //     $extension = end($arr);

                //     # generate a unique gambars name
                //     $model->gambar = Yii::$app->security->generateRandomString() . ".{$extension}";

                //     # the path to save gambars
                //     // unlink(Yii::getAlias("@app/web/uploads/pengajuan/") . $oldFile);
                //     if (file_exists(Yii::getAlias("@app/web/uploads/berita/")) == false) {
                //         mkdir(Yii::getAlias("@app/web/uploads/berita/"), 0777, true);
                //     }
                //     $path = Yii::getAlias("@app/web/uploads/berita/") . $model->gambar;
                //     $gambar->saveAs($path);
                // }
                if ($model->save()) {
                    $usrs = User::find()->where(['<>','fcm_token',""])->all();
                    foreach ($usrs as $value) {
                        $user = User::findOne(['id'=>$value->id]);
                        ActionSendFcm::getMessage($value->fcm_token,"berita",$model->id,"Berita Baru",$model->judul);
                        // var_dump(ActionSendFcm::getMessage($value->fcm_token,$model->id,"Berita Baru",$model->judul));die;
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } elseif (!\Yii::$app->request->isPost) {
                $model->load($_GET);
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            $model->addError('_exception', $msg);
        }
        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing Berita model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldgambar = $model->gambar;

        if ($model->load($_POST)) {
            $gambar = UploadedFile::getInstance($model, 'gambar');
            if ($gambar != NULL) {
                # store the source file name
                $model->gambar = $gambar->name;
                $arr = explode(".", $gambar->name);
                $extension = end($arr);

                # generate a unique file name
                $model->gambar = Yii::$app->security->generateRandomString() . ".{$extension}";

                # the path to save file
                if (file_exists(Yii::getAlias("@app/web/uploads/berita/")) == false) {
                    mkdir(Yii::getAlias("@app/web/uploads/berita/"), 0777, true);
                }
                $path = Yii::getAlias("@app/web/uploads/berita/") . $model->gambar;
                if ($oldgambar != NULL) {

                    $gambar->saveAs($path);
                    unlink(Yii::$app->basePath . '/web/uploads/berita/' . $oldgambar);
                } else {
                    $gambar->saveAs($path);
                }
            } else {
                $model->gambar = $oldgambar;
            }
            
            $model->save();
            return $this->redirect(Url::previous());
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Berita model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->findModel($id);
            $oldGambar = $model->gambar;
            unlink(Yii::$app->basePath . '/web/uploads/berita/' . $oldGambar);
            $model->delete();
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
     * Finds the Berita model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Berita the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Berita::findOne($id)) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }
}
