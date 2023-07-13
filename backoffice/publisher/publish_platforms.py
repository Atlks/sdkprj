# -*- coding: utf-8 -*-

"""
Created on 2022-02-21 13:07:31.923787

@author: dev@debian
@Datei: src/backoffice/publisher/publish_platforms

"""

"""
TODO    
"""


from config import *


class html():
    
    
    def GET(self):
        

        db_target = db.target()
        
        
        limit=100
        
        user_id = cookie("user_id")
        
        keywords=getdata("keywords", None)
        page=getdata("page", 1, val_type=int) or 1
        order=getdata("order", None)
        if order:
            _order = order.replace(db_target._table_name.replace("table_", "")+"__x__", db_target._table_name+"__x__").replace("__x__", ".")
        else:
            _order = None
        
         
        condition_search="table_target.id IS NOT NULL" #basic conditions
        condition_search = create_search_conditions(['id::text', 'name::text', 'level::text', 'location_code::text', 'link::text', 'index_order::text', 'status::text'], keywords, condition=condition_search, condition_operator="AND", operand="OR", keyword_operand="AND")
        
        count=0
        total=0
        pages=0
        
        #addditional data variables
        data=None
        
        data=db_target.search(
            offset=(page-1)*limit, 
            limit=limit,
            _condition=condition_search,
            order=_order, 
            join="RIGHT table_status on table_status.id = table_target.status"
            )
        
        if data == -1:
            print("### DB Error")
            
            
        count=db_target.search_count(
            _condition=condition_search, 
            join="RIGHT table_status on table_status.id = table_target.status"
            )
            
        total=db_target.count()

        

        pages = pages_calc_count(count, limit) or 0     #计算总的页数
        if page > pages:
            page = pages
            
            
            
        
        return render(data=data, pages=pages, page=page, order=order, keywords=keywords)
  
  
    def POST(self):
        data_target = db.target()
        print("backoffice/publisher/publish_platforms::data:", getdata(None))
        id = getdata("id", val_type=int)
        action = getdata("action")
        value = getdata("value")
        
        if action == "set":
            if id:
                data_target.set(condition_id=id, status=value)
        
        
        
        
        return self.GET()
    
    
    def _test(self):
        print ("[src/backoffice/publisher/publish_platforms] index:_test()")
        ctx.data=Storage({"action" : "get", "money_min" : 1, "money_max": 30})
        
        
        return self.GET()

