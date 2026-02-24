<?php

namespace app\models\searchModels;

use app\models\Employee;
use yii\data\ActiveDataProvider;

class EmployeeSearch extends Employee
{
    public function rules()
    {
        return [
            [['fio', 'phone', 'position'], 'string'],
            [['faculty_id'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = Employee::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'fio', $this->fio]);
        $query->andFilterWhere(['like', 'phone', $this->phone]);
        $query->andFilterWhere(['like', 'position', $this->position]);
        $query->andFilterWhere(['faculty_id' => $this->faculty_id]);

        return $dataProvider;
    }
}


