<?php
$this->breadcrumbs=array(
	Yii::t('block','Blocks'),
);

$this->menu=array(
array('label'=>Yii::t('general','Create').' '.Yii::t('block','Block'),'url'=>array('create')),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('block','Blocks'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('block','Blocks');?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
