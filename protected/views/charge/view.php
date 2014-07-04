<?php
$this->breadcrumbs=array(
	Yii::t('charge','Charges')=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>Yii::t('general','List')	.' '.Yii::t('charge','Charges'),'url'=>array('index')),
array('label'=>Yii::t('general','Create').' '.Yii::t('charge','Charge'),'url'=>array('create')),
array('label'=>Yii::t('general','Update').' '.Yii::t('charge','Charge'),'url'=>array('update','id'=>$model->id)),
array('label'=>Yii::t('general','Delete')	.	' '	. Yii::t('charge','Charge'),'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('general'	,	'Are you sure you want to delete this item?'))),
array('label'=>Yii::t('general','Manage')	.	' '	. Yii::t('charge','Charges'),'url'=>array('admin')),
);
?>

<h1><?php	echo Yii::t('general','View')	.	' '	. Yii::t('charge','Charge').' '	. Yii::t('general','#');	?><?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'unityCode.name',
		'userCode.username',
		'monthCode.title',
		'yearCode.title',
		'paymentCode.title',
		'amount',
		'transaction_num',
		 array(            // display 'date_cheque' using an expression
            'name'=>'date_cheque',
		    'value'=>gergorian_to_jalali_string($model->date_cheque),
        ),
		
		'bankCode.title',
		 array(            // display 'create_date' using an expression
            'name'=>'create_date',
		    'value'=>gergorian_to_jalali_string($model->create_date),
        )
		
),
)); ?>
