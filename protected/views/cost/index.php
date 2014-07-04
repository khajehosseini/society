<?php
$this->breadcrumbs=array(
	Yii::t('cost','Costs'),
);

$this->menu=array(
array('label'=>Yii::t('general','Create').' '.Yii::t('cost','Cost'),'url'=>array('create')),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('cost','Cost'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('cost','Costs');?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
