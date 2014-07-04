<?php
$this->breadcrumbs=array(
	Yii::t('cost','Costs')=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('cost','Costs'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('cost','Cost'),'url'=>array('create')),
array('label'=>Yii::t('general','Update').' '.Yii::t('cost','Cost'),'url'=>array('update','id'=>$model->id)),
array('label'=>Yii::t('general','Delete')	.	' '	. Yii::t('cost','Cost'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general'	,	'Are you sure you want to delete this item?'))),
array('label'=>Yii::t('general','Manage')	.	' '	.Yii::t('cost','Costs'),'url'=>array('admin')),
);
?>

<h1><?php	echo Yii::t('general','View')	.	' '	. Yii::t('cost','Costs').' '	. Yii::t('general','#');	?><?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'blockCode.name',
		'description',
		'costTypeCode.title',
		'amount_sharje',
		'amount_income',
		'amount_unity',
		'sharje',
		'income',
		'unity',
		'unity_status',
		'paymentCode.title',
		'transaction_num',
		'date_cheque',
		'bankCode.title',
		'create_date',
),
)); ?>
