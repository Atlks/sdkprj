# -*- coding: utf-8 -*-

from config import *

class crawler(db_check):


    """
       
       action button: 采集=1 set status
       action button: 停用=3 set status
       
       
        \param id **bigint** *爬虫标示*
        \param name **text** *爬虫名*
        \param domain **text** *主域名*
        \param status **integer** *状态  link-content: status[LEFT] status_name*
        \param updated **timestamp with time zone** *更新时间*
    """

    cache = list() #cache content of table

    _table_name='table_crawler'
    _table_keys = ['id', 'name', 'domain', 'status', 'updated']
    _table_Struktur = {'id' : 'bigint', 'name' : 'text', 'domain' : 'text', 'status' : 'integer', 'updated' : 'timestamp with time zone'}
    _table_Kommentar = {"table_crawler" : "\n\naction button: 采集=1 set status\naction button: 停用=3 set status\n\n", "id" : "爬虫标示", "name" : "爬虫名", "domain" : "主域名", "status" : "状态\n\nlink-content: status[LEFT] status_name", "updated" : "更新时间", };
    _table_atributes = {};
    _table_default_values = {"id" : "nextval('table_crawler_id_seq'::regclass)", };
    

    _join_obj = None
    _sql_clauses = None


    def __init__(self, join_obj=None, sql_join="", table_name=None, DB_connection=DB, domain=""):

        self.DB_connection = DB_connection

        """
        通过设定domain可以更改区域
        """
        self._join_obj=join_obj
        

        if table_name:
            self._table_name=table_name


        if domain:
            self._table_name=domain+"."+self._table_name
        elif cookie("user_domain"):
            self._table_name=cookie("user_domain")+"."+self._table_name


    def add(self, name, domain=None, status=None, updated=None):
        """
        插入数据的方法
        """
    
        return self.DB_connection.insert(self._table_name, 'table_crawler_id_seq', _parent_self=self, name=name, domain=domain, status=status, updated=updated)


    def set(self, id=None, condition_name=None, operation="", name=None, domain=None, status=None, updated=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", condition_name, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, domain=domain, status=status, updated=updated, id=id, name=name, _condition=_condition, _parent_self=self)
        else:
            ret=None
        if not ret:
            if name==None:
                name=condition_name
            ret=self.add(name, domain, status, updated)
        return ret


    def update(self, id=None, condition_name=None, operation="", name=None, domain=None, status=None, updated=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", condition_name, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, domain=domain, status=status, updated=updated, id=id, name=name, _condition=_condition, _parent_self=self)
        else:
            ret=None
        return ret


    def get(self, name=None, id=None, domain=None, status=None, updated=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  what=None, join=None, _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        \param id **bigint** *爬虫标示*
        \param name **text** *爬虫名*
        \param domain **text** *主域名*
        \param status **integer** *状态  link-content: status[LEFT] status_name*
        \param updated **timestamp with time zone** *更新时间*
        """
        
        return self.DB_connection.select1([self._table_name], id=id, name=name, domain=domain, status=status, updated=updated, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, name=None, id=None, domain=None, status=None, updated=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        
        ret = self.DB_connection.select1_count([self._table_name], id=id, name=name, domain=domain, status=status, updated=updated, order=order, limit=limit,  join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1 and offset:
           ret=ret-offset

        return ret
    def get_first(self, name=None, id=None, domain=None, status=None, updated=None, order=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  what=None,  join=None, _condition=""):
        """
        获取第一个参数满足条件的情况下的数据列。
        \return -1 database error, 0 no data or util.Storages        """
        
        ret=self.DB_connection.select1([self._table_name], id=id, name=name, domain=domain, status=status, updated=updated, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def count(self, column="*", table_name=None):
        """
        获取本数据库表的信息数量
        """
        
        return self.DB_connection.count(column=column, table_name=table_name, _parent_self=self)

    def search(self, name=None, id=None, domain=None, status=None, updated=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        return self.DB_connection.select1([self._table_name], id=id, name=name, domain=domain, status=status, updated=updated, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def search_first(self, name=None, id=None, domain=None, status=None, updated=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        ret = self.DB_connection.select1([self._table_name], id=id, name=name, domain=domain, status=status, updated=updated, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def search_count(self, name=None, id=None, domain=None, status=None, updated=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def delete(self, id=None, name=None, domain=None, status=None, updated=None, where=""):
        
        
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", name, _parent_self=self)

        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=self._table_name, seqname="%s_id_seq" % self._table_name)
        
        return ret

    def clauses_set(self, name=None, id=None, domain=None, status=None, updated=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  join="", _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        """
        
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)

        return self._sql_clauses

    def _test(self):
        
        ret_del=self.delete(id=79860, name=7777, domain='超级欢迎你1', status=86782, updated="2016-03-07 13:25:32.954272")

        ret_id=self.add(name=7777, domain='超级欢迎你1', status=86782, updated="2016-03-07 13:25:32.954272")
        ret_get=self.get(name=7777, domain='超级欢迎你1', status=86782, updated="2016-03-07 13:25:32.954272")

        ret_set=self.set(ret_id, operation="",domain='超级欢迎你1', status=86782, updated="2016-03-07 13:25:32.954272")

        ret_del=self.delete(ret_id, domain='超级欢迎你1', status=86782, updated="2016-03-07 13:25:32.954272")

        if ret_set!=1:
            print ("insert-result: %s" % ret_id)
            print ("data: %s" % ret_get.first())

