<?php
$this->breadcrumbs=array(
	Yii::t('cost_type_mode','cost_type_modes'),
);

$this->menu=array(
array('label'=>Yii::t('general','Create').' '.Yii::t('cost_type_mode','cost_type_mode'),'url'=>array('create')),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('cost_type_mode','cost_type_mode'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('cost_type_mode','cost_type_modes');?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
