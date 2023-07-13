# -*- coding: utf-8 -*-

"""
Quelldatei zum definieren der URLS

Created on 2020-08-15 09:39:39.797799

@author: dev@debian

Datei: dev/src/backoffice/http_urls.py

"""

"""
TODO    
"""

urls = (                
        "/backoffice/", "backoffice.index.html",
        "/backoffice", "web.functions.redirect.html&url=/backoffice/",
        "/backoffice/index", "backoffice.index.html",
        "/backoffice/task_list_review", "backoffice.task_list_review.html",
        "/backoffice/task_list", "backoffice.task_list.html",
        
        "/backoffice/settings/location/add",  "web.functions.admin_setttings_locations.add",
        '/backoffice/settings/location/start', 'web.functions.admin_setttings_locations.start',
        '/backoffice/settings/location/edit', 'web.functions.admin_setttings_locations.edit',
        '/backoffice/settings/location/combo','web.functions.combo.html&t=&name=',
        
        "/backoffice/platform_settings/categories/add",  "web.functions.admin_setttings_locations.add&t=table_category&name=分类",
        '/backoffice/platform_settings/categories/start', 'web.functions.admin_setttings_locations.start&t=table_category&name=分类',
        '/backoffice/platform_settings/categories/edit', 'web.functions.admin_setttings_locations.edit&t=table_category&name=分类',
        '/backoffice/platform_settings/categories/combo','web.functions.combo.html&t=table_category&name=分类',
                
        "/backoffice/settings/games/add",  "web.functions.admin_setttings_locations.add&t=table_game&name=游戏类型",
        '/backoffice/settings/games/start', 'web.functions.admin_setttings_locations.start&t=table_game&name=游戏类型',
        '/backoffice/settings/games/edit', 'web.functions.admin_setttings_locations.edit&t=table_game&name=游戏类型',
       )

