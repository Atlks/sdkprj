 
#  pip install requests
 # pip install bs4
  #     pip install pymysql

  #end
#   pip install demjson
  

	
# 	    pip install etree
	#	pymysql
# 	 pip install  lxml
	 
# 		
import string
import urllib.request
from bs4 import BeautifulSoup
import hashlib
import pymysql
import requests
import sdk.mysql
import sdk.encry
import sdk.tools
import  sdk.httpclient
# try:
#     #raise 'someEx'
#     raise Exception("抛出一个异常")
# except Exception as e:
#     print(e)
#     print('eee')
print( '------------start')
var1=5
r=vars() 
print( vars() )
print( '------------end')
#sys.exit()



print (sdk.encry. get_md5('555'))

 # 使用cursor()方法获取操作游标 
db = pymysql.connect("182.16.50.115", "tom_akbar", "123456", "dev_kok_sport")
conn=db




    
#, 'lxml'
#raise 'aa'
 
##----------------get url 
url = "http://kokkq.com/live/"
html=sdk.httpclient.getUrl(url)
Soup = BeautifulSoup(html)
trs= Soup.select('tr') 





for tag_tr in trs:
    
    try:    
        #print(tag_tr)
        tds= tag_tr.select('td')
        match_type=str(tds[1].string)
        #print(tds[1].string)   #saishimchen
        match_time=str(tds[2].string)
        home_team=str(tds[3].string)
        直播状态=str(tds[4].string)
        away_team=str(tds[5].string)
       # print(str (saisiMeinchen) +str(time) +str( judui) +str( kadwi))
        
        
        
        # 执行sql语句
       
        
        md5= sdk.encry.get_md5(str (match_type) +str(match_time) +str( home_team) +str( away_team)   )    
        sdk.mysql. uniqueIdx("kok_match_t", "md5key", md5,conn)        
        rel_sql = string.Template("INSERT INTO kok_match_t(id, match_type, match_time, home_team,away_team,md5key,match_status)values" \
                                "('$id','$match_type','$match_time','$home_team','$away_team','$md5','$直播状态')  " )                       
        ##replace  the def vals..beirs if use json mode,,must manual defi  cant auto by var
        rel_sql=rel_sql.safe_substitute(  vars())
        rel_sql=rel_sql.replace('$直播状态',直播状态)
        rel_sql= string.Template(rel_sql)              
        rel_sql=(  rel_sql.safe_substitute( { "id":sdk. tools.generate_id()} )   )
       
        print(rel_sql)
        cursor= sdk.mysql.exeSqlUpdt(rel_sql,conn)    
        print(cursor)  #print(cursor.rowcount)
        #sys.exit()
    except Exception as e:
        print( e)    

  
#print(Soup)
         # rel_sql = f"INSERT INTO kok_match_t(id, match_type, match_time, home_team,away_team,md5key)values" \
        #                         "('{id}','@match_type@','@match_time@','@home_team@','@away_team@','@md5key@')  " 
 
 

 
 