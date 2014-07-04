<?php
$this->breadcrumbs=array(
	Yii::t('householder','householders'),
);

$this->menu=array(
array('label'=>Yii::t('general','Create').' '.Yii::t('householder','householder'),'url'=>array('create')),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('householder','householder'),'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('householder','householders');?></h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
