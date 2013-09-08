<?php

class WebUser extends CWebUser
{
	
	protected $_isSuperUser;
	protected $_isManager;
	protected $_isAccountant;
	protected $_accessLevel;
	protected $_cacheKey;
	public $TTL = 36000; // 10 hours
	
	
	public function init(){
		parent::init();
		/* caching access level */
		if ( ! $this->isGuest && COMPANY ){
			
			$this->_cacheKey = ':accessLvl:' . $this->id;
			
			if (! $this->_accessLevel = Yii::app()->cache->get($this->_cacheKey )){
				$user = Users::model()->setCollection( $this->identifier . '.users' )->findByPk($this->id);
				Yii::app()->cache->set($this->_cacheKey, $user->accessLevel, $this->TTL);
				$this->_accessLevel = $user->accessLevel;
			}
		}
	}
	
	
	
	/*========================================================================
	 * 
	 * the access levels must be uptodate. If it would stored in getState() it cannot be overwriten later (stored in cookies)
	 * 
	 ======================================================================*/
	
	/* 
	 * is the user superuser ?
	 * @return boolean
	 */
	public function getIsSuperUser()
	{
		if ($this->_isSuperUser ===  NULL)
			$this->_isSuperUser = (is_array($this->_accessLevel) && in_array('superUser', $this->_accessLevel ) );
		
		
		return $this->_isSuperUser;
		
	}
	
	/* 
	 * is the user manager ?
	 * @return boolean
	 */
	public function getIsManager()
	{
		if ($this->_isManager ===  NULL )
			$this->_isManager = (is_array($this->_accessLevel) && in_array('manager', $this->_accessLevel ) );
		
		return $this->_isManager;
		
	}
	
	/* 
	 * is the user accountant ?
	 * @return boolean
	 */
	public function getIsAccountant()
	{
		if ($this->_isAccountant ===  NULL)
			$this->_isAccountant = (is_array($this->_accessLevel) && in_array('accountant', $this->_accessLevel ) );
		
		return $this->_isAccountant;
		
	}
	
}