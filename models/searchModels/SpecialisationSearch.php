<?php

namespace app\models\searchModels;

use app\models\Specialisation;
use yii\data\ActiveDataProvider;

class SpecialisationSearch extends Specialisation
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'code'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = Specialisation::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'code', $this->code]);
        return $dataProvider;
    }

}