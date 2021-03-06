<?php
$this->breadcrumbs=array(
	Yii::t('income','incomes')=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('income','income'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('income','income'),'url'=>array('create')),
array('label'=>Yii::t('general','Update').' '.Yii::t('income','income'),'url'=>array('update','id'=>$model->id)),
array('label'=>Yii::t('general','Delete')	.	' '	. Yii::t('income','income'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general','Are you sure you want to delete this item?'))),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('income','income'),'url'=>array('admin')),
);
?>

<h1><?php	echo Yii::t('general','View')	.	' '	. Yii::t('income','income').' '	. Yii::t('general','#');	?><?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'blockCode.name',
		'description',
		'amount',
		'paymentCode.title',
		'transaction_num',
		'date_cheque',
		'bankCode.title',
		'create_date',
),
)); ?>
