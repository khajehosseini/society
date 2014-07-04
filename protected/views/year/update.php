<?php
$this->breadcrumbs=array(
	Yii::t('year','years')=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

	$this->menu=array(
	array('label'=>Yii::t('general','List')	.' '.Yii::t('year','years'),'url'=>array('index')),
	array('label'=>Yii::t('general','Create').' '.Yii::t('year','year'),'url'=>array('create')),
	array('label'=>Yii::t('general','View').' '.Yii::t('year','year'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('general','Manage').' '.Yii::t('year','year'),'url'=>array('admin')),

	);
	?>

	<h1><?php echo Yii::t('general','Update').' '. Yii::t('year','year');?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>