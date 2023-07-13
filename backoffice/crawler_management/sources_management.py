# -*- coding: utf-8 -*-

"""
Created on 2022-02-20 17:27:16.033660

@author: dev@debian
@Datei: src/backoffice/crawler_management/sources_management

"""

"""
TODO    
"""


from config import *


class html():
    
    
    def GET(self):
        

        db_crawler = db.crawler()
        
        
        limit=100
        
        user_id = cookie("user_id")
        
        keywords=getdata("keywords", None)
        page=getdata("page", 1, val_type=int) or 1
        order=getdata("order", None)
        if order:
            _order = order.replace(db_crawler._table_name.replace("table_", "")+"__x__", db_crawler._table_name+"__x__").replace("__x__", ".")
        else:
            _order = None
        
         
        condition_search=None #basic conditions
        condition_search = create_search_conditions(['id::text', 'name::text', 'domain::text', 'status::text', 'updated::text'], keywords, condition=condition_search, condition_operator="AND", operand="OR", keyword_operand="AND")
        
        count=0
        total=0
        pages=0
        
        #addditional data variables
        data=None
        
        data=db_crawler.search(
            offset=(page-1)*limit, 
            limit=limit,
            _condition=condition_search,
            order=_order, 
            join="LEFT table_status on table_status.id = table_crawler.status"
            )
        
        if data == -1:
            print("### DB Error")
            
            
        count=db_crawler.search_count(
            _condition=condition_search, 
            join="LEFT table_status on table_status.id = table_crawler.status"
            )
            
        total=db_crawler.count()

        

        pages = pages_calc_count(count, limit) or 0     #计算总的页数
        if page > pages:
            page = pages
            
            
            
        
        return render(data=data, pages=pages, page=page, order=order, keywords=keywords)
  
  
    def POST(self):
        data_crawler = db.crawler()
        print("data:", getdata(None))
        id = getdata("id", val_type=int)
        action = getdata("action")
        value = getdata("value")
        
        if action == "set":
            if id:
                data_crawler.set(condition_id=id, status=value)
        
        
        
        
        return self.GET()
    
    
    def _test(self):
        print ("[src/backoffice/crawler_management/sources_management] index:_test()")
        ctx.data=Storage({"action" : "get", "money_min" : 1, "money_max": 30})
        
        
        return self.GET()

