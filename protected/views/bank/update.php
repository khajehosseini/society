<?php
$this->breadcrumbs=array(
	Yii::t('bank','Banks')=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

	$this->menu=array(
	array('label'=>Yii::t('general','List')	.' '.Yii::t('bank','Banks'),'url'=>array('index')),
	array('label'=>Yii::t('general','Create').' '.Yii::t('bank','Bank'),'url'=>array('create')),
	array('label'=>Yii::t('general','View').' '.Yii::t('bank','Bank'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('general','Manage').' '.Yii::t('bank','Bank'),'url'=>array('admin')),
	);
	?>

	<h1><?php echo Yii::t('general','Update').' '. Yii::t('bank','Bank');?><?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>