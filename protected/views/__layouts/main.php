<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Login', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Profile', 'url'=>array('/user/profile'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Bank', 'url'=>array('/bank/index'), 'visible'=>Yii::app()->user->checkAccess('Bank.*')),		
				array('label'=>'Municipality', 'url'=>array('/municipality/index'), 'visible'=>Yii::app()->user->checkAccess('Municipality.*')),
				array('label'=>'Block', 'url'=>array('/block/index'), 'visible'=>Yii::app()->user->checkAccess('Block.*')),
				array('label'=>'Unity', 'url'=>array('/unity/index'), 'visible'=>Yii::app()->user->checkAccess('Unity.*')),
				array('label'=>'Charge', 'url'=>array('/charge/index'), 'visible'=>Yii::app()->user->checkAccess('Charge.*')),
				array('label'=>'Cost', 'url'=>array('/cost/index'), 'visible'=>Yii::app()->user->checkAccess('Cost.*')),
				array('label'=>'Householder', 'url'=>array('/householder/index'), 'visible'=>Yii::app()->user->checkAccess('Householder.*')),
				array('label'=>'income', 'url'=>array('/income/index'), 'visible'=>Yii::app()->user->checkAccess('Income.*')),
				array('label'=>'Leaseholder', 'url'=>array('/leaseholder/index'), 'visible'=>Yii::app()->user->checkAccess('Leaseholder.*')),
				array('label'=>'Year', 'url'=>array('/year/index'), 'visible'=>Yii::app()->user->checkAccess('Year.*')),
				array('label'=>'CostType', 'url'=>array('/costType/index'), 'visible'=>Yii::app()->user->checkAccess('CostType.*')),
				array('label'=>'CostTypeMode', 'url'=>array('/costTypeMode/index'), 'visible'=>Yii::app()->user->checkAccess('CostTypeMode.*')),
				array('label'=>'ReportUnity', 'url'=>array('/reportUnity/admin'), 'visible'=>Yii::app()->user->checkAccess('ReportUnity.*')),				
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest),
				),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
