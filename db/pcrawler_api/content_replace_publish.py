# -*- coding: utf-8 -*-

from config import *

class content_replace_publish(db_check):


    """发部时的内容替换
        \param id **bigint** *自增标示  使用范围：后端*
        \param source_id **bigint** *数据来源 爬虫ID）  link-content: crawler name*
        \param type_id **integer** *更换类型 0=全部  link-content: type_content_replace name*
        \param original_text **text** *匹配词*
        \param target_text **text** *替换为*
        \param updated **timestamp with time zone** *更新时间*
    """

    cache = list() #cache content of table

    _table_name='table_content_replace_publish'
    _table_keys = ['id', 'source_id', 'type_id', 'original_text', 'target_text', 'updated']
    _table_Struktur = {'id' : 'bigint', 'source_id' : 'bigint', 'type_id' : 'integer', 'original_text' : 'text', 'target_text' : 'text', 'updated' : 'timestamp with time zone'}
    _table_Kommentar = {"table_content_replace_publish" : "发部时的内容替换", "id" : "自增标示\n\n使用范围：后端", "source_id" : "数据来源\n爬虫ID）\n\nlink-content: crawler name", "type_id" : " 更换类型\n0=全部\n\nlink-content: type_content_replace name", "original_text" : "匹配词", "target_text" : "替换为", "updated" : "更新时间", };
    _table_atributes = {};
    _table_default_values = {"id" : "nextval('table_content_replace_publish_id_seq'::regclass)", "updated" : "now()", };
    

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


    def add(self, source_id, type_id, original_text=None, target_text=None, updated=None):
        """
        插入数据的方法
        """
    
        return self.DB_connection.insert(self._table_name, 'table_content_replace_publish_id_seq', _parent_self=self, source_id=source_id, type_id=type_id, original_text=original_text, target_text=target_text, updated=updated)


    def set(self, id=None, condition_source_id=None, condition_type_id=None, operation="", source_id=None, type_id=None, original_text=None, target_text=None, updated=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "source_id", condition_source_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "type_id", condition_type_id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, original_text=original_text, target_text=target_text, updated=updated, id=id, source_id=source_id, type_id=type_id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        if not ret:
            if source_id==None:
                source_id=condition_source_id
            if type_id==None:
                type_id=condition_type_id
            ret=self.add(source_id, type_id, original_text, target_text, updated)
        return ret


    def update(self, id=None, condition_source_id=None, condition_type_id=None, operation="", source_id=None, type_id=None, original_text=None, target_text=None, updated=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "source_id", condition_source_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "type_id", condition_type_id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, original_text=original_text, target_text=target_text, updated=updated, id=id, source_id=source_id, type_id=type_id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        return ret


    def get(self, source_id=None, type_id=None, id=None, original_text=None, target_text=None, updated=None, order=None, limit=None, offset=None, _min_original_text=None, _max_original_text=None, _lower_original_text=None, _greater_original_text=None, _min_target_text=None, _max_target_text=None, _lower_target_text=None, _greater_target_text=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  what=None, join=None, _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        \param id **bigint** *自增标示  使用范围：后端*
        \param source_id **bigint** *数据来源 爬虫ID）  link-content: crawler name*
        \param type_id **integer** *更换类型 0=全部  link-content: type_content_replace name*
        \param original_text **text** *匹配词*
        \param target_text **text** *替换为*
        \param updated **timestamp with time zone** *更新时间*
        """
        
        return self.DB_connection.select1([self._table_name], id=id, source_id=source_id, type_id=type_id, original_text=original_text, target_text=target_text, updated=updated, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, source_id=None, type_id=None, id=None, original_text=None, target_text=None, updated=None, order=None, limit=None, offset=None, _min_original_text=None, _max_original_text=None, _lower_original_text=None, _greater_original_text=None, _min_target_text=None, _max_target_text=None, _lower_target_text=None, _greater_target_text=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        
        ret = self.DB_connection.select1_count([self._table_name], id=id, source_id=source_id, type_id=type_id, original_text=original_text, target_text=target_text, updated=updated, order=order, limit=limit,  join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1 and offset:
           ret=ret-offset

        return ret
    def get_first(self, source_id=None, type_id=None, id=None, original_text=None, target_text=None, updated=None, order=None, offset=None, _min_original_text=None, _max_original_text=None, _lower_original_text=None, _greater_original_text=None, _min_target_text=None, _max_target_text=None, _lower_target_text=None, _greater_target_text=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  what=None,  join=None, _condition=""):
        """
        获取第一个参数满足条件的情况下的数据列。
        \return -1 database error, 0 no data or util.Storages        """
        
        ret=self.DB_connection.select1([self._table_name], id=id, source_id=source_id, type_id=type_id, original_text=original_text, target_text=target_text, updated=updated, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

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

    def search(self, source_id=None, type_id=None, id=None, original_text=None, target_text=None, updated=None, order=None, limit=None, offset=None, _min_original_text=None, _max_original_text=None, _lower_original_text=None, _greater_original_text=None, _min_target_text=None, _max_target_text=None, _lower_target_text=None, _greater_target_text=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        return self.DB_connection.select1([self._table_name], id=id, source_id=source_id, type_id=type_id, original_text=original_text, target_text=target_text, updated=updated, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def search_first(self, source_id=None, type_id=None, id=None, original_text=None, target_text=None, updated=None, order=None, limit=None, offset=None, _min_original_text=None, _max_original_text=None, _lower_original_text=None, _greater_original_text=None, _min_target_text=None, _max_target_text=None, _lower_target_text=None, _greater_target_text=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        ret = self.DB_connection.select1([self._table_name], id=id, source_id=source_id, type_id=type_id, original_text=original_text, target_text=target_text, updated=updated, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def search_count(self, source_id=None, type_id=None, id=None, original_text=None, target_text=None, updated=None, order=None, limit=None, offset=None, _min_original_text=None, _max_original_text=None, _lower_original_text=None, _greater_original_text=None, _min_target_text=None, _max_target_text=None, _lower_target_text=None, _greater_target_text=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def delete(self, id=None, source_id=None, type_id=None, original_text=None, target_text=None, updated=None, where=""):
        
        
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "source_id", source_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "type_id", type_id, _parent_self=self)

        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=self._table_name, seqname="%s_id_seq" % self._table_name)
        
        return ret

    def clauses_set(self, source_id=None, type_id=None, id=None, original_text=None, target_text=None, updated=None, order=None, limit=None, offset=None, _min_original_text=None, _max_original_text=None, _lower_original_text=None, _greater_original_text=None, _min_target_text=None, _max_target_text=None, _lower_target_text=None, _greater_target_text=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  join="", _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        """
        
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)

        return self._sql_clauses

    def _test(self):
        
        ret_del=self.delete(id=79860, source_id=7777, type_id=7777, original_text='超级欢迎你1', target_text='超级欢迎你2', updated="2016-03-07 13:25:32.954272")

        ret_id=self.add(source_id=7777, type_id=7777, original_text='超级欢迎你1', target_text='超级欢迎你2', updated="2016-03-07 13:25:32.954272")
        ret_get=self.get(source_id=7777, type_id=7777, original_text='超级欢迎你1', target_text='超级欢迎你2', updated="2016-03-07 13:25:32.954272")

        ret_set=self.set(ret_id, type_id=7777, operation="",original_text='超级欢迎你1', target_text='超级欢迎你2', updated="2016-03-07 13:25:32.954272")

        ret_del=self.delete(ret_id, type_id=7777, original_text='超级欢迎你1', target_text='超级欢迎你2', updated="2016-03-07 13:25:32.954272")

        if ret_set!=1:
            print ("insert-result: %s" % ret_id)
            print ("data: %s" % ret_get.first())

