<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'leaseholder-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block"><?php echo Yii::t('general','Fields with <span class="required">*</span> are required.');?></p>

<?php echo $form->errorSummary($model); ?>
	
	<?php	
		$list_data	=	array('0'	=>	'غیر فعال',	'1'	=>	'فعال');
		echo $form->dropDownListRow($model,'status',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5')	);
	?>

	<?php	
		$list_data	=	CHtml::listData(Unity::model()->findAll('block_code=:blockCode'	,	array(':blockCode'	=>	$block_id)),'id','name');
		echo $form->dropDownListRow($model,'unity_code',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5')	);
	?>
	
	<?php	
		$list_data	=	CHtml::listData(User::model()->findAll(),'id','username');
		echo $form->dropDownListRow($model,'user_code',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5')	);?>

	<?php
		echo	"<br> تاریخ شروع:<br>";
		$temp	=	($model->begin_date=='--')?0:$model->begin_date	;
		$model->begin_date	=	gergorian_to_jalali_string(	$temp);
		$this->widget('ext.jalaliCalendar.JalaliCalendar', array(
			'model'=>$model,
			'attribute'=>'begin_date',
			'options'=>array(
				'button'=>'date_btn',
				'ifFormat'=> '%Y/%m/%d',
				'dateType'=>'jalali'
			)
		));
	?>	
	<?php
		echo	"<br> تاریخ پایان:<br>";
		$temp	=	($model->end_date=='--')?0:$model->end_date	;
		$model->end_date	=	gergorian_to_jalali_string($temp);
		$this->widget('ext.jalaliCalendar.JalaliCalendar', array(
			'model'=>$model,
			'attribute'=>'end_date',
			'options'=>array(
				'button'=>'date_btn',
				'ifFormat'=> '%Y/%m/%d',
				'dateType'=>'jalali'
			)
		));
	?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'),
		)); ?>
</div>

<?php $this->endWidget(); ?>
