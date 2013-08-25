<?php

class UserFilter extends CFilter
{
	
    protected function preFilter($filterChain)
    {
        // logic being applied before the action is executed

		if (Yii::app()->user->isGuest){
			Yii::app()->request->redirect('/login');
			Yii::app()->end();
		}
//		if (COMPANY) {
//			if ($company = Companies::model()->findByAttributes(array('subdomain' => COMPANY)) ){
//				$filterChain->controller->company = $company;
//			}
//			else{
//				throw new CHttpException(404, 'Page not found');
//			}
//		}
		
		
        return true; // false if the action should not be executed
    }
 
    protected function postFilter($filterChain)
    {
        // logic being applied after the action is executed
    }	
	
}