<?php
$this->breadcrumbs=array(
	Yii::t('income','incomes')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('income','income'),'url'=>array('index')),
array('label'=>Yii::t('general','Manage').' '.Yii::t('income','income'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create').' '.Yii::t('income','income');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>