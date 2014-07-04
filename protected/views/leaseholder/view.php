<?php
$this->breadcrumbs=array(
	Yii::t('leaseholder','leaseholders')=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('leaseholder','leaseholder'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('leaseholder','leaseholder'),'url'=>array('create')),
array('label'=>Yii::t('general','Update').' '.Yii::t('leaseholder','leaseholder'),'url'=>array('update','id'=>$model->id)),
array('label'=>Yii::t('general','Delete')	.	' '	. Yii::t('leaseholder','leaseholder'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general'	,	'Are you sure you want to delete this item?'))),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('leaseholder','leaseholder'),'url'=>array('admin')),
);
?>

<h1><?php	echo Yii::t('general','View')	.	' '	. Yii::t('leaseholder','leaseholder').' '	. Yii::t('general','#');	?><?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		array(            
            'name'=>'status',
		    'value'=>($model->status	==	0)	?	'غیر فعال'	:	'فعال',
        ),
		'unityCode.name',
		'userCode.username',
		array(            // display 'create_time' using an expression
            'name'=>'begin_date',
		    'value'=>gergorian_to_jalali_string($model->begin_date),
        ),array(            // display 'create_time' using an expression
            'name'=>'end_date',
	        'value'=>gergorian_to_jalali_string($model->end_date),
        ),
),
)); ?>
