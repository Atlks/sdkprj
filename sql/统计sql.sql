
WITH merid_amt_merGrp AS (
   select app_id,sum(amount) sum_amt_alreadyPay 
from order_bill 
WHERE   order_time>=current_date 
and  pay_time is not null 
group by   app_id
), pay_joinUname AS (
 
 
 SELECT r.app_id,
    r.sum_amt_alreadypay AS "金额",	
    m.mername,
    m.uname,
    m."feilv手续费率"
   FROM merid_amt_merGrp r
     LEFT JOIN merchan m ON r.app_id = m.id
  
  
)

 SELECT t.app_id,
    t."金额",
    t.mername,
    t.uname,
    t."feilv手续费率",
    floor("get原始金额"(t."金额", t."feilv手续费率")) AS "ysj原始金额",
    floor("get手续费"(t."金额", t."feilv手续费率")) AS "get手续费"
   FROM pay_joinUname t







作者：时间丶思考
链接：https://www.imooc.com/article/14856
来源：慕课网



//今天 充值金额

select app_id,sum(amount) sum_amt_alreadyPay from order_bill WHERE   order_time>=current_date and  pay_time is not null group by   app_id



SELECT app_id, sum_amt_alreadypay
	FROM public."todayRchg今天充值金额" left join 
	
	
	
	
	CREATE FUNCTION public."get原始金额"(IN "实际金额" numeric, "手续费率" numeric)
    RETURNS numeric
    LANGUAGE 'sql'
    
AS $BODY$return 实际金额/(1-手续费率);$BODY$;

ALTER FUNCTION public."get原始金额"(numeric, numeric)
    OWNER TO postgres;
	
	
	
	SELECT app_id, "金额", mername, uname, "feilv手续费率"
	FROM public."todayRchg今天充值金额JoinUname";
	
	
	
	select get原始金额(12506.97,0.003)
	select  12506.97/(1-0.003)
	
	select  12506.97/(1-0.003)
	
	
--计算手续费	
	 
return 实际金额/(1-手续费率);
--实际金额/(1-手续费率);




CREATE OR REPLACE FUNCTION public."get手续费"(
	"实际金额" numeric,
	"手续费率" numeric)
    RETURNS numeric
    LANGUAGE 'plpgsql'

   
AS $BODY$

begin
--计算手续费 =原始金额-实际金额
--must have begin end block..beir sync err
return 实际金额/(1-手续费率)-实际金额;
 

 

$BODY$;


	"get原始金额"(1,0.2) as "ysj原始金额",
	"get手续费"(r.sum_amt_alreadypay,m."feilv手续费率") get手续费,
	
	
	
	
	
	SELECT app_id, "金额", mername, uname, "feilv手续费率", 
floor("get原始金额"(金额,feilv手续费率)) as "ysj原始金额" ,
floor("get手续费"(金额,feilv手续费率)) get手续费
FROM public."todayRchg今天充值金额JoinUname";


select *,	floor("get原始金额"(金额,feilv手续费率)) as "ysj原始金额" ,
floor("get手续费"(金额,feilv手续费率)) get手续费 from (

 SELECT r.app_id,
    r.sum_amt_alreadypay AS "金额",

	
    m.mername,
    m.uname,
    m."feilv手续费率"
   FROM "todayRchg今天充值金额" r
     LEFT JOIN merchan m ON r.app_id = m.id)
 
 
 
 
 
 
 
 
 
 CREATE OR REPLACE FUNCTION public.sp_tb(
	)
    RETURNS TABLE(c1 numeric,c2 numeric)
    LANGUAGE 'plpgsql'
 
AS $BODY$


begin
select 1,2;
end


$BODY$;