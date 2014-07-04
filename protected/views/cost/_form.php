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
		$('#unityID').change(function(){
			if($(this).is(':checked')){
				$('#unity-status').css({'display':'block'});
			}else{
				$('#unity-status').css({'display':'none'});
			}
		});
		//unity-status
	});
	function	submitCost(){
		var ok=true;
		var	message	=	'';
		var count	=	0;
		if($('#sharjeId').is(':checked')){
			if($('#amount-sharje').val()	==	0	||	$('#amount-sharje').val()	==	''){
				ok	=	false;
				message	=	'لطفا میزانی که از شارژ خرج شود را پر کنید';
			}
			++count;
				
		}
		if($('#incomeId').is(':checked')){
			if($('#amount-income').val()	==	0	||	$('#amount-income').val()	==	'')
			{
				ok	=	false;
				message	+=	'----' +'لطفا میزانی که از درآمد خرج شود را پر کنید';
			}
			++count;
		}
		if($('#unityID').is(':checked')){
			if($('#amount-unity').val()	==	0	||	$('#amount-unity').val()	==	'')
			{
				ok	=	false;
				message	+=	'----' +'لطفا میزانی که از واحدها گرفته شود را پر کنید';
			}
			
			if(!$('#Cost_unity_status_0').is(':checked')	&& 	!$('#Cost_unity_status_1').is(':checked')){
				ok	=	false;
				message	+=	'----' +'لطفا وضعیت واحد را مشخص کنید';
			}
			
			++count;
		}
		
		if(count	==	0	)	{
			alert('لطفا حداقل یکی از روش های شارژ ، درآمد ، واحد را تیک بزنید');
			return false;
		}else{
			if(!ok){
				alert(message);
				return false;
			}
		}
	}
</script>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'cost-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block"><?php echo Yii::t('general','Fields with <span class="required">*</span> are required.');?></p>

<?php echo $form->errorSummary($model); ?>



	<?php echo $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php	
		$list_data	=	CHtml::listData(CostType::model()->findAll(),'id','title');
		echo $form->dropDownListRow($model,'cost_type_code',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5')	);
	?>
	<?php echo $form->checkBoxRow($model,'sharje',array('class'=>'span5' 	,	'id'	=>	'sharjeId')); ?>
	<?php echo $form->textFieldRow($model,'amount_sharje',array('class'=>'span5'	,'id'=>'amount-sharje'	)); ?>

	<?php echo $form->checkBoxRow($model,'income',array('class'=>'span5'	,	'id'	=>	'incomeId')); ?>
	<?php echo $form->textFieldRow($model,'amount_income',array('class'=>'span5'	,	'id'=>'amount-income')); ?>

	<?php echo $form->checkBoxRow($model,'unity',array('class'=>'span5'	,	'id'	=>'unityID')); ?>
	<div id="unity-status"	style="<?php	echo	($model->unity_status	==	1)?	'display: block':	'display: none';?>"	>
	<?php echo $form->radioButtonListRow($model,'unity_status',array('1'	=>'هر کسی که ساکن است'	,	'2'=>'از صاحب خانه ها'	)	); ?>
	

	</div>
	<?php echo $form->textFieldRow($model,'amount_unity',array('class'=>'span5'	,	'id'=>'amount-unity')); ?>



	<?php	
		$list_data	=	CHtml::listData(Payment::model()->findAll(),'id','title');
		echo $form->dropDownListRow($model,'payment_code',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5'	,	'id'	=>'paymentID')	);
	?>

<div id="transaction"	style="<?php	echo	($model->payment_code	==	2)?	'display: block':	'display: none';?>">
	<?php echo $form->textFieldRow($model,'transaction_num',array('class'=>'span5','maxlength'=>255)); ?>
</div>
<div id="cheque"	style="<?php	echo	($model->payment_code	==	3)?	'display: block':	'display: none';?>">
		<?php
		echo	"<br> تاریخ چک:<br>";
		$model->date_cheque	=	gergorian_to_jalali_string($model->date_cheque);
		$this->widget('ext.jalaliCalendar.JalaliCalendar', array(
			'model'=>$model,
			'attribute'=>'date_cheque',
			'options'=>array(
				'button'=>'date_btn',
				'ifFormat'=> '%Y/%m/%d',
				'dateType'=>'jalali'
			)
		));
	?>

	<?php	
		$list_data	=	CHtml::listData(Bank::model()->findAll(),'id','title');
		echo $form->dropDownListRow($model,'bank_code',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5')	);
	?>	

</div>



<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'htmlOptions'	=>	array(
				'onclick'	=>	'js:return submitCost();',
			)	,
			
			'label'=>$model->isNewRecord ?  Yii::t('general','Create') : Yii::t('general','Save'),
		)); ?>
</div>

<?php $this->endWidget(); ?>
