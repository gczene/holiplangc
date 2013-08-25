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
			$this->widget('zii.widgets.CMenu',$this->menu);
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
			<div class="positionCenter container">
				<?php echo $content; ?>
			</div>
		</div>
	</div>
</body>

</html>