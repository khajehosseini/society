select * from(
	SELECT id,amount	,'هزینه واحد' as description  ,create_date	
	FROM `tbl_cost_unity`
	WHERE user_code=$user_current and	unity_code	=	{$_GET['unity_code']}
	
	UNION
	SELECT id,amount,'شارژ' as description ,	create_date	FROM 
		`tbl_charge`
	WHERE 
		user_code=$user_current and	unity_code	=	{$_GET['unity_code']}
) as a order by create_date desc	


select * from(
					SELECT id,amount, 'هزینه واحد' as description	,create_date
					FROM 
						`tbl_cost_unity`
					WHERE 
						user_code=10
					UNION
					SELECT id,amount,'شارژ' as description ,create_date	FROM 
						`tbl_charge`
					WHERE 
					user_code=10
					UNION (
					SELECT cbd.id as id,cb.amount as amount ,'شارژ پایه ماه' as description ,cb.create_date	FROM 
						`tbl_charge_base_detail` cbd
					join tbl_charge_base cb on 	(cbd.charge_base_code = cb.id)
					WHERE 
					cbd.user_code=10)
) as a order by create_date desc

select * from(

select * from(
					
					
					SELECT id,`amount`,'شارژ' as description ,create_date	
					FROM 
						`tbl_charge`
					WHERE 
					user_code=10
					
					UNION
					SELECT id,amount, 'هزینه واحد' as description	,create_date
					FROM 
						`tbl_cost_unity`
					WHERE 
						user_code=10					
					
					
					
									
					
					
) as a 

union 

SELECT CBD.id as id,'bb' as `amount`,'شارژ پایه ماه' as description ,'jj' as create_date	
					FROM 
						`tbl_charge_base_detail` CBD
						JOIN tbl_charge_base CB ON (CBD.charge_base_code = CB.id)
					WHERE 
						CBD.user_code=10
) as b
						
						
						








order by create_date desc



SELECT id,amount, 'هزینه واحد' as description	,create_date
					FROM 
						`tbl_cost_unity`
					WHERE 
						user_code=10
					
					UNION
					SELECT id,amount, 'هزینه واحد' as description	,create_date
					FROM 
						`tbl_cost_unity`
					WHERE 
						user_code=10
					UNION
					SELECT id,amount, 'هزینه واحد' as description	,create_date
					FROM 
						`tbl_cost_unity`
					WHERE 
						user_code=10
						UNION
					SELECT id,amount, 'هزینه واحد' as description	,create_date
					FROM 
						`tbl_cost_unity`
					WHERE 
						user_code=10