# -*- coding: utf-8 -*-

from config import *

class article_audit(db_check):


    """文章审核
       
       action button: 审核=1 audit_status
       action button: 拒绝=2 audit_status
       action button: 删剪=3 audit_status
       
       hide column: id
        \param row **bigint**
        \param article_id **bigint** *审核对象*
        \param audit_status **integer** *状态*
    """

    cache = list() #cache content of table

    _table_name='table_article_audit'
    _table_keys = ['row', 'article_id', 'audit_status']
    _table_Struktur = {'row' : 'bigint', 'article_id' : 'bigint', 'audit_status' : 'integer'}
    _table_Kommentar = {"table_article_audit" : "文章审核\n\naction button: 审核=1 audit_status\naction button: 拒绝=2 audit_status\naction button: 删剪=3 audit_status\n\nhide column: id", "row" : "", "article_id" : "审核对象", "audit_status" : "状态", };
    _table_atributes = {};
    _table_default_values = {"row" : "nextval('table_article_audit_row_seq'::regclass)", };
    

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


    def add(self, article_id, audit_status=None):
        """
        插入数据的方法
        """
    
        return self.DB_connection.insert(self._table_name, 'table_article_audit_row_seq', _parent_self=self, article_id=article_id, audit_status=audit_status)


    def set(self, row=None, condition_article_id=None, operation="", article_id=None, audit_status=None,  _condition=""):
        
        if isinstance(condition_article_id, (tuple, list)):
            ret_loop_result = []
            for loop_item_id in condition_article_id:
                ret_loop_result.append(self.set(row=row, condition_article_id=loop_item_id, operation=operation, article_id=article_id, audit_status=audit_status, _condition=_condition))                
            return ret_loop_result
                
        where=""
        where=self.DB_connection.condition_and(where, "row", row, _parent_self=self)
        where=self.DB_connection.condition_and(where, "article_id", condition_article_id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, audit_status=audit_status, row=row, article_id=article_id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        if not ret:
            if article_id==None:
                article_id=condition_article_id
            ret=self.add(article_id, audit_status)
        return ret


    def update(self, row=None, condition_article_id=None, operation="", article_id=None, audit_status=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "row", row, _parent_self=self)
        where=self.DB_connection.condition_and(where, "article_id", condition_article_id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, audit_status=audit_status, row=row, article_id=article_id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        return ret


    def get(self, article_id=None, row=None, audit_status=None, order=None, limit=None, offset=None, _min_audit_status=None, _max_audit_status=None, _lower_audit_status=None, _greater_audit_status=None,  what=None, join=None, _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        \param row **bigint**
        \param article_id **bigint** *审核对象*
        \param audit_status **integer** *状态*
        """
        
        return self.DB_connection.select1([self._table_name], row=row, article_id=article_id, audit_status=audit_status, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, article_id=None, row=None, audit_status=None, order=None, limit=None, offset=None, _min_audit_status=None, _max_audit_status=None, _lower_audit_status=None, _greater_audit_status=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        
        ret = self.DB_connection.select1_count([self._table_name], row=row, article_id=article_id, audit_status=audit_status, order=order, limit=limit,  join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1 and offset:
           ret=ret-offset

        return ret
    def get_first(self, article_id=None, row=None, audit_status=None, order=None, offset=None, _min_audit_status=None, _max_audit_status=None, _lower_audit_status=None, _greater_audit_status=None,  what=None,  join=None, _condition=""):
        """
        获取第一个参数满足条件的情况下的数据列。
        \return -1 database error, 0 no data or util.Storages        """
        
        ret=self.DB_connection.select1([self._table_name], row=row, article_id=article_id, audit_status=audit_status, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

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

    def search(self, article_id=None, row=None, audit_status=None, order=None, limit=None, offset=None, _min_audit_status=None, _max_audit_status=None, _lower_audit_status=None, _greater_audit_status=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        return self.DB_connection.select1([self._table_name], row=row, article_id=article_id, audit_status=audit_status, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def search_first(self, article_id=None, row=None, audit_status=None, order=None, limit=None, offset=None, _min_audit_status=None, _max_audit_status=None, _lower_audit_status=None, _greater_audit_status=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        ret = self.DB_connection.select1([self._table_name], row=row, article_id=article_id, audit_status=audit_status, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def search_count(self, article_id=None, row=None, audit_status=None, order=None, limit=None, offset=None, _min_audit_status=None, _max_audit_status=None, _lower_audit_status=None, _greater_audit_status=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def delete(self, row=None, article_id=None, audit_status=None, where=""):
        
        
        where=self.DB_connection.condition_and(where, "row", row, _parent_self=self)
        where=self.DB_connection.condition_and(where, "article_id", article_id, _parent_self=self)

        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=self._table_name, seqname="%s_id_seq" % self._table_name)
        
        return ret

    def clauses_set(self, article_id=None, row=None, audit_status=None, order=None, limit=None, offset=None, _min_audit_status=None, _max_audit_status=None, _lower_audit_status=None, _greater_audit_status=None,  join="", _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        """
        
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)

        return self._sql_clauses

    def _test(self):
        
        ret_del=self.delete(row=79860, article_id=7777, audit_status=86782)

        ret_id=self.add(article_id=7777, audit_status=86782)
        ret_get=self.get(article_id=7777, audit_status=86782)

        ret_set=self.set(ret_id, operation="",audit_status=86782)

        ret_del=self.delete(ret_id, audit_status=86782)

        if ret_set!=1:
            print ("insert-result: %s" % ret_id)
            print ("data: %s" % ret_get.first())

