# -*- coding: utf-8 -*-

"""
Created on 2022-03-30 14:38:16.982556

@author: dev@debian
@Datei: src/backoffice/publisher/content_replacer

"""

"""
TODO    
"""


from config import *


class html():
    
    
    def GET(self):
        
        data_content_replace_publish = db.content_replace_publish()
        
        _condition = "table_content_replace_publish.id IS NOT NULL"
        
        data = data_content_replace_publish.get(order="1 DESC", _condition=_condition, join="LEFT table_crawler on table_crawler.id = table_content_replace_publish.source_id LEFT JOIN table_type_content_replace on table_type_content_replace.id = table_content_replace_publish.type_id")
        if data and data != -1:
            data = list(data)
        
        data_last_id = data_content_replace_publish.current_index()
        
        return render(data=data, data_last_id=data_last_id)
  
  
    def POST(self):
        data_content_replace_publish = db.content_replace_publish()

        input=getdata(None)
        print ("content_replace_publish input: %s" % input)
        
        action = getdata("action")
        id = getdata("id")
        
        if action == "save" or action == "create":
            db_content_replace_publish = db.content_replace_publish()
            
            ret_set = db_content_replace_publish.set(id=id, source_id=input.get('source_id', None), type_id=input.get('type_id', None), original_text=input.get('original_text', None), target_text=input.get('target_text', None), updated=input.get('updated', None), )
            print("POST::ret:", ret_set)
            if not id:
                id = ret_set
            
        elif action == "delete":
            if id:
                db_content_replace_publish = db.content_replace_publish()
                db_content_replace_publish.delete(id=id)
            

        return redirect("?")

        
        
        
        return self.GET()
    
    
    def _test(self):
        print ("[src/backoffice/publisher/content_replacer] index:_test()")
        ctx.data=Storage({"action" : "get", "money_min" : 1, "money_max": 30})
        
        
        return self.GET()

