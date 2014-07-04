<?php
$this->breadcrumbs=array(
	Yii::t('year','years'),
);

$this->menu=array(
array('label'=>Yii::t('general','Create').' '.Yii::t('year','year'),'url'=>array('create')),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('year','years'),'url'=>array('admin')),

);
?>

<h1><?php echo Yii::t('year','years');?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
