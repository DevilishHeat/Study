<?php

namespace app\controllers;

use app\models\Faculty;
use app\models\Group;
use app\models\searchModels\GroupSearch;
use app\models\Specialisation;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class GroupController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new GroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    public function actionCreate()
    {
        $model = new Group();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $specialisationList = ArrayHelper::map(Specialisation::find()->all(), 'id', 'name');
        $facultyList = ArrayHelper::map(Faculty::find()->all(), 'id', 'name');
        return $this->render('form', [
            'model' => $model,
            'specialisationList' => $specialisationList,
            'facultyList' => $facultyList,
        ]);
    }

    public function actionView($id)
    {
        $model = Group::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Group not found');
        }
        return $this->render('view', ['model' => $model]);
    }


    public function actionDelete($id)
    {
        $model = Group::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Group not found');
        }
        $model->delete();
        return $this->redirect(['index']);
    }

    public function actionUpdate($id)
    {
         $model = Group::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Group not found');
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $specialisationList = ArrayHelper::map(Specialisation::find()->all(), 'id', 'name');
        $facultyList = ArrayHelper::map(Faculty::find()->all(), 'id', 'name');
        return $this->render('form', [
            'model' => $model,
            'specialisationList' => $specialisationList,
            'facultyList' => $facultyList,
        ]);
    }
}