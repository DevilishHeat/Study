<?php

namespace app\models\searchModels;

use app\models\DocumentTemplate;
use yii\data\ActiveDataProvider;

class DocumentTemplateSearch extends DocumentTemplate
{
    public function rules()
    {
        return [
            [['title', 'created_at', 'updated_at'], 'string'],
        ];
    }

    public function search($params)
    {
        $query = DocumentTemplate::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'created_at', $this->created_at]);
        $query->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }
}