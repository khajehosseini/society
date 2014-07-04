<?php
$this->breadcrumbs=array(
	'Unities'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>Yii::t('general','List')	.' '.Yii::t('Unitiy','Unities'),'url'=>array('index')),
	array('label'=>Yii::t('general','Create').' '.Yii::t('Unitiy','Unitiy'),'url'=>array('create')),
	array('label'=>Yii::t('general','View').' '.Yii::t('Unitiy','Unitiy'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('general','Manage').' '.Yii::t('Unitiy','Unitiy'),'url'=>array('admin')),

	);
	?>

	<h1><?php echo Yii::t('general','Update').' '. Yii::t('Unitiy','Unitiy');?>  <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>