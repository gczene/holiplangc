<?php

class Companies extends CMongo
{
	protected $_collection = 'companies';
	
	public $company;
	public $identifier;
	public $registeredBy;
	public $registered;
	
	
	public static function model($className=__CLASS__)
	{
			  return parent::model($className);
	}	
	 
	public function attributeLabels() {
		return array(
			'company'	=> 'Company',
			'identifier'	=> 'Identifier', // collection name
			'registeredBy' => 'Registered By',
			'registered' => 'Registered at',
		);
	}
	
	
	public function rules()
	{
		return array(
			array('registered', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('company, registeredBy, registered', 'safe',  'on'=>'search'),
		);
	}
	
	
	public static function emailToIdentifier($email){
		return preg_replace('/^.+@/', '', $email);
	}
	
	public function beforeSave() {
		if (! $this->registered){
			$this->registered = time();
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
				'company'=>array(
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