<?php
$this->breadcrumbs=array(
	Yii::t('income','incomes'),
);

$this->menu=array(
array('label'=>Yii::t('general','Create').' '.Yii::t('income','income'),'url'=>array('create')),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('income','income'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('income','incomes');?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
