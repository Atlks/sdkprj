# -*- coding: utf-8 -*-

"""
Created on 2022-02-07 19:32:21.397577

@author: dev@debian

Datei: src/backoffice/crawler_management/article_categories

"""

"""
TODO    
"""


from config import *


class html():
    
    
    def GET(self):
        
        data_category = db.category()
        
        data = data_category.get(order="1 DESC", join="LEFT table_status on table_status.id = table_category.status")
        if data and data != -1:
            data = list(data)
        
        data_last_id = data_category.current_index()
        
        
        data = list(data)
        
        ids = []
        for item in data:
            if isinstance(item.id, int):
                ids.append(item.id)
            else:                    
                for item_id in item.id or []:
                    if item_id not in ids:
                        ids.append(item_id)
    
        data_category_to_sub_category_relation = dict()
        dbdata_category_to_sub_category_relation = db.category_to_sub_category_relation().get(sub_category_id=ids)
        
        if isinstance(dbdata_category_to_sub_category_relation, int):
            print("DB error")            
        elif dbdata_category_to_sub_category_relation:
            data_category_to_sub_category_relation = dbdata_category_to_sub_category_relation.to_dict()

        
        data_sub_category = dict()
        dbdata_sub_category = db.sub_category().get()
        
        if isinstance(dbdata_sub_category, int):
            print("DB error")            
        elif dbdata_sub_category:
            data_sub_category.update(dbdata_sub_category.to_dict())

        
    
        
        return render(data=data, data_last_id=data_last_id,data_category_to_sub_category_relation=data_category_to_sub_category_relation,data_sub_category=data_sub_category)
  
  
    def POST(self):
        data_category = db.category()

        input=getdata(None)
        print ("category input: %s" % input)
        
        action = getdata("action")
        id = getdata("id")
        
        if action == "save" or action == "create":
            db_category = db.category()
            ret_set = db_category.set(id=id, name=input.get('name', None), index_order=input.get('index_order', None), status=input.get('status', None), )
            if not id:
                id = ret_set
            
            selection = get_input_array("sub_category")
            for item_id in selection or []:
                print("	item_id:", item_id)
                db.category_to_sub_category_relation().set(condition_category_id=id, condition_sub_category_id=item_id)
                
            #delete data that was not selected
            category_to_sub_category_relation_ids = category_to_sub_category_relation = db.category_to_sub_category_relation().get(what="sub_category_id", category_id=id)
            if isinstance(category_to_sub_category_relation_ids, int):
                print("db error while deleting data")
            elif category_to_sub_category_relation_ids:
                ids = [item.sub_category_id for item in category_to_sub_category_relation_ids if not item.sub_category_id in selection]
                if ids:
                    ret = db.category_to_sub_category_relation().delete(category_id=id, sub_category_id=ids)
                    print("delete ret:", ret)
            
        elif action == "delete":
            if id:
                db_category = db.category()
                db_category.delete(condition_id=id)
            

        return redirect("?")

        
        
        
        return self.GET()
    
    
    def _test(self):
        print ("[src/backoffice/crawler_management/article_categories] index:_test()")
        ctx.data=Storage({"action" : "get", "money_min" : 1, "money_max": 30})
        
        
        return self.GET()

