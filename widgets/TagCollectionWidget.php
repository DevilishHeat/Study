<?php

use app\models\tags\TagCollection;
use yii\base\Widget;

class TagsDescriptionWidget extends Widget
{
    public ?TagCollection $tagCollection = null;

    public function run()
    {
        if (!$this->tagCollection) {
            return '';
        }
        return $this->render('tagsDescription', ['tagCollection' => $this->tagCollection]);
    }
}