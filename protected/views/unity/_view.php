<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('block_code')); ?>:</b>
	<?php echo CHtml::encode($data->blockCode->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('elect_meter_num')); ?>:</b>
	<?php echo CHtml::encode($data->elect_meter_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('meter')); ?>:</b>
	<?php echo CHtml::encode($data->meter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stage')); ?>:</b>
	<?php echo CHtml::encode($data->stage); ?>
	<br />


</div>