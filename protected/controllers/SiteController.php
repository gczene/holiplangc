<?php

class SiteController extends Controller
{
	
	
	public $layout = '//layouts/layoutSite';
	public $company;
	public $menu;
	
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

		if ($this->company){
			$this->_userRegistratoin();
		}
		else{
			$this->_companyRegistration();
		}
	}
	
	private function _userRegistratoin()
	{
		$user = new Users('register');
		if (isset($_POST['Users'])){
			$user->attributes		= $_POST['Users'];
			$user->identifier			= $this->company->_id;
			if ( $user->validate() ){
				$password = $user->password;
				$user->identifier = $this->company->_id;
				$user->access_level = array();
				$user->save();
				/*
				 * mail to admins
				 */
				$this->redirect( '/successfullRegistration' . ( YII_DEBUG ? '?url=' . urlencode($this->_getValidationLink($user->_id, $this->company->_id, $this->company->subdomain))  : '' ));
                
			}
		}
		
		$this->render('viewUserRegister', array(
			'user'	=> $user,
		));
		
	}
	
	private function _companyRegistration()
	{
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
                
			}
		}
		
			$this->render('viewRegister', array(
				'company' => $company,
				'user'	=> $user,
				
			));
		
	}
	
	/*
	 * validation link after registration
	 * 
	 */
	private function _getValidationLink($userId, $companyId, $subdomain)
	{
		return 'http://' . $subdomain . '.' . Yii::app()->params['domain'] . '/userValidation/' . Yii::app()->encrypt->encode( $userId ) . '/' . Yii::app()->encrypt->encode($companyId);
	}
	
	
	public function actionUserValidation(){
		
		if (isset($_GET['userId']) && isset($_GET['companyId']))
		{
			$userId = Yii::app()->encrypt->decode($_GET['userId']);
			$companyId = Yii::app()->encrypt->decode($_GET['companyId']);
			$company = Companies::model()->findByPk($companyId);
			$user = Users::model()->setCollection( $companyId . '.users' )->findByPk($userId);
			if ($company && (COMPANY == $company->subdomain) && $user ){
				
				if ($user->status == 0){
					$user->status = 1;
					$user->save();
				}
				
				$this->actionLogin(true);

			}
			else{
				throw new CHttpException(404, 'Something went wrong!');
			}
			
		}
		
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
	public function actionLogin($validated = false)
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
//			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			$model->companyId = $this->company->_id;
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect( '/dashboard' );
		}
		
		// display the login form
		$this->render('login',array('model'=>$model, 'validated' => $validated));
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