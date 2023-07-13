#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Wed Feb  2 15:15:19 2022

@author: dev
"""

import traceback, os, sys, re
from config import *

#from core import sync_to_target



def _test_balance():
    ret = db.account().set(condition_user_id=1, operation="+", balance=1.001)    
    ret = db.account().get_first(user_id=1)
        
    print("ret:", ret)
    
    

    

def _test():
    #_test_balance()
    ret=db.login().set(phone="Huangdi",  password=hashlib.sha256((salt + "MyPass1").encode('utf-8')).hexdigest(), password_salt=salt, type=~0, _condition="phone='Huangdi'")
    #crawlers.load_all_modules(http_urls="crawler", attr_name="crawler", path="crawlers")
    #crawlers.crawler_by_id(1)
    #print("crawlers_loaded_g:", crawlers.crawlers_loaded_g)

    
    
if __name__ == "__main__":
    _test()
    #sync_to_target.test()
    
