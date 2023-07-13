# -*- coding: utf-8 -*-

from config import *

class type_content_replace(db_check):


    """更换内容的类型
        \param id **bigint** *标示  使用范围：后端*
        \param name **text** *名称*
        \param is_active **boolean** *激活*
    """

    cache = list() #cache content of table

    _table_name='table_type_content_replace'
    _table_keys = ['id', 'name', 'is_active']
    _table_Struktur = {'id' : 'bigint', 'name' : 'text', 'is_active' : 'boolean'}
    _table_Kommentar = {"table_type_content_replace" : "更换内容的类型", "id" : "标示\n\n使用范围：后端", "name" : "名称", "is_active" : "激活", };
    _table_atributes = {};
    _table_default_values = {"id" : "nextval('table_type_content_replace_id_seq'::regclass)", };
    

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


    def add(self, name, is_active=None):
        """
        插入数据的方法
        """
    
        return self.DB_connection.insert(self._table_name, 'table_type_content_replace_id_seq', _parent_self=self, name=name, is_active=is_active)


    def set(self, id=None, condition_name=None, operation="", name=None, is_active=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", condition_name, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, is_active=is_active, id=id, name=name, _condition=_condition, _parent_self=self)
        else:
            ret=None
        if not ret:
            if name==None:
                name=condition_name
            ret=self.add(name, is_active)
        return ret


    def update(self, id=None, condition_name=None, operation="", name=None, is_active=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", condition_name, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, is_active=is_active, id=id, name=name, _condition=_condition, _parent_self=self)
        else:
            ret=None
        return ret


    def get(self, name=None, id=None, is_active=None, order=None, limit=None, offset=None, _min_is_active=None, _max_is_active=None, _lower_is_active=None, _greater_is_active=None,  what=None, join=None, _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        \param id **bigint** *标示  使用范围：后端*
        \param name **text** *名称*
        \param is_active **boolean** *激活*
        """
        
        return self.DB_connection.select1([self._table_name], id=id, name=name, is_active=is_active, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, name=None, id=None, is_active=None, order=None, limit=None, offset=None, _min_is_active=None, _max_is_active=None, _lower_is_active=None, _greater_is_active=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        
        ret = self.DB_connection.select1_count([self._table_name], id=id, name=name, is_active=is_active, order=order, limit=limit,  join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1 and offset:
           ret=ret-offset

        return ret
    def get_first(self, name=None, id=None, is_active=None, order=None, offset=None, _min_is_active=None, _max_is_active=None, _lower_is_active=None, _greater_is_active=None,  what=None,  join=None, _condition=""):
        """
        获取第一个参数满足条件的情况下的数据列。
        \return -1 database error, 0 no data or util.Storages        """
        
        ret=self.DB_connection.select1([self._table_name], id=id, name=name, is_active=is_active, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

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

    def search(self, name=None, id=None, is_active=None, order=None, limit=None, offset=None, _min_is_active=None, _max_is_active=None, _lower_is_active=None, _greater_is_active=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        return self.DB_connection.select1([self._table_name], id=id, name=name, is_active=is_active, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def search_first(self, name=None, id=None, is_active=None, order=None, limit=None, offset=None, _min_is_active=None, _max_is_active=None, _lower_is_active=None, _greater_is_active=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        ret = self.DB_connection.select1([self._table_name], id=id, name=name, is_active=is_active, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def search_count(self, name=None, id=None, is_active=None, order=None, limit=None, offset=None, _min_is_active=None, _max_is_active=None, _lower_is_active=None, _greater_is_active=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def delete(self, id=None, name=None, is_active=None, where=""):
        
        
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", name, _parent_self=self)

        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=self._table_name, seqname="%s_id_seq" % self._table_name)
        
        return ret

    def clauses_set(self, name=None, id=None, is_active=None, order=None, limit=None, offset=None, _min_is_active=None, _max_is_active=None, _lower_is_active=None, _greater_is_active=None,  join="", _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        """
        
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)

        return self._sql_clauses

    def _test(self):
        
        ret_del=self.delete(id=79860, name=7777, is_active=True)

        ret_id=self.add(name=7777, is_active=True)
        ret_get=self.get(name=7777, is_active=True)

        ret_set=self.set(ret_id, operation="",is_active=True)

        ret_del=self.delete(ret_id, is_active=True)

        if ret_set!=1:
            print ("insert-result: %s" % ret_id)
            print ("data: %s" % ret_get.first())

