# -*- coding: utf-8 -*-

"""
Created on 2018-02-24 09:10:30.367550

@author: dev

Datei: src/paymentgateway/settings/options

"""

"""
TODO    
"""


from config import *


class html():
    
    
    def GET(self):
        
        data_option = db.option()
        
        data = data_option.get(order="1 DESC")
        if data and data != -1:
            data = list(data)
        
        
        data_last_id = data_option.current_index()
        
        return render(data=data, data_last_id=data_last_id)
  
  
    def POST(self):
        data_option = db.option()

        input=getdata(None)
        print ("option input: %s" % input)
        
        action = getdata("action")
        
        if action:
            if  (action == "create" or action == "save"):
                ret=data_option.set(id=input.get('id', None), name=input.name, description=input.description, value=input.value, content=input.content, status=input.status, )
    
            elif action == "delete":
                
                data_option.delete(id=input.get('id', None), )


        return redirect("?")

        
        return self.GET()
    
    
    def _test(self):
        print ("[src/paymentgateway/settings/options] index:_test()")
        ctx.data=Storage({'money_min' : 1, 'money_max': 30})
        
        
        return self.GET()

