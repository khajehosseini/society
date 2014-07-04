<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('block_code')); ?>:</b>
	<?php echo CHtml::encode($data->blockCode->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cost_type_code')); ?>:</b>
	<?php echo CHtml::encode($data->costTypeCode->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo CHtml::encode($data->amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_code')); ?>:</b>
	<?php echo CHtml::encode($data->paymentCode->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_num')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_num); ?>
	<br />

	<?php /*
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