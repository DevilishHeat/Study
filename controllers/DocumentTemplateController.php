<?php

namespace app\controllers;
use app\models\DocumentTemplate;
use app\models\searchModels\DocumentTemplateSearch;
use Yii;
use yii\web\Controller;

class DocumentTemplateController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new DocumentTemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    public function actionCreate()
    {
        $model = new DocumentTemplate();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('form', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = DocumentTemplate::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = DocumentTemplate::findOne($id);
        $model->delete();
        return $this->redirect(['index']);
    }

    public function actionView($id)
    {
        $model = DocumentTemplate::findOne($id);
        return $this->render('view', ['model' => $model]);
    }
}