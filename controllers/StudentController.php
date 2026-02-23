<?php

namespace app\controllers;

use app\models\enums\PaymentTypeEnum;
use app\models\Group;
use app\models\searchModels\StudentSearch;
use app\models\Student;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class StudentController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

    public function actionCreate()
    {
        $model = new Student();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $groupList = ArrayHelper::map(Group::find()->all(), 'id', 'number');
        $paymentTypeList = PaymentTypeEnum::getList();
        return $this->render('form', [
            'model' => $model,
            'groupList' => $groupList,
            'paymentTypeList' => $paymentTypeList,
        ]);
    }

    public function actionView($id)
    {
        $model = Student::findOne($id);
        return $this->render('view', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = Student::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $groupList = ArrayHelper::map(Group::find()->all(), 'id', 'number');
        $paymentTypeList = PaymentTypeEnum::getList();
        return $this->render('form', [
            'model' => $model,
            'groupList' => $groupList,
            'paymentTypeList' => $paymentTypeList,
        ]);
    }

    public function actionDelete($id)
    {
        $model = Student::findOne($id);
        $model->delete();
        return $this->redirect(['index']);
    }
}