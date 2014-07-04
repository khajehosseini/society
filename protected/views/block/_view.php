<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('municipality_code')); ?>:</b>
	<?php echo CHtml::encode($data->municipalityCode->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sort_number')); ?>:</b>
	<?php echo CHtml::encode($data->sort_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gas_meter_num')); ?>:</b>
	<?php echo CHtml::encode($data->gas_meter_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('water_meter_num')); ?>:</b>
	<?php echo CHtml::encode($data->water_meter_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('common_elect_meter_num')); ?>:</b>
	<?php echo CHtml::encode($data->common_elect_meter_num); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('count_unity')); ?>:</b>
	<?php echo CHtml::encode($data->count_unity); ?>
	<br />

	*/ ?>

</div>