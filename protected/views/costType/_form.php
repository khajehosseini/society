<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'cost-type-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block"><?php echo Yii::t('general','Fields with <span class="required">*</span> are required.');?></p>

<?php echo $form->errorSummary($model); ?>
	<?php	
		$list_data	=	CHtml::listData(CostTypeMode::model()->findAll(),'id','title');
		echo $form->dropDownListRow($model,'cost_type_mode_code',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5')	);
	?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>255)); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'),
		)); ?>
</div>

<?php $this->endWidget(); ?>
