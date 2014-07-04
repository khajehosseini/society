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

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount_sharje')); ?>:</b>
	<?php echo CHtml::encode($data->amount_sharje); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount_income')); ?>:</b>
	<?php echo CHtml::encode($data->amount_income); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount_unity')); ?>:</b>
	<?php echo CHtml::encode($data->amount_unity); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('sharje')); ?>:</b>
	<?php echo CHtml::encode($data->sharje); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('income')); ?>:</b>
	<?php echo CHtml::encode($data->income); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unity')); ?>:</b>
	<?php echo CHtml::encode($data->unity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unity_status')); ?>:</b>
	<?php echo CHtml::encode($data->unity_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_code')); ?>:</b>
	<?php echo CHtml::encode($data->payment_code); ?>
	<br />

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