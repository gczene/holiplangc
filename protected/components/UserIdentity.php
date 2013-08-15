<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	
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
        echo $userObj->getCollection();
        echo '<br /' . $this->email;
		$user = $userObj->findByAttributes(array('email' => $this->email));
        
        echo gettype($user);
        echo $user->getCollection();
        die();
		if (! $user){
			$this->errorCode=self::ERROR_USERNAME_INVALID;
            echo 'nincs ilyen user';
        }
		elseif ($user->password != crypt($this->password, $user->salt)){
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
            echo 'password name passol';
        }
		else{
            echo 'nincs ilyen egyaltalan';
			$this->errorCode=self::ERROR_NONE;
			$this->_id = $user->_id;
			$this->setState('firstName', $user->first_name);
			$this->setState('lastName', $user->last_name);
			$this->setState('identifier', $user->identifier);
			$this->setState('email', $user->email);
			Yii::app()->session->add('accessLevel', $user->access_level );
			
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