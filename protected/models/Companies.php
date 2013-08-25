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
		);
	}
	
	
	public function rules()
	{
		return array(
			array('name, url, subdomain', 'required'),
			array('name, subdomain', 'length', 'min' => 3),
			array('url', 'url'),
			array('maxUsers', 'numerical', 'integerOnly' => true),
			array('subdomain', 'isUniqueSubdomain', 'on' => 'register'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, registeredBy, registered', 'safe',  'on'=>'search'),
		);
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
				'first_name'=>array(
					'type'=>'text',
					'maxlength'=>32,
					'class' => 'text required',
				),
				'last_name'=>array(
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
	
			
	
	
}