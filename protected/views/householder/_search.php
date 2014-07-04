<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

		<?php 
			$list_data	=	array('0'	=>	'غیر فعال',	'1'	=>	'فعال');
			echo $form->dropDownListRow($model,'status',$list_data ,	array('empty'	=>	'لطفا انتخاب کنيد'	,	'class'=>'span5')	);
		?>
		<?php	
			$list_data	=	CHtml::listData(Unity::model()->findAll('block_code=:blockCode'	,	array(':blockCode'	=>	$block_id)),'id','name');
			echo $form->dropDownListRow($model,'unity_code',$list_data ,	array('empty'	=>	'لطفا انتخاب کنيد'	,	'class'=>'span5')	);
		?>
		<?php	
			$list_data	=	CHtml::listData(User::model()->findAll(),'id','username');
			echo $form->dropDownListRow($model,'user_code',$list_data ,	array('empty'	=>	'لطفا انتخاب کنيد'	,	'class'=>'span5')	);
		?>	

		<?php echo $form->textFieldRow($model,'begin_date',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'end_date',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>Yii::t('general','Search'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
