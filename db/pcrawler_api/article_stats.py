from config import *

class article_stats(db_check):
    __doc__ = '\n        \\param row **bigint**\n        \\param id **bigint**\n        \\param views **bigint**\n        \\param likes **bigint**\n        \\param dislikes **bigint**\n        \\param reports **bigint** *abuse reports*\n        \\param updated **time with time zone**\n    '
    cache = list()
    _table_name = 'table_article_stats'
    _table_keys = ['row', 'id', 'views', 'likes', 'dislikes', 'reports', 'updated']
    _table_Struktur = {'row':'bigint',  'id':'bigint',  'views':'bigint',  'likes':'bigint',  'dislikes':'bigint',  'reports':'bigint',  'updated':'time with time zone'}
    _table_Kommentar = {'table_article_stats':'',  'row':'',  'id':'',  'views':'',  'likes':'',  'dislikes':'',  'reports':'abuse reports',  'updated':''}
    _table_atributes = {}
    _table_default_values = {'row':"nextval('table_article_stats_row_seq'::regclass)",  'updated':'now()'}
    _join_obj = None
    _sql_clauses = None

    def __init__(self, join_obj=None, sql_join='', table_name=None, DB_connection=DB, domain=''):
        self.DB_connection = DB_connection
        self._join_obj = join_obj
        if table_name:
            self._table_name = table_name
        if domain:
            self._table_name = domain + '.' + self._table_name
        else:
            if cookie('user_domain'):
                self._table_name = cookie('user_domain') + '.' + self._table_name

    def add(self, id, views=None, likes=None, dislikes=None, reports=None, updated=None):
        """
        插入数据的方法
        """
        return self.DB_connection.insert((self._table_name), 'table_article_stats_row_seq', _parent_self=self, id=id, views=views, likes=likes, dislikes=dislikes, reports=reports, updated=updated)

    def set(self, row=None, condition_id=None, operation='', id=None, views=None, likes=None, dislikes=None, reports=None, updated=None, _condition=''):
        where = ''
        where = self.DB_connection.condition_and(where, 'row', row, _parent_self=self)
        where = self.DB_connection.condition_and(where, 'id', condition_id, _parent_self=self)
        if where or _condition:
            ret = self.DB_connection.update1((self._table_name), where, operation, views=views, likes=likes, dislikes=dislikes, reports=reports, updated=updated, row=row, id=id, _condition=_condition, _parent_self=self)
        else:
            ret = None
        if not ret:
            if id == None:
                id = condition_id
            ret = self.add(id, views, likes, dislikes, reports, updated)
        return ret

    def update(self, row=None, condition_id=None, operation='', id=None, views=None, likes=None, dislikes=None, reports=None, updated=None, _condition=''):
        where = ''
        where = self.DB_connection.condition_and(where, 'row', row, _parent_self=self)
        where = self.DB_connection.condition_and(where, 'id', condition_id, _parent_self=self)
        if where or _condition:
            ret = self.DB_connection.update1((self._table_name), where, operation, views=views, likes=likes, dislikes=dislikes, reports=reports, updated=updated, row=row, id=id, _condition=_condition, _parent_self=self)
        else:
            ret = None
        return ret

    def get(self, id=None, row=None, views=None, likes=None, dislikes=None, reports=None, updated=None, order=None, limit=None, offset=None, _min_views=None, _max_views=None, _lower_views=None, _greater_views=None, _min_likes=None, _max_likes=None, _lower_likes=None, _greater_likes=None, _min_dislikes=None, _max_dislikes=None, _lower_dislikes=None, _greater_dislikes=None, _min_reports=None, _max_reports=None, _lower_reports=None, _greater_reports=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None, what=None, join=None, _condition=''):
        r"""
        获取所有的参数满足条件的情况下的数据
        \param row **bigint**
        \param id **bigint**
        \param views **bigint**
        \param likes **bigint**
        \param dislikes **bigint**
        \param reports **bigint** *abuse reports*
        \param updated **time with time zone**
        """
        return self.DB_connection.select1([self._table_name], row=row, id=id, views=views, likes=likes, dislikes=dislikes, reports=reports, updated=updated, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, id=None, row=None, views=None, likes=None, dislikes=None, reports=None, updated=None, order=None, limit=None, offset=None, _min_views=None, _max_views=None, _lower_views=None, _greater_views=None, _min_likes=None, _max_likes=None, _lower_likes=None, _greater_likes=None, _min_dislikes=None, _max_dislikes=None, _lower_dislikes=None, _greater_dislikes=None, _min_reports=None, _max_reports=None, _lower_reports=None, _greater_reports=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None, join=None, _condition=''):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        ret = self.DB_connection.select1_count([self._table_name], row=row, id=id, views=views, likes=likes, dislikes=dislikes, reports=reports, updated=updated, order=order, limit=limit, join=join, _condition=_condition, _parent_self=self)
        if ret:
            if ret != -1:
                if offset:
                    ret = ret - offset
        return ret

    def get_first(self, id=None, row=None, views=None, likes=None, dislikes=None, reports=None, updated=None, order=None, offset=None, _min_views=None, _max_views=None, _lower_views=None, _greater_views=None, _min_likes=None, _max_likes=None, _lower_likes=None, _greater_likes=None, _min_dislikes=None, _max_dislikes=None, _lower_dislikes=None, _greater_dislikes=None, _min_reports=None, _max_reports=None, _lower_reports=None, _greater_reports=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None, what=None, join=None, _condition=''):
        """
        获取第一个参数满足条件的情况下的数据列。
        
eturn -1 database error, 0 no data or util.Storages        """
        ret = self.DB_connection.select1([self._table_name], row=row, id=id, views=views, likes=likes, dislikes=dislikes, reports=reports, updated=updated, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)
        if ret and ret != -1:
            ret = ret.first()
        else:
            ret = 0
        return ret

    def count(self, column='*', table_name=None):
        """
        获取本数据库表的信息数量
        """
        return self.DB_connection.count(column=column, table_name=table_name, _parent_self=self)

    def search(self, id=None, row=None, views=None, likes=None, dislikes=None, reports=None, updated=None, order=None, limit=None, offset=None, _min_views=None, _max_views=None, _lower_views=None, _greater_views=None, _min_likes=None, _max_likes=None, _lower_likes=None, _greater_likes=None, _min_dislikes=None, _max_dislikes=None, _lower_dislikes=None, _greater_dislikes=None, _min_reports=None, _max_reports=None, _lower_reports=None, _greater_reports=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None, join=None, _condition=''):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        return self.DB_connection.select1([self._table_name], row=row, id=id, views=views, likes=likes, dislikes=dislikes, reports=reports, updated=updated, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=' OR ', _parent_self=self)

    def search_first(self, id=None, row=None, views=None, likes=None, dislikes=None, reports=None, updated=None, order=None, limit=None, offset=None, _min_views=None, _max_views=None, _lower_views=None, _greater_views=None, _min_likes=None, _max_likes=None, _lower_likes=None, _greater_likes=None, _min_dislikes=None, _max_dislikes=None, _lower_dislikes=None, _greater_dislikes=None, _min_reports=None, _max_reports=None, _lower_reports=None, _greater_reports=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None, join=None, _condition=''):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        ret = self.DB_connection.select1([self._table_name], row=row, id=id, views=views, likes=likes, dislikes=dislikes, reports=reports, updated=updated, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=' OR ', _parent_self=self)
        if ret and ret != -1:
            ret = ret.first()
        else:
            ret = 0
        return ret

    def search_count(self, id=None, row=None, views=None, likes=None, dislikes=None, reports=None, updated=None, order=None, limit=None, offset=None, _min_views=None, _max_views=None, _lower_views=None, _greater_views=None, _min_likes=None, _max_likes=None, _lower_likes=None, _greater_likes=None, _min_dislikes=None, _max_dislikes=None, _lower_dislikes=None, _greater_dislikes=None, _min_reports=None, _max_reports=None, _lower_reports=None, _greater_reports=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None, join=None, _condition=''):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=' OR ', _parent_self=self)

    def delete(self, row=None, id=None, views=None, likes=None, dislikes=None, reports=None, updated=None, where=''):
        where = self.DB_connection.condition_and(where, 'row', row, _parent_self=self)
        where = self.DB_connection.condition_and(where, 'id', id, _parent_self=self)
        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=(self._table_name), seqname=('%s_id_seq' % self._table_name))
        return ret

    def clauses_set(self, id=None, row=None, views=None, likes=None, dislikes=None, reports=None, updated=None, order=None, limit=None, offset=None, _min_views=None, _max_views=None, _lower_views=None, _greater_views=None, _min_likes=None, _max_likes=None, _lower_likes=None, _greater_likes=None, _min_dislikes=None, _max_dislikes=None, _lower_dislikes=None, _greater_dislikes=None, _min_reports=None, _max_reports=None, _lower_reports=None, _greater_reports=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None, join='', _condition=''):
        """
        获取所有的参数满足条件的情况下的数据
        """
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)
        return self._sql_clauses

    def _test(self):
        ret_del = self.delete(row=79860, id=7777, views=86782, likes=86782, dislikes=86782, reports=86782, updated=86782)
        ret_id = self.add(id=7777, views=86782, likes=86782, dislikes=86782, reports=86782, updated=86782)
        ret_get = self.get(id=7777, views=86782, likes=86782, dislikes=86782, reports=86782, updated=86782)
        ret_set = self.set(ret_id, operation='', views=86782, likes=86782, dislikes=86782, reports=86782, updated=86782)
        ret_del = self.delete(ret_id, views=86782, likes=86782, dislikes=86782, reports=86782, updated=86782)
        if ret_set != 1:
            print('insert-result: %s' % ret_id)
            print('data: %s' % ret_get.first())