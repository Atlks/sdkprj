# -*- coding: utf-8 -*-

"""
Created on 2022-04-02 11:18:41.293010

@author: dev@debian
@Datei: src/backoffice/settings/target_share

"""

"""
TODO    
"""


from config import *


class html():
    
    
    def GET(self):
        
        db_target_share = db.target_share()
        
        _condition = "table_target_share.id IS NOT NULL"
        
        data = db_target_share.get(order="1 DESC", _condition=_condition, join="RIGHT table_status on table_status.id = table_target_share.status")
        if data and data != -1:
            data = list(data)
        
        data_last_id = db_target_share.current_index()
        
        
        
        
    
        
        return render(data=data, data_last_id=data_last_id)
  
  
    def POST(self):
        db_target_share = db.target_share()

        input=getdata(None)
        print ("target_share input: %s" % input)
        
        action = getdata("action")
        id = getdata("id")
        
        if action == "save" or action == "create":
            db_target_share = db.target_share()
            ret_set = db_target_share.set(id=id, name=input.get('name', None), link=input.get('link', None), status=input.get('status', None), condition_include=input.get('condition_include', None), condition_exclude=input.get('condition_exclude', None), )
            if not id:
                id = ret_set
            
        print("{ziel}::data:", getdata(None))
        
        id = getdata("id", val_type=int)
        action = getdata("action")
        value = getdata("value")
        
        if action == "set":
            if id:
                db_target_share.set(condition_id=id, status=value)
        
        elif action == "delete":
            if id:
                db_target_share.delete(id=id)
            

        return redirect("?")

        
        
        
        return self.GET()
    
    
    def _test(self):
        print ("[src/backoffice/settings/target_share] index:_test()")
        ctx.data=Storage({"action" : "get", "money_min" : 1, "money_max": 30})
        
        
        return self.GET()

