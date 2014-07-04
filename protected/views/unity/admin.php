<?php
$this->breadcrumbs=array(
	Yii::t('Unitiy','Unities')=>array('index'),
	Yii::t('general','Manage'),
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('Unitiy','Unitiy'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('Unitiy','Unitiy'),'url'=>array('create')),

);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('unity-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1><?php	echo Yii::t('general','Manage')	.	' '	. Yii::t('Unitiy','Unities');	?></h1>

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
$list_data	=	CHtml::listData(Block::model()->findAll(),'id','name');
$this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'unity-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id',
		'name',
		array(            
            'name'=>'blockCode.name',
			'filter'	=>	CHtml::activeDropDownList($model,'block_code',$list_data ,	array('empty'	=>	'لطفا انتخاب کنيد'	,	'class'=>'span5')),
		
        ),
		'elect_meter_num',
		'meter',
		'stage',
array(
'class'=>'bootstrap.widgets.TbButtonColumn',
),
),
)); ?>
