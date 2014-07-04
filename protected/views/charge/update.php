<?php
$this->breadcrumbs=array(
	Yii::t('charge','Charges')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

	$this->menu=array(
	array('label'=>Yii::t('general','List')	.' '.Yii::t('charge','Charges'),'url'=>array('index')),
	array('label'=>Yii::t('general','Create').' '.Yii::t('charge','Charge'),'url'=>array('create')),
	array('label'=>Yii::t('general','View').' '.Yii::t('charge','Charge'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('general','Manage').' '.Yii::t('charge','Charge'),'url'=>array('admin')),
	);
	?>

	<h1><?php echo Yii::t('general','Update').' '. Yii::t('charge','Charge');?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model	,	'block_id'	=>	$block_id)); ?>