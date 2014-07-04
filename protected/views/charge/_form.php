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
</script>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'charge-form',
	'enableAjaxValidation'=>true,
)); ?>

<p class="help-block"><?php echo Yii::t('general','Fields with <span class="required">*</span> are required.');?></p>

<?php echo $form->errorSummary($model); ?>

	<?php	
		$list_data	=	CHtml::listData(Unity::model()->findAll('block_code=:blockCode'	,	array(':blockCode'	=>	$block_id)),'id','name');
		echo $form->dropDownListRow(	
								$model	,
								'unity_code',
								$list_data	,
								array(	
										'class'=>'span5',
										'empty'	=>	Yii::t('general','Please select')	,
										'id'	=>	'unityID'	,	
										'ajax'	=>	array(	
															'type'	=>	'POST',
															'url'		=>	Yii::app()->baseUrl."/charge/userCodeGet",
															'update'	=>	'#userCodeId',
															'data'=>array('unity_id'=>'js:this.value',),   
															'success'=> 'function(data) {$("#userCodeId").empty();
															$("#userCodeId").append(data); }',															
														),
													)
						); 
	?>	

			

		<?php 	
		echo $form->dropDownListRow($model,'user_code',array() ,	array('id'	=>	'userCodeId','empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5')	);
		?>


	<?php	
		$list_data	=	CHtml::listData(Month::model()->findAll(),'id','title');
		echo $form->dropDownListRow($model,'month_code',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5')	);
	?>	
	

	<?php	
		$list_data	=	CHtml::listData(Year::model()->findAll(),'id','title');
		echo $form->dropDownListRow($model,'year_code',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5')	);
	?>
<?php echo $form->textFieldRow($model,'amount',array('class'=>'span5','maxlength'=>255)); ?>
	<?php	
		$list_data	=	CHtml::listData(Payment::model()->findAll(),'id','title');
		echo $form->dropDownListRow($model,'payment_code',$list_data ,	array('empty'	=>	Yii::t('general','Please select')	,	'class'=>'span5',	'id'	=>'paymentID')	);
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
			'label'=>$model->isNewRecord ? Yii::t('general','Create') : Yii::t('general','Save'),
		)); ?>
</div>

<?php $this->endWidget(); ?>
