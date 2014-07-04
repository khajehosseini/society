<?php
$this->breadcrumbs=array(
	Yii::t('leaseholder','leaseholders')=>array('index'),
	Yii::t('general','Manage'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('leaseholder','leaseholder'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('leaseholder','leaseholder'),'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('leaseholder-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1><?php	echo Yii::t('general','Manage')	.	' '	. Yii::t('leaseholder','leaseholders');	?></h1>

<p>
	<?php	echo Yii::t('general','You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.');	?>
</p>

<?php echo CHtml::link(Yii::t('general','Advanced Search'),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,'block_id'	=>	$block_id
)); ?>
</div><!-- search-form -->

<?php 
$list_data_unity	=	CHtml::listData(Unity::model()->findAll('block_code=:blockCode'	,	array(':blockCode'	=>	$block_id)),'id','name');
$list_data_user		=	CHtml::listData(User::model()->findAll()	,	'id'	,'username');
$list_data_status	=	array('0'	=>	'غیر فعال',	'1'	=>	'فعال');
$this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'leaseholder-grid',
'dataProvider'=>$model->search($block_id),
'filter'=>$model,
'columns'=>array(
		'id',
			array(            
            'name'=>'status',
			'filter'	=>	CHtml::activeDropDownList($model,'status',$list_data_status ,	array('empty'	=>	'لطفا انتخاب کنيد'	,	'class'=>'span5')),
			'value'=>'($data->status	==	0)	?	"غیر فعال"	:	"فعال"',
        ),
		array(            
            'name'=>'unityCode.name',
			'filter'	=>	CHtml::activeDropDownList($model,'unity_code',$list_data_unity ,	array('empty'	=>	'لطفا انتخاب کنيد'	,	'class'=>'span5'))
        )
		,array(            
            'name'=>'userCode.username',
			'filter'	=>	CHtml::activeDropDownList($model,'user_code',$list_data_user ,	array('empty'	=>	'لطفا انتخاب کنيد'	,	'class'=>'span5'))
        ),
		 array(            // display 'create_time' using an expression
            'name'=>'begin_date',
            'value'=>'gergorian_to_jalali_string($data->begin_date)',
        )
		,array(            // display 'create_time' using an expression
            'name'=>'end_date',
            'value'=>'gergorian_to_jalali_string($data->end_date)',
        ),
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
