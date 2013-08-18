<?php

class SiteController extends Controller
{
	
	
	public $layout = '//layouts/layoutSite';
	public $company;
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	
	public function beforeAction(){
		Yii::app()->theme = 'holiday';
		
		Yii::app()->clientScript->registerCoreScript('jquery');
		return true;
		
		
	}
	public function actionRegister()
	{
		
		Yii::app()->clientScript->registerScriptFile( Yii::app()->theme->baseUrl . '/assets/js/registration.js' );

		$user = new Users('register');
		$company = new Companies('register');
		
		if (isset($_POST['Users']) && isset($_POST['Companies'])){
			$company->attributes	= $_POST['Companies'];
			$user->attributes		= $_POST['Users'];
			$validUser				= $user->validate();
			$validCompany			= $company->validate();
			if ( $validCompany && $validUser ){
				$company->save();
                $password = $user->password;
                $user->identifier = $company->_id;
                $user->access_level = Users::$accessLevels;
                $user->save();
                $company->registeredBy = $user->_id;
                $company->save();
				$this->redirect( '/successfullRegistration' . ( YII_DEBUG ? '?url=' . urlencode($this->_getValidationLink($user->_id, $company->_id, $company->subdomain))  : '' ));
                /* log in the user */
                
			}
		}
		else
			$this->render('viewRegister', array(
				'company' => $company,
				'user'	=> $user,
				
			));
	}
	
	
	private function _getValidationLink($userId, $companyId, $subdomain)
	{
		return 'http://' . $subdomain . '.' . Yii::app()->params['domain'] . '/userValidation/' . $userId . '/' . $companyId;
	}
	
	
	public function actionSuccessfullRegistration()
	{
		if (YII_DEBUG)
			echo urldecode ($_GET['url']);
		
		$this->render('viewSuccessfullRegistraion');
	}
	
	public function actionCompanyDetails()
	{
		echo Yii::app()->user->getState('identifier');
		$this->render('viewCompanyDetails');
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	
	public function filters(){
		return array(
			array(
			 'application.filters.SubdomainFilter',
			 )
			
		);
	}
	
}