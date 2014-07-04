<div class="span2 main-menu-span">
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<?php $this->widget('zii.widgets.CMenu',array(
							'items'=>array(
											array(	'label'=>		'<i class="icon-home"></i><span		class="hidden-tablet">صفحه اصلی</span> </a></li>',
													'url'			=>	array('/site/index') ,
													'visible'=>!Yii::app()->user->isGuest	,
													'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
													'linkOptions'	=>	array('class'	=>	'ajax-link')
												),
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">ورود کاربر</span> </a></li>', 
														'url'=>array('/user/login'), 	
														'visible'=>Yii::app()->user->isGuest	,
														'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
														'linkOptions'	=>	array('class'	=>	'ajax-link')
													),
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">صفحه شحصی</span> </a></li>', 
												'url'=>array('/user/profile'), 	
												'visible'=>!Yii::app()->user->isGuest	,
												'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
												'linkOptions'	=>	array('class'	=>	'ajax-link')
											),
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">مدیریت کاربران</span> </a></li>', 
												'url'=>array('/user/admin'), 	
												'visible'=>Yii::app()->user->checkAccess('User.Admin.*')	,
												'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
												'linkOptions'	=>	array('class'	=>	'ajax-link')
											),
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">مدیریت بانک ها</span> </a></li>', 
														'url'=>array('/bank/index'), 	
														'visible'=>Yii::app()->user->checkAccess('Bank.*')	,
														'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
														'linkOptions'	=>	array('class'	=>	'ajax-link')
											),
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">مدیریت شهرداری ها</span> </a></li>', 
														'url'=>array('/municipality/index'), 	
														'visible'=>Yii::app()->user->checkAccess('Municipality.*')	,
														'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
														'linkOptions'	=>	array('class'	=>	'ajax-link')
											),
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">مدیریت بلوک ها</span> </a></li>', 
														'url'=>array('/block/index'), 	
														'visible'=>Yii::app()->user->checkAccess('Block.*')	,
														'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
														'linkOptions'	=>	array('class'	=>	'ajax-link')
											),	
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">مدیریت واحدها</span> </a></li>', 
														'url'=>array('/unity/index'), 	
														'visible'=>Yii::app()->user->checkAccess('Unity.*')	,
														'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
														'linkOptions'	=>	array('class'	=>	'ajax-link')
											),
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">مدیریت شارژ</span> </a></li>', 
														'url'=>array('/charge/index'), 	
														'visible'=>Yii::app()->user->checkAccess('Charge.*')	,
														'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
														'linkOptions'	=>	array('class'	=>	'ajax-link')
											),
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">مدیریت شارژ پایه ماهانه</span> </a></li>', 
														'url'=>array('/chargeBase/index'), 	
														'visible'=>Yii::app()->user->checkAccess('ChargeBase.*')	,
														'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
														'linkOptions'	=>	array('class'	=>	'ajax-link')
											),
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">مدیریت هزینه ها</span> </a></li>', 
														'url'=>array('/cost/index'), 	
														'visible'=>Yii::app()->user->checkAccess('Cost.*')	,
														'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
														'linkOptions'	=>	array('class'	=>	'ajax-link')
											),
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">مدیریت صاحب خانه ها</span> </a></li>', 
														'url'=>array('/householder/index'), 	
														'visible'=>Yii::app()->user->checkAccess('Householder.*')	,
														'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
														'linkOptions'	=>	array('class'	=>	'ajax-link')
											),
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">مدیریت درآمد</span> </a></li>', 
														'url'=>array('/income/index'), 	
														'visible'=>Yii::app()->user->checkAccess('Income.*')	,
														'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
														'linkOptions'	=>	array('class'	=>	'ajax-link')
											),
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">مدیریت مستاجر</span> </a></li>', 
														'url'=>array('/leaseholder/index'), 	
														'visible'=>Yii::app()->user->checkAccess('leaseholder.*')	,
														'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
														'linkOptions'	=>	array('class'	=>	'ajax-link')
											),
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">مدیریت سال</span> </a></li>', 
														'url'=>array('/year/index'), 	
														'visible'=>Yii::app()->user->checkAccess('Year.*')	,
														'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
														'linkOptions'	=>	array('class'	=>	'ajax-link')
											),
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">مدیریت نوع هزینه</span> </a></li>', 
														'url'=>array('/costType/index'), 	
														'visible'=>Yii::app()->user->checkAccess('CostType.*')	,
														'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
														'linkOptions'	=>	array('class'	=>	'ajax-link')
											),
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">مدیریت نوع نوع هزینه</span> </a></li>', 
														'url'=>array('/costTypeMode/index'), 	
														'visible'=>Yii::app()->user->checkAccess('CostTypeMode.*')	,
														'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
														'linkOptions'	=>	array('class'	=>	'ajax-link')
											),
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">گزارش واحد</span> </a></li>', 
														'url'=>array('/reportUnity/normalreport'), 	
														'visible'=>!Yii::app()->user->isGuest	,
														'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
														'linkOptions'	=>	array('class'	=>	'ajax-link')
											),
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">گزارش بلوک</span> </a></li>', 
														'url'=>array('/reportUnity/blockreport'), 	
														'visible'=>Yii::app()->user->checkAccess('ReportUnity.BlockReport') 	,
														'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
														'linkOptions'	=>	array('class'	=>	'ajax-link')
											),											
											
											array(		'label'=>'<i class="icon-home"></i><span		class="hidden-tablet">خروج</span> </a></li>', 
													'url'=>array('/user/logout'), 	
													'visible'=>!Yii::app()->user->isGuest	,
													'itemOptions'	=>	array('class'=>'nav-header hidden-tablet'	),
													'linkOptions'	=>	array('class'	=>	'ajax-link')
												),
											
								
									),
							'htmlOptions'	=>	array('class'	=>'nav nav-tabs nav-stacked main-menu'),
							'encodeLabel'	=>	false
					
							)); ?>
						<?php /*<li><a class="ajax-link" href="<?php echo Yii::app()->homeUrl?>"><i class="icon-home"></i><span
								class="hidden-tablet"> Dashboard</span> </a></li>
						<?php foreach (Main::adminmenu() as $key=>$menu){
							echo '<li><a class="ajax-link" href="'.Yii::app()->createUrl($menu['url']['0']).'"><i class="icon-home"></i><span
								class="hidden-tablet"> '.$menu['label'].'</span> </a></li>';
						}?>			
						<li><a class="ajax-link" href="<?php echo Yii::app()->createUrl('site/index/view/ui')?>"><i class="icon-eye-open"></i><span
								class="hidden-tablet"> UI Features</span> </a></li>
						<li><a class="ajax-link" href="<?php echo Yii::app()->createUrl('site/index/view/form')?>"><i class="icon-edit"></i><span
								class="hidden-tablet"> Forms</span> </a></li>
						<li><a class="ajax-link" href="<?php echo Yii::app()->createUrl('site/index/view/chart')?>"><i
								class="icon-list-alt"></i><span class="hidden-tablet"> Charts</span>
						</a></li>
						<li><a class="ajax-link" href="<?php echo Yii::app()->createUrl('site/index/view/typography')?>"><i
								class="icon-font"></i><span class="hidden-tablet"> Typography</span>
						</a></li>
						<li><a class="ajax-link" href="<?php echo Yii::app()->createUrl('site/index/view/gallery')?>"><i
								class="icon-picture"></i><span class="hidden-tablet"> Gallery</span>
						</a></li>
						<li class="nav-header hidden-tablet">Sample Section</li>
						<li><a class="ajax-link" href="<?php echo Yii::app()->createUrl('site/index/view/table')?>"><i
								class="icon-align-justify"></i><span class="hidden-tablet">
									Tables</span> </a></li>
						<li><a class="ajax-link" href="<?php echo Yii::app()->createUrl('site/index/view/calendar')?>"><i
								class="icon-calendar"></i><span class="hidden-tablet"> Calendar</span>
						</a></li>
						<li><a class="ajax-link" href="<?php echo Yii::app()->createUrl('site/index/view/grid')?>"><i class="icon-th"></i><span
								class="hidden-tablet"> Grid</span> </a></li>
						<li><a class="ajax-link" href="<?php echo Yii::app()->createUrl('site/index/view/icon')?>"><i class="icon-star"></i><span
								class="hidden-tablet"> Icons</span> </a></li>
						<li><a class="ajax-link" href="<?php echo Yii::app()->createUrl('site/index/view/file-manager')?>"><i
								class="icon-folder-open"></i><span class="hidden-tablet"> File
									Manager</span> </a></li>
						<li><a href="<?php echo Yii::app()->createUrl('site/index/view/tour')?>"><i class="icon-globe"></i><span
								class="hidden-tablet"> Tour</span> </a></li>			
						<?php /* 
						<li><a href="<?php echo Yii::app()->createUrl('site/index/view/error')?>"><i class="icon-ban-circle"></i><span
								class="hidden-tablet"> Error Page</span> </a></li>
						<li><a href="<?php echo Yii::app()->createUrl('site/index/view/login')?>"><i class="icon-lock"></i><span
								class="hidden-tablet"> Login Page</span> </a></li> */?>
					</ul>
					<!--<label id="for-is-ajax" class="hidden-tablet" for="is-ajax"><input
						id="is-ajax" type="checkbox"> Ajax on menu</label>-->
				</div>
				<!--/.well -->
			</div><!--/span-->