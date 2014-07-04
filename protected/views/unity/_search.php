<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>255)); ?>
		<?php	
			$list_data	=	CHtml::listData(Block::model()->findAll(),'id','name');
			echo $form->dropDownListRow($model,'block_code',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5')	);
		?>	
		<?php echo $form->textFieldRow($model,'elect_meter_num',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'meter',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'stage',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>Yii::t('general','Search'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
