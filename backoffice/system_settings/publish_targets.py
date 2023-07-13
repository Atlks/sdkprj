# -*- coding: utf-8 -*-

"""
Created on 2022-02-21 12:52:27.924088

@author: dev@debian
@Datei: src/backoffice/system_settings/publish_targets

"""

"""
TODO    
"""


from config import *


class html():
    
    
    def GET(self):
        
        data_target = db.target()
        
        _condition = "table_target.id IS NOT NULL"
        
        data = data_target.get(order="1 DESC", _condition=_condition, join="RIGHT table_status on table_status.id = table_target.status")
        if data and data != -1:
            data = list(data)
        
        data_last_id = data_target.current_index()
        
        
        
        
    
        
        return render(data=data, data_last_id=data_last_id)
  
  
    def POST(self):
        data_target = db.target()

        input=getdata(None)
        print ("target input: %s" % input)
        
        action = getdata("action")
        id = getdata("id")
        
        if action == "save" or action == "create":
            db_target = db.target()
            ret_set = db_target.set(id=id, name=input.get('name', None), link=input.get('link', None), status=input.get('status', None), )
            if not id:
                id = ret_set
            
        print("backoffice/system_settings/publish_targets::data:", getdata(None))
        id = getdata("id", val_type=int)
        action = getdata("action")
        value = getdata("value")
        
        if action == "set":
            if id:
                data_target.set(condition_id=id, status=value)
                    
        elif action == "delete":
            if id:
                db_target = db.target()
                db_target.delete(id=id)
            

        return redirect("?")

        
        
        
        return self.GET()
    
    
    def _test(self):
        print ("[src/backoffice/system_settings/publish_targets] index:_test()")
        ctx.data=Storage({"action" : "get", "money_min" : 1, "money_max": 30})
        
        
        return self.GET()

