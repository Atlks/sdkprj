# -*- coding: utf-8 -*-

"""
Created on 2022-02-17 16:54:39.424323

@author: dev@debian
@Datei: src/backoffice/settings/status

"""

"""
TODO    
"""


from config import *


class html():
    
    
    def GET(self):
        
        data_status = db.status()
        
        data = data_status.get(order="1 DESC", join="")
        if data and data != -1:
            data = list(data)
        
        data_last_id = data_status.current_index()
        
        
        
        
    
        
        return render(data=data, data_last_id=data_last_id)
  
  
    def POST(self):
        data_status = db.status()

        input=getdata(None)
        print ("status input: %s" % input)
        
        action = getdata("action")
        id = getdata("id")
        
        if action == "save" or action == "create":
            db_status = db.status()
            ret_set = db_status.set(id=id, status_name=input.get('status_name', None), is_active=bool(input.get('is_active', None)!=None), )
            if not id:
                id = ret_set
                        
        elif action == "delete":
            if id:
                db_status = db.status()
                db_status.delete(condition_id=id)
            

        return redirect("?")

        
        
        
        return self.GET()
    
    
    def _test(self):
        print ("[src/backoffice/settings/status] index:_test()")
        ctx.data=Storage({"action" : "get", "money_min" : 1, "money_max": 30})
        
        
        return self.GET()

