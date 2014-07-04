<?php
$this->breadcrumbs=array(
	'Costs'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Cost','url'=>array('index')),
array('label'=>'Create Cost','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('cost-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Costs</h1>

<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$list_data_block		=	CHtml::listData(Block::model()->findAll(),'id','name');
$list_data_cost_type	=	CHtml::listData(CostType::model()->findAll(),'id','title');
$list_data_payment		=	CHtml::listData(Payment::model()->findAll(),'id','title');
$this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'cost-grid',
'dataProvider'=>$model->search($block_id),
'filter'=>$model,
'columns'=>array(
		'id',
		'description',
		array(            
            'name'=>'costTypeCode.title',
			'filter'	=>	CHtml::activeDropDownList($model,'cost_type_code',$list_data_cost_type ,	array('empty'	=>	'لطفا انتخاب کنيد'	,	'class'=>'span5')),
			'header'	=>	'cost type code'		
        ),
		'amount',
		array(            
            'name'=>'paymentCode.title',
			'filter'	=>	CHtml::activeDropDownList($model,'payment_code',$list_data_payment ,	array('empty'	=>	'لطفا انتخاب کنيد'	,	'class'=>'span5')),
			'header'	=>	'payment'		
        ),
		/*
		'transaction_num',
		'date_cheque',
		'bank_code',
		'create_date',
		*/
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
