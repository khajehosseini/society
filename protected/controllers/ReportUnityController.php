<?php

class ReportUnityController extends Controller
{
/**
* @var string the default layout for the views. Defaults to '//layouts/column2', meaning
* using two-column layout. See 'protected/views/layouts/column2.php'.
*/
public $layout='//layouts/column2';

/**
* @return array action filters
*/
public function filters()
{
return array(
'accessControl', // perform access control for CRUD operations

);
}

/**
* Specifies the access control rules.
* This method is used by the 'accessControl' filter.
* @return array access control rules
*/
public function accessRules()
{
return array(

array('allow', 
'actions'=>array('normalreport'),
'users'=>array('@'),
),
);
}

public function actionNormalReport()
{	
	$dataProvider	=	array();
	$user_current	=	Yii::app()->user->id;
	if(isset($_GET['unity_code'])	&&	$_GET['unity_code']	!=	''	&&	is_numeric($_GET['unity_code'])){
		$sql1="		select * from(
					SELECT CU.id,CU.amount, 'هزینه واحد' as description	,U.name	,CU.create_date , '1' as type , '--' as month , '--' as year
					FROM 
						`tbl_cost_unity` CU
					JOIN `tbl_unity` U	ON(CU.unity_code	=	U.id)					
						
					WHERE 
						CU.user_code=$user_current and CU.unity_code	=	{$_GET['unity_code']}
					UNION
					SELECT C.id,C.amount,'شارژ' as description ,U.name,C.create_date , '2' as type , M.title as month , Y.title as year 	FROM 
						`tbl_charge` C
					JOIN `tbl_unity` U	ON (C.unity_code	=	U.id)
					JOIN `tbl_month` M	ON (C.month_code	=	M.id)
					JOIN `tbl_year` Y	ON (C.year_code	=	Y.id)			
					WHERE 
						C.user_code=$user_current and C.unity_code	=	{$_GET['unity_code']}
						) as a order by create_date desc
		
					
		";
		$sql2	=	"SELECT CBD.id as id,CB.amount,'شارژ پایه ماه' as description ,U.name,CB.create_date ,'3' as type ,  M.title as month , Y.title as year	
					FROM 
						`tbl_charge_base_detail` CBD
						JOIN tbl_charge_base CB ON (CBD.charge_base_code = CB.id)
						JOIN tbl_unity U ON (U.id=CBD.unity_code)
						JOIN `tbl_month` M	ON (CB.month_code	=	M.id)
						JOIN `tbl_year` Y	ON (CB.year_code	=	Y.id)	
					WHERE 
						CBD.user_code=$user_current and CBD.unity_code	=	{$_GET['unity_code']}";
						
		$sqlCountType1	="select sum(amount) as sum from tbl_cost_unity  where user_code=$user_current and unity_code	=	{$_GET['unity_code']}";
		$sqlCountType2	="select sum(amount) as sum from tbl_charge  where user_code=$user_current and unity_code	=	{$_GET['unity_code']}";
		$sqlCountType3	="select sum(CB.amount) as sum from tbl_charge_base_detail CBD
		JOIN tbl_charge_base CB ON (CBD.charge_base_code = CB.id)
		where CBD.user_code=$user_current and CBD.unity_code	=	{$_GET['unity_code']}";
		
		
	}else{
		$sql1="		
					select * from(
					SELECT CU.id,CU.amount, 'هزینه واحد' as description	,U.name	,CU.create_date , '1' as type , '--' as month , '--' as year
					FROM 
						`tbl_cost_unity` CU
					JOIN `tbl_unity` U	ON(CU.unity_code	=	U.id)
						
					WHERE 
						CU.user_code=$user_current 
					UNION
					SELECT C.id,C.amount,'شارژ' as description ,U.name,C.create_date , '2' as type	, M.title as month , Y.title as year FROM 
						`tbl_charge` C
					JOIN `tbl_unity` U	ON (C.unity_code	=	U.id)
					JOIN `tbl_month` M	ON (C.month_code	=	M.id)
					JOIN `tbl_year` Y	ON (C.year_code	=	Y.id)	
					WHERE 
						C.user_code=$user_current
						) as a order by create_date desc
		
				";
		$sql2	=	"SELECT CBD.id as id,CB.amount,'شارژ پایه ماه' as description,U.name ,CB.create_date , '3' as type	, M.title as month , Y.title as year
				FROM 
					`tbl_charge_base_detail` CBD
					JOIN tbl_charge_base CB ON (CBD.charge_base_code = CB.id)
					JOIN tbl_unity U ON (U.id=CBD.unity_code)
					JOIN `tbl_month` M	ON (CB.month_code	=	M.id)
					JOIN `tbl_year` Y	ON (CB.year_code	=	Y.id)
				WHERE 
					CBD.user_code=$user_current";
					
		$sqlCountType1	="select sum(amount) as sum from tbl_cost_unity  where user_code=$user_current ";
		$sqlCountType2	="select sum(amount) as sum from tbl_charge  where user_code=$user_current";
		$sqlCountType3	="select sum(CB.amount) as sum from tbl_charge_base_detail CBD
		JOIN tbl_charge_base CB ON (CBD.charge_base_code = CB.id)
		where CBD.user_code=$user_current";
	}
	
	$countType1=Yii::app()->db->createCommand($sqlCountType1)->queryRow();
	$countType2=Yii::app()->db->createCommand($sqlCountType2)->queryRow();
	$countType3=Yii::app()->db->createCommand($sqlCountType3)->queryRow();
	
	$sumTotal=$countType2['sum']-($countType1['sum']+$countType3['sum']);
	$arrayData=Yii::app()->db->createCommand($sql1)->queryAll();
	$arrayData1=Yii::app()->db->createCommand($sql2)->queryAll();
	$arrayDataMerge	=	  array_merge($arrayData	,	$arrayData1);

	$dataProvider	=	new CArrayDataProvider(	$arrayDataMerge	,array(
																	'sort'	=>	array(	'attributes'	=>	array('id','amount'	,	'description'	,	'create_date')	)	,			
																	'pagination'	=>	array('pagesize'	=>	10))	);

	$this->render('normalreport',array('dataProvider'	=>	$dataProvider ,'sumTotal'=>$sumTotal));
}
public function actionBlockReport()
{
	$model			=	new BlockStock('search');	
	$this->render('blockreport'	,	array('model'=>$model));
}




}
