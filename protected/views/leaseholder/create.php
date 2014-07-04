<?php
$this->breadcrumbs=array(
	Yii::t('leaseholder','leaseholders')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('leaseholder','leaseholder'),'url'=>array('index')),
array('label'=>Yii::t('general','Manage').' '.Yii::t('leaseholder','leaseholder'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create').' '.Yii::t('leaseholder','leaseholder');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model	,'block_id'	=>	$block_id)); ?>