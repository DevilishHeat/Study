<?php

namespace app\controllers;
use app\models\searchModels\SpecialisationSearch;
use app\models\Specialisation;
use Yii;
use yii\web\Controller;

class SpecialisationController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new SpecialisationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    public function actionCreate()
    {
        $model = new Specialisation();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('form', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = Specialisation::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = Specialisation::findOne($id);
        $model->delete();
        return $this->redirect(['index']);
    }

    public function actionView($id)
    {
        $model = Specialisation::findOne($id);
        return $this->render('view', ['model' => $model]);
    }
}