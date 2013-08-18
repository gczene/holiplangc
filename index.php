<?php

define ('COMPANY', apache_getenv('CLIENT_NAME')) ;

// change the following paths if necessary
$yii=dirname(__FILE__).'./../yii-core/yii.php';
//
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);

$base=require( dirname(__FILE__).'/protected/config/main.php' );
if (file_exists(dirname(__FILE__) . '/protected/config/main-local.php')){
	$local=require(dirname(__FILE__).'/protected/config/main-local.php');
	$config=CMap::mergeArray($base, $local);
}
else{
	$config=dirname(__FILE__).'/protected/config/main.php';
}

Yii::createWebApplication($config)->run();
