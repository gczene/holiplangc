<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/holiday.css" media="screen, projection" />
	
<title>Title of the document</title>
</head>

<body>
	<div id="mainContainer">
		
		<div id="header">
			<div id="logo"></div>
			<div id="logoDesc">
				Feature of the future. Plan your holiday <br />
				Feature of the future. Plan your holiday 
			</div>
		</div><!-- header -->
		
		<div id="mainmenu">
			<?php 
			$this->widget('zii.widgets.CMenu',array(
				'itemTemplate'=>'{menu}<div class="menuBG"></div>',
				'items'=>array(
					array('label'=>'Home', 'url'=>array('/site/index')),
					array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
					array('label'=>'Contact', 'url'=>array('/site/contact')),
					array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'Register', 'url'=>array('/site/register'), 'visible'=>Yii::app()->user->isGuest),
					array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
				),
			));
			?>
<!--						<ul id="yw0">
						<li class="active"><a href="/index.php/site/index">Home
								<div class="menuBG"></div>
								
							</a></li>
						<li><a href="/index.php/site/page?view=about">About
								<div class="menuBG"></div>
							
							</a></li>
						<li><a href="/index.php/site/contact">Contact
								<div class="menuBG"></div>
							</a></li>
						<li><a href="/index.php/site/login">Login
								<div class="menuBG"></div>
							</a></li>
						</ul>-->
		</div><!-- mainmenu -->
		
		<div class="pt-24 pb-24">
			<?php echo $content; ?>
		</div>
	</div>
</body>

</html>