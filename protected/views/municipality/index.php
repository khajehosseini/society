<?php
$this->breadcrumbs=array(
	Yii::t('municipalitiy','municipalities'),
);

$this->menu=array(
array('label'=>Yii::t('general','Create').' '.Yii::t('municipalitiy','municipalitiy'),'url'=>array('create')),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('municipalitiy','municipalitiy'),'url'=>array('admin')),

);
?>

<h1><?php echo Yii::t('municipalitiy','municipalities');?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
