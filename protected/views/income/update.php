<?php
$this->breadcrumbs=array(
	Yii::t('income','incomes')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('general','Update'),
);

	$this->menu=array(
	array('label'=>Yii::t('general','List')	.' '.Yii::t('income','income'),'url'=>array('index')),
	array('label'=>Yii::t('general','Create').' '.Yii::t('income','income'),'url'=>array('create')),
	array('label'=>Yii::t('general','View').' '.Yii::t('income','income'),'url'=>array('view','id'=>$model->id)),
	array('label'=>Yii::t('general','Manage').' '.Yii::t('income','income'),'url'=>array('admin')),
	);
	?>

	<h1><?php echo Yii::t('general','Update').' '. Yii::t('income','income');?> <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>