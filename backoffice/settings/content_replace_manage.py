# -*- coding: utf-8 -*-

"""
Created on 2022-02-01 22:24:39.895018

@author: dev@debian

Datei: src/backoffice/settings/content_replace_manage

"""

"""
TODO    
"""


from config import *


class html():
    
    
    def GET(self):
        
        data_type_content_replace = db.type_content_replace()
        
        data = data_type_content_replace.get(order="1 DESC", join="")
        if data and data != -1:
            data = list(data)
        
        data_last_id = data_type_content_replace.current_index()
        
    
        
        return render(data=data, data_last_id=data_last_id)
  
  
    def POST(self):
        data_type_content_replace = db.type_content_replace()

        input=getdata(None)
        print ("type_content_replace input: %s" % input)
        
        action = getdata("action")
        id = getdata("id")
        
        if action == "save" or action == "create":
            db_type_content_replace = db.type_content_replace()
            db_type_content_replace.set(id=id, name=input.get('name', None), is_active=bool(input.get('is_active', None)!=None), )
            
        elif action == "delete":
            if row:
                db_type_content_replace = db.type_content_replace()
                db_type_content_replace.delete(condition_id=id)
            

        return redirect("?")

        
        
        
        return self.GET()
    
    
    def _test(self):
        print ("[src/backoffice/settings/content_replace_manage] index:_test()")
        ctx.data=Storage({"action" : "get", "money_min" : 1, "money_max": 30})
        
        
        return self.GET()

