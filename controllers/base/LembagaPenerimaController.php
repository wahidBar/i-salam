<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\controllers\base;
use Yii;
use app\models\LembagaPenerima;
    use app\models\search\LembagaPenerimaSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\Action;

use yii\web\UploadedFile;
/**
* LembagaPenerimaController implements the CRUD actions for LembagaPenerima model.
*/
class LembagaPenerimaController extends Controller
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
* Lists all LembagaPenerima models.
* @return mixed
*/
public function actionIndex()
{
    $searchModel  = new LembagaPenerimaSearch;
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
* Displays a single LembagaPenerima model.
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
* Creates a new LembagaPenerima model.
* If creation is successful, the browser will be redirected to the 'view' page.
* @return mixed
*/
public function actionCreate()
{
$model = new LembagaPenerima;

try {
if ($model->load($_POST)) {
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
        if (file_exists(Yii::getAlias("@app/web/uploads/lembaga_penerima/")) == false) {
            mkdir(Yii::getAlias("@app/web/uploads/lembaga_penerima/"), 0777, true);
        }
        $path = Yii::getAlias("@app/web/uploads/lembaga_penerima/") . $model->foto;
        $fotos->saveAs($path);
    }
    if($model->save()){
        return $this->redirect(['view', 'id' => $model->id]);
    }
} elseif (!\Yii::$app->request->isPost) {
$model->load($_GET);
}
} catch (\Exception $e) {
$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
$model->addError('_exception', $msg);
}
return $this->render('create', ['model' => $model]);
}

/**
* Updates an existing LembagaPenerima model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id
* @return mixed
*/
public function actionUpdate($id)
{
$model = $this->findModel($id);

$oldfoto = $model->foto;
if ($model->load($_POST)) {
    $fotos = UploadedFile::getInstance($model, 'foto');
    if ($fotos != NULL) {
        # store the source file name
        $model->foto = $fotos->name;
        $arr = explode(".", $fotos->name);
        $extension = end($arr);

        # generate a unique file name
        $model->foto = Yii::$app->security->generateRandomString() . ".{$extension}";

        # the path to save file
        if (file_exists(Yii::getAlias("@app/web/uploads/lembaga_penerima/")) == false) {
            mkdir(Yii::getAlias("@app/web/uploads/lembaga_penerima/"), 0777, true);
        }
        $path = Yii::getAlias("@app/web/uploads/lembaga_penerima/") . $model->foto;
        if ($oldfoto != NULL) {

            $fotos->saveAs($path);
            unlink(Yii::$app->basePath . '/web/uploads/lembaga_penerima/' . $oldfoto);
        } else {
            $fotos->saveAs($path);
        }
    } else {
        $model->foto = $oldfoto;
    }
    if($model->save()){
        return $this->redirect(Url::previous());
    }
} else {
return $this->render('update', [
'model' => $model,
]);
}
}

/**
* Deletes an existing LembagaPenerima model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param integer $id
* @return mixed
*/
public function actionDelete($id)
{
try {
    $model = $this->findModel($id);
    if($model->flag == 0){
        $model->flag = 1;
    }else{
        $model->flag = 0;
    }
    $model->save();
} catch (\Exception $e) {
$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
\Yii::$app->getSession()->addFlash('error', $msg);
return $this->redirect(Url::previous());
}

// TODO: improve detection
$isPivot = strstr('$id',',');
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
* Finds the LembagaPenerima model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param integer $id
* @return LembagaPenerima the loaded model
* @throws HttpException if the model cannot be found
*/
protected function findModel($id)
{
if (($model = LembagaPenerima::findOne($id)) !== null) {
return $model;
} else {
throw new HttpException(404, 'The requested page does not exist.');
}
}
}
