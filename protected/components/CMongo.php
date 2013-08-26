<?php

class CMongo extends CModel
{
	
	static $_connection ;
	
	public $client;
	protected $_collection;
	private $_md; // metadata	
	public $_id;
	public $id;
	protected $dbName = 'holyplan';
	public $db;
	private static $_models = array();
	
	protected $_new = true;
	
	public $data = array();
	
	private $_justArray = false;
	
	
	public function __construct($scenario = 'insert') {
		
		
		if (self::$_connection === null){
			self::$_connection = new MongoClient();
		}
		$this->client = self::$_connection;
		$this->db = $this->client->{$this->dbName};
		
		if($scenario===null) // internally used by populateRecord() and model()
			return;		
		$this->setScenario($scenario); 
		
	}
	
	public function attributeNames()
	{
		return  array_keys($this->attributeLabels());
	}	
	
	public function attributeLabels(){ return array(); }
	
	
	public function getCollection(){
		return $this->_collection;
	}
	
	public function setCollection($name){
		$this->_collection = $name;
		return $this;
	}
	
	
	
	public function beforeSave()
	{
		if ($this->_id)
			$this->_new = false;
		return true;
	}
	
	public function afterSave()
	{
		return true;
	}
	
	public function save(){
		if ($this->beforeSave())
		{
			$contents = $this->attributes;
			if ($this->_new){
				$this->db->{$this->collection}->insert($contents);
				$this->_id = $contents['_id'];
				$this->_new = false;
			}
			else{
				$this->db->{$this->collection}->update(array('_id' => $this->_id),  $contents);
			}
			unset($contents);
			$this->afterSave();
			return true;
		}
		return false;
		
	}
	
	
	public function findAllByAttributes($condition = null)
	{
		if ($condition === null){
			$this->addError('db_error', 'bad condition in findByAttributes');
			Yii::app()->handleError(220, 'Condition mustn\'t be NULL ' , '' ,'' );
			return false;
		}
		elseif (is_array($condition)){
			$out = array();
			$className = get_class($this);
			if ($results = $this->db->{$this->collection}->find($condition))
			{
				foreach($results as $r){
					$class = new $className;
					$out[] = $class->findByPk($r['_id']);
					unset($class);
				}
			}
			$this->afterFind();
			return $out;
		}
		
	}
	
	public function findByAttributes($condition = null)
	{
		
		if ($condition === null){
			$this->addError('db_error', 'bad condition in findByAttributes');
			Yii::app()->handleError(220, 'Condition mustn\'t be NULL ' , '' ,'' );
			return false;
		}
		elseif (is_array($condition)){
			if ($result =  $this->db->{$this->collection}->findOne($condition)){
				foreach($result as $key => $value){
					if (property_exists($this, $key)){
						$this->{$key} = $value;
					}
					else{
						$this->data[$key] = $value;
					}
				}
				$this->_new = false;
				$this->afterFind();
				
				return $this;
			}
		}
		
	}
	
	public function findByPk($pk){
		if ($result = $this->db->{$this->collection}->findOne( array('_id' => new MongoId($pk)  ))){
			foreach($result as $key => $value){
				if (property_exists($this, $key)){
					$this->{$key} = $value;
				}
				else{
					$this->data[$key] = $value;
				}
			}
			$this->_new = false;			
			$this->afterFind();
			
			return $this;
		}
		else{
			return false;
		}
	}
	
	public static function model($className = __CLASS__)
	{
		if(isset(self::$_models[$className]))
			return self::$_models[$className];
		else
		{
			$model=self::$_models[$className]=new $className(null);
			return $model;
		}		
	}
	
	public function getJustArray(){
		return $this->_justArray;
	}
	
	public function setJustArray($bool){
		$this->_justArray = $bool;
		return $this;
	}
	

	public function getIsNewRecord(){
		return $this->_new;
	}
	
	public function afterFind(){ // STUB
		
	}
	

}