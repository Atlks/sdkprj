# -*- coding: utf-8 -*-

from config import *

class tag(db_check):


    """标签表
        \param id **bigint** *标示*
        \param tag_name **text** *标签名*
        \param status **integer** *状态  link-content: status[LEFT] status_name*
    """

    cache = list() #cache content of table

    _table_name='table_tag'
    _table_keys = ['id', 'tag_name', 'status']
    _table_Struktur = {'id' : 'bigint', 'tag_name' : 'text', 'status' : 'integer'}
    _table_Kommentar = {"table_tag" : "标签表", "id" : "标示", "tag_name" : "标签名", "status" : "状态\n\nlink-content: status[LEFT] status_name", };
    _table_atributes = {};
    _table_default_values = {"id" : "nextval('table_tag_id_seq'::regclass)", };
    

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


    def add(self, tag_name, status=None):
        """
        插入数据的方法
        """
    
        return self.DB_connection.insert(self._table_name, 'table_tag_id_seq', _parent_self=self, tag_name=tag_name, status=status)


    def set(self, id=None, condition_tag_name=None, operation="", tag_name=None, status=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "tag_name", condition_tag_name, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, status=status, id=id, tag_name=tag_name, _condition=_condition, _parent_self=self)
        else:
            ret=None
        if not ret:
            if tag_name==None:
                tag_name=condition_tag_name
            ret=self.add(tag_name, status)
        return ret


    def update(self, id=None, condition_tag_name=None, operation="", tag_name=None, status=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "tag_name", condition_tag_name, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, status=status, id=id, tag_name=tag_name, _condition=_condition, _parent_self=self)
        else:
            ret=None
        return ret


    def get(self, tag_name=None, id=None, status=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None,  what=None, join=None, _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        \param id **bigint** *标示*
        \param tag_name **text** *标签名*
        \param status **integer** *状态  link-content: status[LEFT] status_name*
        """
        
        return self.DB_connection.select1([self._table_name], id=id, tag_name=tag_name, status=status, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, tag_name=None, id=None, status=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        
        ret = self.DB_connection.select1_count([self._table_name], id=id, tag_name=tag_name, status=status, order=order, limit=limit,  join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1 and offset:
           ret=ret-offset

        return ret
    def get_first(self, tag_name=None, id=None, status=None, order=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None,  what=None,  join=None, _condition=""):
        """
        获取第一个参数满足条件的情况下的数据列。
        \return -1 database error, 0 no data or util.Storages        """
        
        ret=self.DB_connection.select1([self._table_name], id=id, tag_name=tag_name, status=status, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

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

    def search(self, tag_name=None, id=None, status=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        return self.DB_connection.select1([self._table_name], id=id, tag_name=tag_name, status=status, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def search_first(self, tag_name=None, id=None, status=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        ret = self.DB_connection.select1([self._table_name], id=id, tag_name=tag_name, status=status, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def search_count(self, tag_name=None, id=None, status=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def delete(self, id=None, tag_name=None, status=None, where=""):
        
        
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "tag_name", tag_name, _parent_self=self)

        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=self._table_name, seqname="%s_id_seq" % self._table_name)
        
        return ret

    def clauses_set(self, tag_name=None, id=None, status=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None,  join="", _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        """
        
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)

        return self._sql_clauses

    def _test(self):
        
        ret_del=self.delete(id=79860, tag_name=7777, status=86782)

        ret_id=self.add(tag_name=7777, status=86782)
        ret_get=self.get(tag_name=7777, status=86782)

        ret_set=self.set(ret_id, operation="",status=86782)

        ret_del=self.delete(ret_id, status=86782)

        if ret_set!=1:
            print ("insert-result: %s" % ret_id)
            print ("data: %s" % ret_get.first())

