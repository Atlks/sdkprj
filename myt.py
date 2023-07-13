
  #python myt.py
  #cd /d D:\0src\acbo_api\dev\src
import pymysql
from cfgx import *
tit='标题111'
con='cc内容ccc'
from sdk.mysql import *
sql=f"insert wp_posts set post_content='{con}' ,post_title='{tit}',post_status='publish',post_date=NOW(),post_date_gmt=NOW(),post_excerpt='' ,to_ping='',pinged='',post_modified=now(),post_modified_gmt=now(),post_content_filtered=''" 
conn = pymysql.connect(host=wdprs_host,user= wdprs_user,password=wdprs_pwd,db= wdprs_db)
print( exeSqlUpdt(sql,conn)  )