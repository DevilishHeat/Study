<?php

namespace app\models\searchModels;

use app\models\Student;
use yii\data\ActiveDataProvider;

class StudentSearch extends Student
{

    public function rules()
    {
        return [
            [['id', 'group_id', 'payment_type_id'], 'integer'],
            [['fio', 'phone'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = static::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'fio', $this->fio]);
        $query->andFilterWhere(['like', 'phone', $this->phone]);
        $query->andFilterWhere(['group_id' => $this->group_id]);
        $query->andFilterWhere(['payment_type_id' => $this->payment_type_id]);
        return $dataProvider;
    }
}