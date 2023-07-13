# -*- coding: utf-8 -*-

from config import *

class category_to_sub_category_relation(db_check):


    """把分类和
       
       
        \param id **bigint** *标示*
        \param category_id **bigint** *分类标示*
        \param sub_category_id **bigint** *扩展分类  扩展分类的标示*
    """

    cache = list() #cache content of table

    _table_name='table_category_to_sub_category_relation'
    _table_keys = ['id', 'category_id', 'sub_category_id']
    _table_Struktur = {'id' : 'bigint', 'category_id' : 'bigint', 'sub_category_id' : 'bigint'}
    _table_Kommentar = {"table_category_to_sub_category_relation" : "把分类和\n\n", "id" : "标示", "category_id" : "分类标示", "sub_category_id" : "扩展分类\n\n扩展分类的标示", };
    _table_atributes = {};
    _table_default_values = {"id" : "nextval('table_category_to_sub_category_relation_id_seq'::regclass)", };
    

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


    def add(self, category_id, sub_category_id):
        """
        插入数据的方法
        """
    
        return self.DB_connection.insert(self._table_name, 'table_category_to_sub_category_relation_id_seq', _parent_self=self, category_id=category_id, sub_category_id=sub_category_id)


    def set(self, id=None, condition_category_id=None, condition_sub_category_id=None, operation="", category_id=None, sub_category_id=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "category_id", condition_category_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "sub_category_id", condition_sub_category_id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, id=id, category_id=category_id, sub_category_id=sub_category_id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        if not ret:
            if category_id==None:
                category_id=condition_category_id
            if sub_category_id==None:
                sub_category_id=condition_sub_category_id
            ret=self.add(category_id, sub_category_id)
        return ret


    def update(self, id=None, condition_category_id=None, condition_sub_category_id=None, operation="", category_id=None, sub_category_id=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "category_id", condition_category_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "sub_category_id", condition_sub_category_id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, id=id, category_id=category_id, sub_category_id=sub_category_id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        return ret


    def get(self, category_id=None, sub_category_id=None, id=None, order=None, limit=None, offset=None,  what=None, join=None, _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        \param id **bigint** *标示*
        \param category_id **bigint** *分类标示*
        \param sub_category_id **bigint** *扩展分类  扩展分类的标示*
        """
        
        return self.DB_connection.select1([self._table_name], id=id, category_id=category_id, sub_category_id=sub_category_id, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, category_id=None, sub_category_id=None, id=None, order=None, limit=None, offset=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        
        ret = self.DB_connection.select1_count([self._table_name], id=id, category_id=category_id, sub_category_id=sub_category_id, order=order, limit=limit,  join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1 and offset:
           ret=ret-offset

        return ret
    def get_first(self, category_id=None, sub_category_id=None, id=None, order=None, offset=None,  what=None,  join=None, _condition=""):
        """
        获取第一个参数满足条件的情况下的数据列。
        \return -1 database error, 0 no data or util.Storages        """
        
        ret=self.DB_connection.select1([self._table_name], id=id, category_id=category_id, sub_category_id=sub_category_id, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

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

    def search(self, category_id=None, sub_category_id=None, id=None, order=None, limit=None, offset=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        return self.DB_connection.select1([self._table_name], id=id, category_id=category_id, sub_category_id=sub_category_id, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def search_first(self, category_id=None, sub_category_id=None, id=None, order=None, limit=None, offset=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        ret = self.DB_connection.select1([self._table_name], id=id, category_id=category_id, sub_category_id=sub_category_id, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def search_count(self, category_id=None, sub_category_id=None, id=None, order=None, limit=None, offset=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def delete(self, id=None, category_id=None, sub_category_id=None, where=""):
        
        
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "category_id", category_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "sub_category_id", sub_category_id, _parent_self=self)

        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=self._table_name, seqname="%s_id_seq" % self._table_name)
        
        return ret

    def clauses_set(self, category_id=None, sub_category_id=None, id=None, order=None, limit=None, offset=None,  join="", _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        """
        
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)

        return self._sql_clauses

    def _test(self):
        
        ret_del=self.delete(id=79860, category_id=7777, sub_category_id=7777)

        ret_id=self.add(category_id=7777, sub_category_id=7777)
        ret_get=self.get(category_id=7777, sub_category_id=7777)

        ret_set=self.set(ret_id, sub_category_id=7777, operation="",)

        ret_del=self.delete(ret_id, sub_category_id=7777)

        if ret_set!=1:
            print ("insert-result: %s" % ret_id)
            print ("data: %s" % ret_get.first())

