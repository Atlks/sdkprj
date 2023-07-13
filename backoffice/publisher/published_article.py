# -*- coding: utf-8 -*-

"""
Created on 2022-02-22 15:23:56.026785

@author: dev@debian
@Datei: src/backoffice/publisher/published_article

"""

"""
TODO    
"""


from config import *


class html():
    
    
    def GET(self):
        

        db_target_synced = db.target_synced()
        
        
        limit=100
        
        user_id = cookie("user_id")
        
        keywords=getdata("keywords", None)
        page=getdata("page", 1, val_type=int) or 1
        order=getdata("order", None)
        if order:
            _order = order.replace(db_target_synced._table_name.replace("table_", "")+"__x__", db_target_synced._table_name+"__x__").replace("__x__", ".")
        else:
            _order = None
        
         
        condition_search="table_target_synced.id IS NOT NULL" #basic conditions
        condition_search = create_search_conditions(['table_article.name', 'table_target_synced.source_id::text', 'table_target_synced.target_id::text', 'table_target_synced.item_id::text', 'table_target_synced.status::text', 'table_target_synced.created::text', 'table_target_synced.result_id::text'], keywords, condition=condition_search, condition_operator="AND", operand="OR", keyword_operand="AND")
        
        count=0
        total=0
        pages=0
        
        #addditional data variables
        data=None
        
        data=db_target_synced.search(
            offset=(page-1)*limit, 
            limit=limit,
            _condition=condition_search,
            order=_order, 
            join="LEFT table_crawler on table_crawler.id = table_target_synced.source_id LEFT JOIN table_target on table_target.id = table_target_synced.target_id LEFT JOIN table_article on table_article.id = table_target_synced.item_id LEFT JOIN table_status on table_status.id = table_target_synced.status"
            )
        
        if data == -1:
            print("### DB Error")
            
            
        count=db_target_synced.search_count(
            _condition=condition_search, 
            join="LEFT table_crawler on table_crawler.id = table_target_synced.source_id LEFT JOIN table_target on table_target.id = table_target_synced.target_id LEFT JOIN table_article on table_article.id = table_target_synced.item_id LEFT JOIN table_status on table_status.id = table_target_synced.status"
            )
            
        total=db_target_synced.count()

        

        pages = pages_calc_count(count, limit) or 0     #计算总的页数
        if page > pages:
            page = pages
            
            
            
        
        return render(data=data, pages=pages, page=page, order=order, keywords=keywords)
  
  
    def POST(self):
        data_target_synced = db.target_synced()
        print("{ziel}::data:", getdata(None))
        
        id = getdata("id", val_type=int)
        action = getdata("action")
        value = getdata("value")
        
        if action == "sync.delete":
            pass
                
        elif action == "delete":
            if id:
                data_target_synced.delete(id=id)
        
        
        
        
        return self.GET()
    
    
    def _test(self):
        print ("[src/backoffice/publisher/published_article] index:_test()")
        ctx.data=Storage({"action" : "get", "money_min" : 1, "money_max": 30})
        
        
        return self.GET()

