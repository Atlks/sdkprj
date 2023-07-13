# -*- coding: utf-8 -*-

from config import *

class target_share_synced(db_check):


    """记录已经同步的数据了
       
       action button: 撤回=code sync.delete
       action button: 删除=delete delete
        \param id **bigint** *标示*
        \param source_id **bigint** *来源  link-content: crawler[LEFT] name*
        \param target_id **bigint** *目标  link-content: target[LEFT] name*
        \param item_id **bigint** *对象   link-content: article[LEFT] name*
        \param status **integer** *状态  link-content: status[LEFT] status_name*
        \param created **timestamp with time zone** *同步时间*
        \param result_id **bigint** *结果标示*
        \param result_link **text** *外联结果*
    """

    cache = list() #cache content of table

    _table_name='table_target_share_synced'
    _table_keys = ['id', 'source_id', 'target_id', 'item_id', 'status', 'created', 'result_id', 'result_link']
    _table_Struktur = {'id' : 'bigint', 'source_id' : 'bigint', 'target_id' : 'bigint', 'item_id' : 'bigint', 'status' : 'integer', 'created' : 'timestamp with time zone', 'result_id' : 'bigint', 'result_link' : 'text'}
    _table_Kommentar = {"table_target_share_synced" : "记录已经同步的数据了\n\naction button: 撤回=code sync.delete\naction button: 删除=delete delete", "id" : "标示", "source_id" : "来源\n\nlink-content: crawler[LEFT] name", "target_id" : "目标\n\nlink-content: target[LEFT] name", "item_id" : "对象\n\n\nlink-content: article[LEFT] name", "status" : "状态\n\nlink-content: status[LEFT] status_name", "created" : "同步时间", "result_id" : "结果标示", "result_link" : "外联结果", };
    _table_atributes = {};
    _table_default_values = {"id" : "nextval('table_target_share_synced_id_seq'::regclass)", "created" : "now()", };
    

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


    def add(self, source_id, target_id, item_id, result_id, status=None, created=None, result_link=None):
        """
        插入数据的方法
        """
    
        return self.DB_connection.insert(self._table_name, 'table_target_share_synced_id_seq', _parent_self=self, source_id=source_id, target_id=target_id, item_id=item_id, result_id=result_id, status=status, created=created, result_link=result_link)


    def set(self, id=None, condition_source_id=None, condition_target_id=None, condition_item_id=None, condition_result_id=None, operation="", source_id=None, target_id=None, item_id=None, result_id=None, status=None, created=None, result_link=None,  _condition=""):
        if isinstance(condition_article_id, (tuple, list)):
            ret_loop_result = []
            for loop_item_id in condition_article_id:
                ret_loop_result.append(self.set(row=row, condition_article_id=loop_item_id, operation=operation, article_id=article_id, audit_status=audit_status, _condition=_condition))
            return ret_loop_result

        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "source_id", condition_source_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "target_id", condition_target_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "item_id", condition_item_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "result_id", condition_result_id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, status=status, created=created, result_link=result_link, id=id, source_id=source_id, target_id=target_id, item_id=item_id, result_id=result_id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        if not ret:
            if source_id==None:
                source_id=condition_source_id
            if target_id==None:
                target_id=condition_target_id
            if item_id==None:
                item_id=condition_item_id
            if result_id==None:
                result_id=condition_result_id
            ret=self.add(source_id, target_id, item_id, result_id, status, created, result_link)
        return ret


    def update(self, id=None, condition_source_id=None, condition_target_id=None, condition_item_id=None, condition_result_id=None, operation="", source_id=None, target_id=None, item_id=None, result_id=None, status=None, created=None, result_link=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "source_id", condition_source_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "target_id", condition_target_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "item_id", condition_item_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "result_id", condition_result_id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, status=status, created=created, result_link=result_link, id=id, source_id=source_id, target_id=target_id, item_id=item_id, result_id=result_id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        return ret


    def get(self, source_id=None, target_id=None, item_id=None, result_id=None, id=None, status=None, created=None, result_link=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None, _min_result_link=None, _max_result_link=None, _lower_result_link=None, _greater_result_link=None,  what=None, join=None, _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        \param id **bigint** *标示*
        \param source_id **bigint** *来源  link-content: crawler[LEFT] name*
        \param target_id **bigint** *目标  link-content: target[LEFT] name*
        \param item_id **bigint** *对象   link-content: article[LEFT] name*
        \param status **integer** *状态  link-content: status[LEFT] status_name*
        \param created **timestamp with time zone** *同步时间*
        \param result_id **bigint** *结果标示*
        \param result_link **text** *外联结果*
        """
        
        return self.DB_connection.select1([self._table_name], id=id, source_id=source_id, target_id=target_id, item_id=item_id, status=status, created=created, result_id=result_id, result_link=result_link, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, source_id=None, target_id=None, item_id=None, result_id=None, id=None, status=None, created=None, result_link=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None, _min_result_link=None, _max_result_link=None, _lower_result_link=None, _greater_result_link=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        
        ret = self.DB_connection.select1_count([self._table_name], id=id, source_id=source_id, target_id=target_id, item_id=item_id, status=status, created=created, result_id=result_id, result_link=result_link, order=order, limit=limit,  join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1 and offset:
           ret=ret-offset

        return ret
    def get_first(self, source_id=None, target_id=None, item_id=None, result_id=None, id=None, status=None, created=None, result_link=None, order=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None, _min_result_link=None, _max_result_link=None, _lower_result_link=None, _greater_result_link=None,  what=None,  join=None, _condition=""):
        """
        获取第一个参数满足条件的情况下的数据列。
        \return -1 database error, 0 no data or util.Storages        """
        
        ret=self.DB_connection.select1([self._table_name], id=id, source_id=source_id, target_id=target_id, item_id=item_id, status=status, created=created, result_id=result_id, result_link=result_link, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

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

    def search(self, source_id=None, target_id=None, item_id=None, result_id=None, id=None, status=None, created=None, result_link=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None, _min_result_link=None, _max_result_link=None, _lower_result_link=None, _greater_result_link=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        return self.DB_connection.select1([self._table_name], id=id, source_id=source_id, target_id=target_id, item_id=item_id, status=status, created=created, result_id=result_id, result_link=result_link, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def search_first(self, source_id=None, target_id=None, item_id=None, result_id=None, id=None, status=None, created=None, result_link=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None, _min_result_link=None, _max_result_link=None, _lower_result_link=None, _greater_result_link=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        ret = self.DB_connection.select1([self._table_name], id=id, source_id=source_id, target_id=target_id, item_id=item_id, status=status, created=created, result_id=result_id, result_link=result_link, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def search_count(self, source_id=None, target_id=None, item_id=None, result_id=None, id=None, status=None, created=None, result_link=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None, _min_result_link=None, _max_result_link=None, _lower_result_link=None, _greater_result_link=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def delete(self, id=None, source_id=None, target_id=None, item_id=None, result_id=None, status=None, created=None, result_link=None, where=""):
        
        
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "source_id", source_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "target_id", target_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "item_id", item_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "result_id", result_id, _parent_self=self)

        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=self._table_name, seqname="%s_id_seq" % self._table_name)
        
        return ret

    def clauses_set(self, source_id=None, target_id=None, item_id=None, result_id=None, id=None, status=None, created=None, result_link=None, order=None, limit=None, offset=None, _min_status=None, _max_status=None, _lower_status=None, _greater_status=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None, _min_result_link=None, _max_result_link=None, _lower_result_link=None, _greater_result_link=None,  join="", _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        """
        
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)

        return self._sql_clauses

    def _test(self):
        
        ret_del=self.delete(id=79860, source_id=7777, target_id=7777, item_id=7777, result_id=7777, status=86782, created="2016-03-07 13:25:32.954272", result_link='超级欢迎你3')

        ret_id=self.add(source_id=7777, target_id=7777, item_id=7777, result_id=7777, status=86782, created="2016-03-07 13:25:32.954272", result_link='超级欢迎你3')
        ret_get=self.get(source_id=7777, target_id=7777, item_id=7777, result_id=7777, status=86782, created="2016-03-07 13:25:32.954272", result_link='超级欢迎你3')

        ret_set=self.set(ret_id, target_id=7777, item_id=7777, result_id=7777, operation="",status=86782, created="2016-03-07 13:25:32.954272", result_link='超级欢迎你3')

        ret_del=self.delete(ret_id, target_id=7777, item_id=7777, result_id=7777, status=86782, created="2016-03-07 13:25:32.954272", result_link='超级欢迎你3')

        if ret_set!=1:
            print ("insert-result: %s" % ret_id)
            print ("data: %s" % ret_get.first())

