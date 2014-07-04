<?php
$this->breadcrumbs=array(
	'Charge Bases',
);

$this->menu=array(
array('label'=>Yii::t('general','Create').' '.Yii::t('chargeBase','chargeBase'),'url'=>array('create')),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('chargeBase','chargeBase'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('chargeBase','chargeBases');?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
