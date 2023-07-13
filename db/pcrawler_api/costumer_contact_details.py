# -*- coding: utf-8 -*-

from config import *

class costumer_contact_details(db_check):


    """
        \param row **bigint** *使用范围：后端*
        \param QQ **text** *扣扣号*
        \param WeChat **text** *微信号*
        \param email **text** *邮箱地址*
        \param cellphone **text** *手机号码*
        \param url **text** *涞源网站*
    """

    cache = list() #cache content of table

    _table_name='table_costumer_contact_details'
    _table_keys = ['row', 'QQ', 'WeChat', 'email', 'cellphone', 'url']
    _table_Struktur = {'row' : 'bigint', 'QQ' : 'text', 'WeChat' : 'text', 'email' : 'text', 'cellphone' : 'text', 'url' : 'text'}
    _table_Kommentar = {"table_costumer_contact_details" : "", "row" : "使用范围：后端", "QQ" : "扣扣号", "WeChat" : "微信号", "email" : "邮箱地址", "cellphone" : "手机号码", "url" : "涞源网站", };
    _table_atributes = {};
    _table_default_values = {"row" : "nextval('table_costumer_contact_details_row_seq'::regclass)", };
    

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


    def add(self, QQ=None, WeChat=None, email=None, cellphone=None, url=None):
        """
        插入数据的方法
        """
    
        return self.DB_connection.insert(self._table_name, 'table_costumer_contact_details_row_seq', _parent_self=self, QQ=QQ, WeChat=WeChat, email=email, cellphone=cellphone, url=url)


    def set(self, row=None, operation="", QQ=None, WeChat=None, email=None, cellphone=None, url=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "row", row, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, QQ=QQ, WeChat=WeChat, email=email, cellphone=cellphone, url=url, row=row, _condition=_condition, _parent_self=self)
        else:
            ret=None
        if not ret:
            ret=self.add(QQ, WeChat, email, cellphone, url)
        return ret


    def update(self, row=None, operation="", QQ=None, WeChat=None, email=None, cellphone=None, url=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "row", row, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, QQ=QQ, WeChat=WeChat, email=email, cellphone=cellphone, url=url, row=row, _condition=_condition, _parent_self=self)
        else:
            ret=None
        return ret


    def get(self, row=None, QQ=None, WeChat=None, email=None, cellphone=None, url=None, order=None, limit=None, offset=None, _min_QQ=None, _max_QQ=None, _lower_QQ=None, _greater_QQ=None, _min_WeChat=None, _max_WeChat=None, _lower_WeChat=None, _greater_WeChat=None, _min_email=None, _max_email=None, _lower_email=None, _greater_email=None, _min_cellphone=None, _max_cellphone=None, _lower_cellphone=None, _greater_cellphone=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None,  what=None, join=None, _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        \param row **bigint** *使用范围：后端*
        \param QQ **text** *扣扣号*
        \param WeChat **text** *微信号*
        \param email **text** *邮箱地址*
        \param cellphone **text** *手机号码*
        \param url **text** *涞源网站*
        """
        
        return self.DB_connection.select1([self._table_name], row=row, QQ=QQ, WeChat=WeChat, email=email, cellphone=cellphone, url=url, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, row=None, QQ=None, WeChat=None, email=None, cellphone=None, url=None, order=None, limit=None, offset=None, _min_QQ=None, _max_QQ=None, _lower_QQ=None, _greater_QQ=None, _min_WeChat=None, _max_WeChat=None, _lower_WeChat=None, _greater_WeChat=None, _min_email=None, _max_email=None, _lower_email=None, _greater_email=None, _min_cellphone=None, _max_cellphone=None, _lower_cellphone=None, _greater_cellphone=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        
        ret = self.DB_connection.select1_count([self._table_name], row=row, QQ=QQ, WeChat=WeChat, email=email, cellphone=cellphone, url=url, order=order, limit=limit,  join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1 and offset:
           ret=ret-offset

        return ret
    def get_first(self, row=None, QQ=None, WeChat=None, email=None, cellphone=None, url=None, order=None, offset=None, _min_QQ=None, _max_QQ=None, _lower_QQ=None, _greater_QQ=None, _min_WeChat=None, _max_WeChat=None, _lower_WeChat=None, _greater_WeChat=None, _min_email=None, _max_email=None, _lower_email=None, _greater_email=None, _min_cellphone=None, _max_cellphone=None, _lower_cellphone=None, _greater_cellphone=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None,  what=None,  join=None, _condition=""):
        """
        获取第一个参数满足条件的情况下的数据列。
        \return -1 database error, 0 no data or util.Storages        """
        
        ret=self.DB_connection.select1([self._table_name], row=row, QQ=QQ, WeChat=WeChat, email=email, cellphone=cellphone, url=url, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

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

    def search(self, row=None, QQ=None, WeChat=None, email=None, cellphone=None, url=None, order=None, limit=None, offset=None, _min_QQ=None, _max_QQ=None, _lower_QQ=None, _greater_QQ=None, _min_WeChat=None, _max_WeChat=None, _lower_WeChat=None, _greater_WeChat=None, _min_email=None, _max_email=None, _lower_email=None, _greater_email=None, _min_cellphone=None, _max_cellphone=None, _lower_cellphone=None, _greater_cellphone=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        return self.DB_connection.select1([self._table_name], row=row, QQ=QQ, WeChat=WeChat, email=email, cellphone=cellphone, url=url, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def search_first(self, row=None, QQ=None, WeChat=None, email=None, cellphone=None, url=None, order=None, limit=None, offset=None, _min_QQ=None, _max_QQ=None, _lower_QQ=None, _greater_QQ=None, _min_WeChat=None, _max_WeChat=None, _lower_WeChat=None, _greater_WeChat=None, _min_email=None, _max_email=None, _lower_email=None, _greater_email=None, _min_cellphone=None, _max_cellphone=None, _lower_cellphone=None, _greater_cellphone=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        ret = self.DB_connection.select1([self._table_name], row=row, QQ=QQ, WeChat=WeChat, email=email, cellphone=cellphone, url=url, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def search_count(self, row=None, QQ=None, WeChat=None, email=None, cellphone=None, url=None, order=None, limit=None, offset=None, _min_QQ=None, _max_QQ=None, _lower_QQ=None, _greater_QQ=None, _min_WeChat=None, _max_WeChat=None, _lower_WeChat=None, _greater_WeChat=None, _min_email=None, _max_email=None, _lower_email=None, _greater_email=None, _min_cellphone=None, _max_cellphone=None, _lower_cellphone=None, _greater_cellphone=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def delete(self, row=None, QQ=None, WeChat=None, email=None, cellphone=None, url=None, where=""):
        
        
        where=self.DB_connection.condition_and(where, "row", row, _parent_self=self)

        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=self._table_name, seqname="%s_id_seq" % self._table_name)
        
        return ret

    def clauses_set(self, row=None, QQ=None, WeChat=None, email=None, cellphone=None, url=None, order=None, limit=None, offset=None, _min_QQ=None, _max_QQ=None, _lower_QQ=None, _greater_QQ=None, _min_WeChat=None, _max_WeChat=None, _lower_WeChat=None, _greater_WeChat=None, _min_email=None, _max_email=None, _lower_email=None, _greater_email=None, _min_cellphone=None, _max_cellphone=None, _lower_cellphone=None, _greater_cellphone=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None,  join="", _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        """
        
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)

        return self._sql_clauses

    def _test(self):
        
        ret_del=self.delete(row=79860, QQ='超级欢迎你1', WeChat='超级欢迎你2', email='超级欢迎你3', cellphone='超级欢迎你4', url='超级欢迎你5')

        ret_id=self.add(QQ='超级欢迎你1', WeChat='超级欢迎你2', email='超级欢迎你3', cellphone='超级欢迎你4', url='超级欢迎你5')
        ret_get=self.get(QQ='超级欢迎你1', WeChat='超级欢迎你2', email='超级欢迎你3', cellphone='超级欢迎你4', url='超级欢迎你5')

        ret_set=self.set(ret_id, operation="",QQ='超级欢迎你1', WeChat='超级欢迎你2', email='超级欢迎你3', cellphone='超级欢迎你4', url='超级欢迎你5')

        ret_del=self.delete(ret_id, QQ='超级欢迎你1', WeChat='超级欢迎你2', email='超级欢迎你3', cellphone='超级欢迎你4', url='超级欢迎你5')

        if ret_set!=1:
            print ("insert-result: %s" % ret_id)
            print ("data: %s" % ret_get.first())

