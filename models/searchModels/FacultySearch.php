<?php

namespace app\models\searchModels;

use app\models\Faculty;
use yii\data\ActiveDataProvider;

class FacultySearch extends Faculty
{
    public function rules()
    {
        return [
            [['name'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Faculty::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}