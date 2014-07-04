<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'description',array('class'=>'span5')); ?>

		<?php	
			$list_data	=	CHtml::listData(CostType::model()->findAll(),'id','title');
			echo $form->dropDownListRow($model,'cost_type_code',$list_data ,	array('empty'	=>	'لطفا انتخاب کنيد'	,	'class'=>'span5')	);
		?>

		<?php echo $form->textFieldRow($model,'amount',array('class'=>'span5','maxlength'=>255)); ?>

		
		<?php	
			$list_data	=	CHtml::listData(Payment::model()->findAll(),'id','title');
			echo $form->dropDownListRow($model,'payment_code',$list_data ,	array('empty'	=>	'لطفا انتخاب کنيد'	,	'class'=>'span5')	);
		?>

		<?php echo $form->textFieldRow($model,'transaction_num',array('class'=>'span5','maxlength'=>255)); ?>

		<?php echo $form->textFieldRow($model,'date_cheque',array('class'=>'span5')); ?>

		<?php	
			$list_data	=	CHtml::listData(Bank::model()->findAll(),'id','title');
			echo $form->dropDownListRow($model,'bank_code',$list_data ,	array('empty'	=>	'لطفا انتخاب کنيد'	,	'class'=>'span5')	);
		?>

		<?php echo $form->textFieldRow($model,'create_date',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
