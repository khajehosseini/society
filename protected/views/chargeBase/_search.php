<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

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
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>Yii::t('general','Search'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
