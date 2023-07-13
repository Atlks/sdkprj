# -*- coding: utf-8 -*-

"""
Created on 2022-02-09 17:01:22.839547

@author: dev@debian

Datei: backoffice/crawler_management/article_management

"""

"""
TODO    
"""


from config import *


class html():
    
    
    def GET(self):
        

        db_article = db.article()
        
        
        limit=100
        
        user_id = cookie("user_id")
        
        keywords=getdata("keywords", None)
        page=getdata("page", 1, val_type=int) or 1
        order=getdata("order", db_article._table_name+".id DESC")
        if order:
            _order = order.replace(db_article._table_name.replace("table_", "")+"__x__", db_article._table_name+"__x__").replace("__x__", ".")
        else:
            _order = None
            
        print("_order:", _order)
        
        condition_search = None
        condition_search = create_search_conditions(["name", db_article._table_name+".id::text", "text_content"], keywords, condition=condition_search, condition_operator="AND", operand="OR", keyword_operand="AND")
        
        join = "LEFT table_article_stats ON table_article_stats.id = table_article.id"
        count=0
        total=0
        pages=0
        
        #addditional data variables
        data=None
        data_category=None
        data_tag=None
        
        data=db_article.search(
            offset=(page-1)*limit, 
            limit=limit,
            _condition=condition_search,
            order=_order, 
            join=join
            )
        
        if data == -1:
            print("### DB Error")
            
            
        count=db_article.search_count(
            _condition=condition_search, 
            join=join
            )
            
        total=db_article.count()

        
        data = list(data)
        
        ids = []
        for item in data:
            if isinstance(item.category_ids, int):
                ids.append(item.id)
            else:                    
                for item_id in item.category_ids or []:
                    if item_id not in ids:
                        ids.append(item_id)
    
        data_category = dict()
        dbdata_category = db.category().get(id=ids)
        
        if isinstance(dbdata_category, int):
            print("DB error")            
        elif dbdata_category:
            data_category = dbdata_category.to_dict()

        data = list(data)
        
        ids = []
        for item in data:
            if isinstance(item.tag_ids, int):
                ids.append(item.id)
            else:                    
                for item_id in item.tag_ids or []:
                    if item_id not in ids:
                        ids.append(item_id)
    
        data_tag = dict()
        dbdata_tag = db.tag().get(id=ids)
        
        if isinstance(dbdata_tag, int):
            print("DB error")            
        elif dbdata_tag:
            data_tag = dbdata_tag.to_dict()


        pages = pages_calc_count(count, limit) or 0     #计算总的页数
        if page > pages:
            page = pages
            
            
            
        
        return render(data=data, pages=pages, page=page, order=order,data_category=data_category,data_tag=data_tag, keywords=keywords)
  
  
    def POST(self):
        
        
        
        
        return self.GET()
    
    
    def _test(self):
        print ("[backoffice/crawler_management/article_management] index:_test()")
        ctx.data=Storage({"action" : "get", "money_min" : 1, "money_max": 30})
        
        
        return self.GET()

