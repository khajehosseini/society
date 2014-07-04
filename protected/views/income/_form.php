<script>
	$(document).ready(function(){
		$('#paymentID').change(function(){
			var	paymentId	=	$(this).val();
			if(paymentId	==	1	||	paymentId	==	''){
				$('#transaction').css({'display':'none'});
				$('#cheque').css({'display':'none'});
			}
			if(paymentId	==	2	){
				$('#transaction').css({'display':'block'});
				$('#cheque').css({'display':'none'});
			}
			if(paymentId	==	3	){
				$('#cheque').css({'display':'block'});
				$('#transaction').css({'display':'none'});
			}
		});
	});
</script>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'income-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block"><?php echo Yii::t('general','Fields with <span class="required">*</span> are required.');?></p>

<?php echo $form->errorSummary($model); ?>

	<?php	
		$list_data	=	CHtml::listData(Block::model()->findAll(),'id','name');
		echo $form->dropDownListRow($model,'block_code',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5')	);
	?>
	
	<?php echo $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'amount',array('class'=>'span5')); ?>

	<?php	
		$list_data	=	CHtml::listData(Payment::model()->findAll(),'id','title');
		echo $form->dropDownListRow($model,'payment_code',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5', 'id'	=>'paymentID')	);
	?>
<div id="transaction"	style="<?php	echo	($model->payment_code	==	2)?	'display: block':	'display: none';?>">
	<?php echo $form->textFieldRow($model,'transaction_num',array('class'=>'span5','maxlength'=>255)); ?>
</div>
<div id="cheque"	style="<?php	echo	($model->payment_code	==	3)?	'display: block':	'display: none';?>">
	<?php echo $form->textFieldRow($model,'date_cheque',array('class'=>'span5')); ?>
	
		<?php	
		$list_data	=	CHtml::listData(Bank::model()->findAll(),'id','title');
		echo $form->dropDownListRow($model,'bank_code',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5')	);
	?>
</div>	
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'),
		)); ?>
</div>

<?php $this->endWidget(); ?>
