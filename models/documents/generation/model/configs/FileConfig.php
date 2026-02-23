<?php

namespace proleads\documents\models\generation\model\configs;

use Yii;
use yii\base\BaseObject;

class FileConfig extends BaseObject
{
    public string $rootDir;

    public string $webDir;

    public string $fileName;

    public function getFileDir(): string
    {
        return Yii::getAlias($this->rootDir . $this->webDir);
    }

    public function getFilePath($web = false):string{
        if(!$web) {
            return $this->getFileDir() . "/" . $this->fileName;
        }

        return Yii::getAlias($this->webDir."/".$this->fileName);
    }
    
}