<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>255)); ?>

		<?php	
			$list_data	=	CHtml::listData(Municipality::model()->findAll(),'id','name');
			echo $form->dropDownListRow($model,'municipality_code',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5')	);
		?>	

		<?php echo $form->textFieldRow($model,'sort_number',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'gas_meter_num',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'water_meter_num',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'common_elect_meter_num',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'count_unity',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>Yii::t('general','Search'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
