<?php
$this->breadcrumbs=array(
	Yii::t('chargeBase','chargeBases')=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('chargeBase','chargeBases'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('chargeBase','chargeBase'),'url'=>array('create')),
array('label'=>Yii::t('general','Update').' '.Yii::t('chargeBase','chargeBase'),'url'=>array('update','id'=>$model->id)),
array('label'=>Yii::t('general','Delete')	.	' '	. Yii::t('chargeBase','chargeBase'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general'	,	'Are you sure you want to delete this item?'))),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('chargeBase','chargeBase'),'url'=>array('admin')),
);
?>

<h1><?php	echo Yii::t('general','View')	.	' '	. Yii::t('chargeBase','chargeBase').' '	. Yii::t('general','#');	?><?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'monthCode.title',
		'yearCode.title',
		'amount',
		'description',
		 array(            // display 'create_date' using an expression
            'name'=>'create_date',
		    'value'=>gergorian_to_jalali_string($model->create_date),
        )
),
)); ?>
