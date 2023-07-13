# -*- coding: utf-8 -*-

from config import *

 
#判断读写权限
#login  

class user_rights(have_system_rights):
    
    
    
    def have_prevelegies(self):
        import web.functions.account as account #todo it is login and not login.account
        
        self.fail_class=account.login.html()
        
        try:
            if debug_auto:
                cookie("user_id", 1)
                cookie("user_type", 4095)
                cookie("token_admin", 1)
                cookie("user_username", "Huangdi")
        except:
            pass
        
        #print ("user_rights:", cookie(None))
        user_id=cookie('user_id')
        
        #todo 
        
        if debug:
            print ("user_rights:user_id:",user_id)

        return user_id
        
       
       
 
class user_rights_user_list(have_system_rights):
    fail_url="/test/lo"
    
    def have_prevelegies(self):
       user_type = cookie("user_type")
       user_id = cookie('user_id')
       if user_type and int(user_type) & 2**0 == 2**0:
           previlege_id = 1
           location = "/userlist"
           write_into_db(previlege_id,location)
           return 1
       return 0
       
       
class user_rights_sms(have_system_rights):
    fail_url="/test/lo"
    
    def have_prevelegies(self):
        user_type = cookie("user_type")
        user_id = cookie('user_id')
        if user_type and int(user_type) & 2**1 == 2**1:
            previlege_id = 2
            location = "/sms_gateway"
            write_into_db(previlege_id,location)
            return 1
        return 0


def write_into_db(previlege_id,location):
    import datetime
    import db
    data = db.log_user_previlege_function()
    user_id = cookie("user_id")
    data.add(id = user_id,previlege_id = previlege_id,location = location,datetime = datetime.datetime.now())
        
'''
class user_rights_write(have_system_rights_write):
    fail_url="/login"
    
    def have_prevelegies(self):
       
       user_id=cookie('user_id')
       
       return user_id
'''
# -*- coding: utf-8 -*-

from config import *



#判断读写权限
#login

class user_rights(have_system_rights):
    
    
    
    def have_prevelegies(self):
        import web.functions.account as account #todo it is login and not login.account
        
        self.fail_class=account.login.html()
        
        try:
            if debug_auto:
                cookie("user_id", 1)
                cookie("user_type", 4095)
                cookie("token_admin", 1)
                cookie("user_username", "Huangdi")
        except:
            pass
        
        #print ("user_rights:", cookie(None))
        user_id=cookie('user_id')
        
        #todo        

        return user_id
        
       
       
 
class user_rights_user_list(have_system_rights):
    fail_url="/test/lo"
    
    def have_prevelegies(self):
       user_type = cookie("user_type")
       user_id = cookie('user_id')
       if user_type and int(user_type) & 2**0 == 2**0:
           previlege_id = 1
           location = "/userlist"
           write_into_db(previlege_id,location)
           return 1
       return 0
       
       
class user_rights_sms(have_system_rights):
    fail_url="/test/lo"
    
    def have_prevelegies(self):
        user_type = cookie("user_type")
        user_id = cookie('user_id')
        if user_type and int(user_type) & 2**1 == 2**1:
            previlege_id = 2
            location = "/sms_gateway"
            write_into_db(previlege_id,location)
