<?php

use yii\db\mssql\Schema;

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=study_practice',
    'username' => 'admin',
    'password' => 'vertrigo',
    'charset' => 'utf8',
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600,
    'schemaCache' => 'cache',
];
