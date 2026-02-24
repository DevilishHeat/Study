<?php

namespace app\controllers;

use app\models\Employee;
use app\models\Faculty;
use app\models\searchModels\EmployeeSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class EmployeeController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    public function actionCreate()
    {
        $model = new Employee();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $facultyList = ArrayHelper::map(Faculty::find()->all(), 'id', 'name');
        return $this->render('form', ['model' => $model, 'facultyList' => $facultyList]);
    }

    public function actionUpdate($id)
    {
        $model = Employee::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $facultyList = ArrayHelper::map(Faculty::find()->all(), 'id', 'name');
        return $this->render('form', ['model' => $model, 'facultyList' => $facultyList]);
    }

    public function actionDelete($id)
    {
        $model = Employee::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Employee not found');
        }
        $model->delete();
        return $this->redirect(['index']);
    }

    public function actionView($id)
    {
        $model = Employee::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Employee not found');
        }
        return $this->render('view', ['model' => $model]);
    }
}