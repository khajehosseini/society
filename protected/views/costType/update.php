<?php
$this->breadcrumbs=array(
	Yii::t('cost_type','cost_types')=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

	$this->menu=array(
	array('label'=>Yii::t('general','List')	.' '.Yii::t('cost_type','cost_type'),'url'=>array('index')),
	array('label'=>Yii::t('general','Create').' '.Yii::t('cost_type','cost_type'),'url'=>array('create')),
	array('label'=>Yii::t('general','View').' '.Yii::t('cost_type','cost_type'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('general','Manage').' '.Yii::t('cost_type','cost_type'),'url'=>array('admin')),
	);
	?>

	<h1><?php echo Yii::t('general','Update').' '. Yii::t('cost_type','cost_type');?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>