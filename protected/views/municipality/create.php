<?php
$this->breadcrumbs=array(
	Yii::t('municipalitiy','municipalities')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('municipalitiy','municipalitiy'),'url'=>array('index')),
array('label'=>Yii::t('general','Manage').' '.Yii::t('municipalitiy','municipalitiy'),'url'=>array('admin')),

);
?>

<h1><?php echo Yii::t('general','Create').' '.Yii::t('municipalitiy','municipalitiy');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>