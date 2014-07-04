<?php
$this->breadcrumbs=array(
	Yii::t('block','Blocks')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('block','Blocks'),'url'=>array('index')),
array('label'=>Yii::t('general','Manage')	.' '.Yii::t('block','Blocks'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create').' '.Yii::t('block','Block');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>