<?php
$this->breadcrumbs=array(
	Yii::t('municipalitiy','municipalities')=>array('index'),
	Yii::t('general','Manage'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('municipalitiy','municipalitiy'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('municipalitiy','municipalitiy'),'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('municipality-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1><?php	echo Yii::t('general','Manage')	.	' '	. Yii::t('municipalitiy','municipalities');	?></h1>

<p>
	<?php	echo Yii::t('general','You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.');	?>
</p>

<?php echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'municipality-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'name',
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
