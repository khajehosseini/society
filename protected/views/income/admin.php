<?php
$this->breadcrumbs=array(
	Yii::t('income','incomes')=>array('index'),
	Yii::t('general','Manage'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('income','incomes'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('income','income'),'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('income-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1><?php	echo Yii::t('general','Manage')	.	' '	. Yii::t('income','incomes');	?></h1>

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
$list_data_block	=	CHtml::listData(Block::model()->findAll(),'id','name');
$list_data_payment	=	CHtml::listData(Payment::model()->findAll(),'id','title');
$this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'income-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		 array(            
            'name'=>'blockCode.name',
			'filter'	=>	CHtml::activeDropDownList($model,'block_code',$list_data_block ,	array('empty'	=>	'لطفا انتخاب کنيد'	,	'class'=>'span5')),
			'header'	=>	'Block'
			
        ),
		'description',
		'amount',
		 array(            
            'name'=>'paymentCode.title',
			'filter'	=>	CHtml::activeDropDownList($model,'payment_code',$list_data_payment ,	array('empty'	=>	'لطفا انتخاب کنيد'	,	'class'=>'span5')),
			'header'	=>	'Payment'
			
        ),
		'transaction_num',
		/*
		'date_cheque',
		'bank_code',
		'create_date',
		*/
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
