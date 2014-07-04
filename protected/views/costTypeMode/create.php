<?php
$this->breadcrumbs=array(
	Yii::t('cost_type_mode','cost_type_modes')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('cost_type_mode','cost_type_mode'),'url'=>array('index')),
array('label'=>Yii::t('general','Manage').' '.Yii::t('cost_type_mode','cost_type_mode'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create').' '.Yii::t('cost_type_mode','cost_type_mode');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>