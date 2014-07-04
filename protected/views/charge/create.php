<?php
$this->breadcrumbs=array(
	Yii::t('charge','Charges')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('charge','Charges'),'url'=>array('index')),
array('label'=>Yii::t('general','Manage').' '.Yii::t('charge','Charge'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create').' '.Yii::t('charge','Charge');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model	,	'block_id'	=>	$block_id)); ?>