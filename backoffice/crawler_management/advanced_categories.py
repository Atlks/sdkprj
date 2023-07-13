# -*- coding: utf-8 -*-

"""
Created on 2022-02-02 17:58:58.604835

@author: dev@debian

Datei: src/backoffice/crawler_management/advanced_categories

"""

"""
TODO    
"""


from config import *


class html():
    
    
    def GET(self):
        
        data_sub_category = db.sub_category()
        
        data = data_sub_category.get(order="1 DESC", join="LEFT table_status on table_status.id = table_sub_category.status")
        if data and data != -1:
            data = list(data)
        
        data_last_id = data_sub_category.current_index()
        
    
        
        return render(data=data, data_last_id=data_last_id)
  
  
    def POST(self):
        data_sub_category = db.sub_category()

        input=getdata(None)
        print ("sub_category input: %s" % input)
        
        action = getdata("action")
        id = getdata("id")
        
        if action == "save" or action == "create":
            db_sub_category = db.sub_category()
            db_sub_category.set(id=id, name=input.get('name', None), link=input.get('link', None), index_order=input.get('index_order', None), status=input.get('status', None), )
            
        elif action == "delete":
            if row:
                db_sub_category = db.sub_category()
                db_sub_category.delete(condition_id=id)
            

        return redirect("?")

        
        
        
        return self.GET()
    
    
    def _test(self):
        print ("[src/backoffice/crawler_management/advanced_categories] index:_test()")
        ctx.data=Storage({"action" : "get", "money_min" : 1, "money_max": 30})
        
        
        return self.GET()

