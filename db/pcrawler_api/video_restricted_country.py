# -*- coding: utf-8 -*-

from config import *

class video_restricted_country(db_check):


    """https://www.pornhub.com/view_video.php?viewkey=ph61c36d472954b
        \param id **bigint** *子增标示*
        \param server_ip **text** *爬虫服务器IP地址*
        \param url **text** *创建时间*
        \param created **timestamp with time zone**
    """

    cache = list() #cache content of table

    _table_name='table_video_restricted_country'
    _table_keys = ['id', 'server_ip', 'url', 'created']
    _table_Struktur = {'id' : 'bigint', 'server_ip' : 'text', 'url' : 'text', 'created' : 'timestamp with time zone'}
    _table_Kommentar = {"table_video_restricted_country" : "https://www.pornhub.com/view_video.php?viewkey=ph61c36d472954b", "id" : "子增标示", "server_ip" : "爬虫服务器IP地址", "url" : "创建时间", "created" : "", };
    _table_atributes = {};
    _table_default_values = {"id" : "nextval('table_video_restricted_country_id_seq'::regclass)", "created" : "now()", };
    

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


    def add(self, server_ip=None, url=None, created=None):
        """
        插入数据的方法
        """
    
        return self.DB_connection.insert(self._table_name, 'table_video_restricted_country_id_seq', _parent_self=self, server_ip=server_ip, url=url, created=created)


    def set(self, id=None, operation="", server_ip=None, url=None, created=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, server_ip=server_ip, url=url, created=created, id=id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        if not ret:
            ret=self.add(server_ip, url, created)
        return ret


    def update(self, id=None, operation="", server_ip=None, url=None, created=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, server_ip=server_ip, url=url, created=created, id=id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        return ret


    def get(self, id=None, server_ip=None, url=None, created=None, order=None, limit=None, offset=None, _min_server_ip=None, _max_server_ip=None, _lower_server_ip=None, _greater_server_ip=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None,  what=None, join=None, _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        \param id **bigint** *子增标示*
        \param server_ip **text** *爬虫服务器IP地址*
        \param url **text** *创建时间*
        \param created **timestamp with time zone**
        """
        
        return self.DB_connection.select1([self._table_name], id=id, server_ip=server_ip, url=url, created=created, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, id=None, server_ip=None, url=None, created=None, order=None, limit=None, offset=None, _min_server_ip=None, _max_server_ip=None, _lower_server_ip=None, _greater_server_ip=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        
        ret = self.DB_connection.select1_count([self._table_name], id=id, server_ip=server_ip, url=url, created=created, order=order, limit=limit,  join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1 and offset:
           ret=ret-offset

        return ret
    def get_first(self, id=None, server_ip=None, url=None, created=None, order=None, offset=None, _min_server_ip=None, _max_server_ip=None, _lower_server_ip=None, _greater_server_ip=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None,  what=None,  join=None, _condition=""):
        """
        获取第一个参数满足条件的情况下的数据列。
        \return -1 database error, 0 no data or util.Storages        """
        
        ret=self.DB_connection.select1([self._table_name], id=id, server_ip=server_ip, url=url, created=created, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

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

    def search(self, id=None, server_ip=None, url=None, created=None, order=None, limit=None, offset=None, _min_server_ip=None, _max_server_ip=None, _lower_server_ip=None, _greater_server_ip=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        return self.DB_connection.select1([self._table_name], id=id, server_ip=server_ip, url=url, created=created, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def search_first(self, id=None, server_ip=None, url=None, created=None, order=None, limit=None, offset=None, _min_server_ip=None, _max_server_ip=None, _lower_server_ip=None, _greater_server_ip=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        ret = self.DB_connection.select1([self._table_name], id=id, server_ip=server_ip, url=url, created=created, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def search_count(self, id=None, server_ip=None, url=None, created=None, order=None, limit=None, offset=None, _min_server_ip=None, _max_server_ip=None, _lower_server_ip=None, _greater_server_ip=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def delete(self, id=None, server_ip=None, url=None, created=None, where=""):
        
        
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)

        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=self._table_name, seqname="%s_id_seq" % self._table_name)
        
        return ret

    def clauses_set(self, id=None, server_ip=None, url=None, created=None, order=None, limit=None, offset=None, _min_server_ip=None, _max_server_ip=None, _lower_server_ip=None, _greater_server_ip=None, _min_url=None, _max_url=None, _lower_url=None, _greater_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None,  join="", _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        """
        
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)

        return self._sql_clauses

    def _test(self):
        
        ret_del=self.delete(id=79860, server_ip='超级欢迎你1', url='超级欢迎你2', created="2016-03-07 13:25:32.954272")

        ret_id=self.add(server_ip='超级欢迎你1', url='超级欢迎你2', created="2016-03-07 13:25:32.954272")
        ret_get=self.get(server_ip='超级欢迎你1', url='超级欢迎你2', created="2016-03-07 13:25:32.954272")

        ret_set=self.set(ret_id, operation="",server_ip='超级欢迎你1', url='超级欢迎你2', created="2016-03-07 13:25:32.954272")

        ret_del=self.delete(ret_id, server_ip='超级欢迎你1', url='超级欢迎你2', created="2016-03-07 13:25:32.954272")

        if ret_set!=1:
            print ("insert-result: %s" % ret_id)
            print ("data: %s" % ret_get.first())

