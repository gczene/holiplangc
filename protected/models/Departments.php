<?php
class Departments extends CFormModel
{
	
	public $_id;
	public $label;
	public $departments;
	
	
	public function rules(){
		return array(
			array('_id, label', 'required'),
			array('_id, label, departments', 'safe', 'on' => 'search'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'_id' => 'ID',
			'label' => 'Department Name',
			'departments' => 'Departments',
		);
	}
	
}