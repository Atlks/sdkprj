# -*- coding: utf-8 -*-

from config import *

class target_share(db_check):


    """发部目标
       
       action button: 同步=1 set status
       action button: 停止=3 set status
        \param id **bigint** *标示*
        \param name **text** *名称  name of the location*
        \param level **bigint** *define level or order  使用范围：后端*
        \param location_code **text** *internal usage only  使用范围：后端*
        \param link **text** *链接  use to define relation, like url or abbreviation*
        \param index_order **bigint** *to control the show order  使用范围：后端*
        \param status **smallint** *状态  link-content: status[RIGHT] status_name*
    """

    cache = list() #cache content of table

    _table_name='table_target_share'
    _table_keys = ['id', 'name', 'level', 'location_code', 'link', 'index_order', 'status']
    _table_Struktur = {'id' : 'bigint', 'name' : 'text', 'level' : 'bigint', 'location_code' : 'text', 'link' : 'text', 'index_order' : 'bigint', 'status' : 'smallint'}
    _table_Kommentar = {"table_target_share" : "发部目标\n\naction button: 同步=1 set status\naction button: 停止=3 set status", "id" : "标示\n", "name" : "名称\n\nname of the location", "level" : "define level or order\n\n使用范围：后端", "location_code" : "internal usage only\n\n使用范围：后端", "link" : "链接\n\nuse to define relation, like url or abbreviation", "index_order" : "to control the show order\n\n使用范围：后端", "status" : "状态\n\nlink-content: status[RIGHT] status_name", };
    _table_atributes = {};
    _table_default_values = {"id" : "nextval('table_target_share_id_seq'::regclass)", };
    

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


    def add(self, name, level=None, location_code=None, link=None, index_order=None, status=None):
        """
        插入数据的方法
        """
    
        return self.DB_connection.insert(self._table_name, 'table_target_share_id_seq', _parent_self=self, name=name, level=level, location_code=location_code, link=link, index_order=index_order, status=status)


    def set(self, id=None, condition_name=None, operation="", name=None, level=None, location_code=None, link=None, index_order=None, status=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", condition_name, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, level=level, location_code=location_code, link=link, index_order=index_order, status=status, id=id, name=name, _condition=_condition, _parent_self=self)
        else:
            ret=None
        if not ret:
            if name==None:
                name=condition_name
            ret=self.add(name, level, location_code, link, index_order, status)
        return ret


    def update(self, id=None, condition_name=None, operation="", name=None, level=None, location_code=None, link=None, index_order=None, status=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", condition_name, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, level=level, location_code=location_code, link=link, index_order=index_order, status=status, id=id, name=name, _condition=_condition, _parent_self=self)
        else:
            ret=None
        return ret


    def get(self, name=None, id=None, level=None, location_code=None, link=None, index_order=None, status=None, order=None, limit=None, offset=None, _min_level=None, _max_level=None, _lower_level=None, _greater_level=None, _min_location_code=None, _max_location_code=None, _lower_location_code=None, _greater_location_code=None, _min_link=None, _max_link=None, _lower_link=None, _greater_link=None, _min_index_order=None, _max_index_order=None, _lower_index_order=None, _greater_index_order=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None,  what=None, join=None, _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        \param id **bigint** *标示*
        \param name **text** *名称  name of the location*
        \param level **bigint** *define level or order  使用范围：后端*
        \param location_code **text** *internal usage only  使用范围：后端*
        \param link **text** *链接  use to define relation, like url or abbreviation*
        \param index_order **bigint** *to control the show order  使用范围：后端*
        \param status **smallint** *状态  link-content: status[RIGHT] status_name*
        """
        
        return self.DB_connection.select1([self._table_name], id=id, name=name, level=level, location_code=location_code, link=link, index_order=index_order, status=status, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, name=None, id=None, level=None, location_code=None, link=None, index_order=None, status=None, order=None, limit=None, offset=None, _min_level=None, _max_level=None, _lower_level=None, _greater_level=None, _min_location_code=None, _max_location_code=None, _lower_location_code=None, _greater_location_code=None, _min_link=None, _max_link=None, _lower_link=None, _greater_link=None, _min_index_order=None, _max_index_order=None, _lower_index_order=None, _greater_index_order=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        
        ret = self.DB_connection.select1_count([self._table_name], id=id, name=name, level=level, location_code=location_code, link=link, index_order=index_order, status=status, order=order, limit=limit,  join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1 and offset:
           ret=ret-offset

        return ret
    def get_first(self, name=None, id=None, level=None, location_code=None, link=None, index_order=None, status=None, order=None, offset=None, _min_level=None, _max_level=None, _lower_level=None, _greater_level=None, _min_location_code=None, _max_location_code=None, _lower_location_code=None, _greater_location_code=None, _min_link=None, _max_link=None, _lower_link=None, _greater_link=None, _min_index_order=None, _max_index_order=None, _lower_index_order=None, _greater_index_order=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None,  what=None,  join=None, _condition=""):
        """
        获取第一个参数满足条件的情况下的数据列。
        \return -1 database error, 0 no data or util.Storages        """
        
        ret=self.DB_connection.select1([self._table_name], id=id, name=name, level=level, location_code=location_code, link=link, index_order=index_order, status=status, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

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

    def search(self, name=None, id=None, level=None, location_code=None, link=None, index_order=None, status=None, order=None, limit=None, offset=None, _min_level=None, _max_level=None, _lower_level=None, _greater_level=None, _min_location_code=None, _max_location_code=None, _lower_location_code=None, _greater_location_code=None, _min_link=None, _max_link=None, _lower_link=None, _greater_link=None, _min_index_order=None, _max_index_order=None, _lower_index_order=None, _greater_index_order=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        return self.DB_connection.select1([self._table_name], id=id, name=name, level=level, location_code=location_code, link=link, index_order=index_order, status=status, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def search_first(self, name=None, id=None, level=None, location_code=None, link=None, index_order=None, status=None, order=None, limit=None, offset=None, _min_level=None, _max_level=None, _lower_level=None, _greater_level=None, _min_location_code=None, _max_location_code=None, _lower_location_code=None, _greater_location_code=None, _min_link=None, _max_link=None, _lower_link=None, _greater_link=None, _min_index_order=None, _max_index_order=None, _lower_index_order=None, _greater_index_order=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        ret = self.DB_connection.select1([self._table_name], id=id, name=name, level=level, location_code=location_code, link=link, index_order=index_order, status=status, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def search_count(self, name=None, id=None, level=None, location_code=None, link=None, index_order=None, status=None, order=None, limit=None, offset=None, _min_level=None, _max_level=None, _lower_level=None, _greater_level=None, _min_location_code=None, _max_location_code=None, _lower_location_code=None, _greater_location_code=None, _min_link=None, _max_link=None, _lower_link=None, _greater_link=None, _min_index_order=None, _max_index_order=None, _lower_index_order=None, _greater_index_order=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def delete(self, id=None, name=None, level=None, location_code=None, link=None, index_order=None, status=None, where=""):
        
        
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", name, _parent_self=self)

        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=self._table_name, seqname="%s_id_seq" % self._table_name)
        
        return ret

    def clauses_set(self, name=None, id=None, level=None, location_code=None, link=None, index_order=None, status=None, order=None, limit=None, offset=None, _min_level=None, _max_level=None, _lower_level=None, _greater_level=None, _min_location_code=None, _max_location_code=None, _lower_location_code=None, _greater_location_code=None, _min_link=None, _max_link=None, _lower_link=None, _greater_link=None, _min_index_order=None, _max_index_order=None, _lower_index_order=None, _greater_index_order=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None,  join="", _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        """
        
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)

        return self._sql_clauses

    def _test(self):
        
        ret_del=self.delete(id=79860, name=7777, level=86782, location_code='超级欢迎你2', link='超级欢迎你3', index_order=86782, status=86782)

        ret_id=self.add(name=7777, level=86782, location_code='超级欢迎你2', link='超级欢迎你3', index_order=86782, status=86782)
        ret_get=self.get(name=7777, level=86782, location_code='超级欢迎你2', link='超级欢迎你3', index_order=86782, status=86782)

        ret_set=self.set(ret_id, operation="",level=86782, location_code='超级欢迎你2', link='超级欢迎你3', index_order=86782, status=86782)

        ret_del=self.delete(ret_id, level=86782, location_code='超级欢迎你2', link='超级欢迎你3', index_order=86782, status=86782)

        if ret_set!=1:
            print ("insert-result: %s" % ret_id)
            print ("data: %s" % ret_get.first())

