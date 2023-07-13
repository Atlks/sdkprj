# -*- coding: utf-8 -*-

from config import *

class crawler_publish_task(db_check):


    """发部计划
       
       
       action button: 同步=1 status
       action button: 停止=3 status
        \param id **bigint** *标示  使用范围：后端*
        \param name **text** *名称  content append: <font size=-1><i> content append attribute: name2*
        \param target_id **bigint** *目标  link-content: target[RIGHT] link*
        \param status **integer** *状态  使用范围：前端  link-content: status[LEFT] status_name*
        \param last_operation **timestamp with time zone** *最后同步时间*
    """

    cache = list() #cache content of table

    _table_name='table_crawler_publish_task'
    _table_keys = ['id', 'name', 'target_id', 'status', 'last_operation']
    _table_Struktur = {'id' : 'bigint', 'name' : 'text', 'target_id' : 'bigint', 'status' : 'integer', 'last_operation' : 'timestamp with time zone'}
    _table_Kommentar = {"table_crawler_publish_task" : "发部计划\n\n\naction button: 同步=1 status\naction button: 停止=3 status", "id" : "标示\n\n使用范围：后端\n\n\n\n\n", "name" : "名称\n\ncontent append: <font size=-1><i>\ncontent append attribute: name2", "target_id" : "目标\n\nlink-content: target[RIGHT] link", "status" : "状态\n\n使用范围：前端\n\nlink-content: status[LEFT] status_name\n\n", "last_operation" : "最后同步时间", };
    _table_atributes = {};
    _table_default_values = {"id" : "nextval('table_crawler_publish_task_id_seq'::regclass)", };
    

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


    def add(self, name, target_id, status=None, last_operation=None):
        """
        插入数据的方法
        """
    
        return self.DB_connection.insert(self._table_name, 'table_crawler_publish_task_id_seq', _parent_self=self, name=name, target_id=target_id, status=status, last_operation=last_operation)


    def set(self, id=None, condition_name=None, condition_target_id=None, operation="", name=None, target_id=None, status=None, last_operation=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", condition_name, _parent_self=self)
        where=self.DB_connection.condition_and(where, "target_id", condition_target_id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, status=status, last_operation=last_operation, id=id, name=name, target_id=target_id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        if not ret:
            if name==None:
                name=condition_name
            if target_id==None:
                target_id=condition_target_id
            ret=self.add(name, target_id, status, last_operation)
        return ret


    def update(self, id=None, condition_name=None, condition_target_id=None, operation="", name=None, target_id=None, status=None, last_operation=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", condition_name, _parent_self=self)
        where=self.DB_connection.condition_and(where, "target_id", condition_target_id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, status=status, last_operation=last_operation, id=id, name=name, target_id=target_id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        return ret


    def get(self, name=None, target_id=None, id=None, status=None, last_operation=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_last_operation=None, _max_last_operation=None, _lower_last_operation=None, _greater_last_operation=None,  what=None, join=None, _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        \param id **bigint** *标示  使用范围：后端*
        \param name **text** *名称  content append: <font size=-1><i> content append attribute: name2*
        \param target_id **bigint** *目标  link-content: target[RIGHT] link*
        \param status **integer** *状态  使用范围：前端  link-content: status[LEFT] status_name*
        \param last_operation **timestamp with time zone** *最后同步时间*
        """
        
        return self.DB_connection.select1([self._table_name], id=id, name=name, target_id=target_id, status=status, last_operation=last_operation, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, name=None, target_id=None, id=None, status=None, last_operation=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_last_operation=None, _max_last_operation=None, _lower_last_operation=None, _greater_last_operation=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        
        ret = self.DB_connection.select1_count([self._table_name], id=id, name=name, target_id=target_id, status=status, last_operation=last_operation, order=order, limit=limit,  join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1 and offset:
           ret=ret-offset

        return ret
    def get_first(self, name=None, target_id=None, id=None, status=None, last_operation=None, order=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_last_operation=None, _max_last_operation=None, _lower_last_operation=None, _greater_last_operation=None,  what=None,  join=None, _condition=""):
        """
        获取第一个参数满足条件的情况下的数据列。
        \return -1 database error, 0 no data or util.Storages        """
        
        ret=self.DB_connection.select1([self._table_name], id=id, name=name, target_id=target_id, status=status, last_operation=last_operation, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

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

    def search(self, name=None, target_id=None, id=None, status=None, last_operation=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_last_operation=None, _max_last_operation=None, _lower_last_operation=None, _greater_last_operation=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        return self.DB_connection.select1([self._table_name], id=id, name=name, target_id=target_id, status=status, last_operation=last_operation, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def search_first(self, name=None, target_id=None, id=None, status=None, last_operation=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_last_operation=None, _max_last_operation=None, _lower_last_operation=None, _greater_last_operation=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        ret = self.DB_connection.select1([self._table_name], id=id, name=name, target_id=target_id, status=status, last_operation=last_operation, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def search_count(self, name=None, target_id=None, id=None, status=None, last_operation=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_last_operation=None, _max_last_operation=None, _lower_last_operation=None, _greater_last_operation=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def delete(self, id=None, name=None, target_id=None, status=None, last_operation=None, where=""):
        
        
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", name, _parent_self=self)
        where=self.DB_connection.condition_and(where, "target_id", target_id, _parent_self=self)

        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=self._table_name, seqname="%s_id_seq" % self._table_name)
        
        return ret

    def clauses_set(self, name=None, target_id=None, id=None, status=None, last_operation=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_last_operation=None, _max_last_operation=None, _lower_last_operation=None, _greater_last_operation=None,  join="", _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        """
        
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)

        return self._sql_clauses

    def _test(self):
        
        ret_del=self.delete(id=79860, name=7777, target_id=7777, status=86782, last_operation="2016-03-07 13:25:32.954272")

        ret_id=self.add(name=7777, target_id=7777, status=86782, last_operation="2016-03-07 13:25:32.954272")
        ret_get=self.get(name=7777, target_id=7777, status=86782, last_operation="2016-03-07 13:25:32.954272")

        ret_set=self.set(ret_id, target_id=7777, operation="",status=86782, last_operation="2016-03-07 13:25:32.954272")

        ret_del=self.delete(ret_id, target_id=7777, status=86782, last_operation="2016-03-07 13:25:32.954272")

        if ret_set!=1:
            print ("insert-result: %s" % ret_id)
            print ("data: %s" % ret_get.first())

