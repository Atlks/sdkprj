#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Wed Aug  5 01:13:22 2020

@author: dev
"""


from config import *

class html:
    
     def GET(self):
         user_type=cookie("user_type", type=int)
         user_id=cookie("user_id", type=int)
         
         print("menu.html", user_type, user_id)
         return render.menu_left(user_type=user_type, user_id=user_id)
