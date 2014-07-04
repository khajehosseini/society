<?php
$this->breadcrumbs=array(
	Yii::t('Unitiy','Unities'),
);

$this->menu=array(
array('label'=>Yii::t('general','Create').' '.Yii::t('Unitiy','Unitiy'),'url'=>array('create')),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('Unitiy','Unitiy'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('Unitiy','Unities');?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
