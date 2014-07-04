<?php
$this->breadcrumbs=array(
	Yii::t('chargeBase','chargeBases')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

	$this->menu=array(
	array('label'=>Yii::t('general','List')	.' '.Yii::t('chargeBase','chargeBases'),'url'=>array('index')),
	array('label'=>Yii::t('general','Create').' '.Yii::t('chargeBase','chargeBase'),'url'=>array('create')),
	array('label'=>Yii::t('general','View').' '.Yii::t('chargeBase','chargeBase'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('general','Manage').' '.Yii::t('chargeBase','chargeBase'),'url'=>array('admin')),
	);
	?>

	<h1><?php echo Yii::t('general','Update').' '. Yii::t('chargeBase','chargeBase');?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>