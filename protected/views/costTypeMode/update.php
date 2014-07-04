<?php
$this->breadcrumbs=array(
	Yii::t('cost_type_mode','cost_type_modes')=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

	$this->menu=array(
	array('label'=>Yii::t('general','List')	.' '.Yii::t('cost_type_mode','cost_type_mode'),'url'=>array('index')),
	array('label'=>Yii::t('general','Create').' '.Yii::t('cost_type_mode','cost_type_mode'),'url'=>array('create')),
	array('label'=>Yii::t('general','View').' '.Yii::t('cost_type_mode','cost_type_mode'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('general','Manage').' '.Yii::t('cost_type_mode','cost_type_mode'),'url'=>array('admin')),
	);
	?>

	<h1><?php echo Yii::t('general','Update').' '. Yii::t('cost_type_mode','cost_type_mode');?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>