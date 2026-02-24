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
            [['groupNumber'], 'safe'],
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
        $query->joinWith('group');
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'fio', $this->fio]);
        $query->andFilterWhere(['like', 'phone', $this->phone]);
        $query->andFilterWhere(['group_id' => $this->group_id]);
        $query->andFilterWhere(['payment_type_id' => $this->payment_type_id]);
        $query->andFilterWhere(['group.number' => $this->group_id]);
        return $dataProvider;
    }
}