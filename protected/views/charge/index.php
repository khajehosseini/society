<?php
$this->breadcrumbs=array(
	Yii::t('charge','Charges'),
);

$this->menu=array(
array('label'=>Yii::t('general','Create').' '.Yii::t('charge','Charge'),'url'=>array('create')),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('charge','Charges'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('charge','Charges');?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
