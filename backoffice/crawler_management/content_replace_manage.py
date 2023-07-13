# -*- coding: utf-8 -*-

"""
Created on 2022-02-01 22:25:17.923777

@author: dev@debian

Datei: src/backoffice/crawler_management/content_replace_manage

"""

"""
TODO    
"""


from config import *


class html():
    
    
    def GET(self):
        
        data_content_replace = db.content_replace()
        
        data = data_content_replace.get(order="1 DESC", join=" table_type_content_replace on table_type_content_replace.id = table_content_replace.type_id")
        if data and data != -1:
            data = list(data)
        
        data_last_id = data_content_replace.current_index()
        
    
        
        return render(data=data, data_last_id=data_last_id)
  
  
    def POST(self):
        data_content_replace = db.content_replace()

        input=getdata(None)
        print ("content_replace input: %s" % input)
        
        action = getdata("action")
        id = getdata("id")
        
        if action == "save" or action == "create":
            db_content_replace = db.content_replace()
            db_content_replace.set(id=id, type_id=input.get('type_id', None), original_text=input.get('original_text', None), target_text=input.get('target_text', None), updated=input.get('updated', None), )
            
        elif action == "delete":
            if row:
                db_content_replace = db.content_replace()
                db_content_replace.delete(condition_id=id)
            

        return redirect("?")

        
        
        
        return self.GET()
    
    
    def _test(self):
        print ("[src/backoffice/crawler_management/content_replace_manage] index:_test()")
        ctx.data=Storage({"action" : "get", "money_min" : 1, "money_max": 30})
        
        
        return self.GET()

