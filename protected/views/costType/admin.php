<?php
$this->breadcrumbs=array(
	Yii::t('cost_type','cost_types')=>array('index'),
	Yii::t('general','Manage'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('cost_type','cost_type'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('cost_type','cost_type'),'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('cost-type-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1><?php	echo Yii::t('general','Manage')	.	' '	. Yii::t('cost_type','cost_types');	?></h1>

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

<?php 
$list_data	=	CHtml::listData(CostTypeMode::model()->findAll(),'id','title');
$this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'cost-type-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		array(            
            'name'=>'costTypeModeCode.title',
			'filter'	=>	CHtml::activeDropDownList($model,'cost_type_mode_code',$list_data ,	array('empty'	=>	'لطفا انتخاب کنيد'	,	'class'=>'span5')),
			
        ),
		'title',
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
