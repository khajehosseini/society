<?php
$this->breadcrumbs=array(
	Yii::t('leaseholder','leaseholders'),
);

$this->menu=array(
array('label'=>Yii::t('general','Create').' '.Yii::t('leaseholder','leaseholder'),'url'=>array('create')),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('leaseholder','leaseholder'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('leaseholder','leaseholders');?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
