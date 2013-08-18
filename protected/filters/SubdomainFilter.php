<?php

class SubdomainFilter extends CFilter
{
	
    protected function preFilter($filterChain)
    {
        // logic being applied before the action is executed
		
		if (COMPANY) {
			if ($company = Companies::model()->findByAttributes(array('subdomain' => COMPANY)) ){
				$filterChain->controller->company = $company;
			}
			else{
				throw new CHttpException(404, 'Page not found');
			}
		}
		
		
        return true; // false if the action should not be executed
    }
 
    protected function postFilter($filterChain)
    {
        // logic being applied after the action is executed
    }	
	
}