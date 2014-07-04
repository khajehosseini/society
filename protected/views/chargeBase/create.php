<?php
$this->breadcrumbs=array(
	Yii::t('chargeBase','chargeBases')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('chargeBase','chargeBase'),'url'=>array('index')),
array('label'=>Yii::t('general','Manage').' '.Yii::t('chargeBase','chargeBase'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create').' '.Yii::t('chargeBase','chargeBase');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>