<?php
$this->breadcrumbs=array(
	Yii::t('chargeBase','chargeBases')=>array('index'),
	Yii::t('general','Manage'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('chargeBase','chargeBase'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('chargeBase','chargeBase'),'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('charge-base-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1><?php	echo Yii::t('general','Manage')	.	' '	. Yii::t('chargeBase','chargeBase');	?></h1>

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
$list_data_month		=	CHtml::listData(Month::model()->findAll(),'id','title');
$list_data_year			=	CHtml::listData(Year::model()->findAll(),'id','title');

$this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'charge-base-grid',
'dataProvider'=>$model->search($block_id),
'filter'=>$model,
'columns'=>array(
		'id',
		array(            
            'name'=>'monthCode.title',
			'filter'	=>	CHtml::activeDropDownList($model,'month_code',$list_data_month ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5'))
        ),
		array(            
            'name'=>'yearCode.title',
			'filter'	=>	CHtml::activeDropDownList($model,'year_code',$list_data_year ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5'))
        ),
		'amount',
		/*
		'create_date',
		*/
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
