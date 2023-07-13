# -*- coding: utf-8 -*-

"""
Created on 2022-01-31 14:19:04.817066

@author: dev@debian

Datei: src/backoffice/crawler_management/tag_management

"""

"""
TODO    
"""


from config import *


class html():
    
    
    def GET(self):
        
        data_tag = db.tag()
        
        data = data_tag.get(order="1 DESC", join="LEFT table_status on table_status.id = table_tag.status")
        if data and data != -1:
            data = list(data)
        
        data_last_id = data_tag.current_index()
        
    
        
        return render(data=data, data_last_id=data_last_id)
  
  
    def POST(self):
        data_tag = db.tag()

        input=getdata(None)
        print ("tag input: %s" % input)
        
        action = getdata("action")
        
        if action and (action == "create" or action == "save"):
            ret=data_tag.set(id=input.get('id', None), tag_name=input.get('tag_name', None), status=input.get('status', None), )

        if action and action == "delete":
            
            data_tag.delete(id=input.get('id', None), )
            

        return redirect("?")

        
        action = getdata("action")
        id = getdata("id")        
        credibility = getdata("credibility")
        
        if action == "save":
            db_user_credibility = db.user_credibility()
            db_user_credibility.set(row=row, credibility=credibility)
            
        elif action == "delete":
            if row:
                db_user_credibility = db.user_credibility()
                db_user_credibility.delete(row=row)      
        
        
        return self.GET()
    
    
    def _test(self):
        print ("[src/backoffice/crawler_management/tag_management] index:_test()")
        ctx.data=Storage({"action" : "get", "money_min" : 1, "money_max": 30})
        
        
        return self.GET()

