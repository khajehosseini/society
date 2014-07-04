<?php
$this->breadcrumbs=array(
	Yii::t('year','years')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
array('label'=>Yii::t('year','years')	.' '.Yii::t('charge','Charges'),'url'=>array('index')),
array('label'=>Yii::t('general','Manage').' '.Yii::t('year','year'),'url'=>array('admin')),

);
?>

<h1><?php echo Yii::t('general','Create').' '.Yii::t('year','year');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>