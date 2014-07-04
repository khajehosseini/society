<?php
$this->breadcrumbs=array(
	Yii::t('cost','Costs')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('cost','Costs'),'url'=>array('index')),
array('label'=>Yii::t('general','Manage')	.' '.Yii::t('cost','Costs'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create').' '.Yii::t('cost','Cost');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>