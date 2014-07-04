<?php
$this->breadcrumbs=array(
	Yii::t('householder','householders')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('householder','householder'),'url'=>array('index')),
array('label'=>Yii::t('general','Manage').' '.Yii::t('householder','householder'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create').' '.Yii::t('householder','householder');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model	,'block_id'	=>	$block_id)); ?>