<?php
$this->breadcrumbs=array(
	Yii::t('bank','Banks')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('bank','Banks'),'url'=>array('index')),
array('label'=>Yii::t('general','Manage')	.' '.Yii::t('bank','Banks'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('general','Create').' '.Yii::t('bank','Bank');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>