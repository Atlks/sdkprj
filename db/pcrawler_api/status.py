# -*- coding: utf-8 -*-

from config import *

class status(db_check):


    """状态表
        \param id **integer** *标示*
        \param status_name **text** *名称*
        \param status_link **text** *链接  使用范围：后端*
        \param is_active **boolean** *激活*
    """

    cache = list() #cache content of table

    _table_name='table_status'
    _table_keys = ['id', 'status_name', 'status_link', 'is_active']
    _table_Struktur = {'id' : 'integer', 'status_name' : 'text', 'status_link' : 'text', 'is_active' : 'boolean'}
    _table_Kommentar = {"table_status" : "状态表", "id" : "标示\n", "status_name" : "名称", "status_link" : "链接\n\n使用范围：后端", "is_active" : "激活", };
    _table_atributes = {};
    _table_default_values = {"id" : "nextval('table_status_id_seq'::regclass)", };
    

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


    def add(self, status_name, status_link=None, is_active=None):
        """
        插入数据的方法
        """
    
        return self.DB_connection.insert(self._table_name, 'table_status_id_seq', _parent_self=self, status_name=status_name, status_link=status_link, is_active=is_active)


    def set(self, id=None, condition_status_name=None, operation="", status_name=None, status_link=None, is_active=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "status_name", condition_status_name, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, status_link=status_link, is_active=is_active, id=id, status_name=status_name, _condition=_condition, _parent_self=self)
        else:
            ret=None
        if not ret:
            if status_name==None:
                status_name=condition_status_name
            ret=self.add(status_name, status_link, is_active)
        return ret


    def update(self, id=None, condition_status_name=None, operation="", status_name=None, status_link=None, is_active=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "status_name", condition_status_name, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, status_link=status_link, is_active=is_active, id=id, status_name=status_name, _condition=_condition, _parent_self=self)
        else:
            ret=None
        return ret


    def get(self, status_name=None, id=None, status_link=None, is_active=None, order=None, limit=None, offset=None, _min_status_link=None, _max_status_link=None, _lower_status_link=None, _greater_status_link=None, _min_is_active=None, _max_is_active=None, _lower_is_active=None, _greater_is_active=None,  what=None, join=None, _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        \param id **integer** *标示*
        \param status_name **text** *名称*
        \param status_link **text** *链接  使用范围：后端*
        \param is_active **boolean** *激活*
        """
        
        return self.DB_connection.select1([self._table_name], id=id, status_name=status_name, status_link=status_link, is_active=is_active, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, status_name=None, id=None, status_link=None, is_active=None, order=None, limit=None, offset=None, _min_status_link=None, _max_status_link=None, _lower_status_link=None, _greater_status_link=None, _min_is_active=None, _max_is_active=None, _lower_is_active=None, _greater_is_active=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        
        ret = self.DB_connection.select1_count([self._table_name], id=id, status_name=status_name, status_link=status_link, is_active=is_active, order=order, limit=limit,  join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1 and offset:
           ret=ret-offset

        return ret
    def get_first(self, status_name=None, id=None, status_link=None, is_active=None, order=None, offset=None, _min_status_link=None, _max_status_link=None, _lower_status_link=None, _greater_status_link=None, _min_is_active=None, _max_is_active=None, _lower_is_active=None, _greater_is_active=None,  what=None,  join=None, _condition=""):
        """
        获取第一个参数满足条件的情况下的数据列。
        \return -1 database error, 0 no data or util.Storages        """
        
        ret=self.DB_connection.select1([self._table_name], id=id, status_name=status_name, status_link=status_link, is_active=is_active, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

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

    def search(self, status_name=None, id=None, status_link=None, is_active=None, order=None, limit=None, offset=None, _min_status_link=None, _max_status_link=None, _lower_status_link=None, _greater_status_link=None, _min_is_active=None, _max_is_active=None, _lower_is_active=None, _greater_is_active=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        return self.DB_connection.select1([self._table_name], id=id, status_name=status_name, status_link=status_link, is_active=is_active, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def search_first(self, status_name=None, id=None, status_link=None, is_active=None, order=None, limit=None, offset=None, _min_status_link=None, _max_status_link=None, _lower_status_link=None, _greater_status_link=None, _min_is_active=None, _max_is_active=None, _lower_is_active=None, _greater_is_active=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        ret = self.DB_connection.select1([self._table_name], id=id, status_name=status_name, status_link=status_link, is_active=is_active, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def search_count(self, status_name=None, id=None, status_link=None, is_active=None, order=None, limit=None, offset=None, _min_status_link=None, _max_status_link=None, _lower_status_link=None, _greater_status_link=None, _min_is_active=None, _max_is_active=None, _lower_is_active=None, _greater_is_active=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def delete(self, id=None, status_name=None, status_link=None, is_active=None, where=""):
        
        
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "status_name", status_name, _parent_self=self)

        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=self._table_name, seqname="%s_id_seq" % self._table_name)
        
        return ret

    def clauses_set(self, status_name=None, id=None, status_link=None, is_active=None, order=None, limit=None, offset=None, _min_status_link=None, _max_status_link=None, _lower_status_link=None, _greater_status_link=None, _min_is_active=None, _max_is_active=None, _lower_is_active=None, _greater_is_active=None,  join="", _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        """
        
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)

        return self._sql_clauses

    def _test(self):
        
        ret_del=self.delete(id=79860, status_name=7777, status_link='超级欢迎你1', is_active=True)

        ret_id=self.add(status_name=7777, status_link='超级欢迎你1', is_active=True)
        ret_get=self.get(status_name=7777, status_link='超级欢迎你1', is_active=True)

        ret_set=self.set(ret_id, operation="",status_link='超级欢迎你1', is_active=True)

        ret_del=self.delete(ret_id, status_link='超级欢迎你1', is_active=True)

        if ret_set!=1:
            print ("insert-result: %s" % ret_id)
            print ("data: %s" % ret_get.first())

