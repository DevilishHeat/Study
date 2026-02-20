<?php

namespace app\models\searchModels;

use app\models\Group;
use yii\data\ActiveDataProvider;

class GroupSearch extends Group
{
    public function rules()
    {
        return [
            [['number', 'specialisation_id', 'faculty_id'], 'integer'],
            [['start_date'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = Group::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['number' => $this->number]);
        $query->andFilterWhere(['specialisation_id' => $this->specialisation_id]);
        $query->andFilterWhere(['faculty_id' => $this->faculty_id]);
        $query->andFilterWhere(['like', 'start_date', $this->start_date]);
        return $dataProvider;
    }
}