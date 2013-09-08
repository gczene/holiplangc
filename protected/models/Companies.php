<?php

class Companies extends CMongo
{
	protected $_collection = 'companies';
	
	public $name;
	public $identifier;
	public $registeredBy;
	public $registered;
	public $url;
	public $subdomain;
	public $maxUsers;
	public $allowedDomains;
	public $organigram;
	
	static $minUsers = 20;
	
	
	public static function model($className=__CLASS__)
	{
			  return parent::model($className);
	}	
	 
	public function attributeLabels() {
		return array(
			'name'	=> 'Company Name',
			'identifier'	=> 'Identifier', // collection name
			'registeredBy' => 'Registered By',
			'registered' => 'Registered at',
			'url' => 'Website',
			'subdomain' => 'Subdomain',
			'maxUsers' => 'Max Users',
			'allowedDomains' => 'Allowed domains',
			'organigram' => 'Organigram',
		);
	}
	
	
	public function afterFind()
	{
//		if (is_array( $this->allowedDomains))
//			$this->allowedDomains = implode(',', $this->allowedDomains);
	}
	
	public function rules()
	{
		return array(
			array('name, url, subdomain', 'required'),
			array('name, subdomain', 'length', 'min' => 3),
			array('url', 'url'),
			array('maxUsers', 'numerical', 'integerOnly' => true),
			array('subdomain', 'isUniqueSubdomain', 'on' => 'register'),
			array('allowedDomains', 'arrangeDomains', 'on' => 'register'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, registeredBy, registered, allowedDomains, organigram', 'safe',  'on'=>'search'),
		);
	}
	
	public function arrangeDomains($attr){
		
		if ($this->{$attr}){
			$domains = array();
			$arr = explode(',', $this->{$attr});
			
			foreach($arr as $domain){
				$domain = trim($domain);
				if (!preg_match('/^[a-z0-9\-\._]+\.[a-z]{2,4}$/', $domain)){
					$this->addError($attr, 'One of the allowed domains is not correct: ' . $domain);
					return false;
				}
				else
					$domains[] = $domain;
			}
			$this->allowedDomains = $domains;
			return true;
		}
		else{
			$this->allowedDomains = array();
			return true;
		}
	}
	
	public function isUniqueSubdomain($attr){
		if ($this->isNewRecord){
			$subdomain = self::model()->findByAttributes(array('subdomain' => $this->{$attr}));
			if ($subdomain){
				$this->addError('subdomain', 'This subdomain is already in use!');
				return false;
			}
			else{
				return true;
			}
		}
		return true;
	}
	
	public static function emailToIdentifier($email){
		return preg_replace('/^.+@/', '', $email);
	}
	
	public function beforeSave() {
		if (! $this->registered){
			$this->registered = time();
		}
		
		if ($this->isNewRecord){
			$this->maxUsers = self::$minUsers;
		}
		
		parent::beforeSave();
		
		return true;
		
	}

	public function getCrudConfig()
	{
		$fields = array(

			'elements'=>array(
				'<fieldset ><legend class=""><i class="icol-pencil"></i>Register your company!</legend>',
				'firstName'=>array(
					'type'=>'text',
					'maxlength'=>32,
					'class' => 'text required',
				),
				'lastName'=>array(
					'type'=>'text',
					'maxlength'=>32,
					'class' => 'text required',
				),
				'name'=>array(
					'type'=>'text',
					'maxlength'=>32,
					'class' => 'text required',
				),
				'email'=>array(
					'type'=>'text',
					'maxlength'=>32,
					'class' => 'text required',
				),
				'</fieldset>',
			),
			'buttons'=>array(
					'register'=>array(
						'type'=>'submit',
						'label'=>'Register Your Company',
						'class'=>'submit'
					),				
			),			
			'class' => 'form'
		);	
		return $fields;
		
	}
	
			
	public function hints($key){
		$hints =  array(
			'allowedDomains' => 'If your company use more than one domain for emails (e.g. <i>domain.co, domain.org, etc</i>) specify them here <i>separated by commas</i>. <br /><b>Your email\'s domain added by default.</b>',
			'subdomain' => 'After registration your subdomain will be created at once. <br />You can visit the page at <b>http://choosedsubdomain.' . Yii::app()->params['domain'] .'</b>',
			'url'	=> 'Your company\'s website. <br />Started with http:// or https://',
		);
		return isset($hints[$key]) ? $hints[$key] : '';
		
	}
	
}