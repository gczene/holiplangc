<?php
class Users extends CMongo
{
	public $first_name;
	public $last_name;
	public $email;
	public $identifier;
	public $password;
	public $password2;
	public $registered;
	public  $salt;

	
	public static function model($className=__CLASS__)
	{
			  return parent::model($className);
	}	

	public function attributeLabels() {
		return array(
			'first_name' => 'First Name',
			'last_name'	=> 'Last Name',
			'email'	=> 'E-mail',
			'password'	=> 'Password',
			'password2'	=> 'Password again',
			'identifier'	=> 'Identifier',
			'registered' => 'Registered',
			'salt'		=> 'Salt',
		);
	}
	
	public function rules()
	{
		return array(
			array('first_name, last_name, email', 'required'),
			array('email', 'email'),
			array('password, password2', 'required', 'on' => 'register'),
			array('password', 'compare', 'compareAttribute' => 'password2' , 'on' => 'register'),
			array('email', 'isRegistered', 'on' => 'register'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('_id,first_name, last_name, company, email, password, registered', 'safe', 'on'=>'search'),
		);
	}
	
	
	public function isRegistered()
	{
		$this->setCollection( Companies::emailToIdentifier($this->email) . '.users' );
		if (Users::model()->setCollection($this->getCollection())->findByAttributes(array('email' => $this->email))){
			$this->addError('email', 'You are already registered!');
			return false;
		}
		else{
			$this->registered = time();
			return true;
		}
	}
	
	
	public function getRegisterConfig()
	{
		$fields = array(

			'elements'=>array(
				'<fieldset ><legend class=""><i class="icol-pencil"></i>Register here!</legend>',
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

	
	public function beforeSave(){
		if ($this->getScenario() == 'register'){
			$this->identifier = Companies::emailToIdentifier($this->email);
			$this->salt = self::blowfishSalt();
			$this->password = crypt($this->password, $this->salt);
			$this->password2 = null;
		}
		$this->setCollection($this->identifier. '.users' );
		return true;
	}
	
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


