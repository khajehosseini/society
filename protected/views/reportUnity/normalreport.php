<?php 
Yii::app()->clientScript->registerScript('search', "
$('#normal-report-form').submit(function(){
$.fn.yiiGridView.update('cost-grid', {
data: $(this).serialize()
});
return false;
});
");
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'normal-report-form',
	'enableAjaxValidation'=>false,
)); ?>
<table border	='1'>
	<tr>
		<td>واحد</td>
		<td>
			<?php	
		
			$list_data		=	
								CHtml::listData(	Leaseholder::model()->with('unityCode')->findAll(
													'	user_code	=:userid	and 	status	=:status	'	,
													array(':userid'	=>Yii::app()->user->id		,	':status'	=>	1)
													),
													'unity_code'	,'unityCode.name'
												);	
	
			$list_data2		=	
								CHtml::listData(
													Householder::model()->with('unityCode')->findAll(
													'user_code	=:userid	and 	status	=:status'	,
													array(':userid'	=>Yii::app()->user->id	,	':status'	=>	1	)
													),
													'unity_code'	,'unityCode.name'
												);
			if(!empty($list_data2)){
				foreach	 ($list_data2	as $k	=>	$value)	{
					$list_data[$k]	=	$value;
				}	
			}
			if(!empty($list_data))	ksort($list_data);

			echo CHtml::dropDownList('unity_code','unity_code',$list_data ,	array('empty'	=>	'لطفا انتخاب کنيد')	);
			?>
		</td>
				<td>مانده</td>
		<td>
		<?php 
		echo $sumTotal; ?> 
		</td>
	<tr>
</table>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'جستجو',
		)); ?>
</div>

<?php $this->endWidget(); ?>
<?php 
if(	!empty($dataProvider)	){	
	$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'cost-grid',
	'dataProvider'=>$dataProvider,
	'ajaxUpdate'	=>	true,
	'columns'=>array(
			array(
				'name'		=>	'id'	,	
				'value'		=>	'++$row' ,
				'header'	=>	'ردیف'
			),
			array(
				'name'		=>	'create_date',
				'header'	=>	'تاریخ'	,
				'value'		=>	'gergorian_to_jalali_string($data["create_date"])',			
			),
			array(
				'name'		=>	'name'	,	
				'header'	=>	'واحد'
			),
			
			array(
				'name'	=>	'description',
				'header'	=>	'توضیحات',
				
			),			
			array(
				'name'	=>	'year',
				'header'	=>	'سال',
				
			),
			array(
				'name'	=>	'month',
				'header'	=>	'ماه',
				
			),
			array(
				'type'=>'raw',
				'value'	=>	'($data["type"]	==	2)?	$data["amount"]:"--"'	,	
				'header'=>	'بستانکار'
			),
			array(
				'type'=>'raw',
				'value'	=>	'($data["type"]	==	3 || $data["type"]	== 1)?	$data["amount"]:"--"'	,					
				'header'=>	'بدهکار'
			),
		
		),
	));

} 
?>