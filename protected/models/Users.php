<?php
class Users extends CMongo
{
	public $firstName;
	public $lastName;
	public $email;
	public $identifier;
	public $password;
	public $password2;
	public $registered;
	public  $salt;
	public $last_activity;
	public $status;
	public $accessLevel;
	static $accessLevels = array(
		'accountant',
		'manager',
		'superUser',
	);

	
	public static function model($className=__CLASS__)
	{
			  return parent::model($className);
	}	

	/*
	 * a user attributes
	 * @return array
	 */
	public function attributeLabels() {
		return array(
			'firstName'	=> 'First Name',
			'lastName'		=> 'Last Name',
			'email'		=> 'E-mail',
			'password'		=> 'Password',
			'password2'	=> 'Password again',
			'identifier'		=> 'Identifier',
			'registered'		=> 'Registered',
			'salt'			=> 'Salt',
			'last_activity'	=> 'Last activity',
			'status'		=> 'Status',
			'accessLevel'	=> 'Access Level',
		);
	}
	
	/*
	 * validation rules 
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('firstName, lastName, email', 'required'),
			array('email', 'email'),
			array('password', 'length', 'min' => 5, 'on' => 'register'),
			array('password, password2', 'required', 'on' => 'register'),
			array('password', 'compare', 'compareAttribute' => 'password2' , 'on' => 'register'),
			array('email', 'isRegistered', 'on' => 'register'),
			array('last_activity, registered, status', 'numerical',  'integerOnly' => true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('_id,firstName, lastName, company, email, password, registered, accessLevel', 'safe', 'on'=>'search'),
		);
	}
	
	/*
	 * unique checking for "register" scenario
	 * @return bool
	 */
	public function isRegistered()
	{
		/* company's page and the user identifier's property is filled */
		if (COMPANY && $this->identifier){
				$company = Companies::model()->findByPk($this->identifier);
				if (!in_array( preg_replace('/.+@/', '', $this->email ), $company->allowedDomains )){
					$this->addError('email', 'You can not register with this email address!');
					return false;
				}
				$this->setCollection( $this->identifier  . '.users' );
				if (Users::model()->setCollection($this->getCollection())->findByAttributes(array('email' => $this->email))){
					$this->addError('email', 'You are already registered!');
					return false;
				}
				else{
					$this->last_activity = $this->registered = time();
					return true;
				}
		}
		/* company registration  */
		else
			return true;
	}
	
	/*
	 * registration form config
	 * @return array
	 */
	public function getRegisterConfig()
	{
		$fields = array(

			'elements'=>array(
				'<fieldset ><legend class=""><i class="icol-pencil"></i>Register here!</legend>',
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
				'email'=>array(
					'type'=>'text',
					'maxlength'=>32,
					'class' => 'text required',
				),
				'password'=>array(
					'type'=>'password',
					'maxlength'=>32,
					'class' => 'text required',
				),
				'password2'=>array(
					'type'=>'password',
					'maxlength'=>32,
					'class' => 'text required',
				),
				'</fieldset>',
			),
			'buttons'=>array(
					'register'=>array(
						'type'=>'submit',
						'label'=>'Register!',
						'class'=>'submit'
					),				
			),			
			'class' => 'form'
		);	
		return $fields;
		
	}

	/*
	 * method before saving an object. It can be grouped by scenarios
	 */
	public function beforeSave(){
		if ($this->getScenario() == 'register'){
			$this->salt = self::blowfishSalt();
			$this->password = crypt($this->password, $this->salt);
			$this->password2 = null;
			$this->status = 0;
		}
		$this->setCollection($this->identifier. '.users' );
		return true;
	}
	
	/*
	 * method after saving process
	 */
	public function afterSave() {
		parent::afterSave();
			$this->db->{$this->collection}->ensureIndex(array("email" => 1), array("unique" => 1, "dropDups" => 1));
	}
	
	
	/**
	 * Generate a random salt in the crypt(3) standard Blowfish format.
	 *
	 * @param int $cost Cost parameter from 4 to 31.
	 *
	 * @throws Exception on invalid cost parameter.
	 * @return string A Blowfish hash salt for use in PHP's crypt()
	 */
	public static function blowfishSalt($cost = 13)
	{
		if (!is_numeric($cost) || $cost < 4 || $cost > 31) {
			throw new Exception("cost parameter must be between 4 and 31");
		}
		$rand = array();
		for ($i = 0; $i < 8; $i += 1) {
			$rand[] = pack('S', mt_rand(0, 0xffff));
		}
		$rand[] = substr(microtime(), 2, 6);
		$rand = sha1(implode('', $rand), true);
		$salt = '$2a$' . sprintf('%02d', $cost) . '$';
		$salt .= strtr(substr(base64_encode($rand), 0, 22), array('+' => '.'));
		return $salt;
	}	
	
}


