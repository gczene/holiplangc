<?php

class OrganigramController extends Controller
{
	public $layout = '//layouts/layoutSite';
	public $company;
	public $menu;
	
	public function actionIndex()
	{
		Yii::app()->clientScript->registerScript('org', 'var organogram = ' . json_encode($this->company->organigram) .' ;', CClientScript::POS_HEAD)
				->registerScript('compName', 'var compName = "' . $this->company->name . '";', CClientScript::POS_HEAD);
		
		$this->render('index', array(
			'company' => $this->company,
		));
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
	
	
	public function beforeAction(){
		Yii::app()->theme = 'holiday';
		Yii::app()->clientScript->registerScriptFile( Yii::app()->theme->baseUrl .'/assets/js/jquery.orgchart.min.js' )
				->registerScriptFile( Yii::app()->theme->baseUrl .'/assets/colorbox/jquery.colorbox-min.js' )
				->registerScriptFile( Yii::app()->theme->baseUrl .'/assets/js/organigram.js' )
				->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/organogram.css')
				->registerCssFile(Yii::app()->theme->baseUrl . '/assets/colorbox/colorbox.css')
				;

		
		return true;
		
		
	}
	
	public function actionGetForm()
	{
		$department = Companies::getOneDepartment($this->company, $_GET['id']);
		$this->renderPartial('partials/viewGetForm', array(
			'id' => $_GET['id'],
			'department' => $department,
		));
	}


	
	public function actionAddDepartment(){
		if (isset($_POST['Department']) && YII::app()->request->isAjaxRequest){
			
			$department = new Departments; // for validate
			$department->attributes = $_POST['Department'];
			if ($department->validate())
			{
				$this->company->updateDepartment($department);
			}
//			die();
			print_r($department->attributes);
			
			print_r($department->errors);
//			$this->company->updateDepartment()
		}
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

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