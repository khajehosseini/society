<?php
$this->breadcrumbs=array(
	Yii::t('block','Blocks')=>array('index'),
	Yii::t('general','Manage'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('block','Blocks'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('block','Block'),'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('block-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1><?php	echo Yii::t('general','Manage')	.	' '	. Yii::t('block','Blocks');	?></h1>

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
$list_data	=	CHtml::listData(Municipality::model()->findAll(),'id','name');
$this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'block-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'name',


		array(            
            'name'=>'municipalityCode.name',
			'filter'	=>	CHtml::activeDropDownList($model,'municipality_code',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5')),

        ),

		'sort_number',
		'gas_meter_num',
		'water_meter_num',
		/*
		'common_elect_meter_num',
		'count_unity',
		*/
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
