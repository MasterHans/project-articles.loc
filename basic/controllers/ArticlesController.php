<?php

namespace app\controllers;

use app\models\Sections;
use Imagine\Image\Box;
use Yii;
use app\models\Articles;
use app\models\ArticlesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

use yii\imagine\Image;
/**
 * ArticlesController implements the CRUD actions for Articles model.
 */
class ArticlesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Articles models.
     * @return mixed
     */
    public function actionIndex()
    {


        $searchModel = new ArticlesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 5; // пагинация

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Articles model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Articles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $sections = new Sections();
        $model = new Articles();

        /*
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'sections' => $sections,
            ]);
        }
        */

        if ($model->load(Yii::$app->request->post())) {

            // убираем все теги, кроме маски
            $model->text = strip_tags($model->text, '<a><code><i><strike><strong>');

            // получаем загруженный файл
            $imageFile = UploadedFile::getInstance($model,'img');
            $model->img = $imageFile;


            // валидируем
            if ($model->validate()) {

                // сохраняем изображение в папку
                $imageFile->saveAs('uploads/' . $model->img->baseName . '.' . $model->img->extension);

                // жесткое изменение размера сохраненного файла
                //Image::thumbnail(Yii::getAlias('@webroot/uploads/'.$imageFile->name), 300, 200)->save(Yii::getAlias('@webroot/uploads/resize-'.$imageFile->name), ['quality' => 80]);

                // пропорциональное изменение размера сохраненного файла
                $img = Image::getImagine()->open(Yii::getAlias('@webroot/uploads/'.$imageFile->name));
                $size = $img->getSize();
                $ratio = $size->getWidth()/$size->getHeight();
                $width = 300;
                $height = round($width/$ratio);
                Image::thumbnail(Yii::getAlias('@webroot/uploads/'.$imageFile->name),$width,$height)
                    ->save('uploads/resize-'.$imageFile->name);

                $model->img = $imageFile->name;

                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'sections' => $sections,
            ]);
        }



    }

    /**
     * Updates an existing Articles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Articles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Articles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Articles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Articles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
