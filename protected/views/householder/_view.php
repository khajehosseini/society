<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unity_code')); ?>:</b>
	<?php echo CHtml::encode($data->unityCode->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_code')); ?>:</b>
	<?php echo CHtml::encode($data->userCode->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('begin_date')); ?>:</b>
	<?php echo CHtml::encode(gergorian_to_jalali_string($data->begin_date)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date')); ?>:</b>
	<?php echo CHtml::encode(gergorian_to_jalali_string($data->end_date)); ?>
	<br />


</div>