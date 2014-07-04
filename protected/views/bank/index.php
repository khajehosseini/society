<?php
$this->breadcrumbs=array(
	Yii::t('bank','Banks'),
);

$this->menu=array(
array('label'=>Yii::t('general','Create').' '.Yii::t('bank','Bank'),'url'=>array('create')),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('bank','Banks'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('bank','Banks');?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
