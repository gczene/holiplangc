<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_USER_NOT_ACTIVATED = 200;
	private $_id;
	public $email;
	public $companyId;
	
	public function __construct($email,$password, $companyId)
	{
		$this->email        = $email;
		$this->password     = $password;
		$this->companyId    = $companyId;
	}	
	
	public function authenticate()
	{
		$userObj = new Users;
		$userObj->setCollection($this->companyId . '.users');
		$user = $userObj->findByAttributes(array('email' => $this->email));

		if (! $user){
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		elseif  ( ! $user->status ){
			$this->errorCode = self::ERROR_USER_NOT_ACTIVATED;
		}
		elseif ($user->password != crypt($this->password, $user->salt)){
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		else{
			$this->errorCode=self::ERROR_NONE;
			$this->_id = $user->_id;
			$this->username = $user->firstName;
			
			foreach($user->attributes as $key => $value)
				if ($key != 'password' && $key != 'accessLevel') // password and accesslevels mustnt store in cookies! see: components/WebUser.php
					$this->setState($key, $value);
			
			//set last activity
			$user->last_activity = time();
			$user->save();
		}
		
		
		return !$this->errorCode;
		
	}
	
	
	public function getId()
	{
		return $this->_id;
	}	
	
}