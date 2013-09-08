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
		$filterChain->controller->menu = $this->_menu();
		
        return true; // false if the action should not be executed
    }
 
	
	private function _menu()
	{
		
		/* user is on a company page but not logged in */
		if (COMPANY && Yii::app()->user->isGuest){
			return array(
				'itemTemplate'=>'{menu}<div class="menuBG"></div>',
				'items'=>array(
					array('label'=>'Home', 'url'=>array('/site/index')),
					array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
					array('label'=>'Contact', 'url'=>array('/site/contact')),
					array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'Register', 'url'=>array('/site/register'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
				),
			);		
		}
		/* user is logged in its dubdomain */
		elseif(COMPANY && !Yii::app()->user->isGuest){
			return array(
				'itemTemplate'=>'{menu}<div class="menuBG"></div>',
				'items'=>array(
					array('label'=>'Home', 'url'=>array('/dashboard')),
					array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
					array('label'=>'Contact', 'url'=>array('/site/contact')),
					array('label'=> 'Organigram', 'url' => array('/organigram'), 'visible' => Yii::app()->user->isAccountant ),
					array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'Register', 'url'=>array('/site/register'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
				),
			);		
			
		}
		/* main site */
		else{
			return array(
				'itemTemplate'=>'{menu}<div class="menuBG"></div>',
				'items'=>array(
					array('label'=>'Home', 'url'=>array('/site/index')),
					array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
					array('label'=>'Contact', 'url'=>array('/site/contact')),
					array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'Register', 'url'=>array('/site/register'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
				),
			);		
			
		}
		
	}
    protected function postFilter($filterChain)
    {
        // logic being applied after the action is executed
    }	
	
}