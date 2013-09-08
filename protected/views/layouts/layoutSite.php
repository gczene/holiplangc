<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/holiday.css" media="screen, projection" />
<?php 
		Yii::app()->clientScript->registerCoreScript('jquery')
				->registerScriptFile( Yii::app()->theme->baseUrl .'/assets/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js' )
				->registerCssFile(Yii::app()->theme->baseUrl .'/assets/jquery-ui-1.10.3.custom/css/holiday/jquery-ui-1.10.3.custom.min.css' )
				;

?>	
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
			$this->widget('application.widgets.menu.Menu',$this->menu);
			?>
		</div><!-- mainmenu -->
		
		<div class="pt-24 pb-24">
			<div class="container">
				<div class="innerH">
					<?php echo $content; ?>
				</div>
			</div>
		</div>
		<div class="footer">
			<div class="innterH">
				Footer
			</div>
		</div>
	</div>
</body>

</html>