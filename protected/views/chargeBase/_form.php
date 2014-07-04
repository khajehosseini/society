<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'charge-base-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block"><?php echo Yii::t('general','Fields with <span class="required">*</span> are required.');?></p>

<?php echo $form->errorSummary($model); ?>

	<?php	
		$list_data	=	CHtml::listData(Month::model()->findAll(),'id','title');
		echo $form->dropDownListRow($model,'month_code',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5')	);
	?>
	<?php	
		$list_data	=	CHtml::listData(Year::model()->findAll(),'id','title');
		echo $form->dropDownListRow($model,'year_code',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5')	);
	?>

	<?php echo $form->textFieldRow($model,'amount',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>


<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'),
		)); ?>
</div>

<?php $this->endWidget(); ?>
