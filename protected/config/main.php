<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Holiday Planner',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.yiimailer.YiiMailer',		
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'alma',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'mongoAdmin'=>array(
		),
		'alma' => array(
			
		),
		
	),

	// application components
	'components'=>array(
		'cache' => array(
				'class'=>'CRedisCache',
				'hostname'=>'localhost',
				'port'=>6379,
				'database'=>0,		
				'hashKey' => false,
		),
		'user'=>array(
			// enable cookie-based authentication
			'class' => 'application.components.WebUser',
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'encrypt' => array(
			'class' => 'application.components.Encrypt',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,			
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
//				'<controller:dashboard>'=>'<controller>/index',
//				'<controller:dashboard>/<id:\d+>'=>'<controller>/view',
//				'<controller:dashboard>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//				'<controller:dashboard>/<action:\w+>'=>'<controller>/<action>',
//				'<action:\w+>' => 'site/<action>',
//				'<action:\w+>/<userId:[\d\w]+>/<companyId:[\d\w]+>' => 'site/<action>',
//				'<action:userValidation>/<userId:[\d\w\.\-~]+>/<companyId:[\d\w\.\-~]+>' => 'site/<action>',
			),
		),
		
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'czene.gabor@gmail.com',
		'domain'	=> '',
		'encryption_key' => '4árvíztűrőtükö0rfúrógép',
	),
);