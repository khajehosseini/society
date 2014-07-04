<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'unity-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block"><?php echo Yii::t('general','Fields with <span class="required">*</span> are required.');?></p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>255)); ?>

	<?php	
		$list_data	=	CHtml::listData(Block::model()->findAll(),'id','name');
		echo $form->dropDownListRow($model,'block_code',$list_data ,	array('empty'	=>	'لطفا انتخاب کنيد'	,	'class'=>'span5')	);
	?>	

	<?php echo $form->textFieldRow($model,'elect_meter_num',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'meter',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'stage',array('class'=>'span5')); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'),
		)); ?>
</div>

<?php $this->endWidget(); ?>
