# -*- coding: utf-8 -*-
"""
Created on Tue Mar 29 20:59:47 2016

@author: dev
"""

"""
TODO ＊ 根据预约的id传输订单号
        按时间
        金额
"""

from config import *
import random
import json
import hashlib



try:
    import crawl
except:
    class crawl:
        need_login = None
        login_error = None


class html(user_rights):
    
    
    def GET(self):
        
        #print("index::GET")
  
        password=getdata("p")
        

        password = "saosaosao8888"
        if password == "saosaosao8888":
            msg=""
            try:
                if crawl.need_login:
                    msg="<h2><font color=red>请输入OTP</h2>"
            except:
                pass
            
            user_type=cookie("user_type", type=int)
            user_id=cookie("user_id", type=int)
            username=cookie("user_username")

            
            need_login=crawl.need_login
            login_error=crawl.login_error
            if login_error==None:
                login_error=0
            
            return render.index(msg=msg, user_type=user_type, user_id=user_id, need_login=need_login,login_error=login_error,username=username)
        else:
            return "无权限"

    def POST(self):
        return self.GET()
    
    
    def _test(self):
        

        ctx.data=Storage({'p' : 'saosaosao8888','keywords': u'188', 'page' : 1})
        
        return self.GET()


         
        
         
