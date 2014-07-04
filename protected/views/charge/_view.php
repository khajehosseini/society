<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unity_code')); ?>:</b>
	<?php echo CHtml::encode($data->unityCode->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_code')); ?>:</b>
	<?php echo CHtml::encode($data->userCode->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('month_code')); ?>:</b>
	<?php echo CHtml::encode($data->monthCode->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('year_code')); ?>:</b>
	<?php echo CHtml::encode($data->yearCode->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_code')); ?>:</b>
	<?php echo CHtml::encode($data->paymentCode->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo CHtml::encode($data->amount); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_num')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_cheque')); ?>:</b>
	<?php echo CHtml::encode($data->date_cheque); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bank_code')); ?>:</b>
	<?php echo CHtml::encode($data->bank_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_date); ?>
	<br />

	*/ ?>

</div>