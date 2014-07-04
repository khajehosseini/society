<?php	
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user'),
	UserModule::t('Manage')=>array('/manage'),
	UserModule::t('RoleManage')
);
$this->menu=array(
    array('label'=>UserModule::t('Create User'), 'url'=>array('create')),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
);	?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'role-manage-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>
<div class="form">
<table  class="items table"  style="float: right; text-align: right; direction: rtl;">
	<thead>
	<tr>
		<th>شخصیت</th>
		<th>
		<?php 
			$list_data	=	CHtml::listData(Role::model()->findAll(),'id','title');
			echo $form->dropDownList(	
										$modelS	,
										'role_code',
										$list_data,
										array('id'	=>	'roleCodeID')	
										
									); 
									?>
									
		</th>
		
		<th class="block" style="display: block;">بلوک</th>
		<th class="block"	style="display: block;">		
			<?php 
			$list_data1	=	CHtml::listData(Block::model()->findAll(),'id','name');
			echo	CHtml::dropDownList('block_code',	''	,$list_data1,
								array(	
										'empty'	=>	'لطفا انتخاب کنید'	,
										'id'	=>	'blockCodeId'	,
										
											
									)
					); 
			
		
									?>
		</th>
		<th>
			<?php	echo	CHtml::ajaxLink(
												'ارسال',
												Yii::app()->createUrl('user/admin/assginrole')	,
												array(	
													'type'	=>	'POST',
													'data'			=>	array(
																				'role_id'		=>	'js:function(){ return $(\'#roleCodeID\').attr(\'value\');}'	,
																				'user_id'		=>	$user_id,
																				'block_code'	=>	'js:function(){ return $(\'#blockCodeId\').attr(\'value\');}'
																			)	,
													'success'	=>	"js:function(data){
																						if (data	==	'exist'){
																							alert('این شخصیت قبلا ثبت شده است');
																						}else if(data	==	'No_Block'){	
																							alert('لطفا بلوک را انتخاب کنید');
																						}else{
																							$.fn.yiiGridView.update('role-manage-grid');
																						}
																				}"
													)
												,array(	'id'	=>	'linkSubmitId'	,	'class'	=>	'btn-primary')
																										
											);?>
		</th>
	</tr>

</table>
</div><!-- form -->

<?php $this->endWidget(); ?>
<?php
$this->widget('bootstrap.widgets.TbGridView',array(
'id'=>'role-manage-grid',
'dataProvider'=>$modelS->search($user_id),
//'filter'=>$modelS,
'columns'=>array(
		array(	'name'	=>	'roleCode.title'	,	'header'	=>	'شخصیت'	),
		array(	'name'	=>	'blockCode.name'	,	'header'	=>	'بلوک'	),
		array(	'class'				=>	'CButtonColumn',
				'deleteButtonUrl'	=>'Yii::app()->createUrl("user/admin/deleteassginrole"	,	array("role_id"	=>	$data->role_code,	"user_id"	=>	$data->user_code))',
				'template'	=>	'{delete}'
			),

),
)); ?>