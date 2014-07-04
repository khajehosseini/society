<?php
$this->breadcrumbs=array(
	Yii::t('Unitiy','Unities')=>array('index'),
	Yii::t('general','Create'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('Unitiy','Unities'),'url'=>array('index')),
array('label'=>Yii::t('general','Manage').' '.Yii::t('Unitiy','Unitiy'),'url'=>array('admin')),

);
?>

<h1><?php echo Yii::t('general','Create').' '.Yii::t('Unitiy','Unitiy');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>