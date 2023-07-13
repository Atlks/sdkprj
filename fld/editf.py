class tasksCls2:
    def GET(self):
        return "Hello, tasksCls! 3333"
    def POST(self):
        return "Hello, tasksCls! post meth"   
    @staticmethod    
    def m():
        print("m me out...")
        return    
import web
import os
from utifld.util import *
from utifld.dbx import *
from sdk.mysql import *
from cfgx import *
from sdk.mysql import *
from pymysql.converters import escape_string
class edsvCls:
      def POST(self):
     
         
        tit=escape_string(web.input().tit)   
        con=  (web.input().content1) .replace("'", "''")
        id=str(int(web.input().id))
        
        sql=f"UPDATE table_article set text_content='{con}' ,name='{tit}' where id={id}" 
        print(sql)
         
        print( updt('',sql)  ) 
        return "ok" 
class pubCls:
       def GET(self):
       
        sql='select * from  table_article where id='+str(int(web.input().id))
        print(sql)
        (results,field_names)=query('',sql)
        row=results[0]
         
        tit=row[field_names.index('name')]
        con=row[field_names.index('text_content')]
        
        sql=f"insert wp_posts set post_content='{con}' ,post_title='{tit}',post_status='publish',post_date=NOW(),post_date_gmt=NOW(),post_excerpt='' ,to_ping='',pinged='',post_modified=now(),post_modified_gmt=now(),post_content_filtered=''" 
        conn = pymysql.connect(host=wdprs_host,user= wdprs_user,password=wdprs_pwd,db= wdprs_db)
        print( exeSqlUpdt(sql,conn)  ) 
        return "ok" 
class shareCls:
       def GET(self):
       
        sql='select * from  table_article where id='+str(int(web.input().id))
        print(sql)
        (results,field_names)=query('',sql)
        row=results[0]
         
        tit=row[field_names.index('name')]
        #  parse_mode=telegram.ParseMode.HTML
        bot_token="5178273178:AAE7Ev4HbQa22n9rcrbwZK1_LePgHMXCELI"  #jmb bot  
        
        chatid_music='-1001553102139'
        jonbmgrpid="-1001637725289"
       
        sendMsgx(bot_token,jonbmgrpid,"https://zbm.news/1654250527_2/")
        sendMsgx(bot_token,chatid_music,"https://zbm.news/1654250527_2/")
        return "ok"    
class  staticxCls:
    def GET(self, name):
        import sys
        f = open(sys.path[0]+'/../staticx/' + name)
        return f.read()


class editCls:
    def GET(self):
        import web
        import os
        #render = web.template.render('templates/')
        #render = web.template.render('/',cache = False )
        #render = web.template.render('fld/',cache = False )
        print(os.path.dirname(__file__))
        #D:\0src\acbo_api\dev\src\fld
        web_ipt = web.input()
        print(web_ipt)
        print(web_ipt.id)
        print(type(web_ipt.id))
        sql='select * from  table_article where id='+str(int(web_ipt.id))
        print(sql)
        (results,field_names)=query('',sql)
        print(results[0])
        tmpTxt=open(os.path.dirname(__file__)+"/editor.html",encoding='utf8').read()
        print(tmpTxt)
        #render=  web.template.frender(os.path.dirname(__file__)+"/editor.html"  )
        render=  web.template.Template(tmpTxt  )
        #hello = web.template.Template(template)
        tit=results[0][field_names.index('name')]
        art={};
        art['id']=results[0][field_names.index('id')]
        print(art)
        return render(results,field_names,tit,results[0][field_names.index('text_content')],art);

        #return "Hello, edit cls"
        print(render)
        #return render.editor()
