<?php

class DashboardController extends Controller
{
	
	public $layout = '//layouts/layoutSite';
	public $company;
	public $menu;
	
	public function actionIndex()
	{
		
		$this->render('index');
	}
	public function beforeAction(){
		Yii::app()->theme = 'holiday';
		return true;
	}

	public function filters(){
		return array(
			array(
			 'application.filters.SubdomainFilter',
			 ),
			array(
			 'application.filters.UserFilter',
			 ),
			
		);
	}

/*
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}