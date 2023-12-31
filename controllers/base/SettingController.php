<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\controllers\base;

use Yii;
use app\models\Setting;
use app\models\search\SettingSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\Action;
use yii\web\UploadedFile;
use app\components\UploadFile;

/**
 * SettingController implements the CRUD actions for Setting model.
 */
class SettingController extends Controller
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
     * Lists all Setting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = Setting::find()->all();
        $searchModel  = new SettingSearch;
        $dataProvider = $searchModel->search($_GET);

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        if ($model == null) {
            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]);
        } else {
            return $this->redirect(['view', 'id' => $model[0]["id"]]);
        }
    }

    /**
     * Displays a single Setting model.
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
     * Creates a new Setting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Setting;

        try {
            if ($model->load($_POST)) {
                $url = 'https://www.youtube.com/watch?v=oVT78QcRQtU';
                $embeded_url = $this->getYoutubeEmbedUrl($url);

                echo $embeded_url;
                die;

                $logos = UploadedFile::getInstance($model, 'logo');
                if ($logos != NULL) {
                    # store the source logos name
                    $model->logo = $logos->name;
                    $arr = explode(".", $logos->name);
                    $extension = end($arr);

                    # generate a unique logos name
                    $model->logo = Yii::$app->security->generateRandomString() . ".{$extension}";

                    # the path to save logos
                    // unlink(Yii::getAlias("@app/web/uploads/pengajuan/") . $oldFile);
                    if (file_exists(Yii::getAlias("@app/web/uploads/setting/")) == false) {
                        mkdir(Yii::getAlias("@app/web/uploads/setting/"), 0777, true);
                    }
                    $path = Yii::getAlias("@app/web/uploads/setting/") . $model->logo;
                    $logos->saveAs($path);
                }

                $bg_logins = UploadedFile::getInstance($model, 'bg_login');
                if ($bg_logins != NULL) {
                    # store the source bg_logins name
                    $model->bg_login = $bg_logins->name;
                    $arr = explode(".", $bg_logins->name);
                    $extension = end($arr);

                    # generate a unique bg_logins name
                    $model->bg_login = Yii::$app->security->generateRandomString() . ".{$extension}";

                    # the path to save bg_logins
                    // unlink(Yii::getAlias("@app/web/uploads/pengajuan/") . $oldFile);
                    if (file_exists(Yii::getAlias("@app/web/uploads/setting/")) == false) {
                        mkdir(Yii::getAlias("@app/web/uploads/setting/"), 0777, true);
                    }
                    $path = Yii::getAlias("@app/web/uploads/setting/") . $model->bg_login;
                    $bg_logins->saveAs($path);
                }

                $bg_pins = UploadedFile::getInstance($model, 'bg_pin');
                if ($bg_pins != NULL) {
                    # store the source bg_pins name
                    $model->bg_pin = $bg_pins->name;
                    $arr = explode(".", $bg_pins->name);
                    $extension = end($arr);

                    # generate a unique bg_pins name
                    $model->bg_pin = Yii::$app->security->generateRandomString() . ".{$extension}";

                    # the path to save bg_pins
                    // unlink(Yii::getAlias("@app/web/uploads/pengajuan/") . $oldFile);
                    if (file_exists(Yii::getAlias("@app/web/uploads/setting/")) == false) {
                        mkdir(Yii::getAlias("@app/web/uploads/setting/"), 0777, true);
                    }
                    $path = Yii::getAlias("@app/web/uploads/setting/") . $model->bg_pin;
                    $bg_pins->saveAs($path);
                }

                $banners = UploadedFile::getInstance($model, 'banner');
                if ($banners != NULL) {
                    # store the source banners name
                    $model->banner = $banners->name;
                    $arr = explode(".", $banners->name);
                    $extension = end($arr);

                    # generate a unique banners name
                    $model->banner = Yii::$app->security->generateRandomString() . ".{$extension}";

                    # the path to save banners
                    // unlink(Yii::getAlias("@app/web/uploads/pengajuan/") . $oldFile);
                    if (file_exists(Yii::getAlias("@app/web/uploads/setting/")) == false) {
                        mkdir(Yii::getAlias("@app/web/uploads/setting/"), 0777, true);
                    }
                    $path = Yii::getAlias("@app/web/uploads/setting/") . $model->banner;
                    $banners->saveAs($path);
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
        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing Setting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldlogo = $model->logo;
        $oldlogin = $model->bg_login;
        $oldpin = $model->bg_pin;
        $oldikut = $model->ikut_wakaf;
        $oldftk = $model->banner;
        $olddaftar_wakaf = $model->daftar_wakaf;

        if ($model->load($_POST)) {
            $url = $model->youtube_link;
            $embeded_url = $this->getYoutubeEmbedUrl($url);
            $model->youtube_link = $embeded_url;
            $logo = UploadedFile::getInstance($model, 'logo');
            if ($logo != NULL) {
                # store the source file name
                $model->logo = $logo->name;
                $arr = explode(".", $logo->name);
                $extension = end($arr);

                # generate a unique file name
                $model->logo = Yii::$app->security->generateRandomString() . ".{$extension}";

                # the path to save file
                if (file_exists(Yii::getAlias("@app/web/uploads/setting/")) == false) {
                    mkdir(Yii::getAlias("@app/web/uploads/setting/"), 0777, true);
                }
                $path = Yii::getAlias("@app/web/uploads/setting/") . $model->logo;
                if ($oldlogo != NULL) {

                    $logo->saveAs($path);
                    unlink(Yii::$app->basePath . '/web/uploads/setting/' . $oldlogo);
                } else {
                    $logo->saveAs($path);
                }
            } else {
                $model->logo = $oldlogo;
            }

            $daftar_wakaf = UploadedFile::getInstance($model, 'daftar_wakaf');
            if ($daftar_wakaf != NULL) {
                # store the source file name
                $model->daftar_wakaf = $daftar_wakaf->name;
                $arr = explode(".", $daftar_wakaf->name);
                $extension = end($arr);

                # generate a unique file name
                $model->daftar_wakaf = Yii::$app->security->generateRandomString() . ".{$extension}";

                # the path to save file
                if (file_exists(Yii::getAlias("@app/web/uploads/setting/")) == false) {
                    mkdir(Yii::getAlias("@app/web/uploads/setting/"), 0777, true);
                }
                $path = Yii::getAlias("@app/web/uploads/setting/") . $model->daftar_wakaf;
                if ($olddaftar_wakaf != NULL) {

                    $daftar_wakaf->saveAs($path);
                    unlink(Yii::$app->basePath . '/web/uploads/setting/' . $olddaftar_wakaf);
                } else {
                    $daftar_wakaf->saveAs($path);
                }
            } else {
                $model->daftar_wakaf = $olddaftar_wakaf;
            }

            // if ($ikut_wakaf != NULL) {
            //     # store the source file name
            //     $model->ikut_wakaf = $ikut_wakaf->name;
            //     $arr = explode(".", $ikut_wakaf->name);
            //     $extension = end($arr);

            //     # generate a unique file name
            //     $model->ikut_wakaf = Yii::$app->security->generateRandomString() . ".{$extension}";

            //     # the path to save file
            //     if (file_exists(Yii::getAlias("@app/web/uploads/setting/")) == false) {
            //         mkdir(Yii::getAlias("@app/web/uploads/setting/"), 0777, true);
            //     }
            //     $path = Yii::getAlias("@app/web/uploads/setting/") . $model->ikut_wakaf;
            //     if ($oldikut != NULL) {

            //         $ikut_wakaf->saveAs($path);
            //         unlink(Yii::$app->basePath . '/web/uploads/setting/' . $oldikut);
            //     } else {
            //         $ikut_wakaf->saveAs($path);
            //     }
            // } else {
            //     $model->ikut_wakaf = $oldikut;
            // }

            $ikut_wakaf = UploadedFile::getInstance($model, 'ikut_wakaf');
            if ($ikut_wakaf) {
                $response = $this->uploadImage($ikut_wakaf, "setting");
                if ($response->success == false) {
                    throw new HttpException(419, "Gambar gagal diunggah");
                }
                $model->ikut_wakaf = $response->filename;
            } else {
                $model->ikut_wakaf = $oldikut;
            }

            $bg_login = UploadedFile::getInstance($model, 'bg_login');
            if ($bg_login != NULL) {
                # store the source file name
                $model->bg_login = $bg_login->name;
                $arr = explode(".", $bg_login->name);
                $extension = end($arr);

                # generate a unique file name
                $model->bg_login = Yii::$app->security->generateRandomString() . ".{$extension}";

                # the path to save file
                if (file_exists(Yii::getAlias("@app/web/uploads/setting/")) == false) {
                    mkdir(Yii::getAlias("@app/web/uploads/setting/"), 0777, true);
                }
                $path = Yii::getAlias("@app/web/uploads/setting/") . $model->bg_login;
                if ($oldlogin != NULL) {

                    $bg_login->saveAs($path);
                    // unlink(Yii::$app->basePath . '/web/uploads/setting/' . $oldlogin);
                } else {
                    $bg_login->saveAs($path);
                }
            } else {
                $model->bg_login = $oldlogin;
            }

            $bg_pin = UploadedFile::getInstance($model, 'bg_pin');
            if ($bg_pin != NULL) {
                # store the source file name
                $model->bg_pin = $bg_pin->name;
                $arr = explode(".", $bg_pin->name);
                $extension = end($arr);

                # generate a unique file name
                $model->bg_pin = Yii::$app->security->generateRandomString() . ".{$extension}";

                # the path to save file
                if (file_exists(Yii::getAlias("@app/web/uploads/setting/")) == false) {
                    mkdir(Yii::getAlias("@app/web/uploads/setting/"), 0777, true);
                }
                $path = Yii::getAlias("@app/web/uploads/setting/") . $model->bg_pin;
                if ($oldpin != NULL) {

                    $bg_pin->saveAs($path);
                    unlink(Yii::$app->basePath . '/web/uploads/setting/' . $oldpin);
                } else {
                    $bg_pin->saveAs($path);
                }
            } else {
                $model->bg_pin = $oldpin;
            }

            $banner = UploadedFile::getInstance($model, 'banner');
            if ($banner != NULL) {
                # store the source file name
                $model->banner = $banner->name;
                $arr = explode(".", $banner->name);
                $extension = end($arr);

                # generate a unique file name
                $model->banner = Yii::$app->security->generateRandomString() . ".{$extension}";

                # the path to save file
                if (file_exists(Yii::getAlias("@app/web/uploads/setting/")) == false) {
                    mkdir(Yii::getAlias("@app/web/uploads/setting/"), 0777, true);
                }
                $path = Yii::getAlias("@app/web/uploads/setting/") . $model->banner;
                if ($oldftk != NULL) {

                    $banner->saveAs($path);
                    unlink(Yii::$app->basePath . '/web/uploads/setting/' . $oldftk);
                } else {
                    $banner->saveAs($path);
                }
            } else {
                $model->banner = $oldftk;
            }

            $model->save();
            return $this->redirect(Url::previous());
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    function getYoutubeEmbedUrl($url)
    {
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))(\w+)/i';

        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }

        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        return 'https://www.youtube.com/embed/' . $youtube_id;
    }
    /**
     * Deletes an existing Setting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
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

    public function actionUnduh($id)
    {
        $model = $this->findModel($id);
        $file = $model->ikut_wakaf;
        // $model->tanggal_received=date('Y-m-d H:i:s');
        $path = Yii::getAlias("@app/web/uploads/setting/") . $file;
        $arr = explode(".", $file);
        $extension = end($arr);
        $nama_file = "Tata Cara ikut Wakaf ." . $extension;

        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path, $nama_file);
        } else {
            throw new \yii\web\NotFoundHttpException("{$path} is not found!");
        }
    }
    /**
     * Finds the Setting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Setting the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Setting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }
}
