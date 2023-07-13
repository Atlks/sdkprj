# -*- coding: utf-8 -*-

from config import *

class video_censored(db_check):


    """
        \param row **bigint**
        \param id **bigint**
        \param url **text**
        \param created **timestamp with time zone**
    """

    cache = list() #cache content of table

    _table_name='table_video_censored'
    _table_keys = ['row', 'id', 'url', 'created']
    _table_Struktur = {'row' : 'bigint', 'id' : 'bigint', 'url' : 'text', 'created' : 'timestamp with time zone'}
    _table_Kommentar = {"table_video_censored" : "", "row" : "", "id" : "", "url" : "", "created" : "", };
    _table_atributes = {};
    _table_default_values = {"row" : "nextval('table_video_censored_row_seq'::regclass)", "created" : "now()", };
    

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


    def add(self, id=None, url=None, created=None):
        """
        插入数据的方法
        """
    
        return self.DB_connection.insert(self._table_name, 'table_video_censored_row_seq', _parent_self=self, id=id, url=url, created=created)


    def set(self, row=None, condition_id=None, operation="", id=None, url=None, created=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "row", row, _parent_self=self)
        where=self.DB_connection.condition_and(where, "id", condition_id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, url=url, created=created, row=row, id=id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        if not ret:
            if id==None:
                id=condition_id
            ret=self.add(id, url, created)
        return ret


    def update(self, row=None, condition_id=None, operation="", id=None, url=None, created=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "row", row, _parent_self=self)
        where=self.DB_connection.condition_and(where, "id", condition_id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, url=url, created=created, row=row, id=id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        return ret


    def get(self, id=None, row=None, url=None, created=None, order=None, limit=None, offset=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None,  what=None, join=None, _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        \param row **bigint**
        \param id **bigint**
        \param url **text**
        \param created **timestamp with time zone**
        """
        
        return self.DB_connection.select1([self._table_name], row=row, id=id, url=url, created=created, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, id=None, row=None, url=None, created=None, order=None, limit=None, offset=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        
        ret = self.DB_connection.select1_count([self._table_name], row=row, id=id, url=url, created=created, order=order, limit=limit,  join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1 and offset:
           ret=ret-offset

        return ret
    def get_first(self, id=None, row=None, url=None, created=None, order=None, offset=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None,  what=None,  join=None, _condition=""):
        """
        获取第一个参数满足条件的情况下的数据列。
        \return -1 database error, 0 no data or util.Storages        """
        
        ret=self.DB_connection.select1([self._table_name], row=row, id=id, url=url, created=created, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

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

    def search(self, id=None, row=None, url=None, created=None, order=None, limit=None, offset=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        return self.DB_connection.select1([self._table_name], row=row, id=id, url=url, created=created, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def search_first(self, id=None, row=None, url=None, created=None, order=None, limit=None, offset=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        ret = self.DB_connection.select1([self._table_name], row=row, id=id, url=url, created=created, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def search_count(self, id=None, row=None, url=None, created=None, order=None, limit=None, offset=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def delete(self, row=None, id=None, url=None, created=None, where=""):
        
        
        where=self.DB_connection.condition_and(where, "row", row, _parent_self=self)
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)

        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=self._table_name, seqname="%s_id_seq" % self._table_name)
        
        return ret

    def clauses_set(self, id=None, row=None, url=None, created=None, order=None, limit=None, offset=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None,  join="", _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        """
        
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)

        return self._sql_clauses

    def _test(self):
        
        ret_del=self.delete(row=79860, id=7777, url='超级欢迎你1', created="2016-03-07 13:25:32.954272")

        ret_id=self.add(id=7777, url='超级欢迎你1', created="2016-03-07 13:25:32.954272")
        ret_get=self.get(id=7777, url='超级欢迎你1', created="2016-03-07 13:25:32.954272")

        ret_set=self.set(ret_id, operation="",url='超级欢迎你1', created="2016-03-07 13:25:32.954272")

        ret_del=self.delete(ret_id, url='超级欢迎你1', created="2016-03-07 13:25:32.954272")

        if ret_set!=1:
            print ("insert-result: %s" % ret_id)
            print ("data: %s" % ret_get.first())

