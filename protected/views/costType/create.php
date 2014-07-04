<?php
$this->breadcrumbs=array(
	Yii::t('cost_type','cost_types')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('cost_type','cost_types'),'url'=>array('index')),
array('label'=>Yii::t('general','Manage').' '.Yii::t('cost_type','cost_types'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create').' '.Yii::t('cost_type','cost_type');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>