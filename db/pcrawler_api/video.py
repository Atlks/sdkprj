# -*- coding: utf-8 -*-

from config import *

class video(db_check):


    """
        \param id **bigint**
        \param name **text**
        \param date_time **timestamp with time zone**
        \param remarks **text**
        \param source_site **text**
        \param pic **text**
        \param language_text **text**
        \param play_url **text**
        \param updated **timestamp with time zone**
        \param type_id **bigint**
        \param tags **text**
        \param duration **text**
        \param media_url **text[]** *媒体连接*
        \param category_ids **bigint[]** *分类*
        \param tag_ids **bigint[]** *标签*
    """

    cache = list() #cache content of table

    _table_name='table_video'
    _table_keys = ['id', 'name', 'date_time', 'remarks', 'source_site', 'pic', 'language_text', 'play_url', 'updated', 'type_id', 'tags', 'duration', 'media_url', 'category_ids', 'tag_ids']
    _table_Struktur = {'id' : 'bigint', 'name' : 'text', 'date_time' : 'timestamp with time zone', 'remarks' : 'text', 'source_site' : 'text', 'pic' : 'text', 'language_text' : 'text', 'play_url' : 'text', 'updated' : 'timestamp with time zone', 'type_id' : 'bigint', 'tags' : 'text', 'duration' : 'text', 'media_url' : 'text[]', 'category_ids' : 'bigint[]', 'tag_ids' : 'bigint[]'}
    _table_Kommentar = {"table_video" : "", "id" : "", "name" : "", "date_time" : "", "remarks" : "", "source_site" : "", "pic" : "", "language_text" : "", "play_url" : "", "updated" : "", "type_id" : "", "tags" : "", "duration" : "", "media_url" : "媒体连接", "category_ids" : "分类", "tag_ids" : "标签", };
    _table_atributes = {};
    _table_default_values = {"id" : "nextval('table_video_id_seq'::regclass)", "updated" : "now()", };
    

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


    def add(self, name, type_id, date_time=None, remarks=None, source_site=None, pic=None, language_text=None, play_url=None, updated=None, tags=None, duration=None, media_url=None, category_ids=None, tag_ids=None):
        """
        插入数据的方法
        """
    
        return self.DB_connection.insert(self._table_name, 'table_video_id_seq', _parent_self=self, name=name, type_id=type_id, date_time=date_time, remarks=remarks, source_site=source_site, pic=pic, language_text=language_text, play_url=play_url, updated=updated, tags=tags, duration=duration, media_url=media_url, category_ids=category_ids, tag_ids=tag_ids)


    def set(self, id=None, condition_name=None, condition_type_id=None, operation="", name=None, type_id=None, date_time=None, remarks=None, source_site=None, pic=None, language_text=None, play_url=None, updated=None, tags=None, duration=None, media_url=None, category_ids=None, tag_ids=None,  _condition=""):
        #if isinstance(condition_article_id, (tuple, list)):
        #    ret_loop_result = []
        #    for loop_item_id in condition_article_id:
        #        ret_loop_result.append(self.set(row=row, condition_article_id=loop_item_id, operation=operation, article_id=article_id, audit_status=audit_status, _condition=_condition))
        #    return ret_loop_result

        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", condition_name, _parent_self=self)
        where=self.DB_connection.condition_and(where, "type_id", condition_type_id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, date_time=date_time, remarks=remarks, source_site=source_site, pic=pic, language_text=language_text, play_url=play_url, updated=updated, tags=tags, duration=duration, media_url=media_url, category_ids=category_ids, tag_ids=tag_ids, id=id, name=name, type_id=type_id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        if not ret:
            if name==None:
                name=condition_name
            if type_id==None:
                type_id=condition_type_id
            ret=self.add(name, type_id, date_time, remarks, source_site, pic, language_text, play_url, updated, tags, duration, media_url, category_ids, tag_ids)
        return ret


    def update(self, id=None, condition_name=None, condition_type_id=None, operation="", name=None, type_id=None, date_time=None, remarks=None, source_site=None, pic=None, language_text=None, play_url=None, updated=None, tags=None, duration=None, media_url=None, category_ids=None, tag_ids=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", condition_name, _parent_self=self)
        where=self.DB_connection.condition_and(where, "type_id", condition_type_id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, date_time=date_time, remarks=remarks, source_site=source_site, pic=pic, language_text=language_text, play_url=play_url, updated=updated, tags=tags, duration=duration, media_url=media_url, category_ids=category_ids, tag_ids=tag_ids, id=id, name=name, type_id=type_id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        return ret


    def get(self, name=None, type_id=None, id=None, date_time=None, remarks=None, source_site=None, pic=None, language_text=None, play_url=None, updated=None, tags=None, duration=None, media_url=None, category_ids=None, tag_ids=None, order=None, limit=None, offset=None, _min_date_time=None, _max_date_time=None, _lower_date_time=None, _greater_date_time=None, _min_remarks=None, _max_remarks=None, _lower_remarks=None, _greater_remarks=None, _min_source_site=None, _max_source_site=None, _lower_source_site=None, _greater_source_site=None, _min_pic=None, _max_pic=None, _lower_pic=None, _greater_pic=None, _min_language_text=None, _max_language_text=None, _lower_language_text=None, _greater_language_text=None, _min_play_url=None, _max_play_url=None, _lower_play_url=None, _greater_play_url=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None, _min_tags=None, _max_tags=None, _lower_tags=None, _greater_tags=None, _min_duration=None, _max_duration=None, _lower_duration=None, _greater_duration=None, _min_media_url=None, _max_media_url=None, _lower_media_url=None, _greater_media_url=None, _min_category_ids=None, _max_category_ids=None, _lower_category_ids=None, _greater_category_ids=None, _min_tag_ids=None, _max_tag_ids=None, _lower_tag_ids=None, _greater_tag_ids=None,  what=None, join=None, _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        \param id **bigint**
        \param name **text**
        \param date_time **timestamp with time zone**
        \param remarks **text**
        \param source_site **text**
        \param pic **text**
        \param language_text **text**
        \param play_url **text**
        \param updated **timestamp with time zone**
        \param type_id **bigint**
        \param tags **text**
        \param duration **text**
        \param media_url **text[]** *媒体连接*
        \param category_ids **bigint[]** *分类*
        \param tag_ids **bigint[]** *标签*
        """
        
        return self.DB_connection.select1([self._table_name], id=id, name=name, date_time=date_time, remarks=remarks, source_site=source_site, pic=pic, language_text=language_text, play_url=play_url, updated=updated, type_id=type_id, tags=tags, duration=duration, media_url=media_url, category_ids=category_ids, tag_ids=tag_ids, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, name=None, type_id=None, id=None, date_time=None, remarks=None, source_site=None, pic=None, language_text=None, play_url=None, updated=None, tags=None, duration=None, media_url=None, category_ids=None, tag_ids=None, order=None, limit=None, offset=None, _min_date_time=None, _max_date_time=None, _lower_date_time=None, _greater_date_time=None, _min_remarks=None, _max_remarks=None, _lower_remarks=None, _greater_remarks=None, _min_source_site=None, _max_source_site=None, _lower_source_site=None, _greater_source_site=None, _min_pic=None, _max_pic=None, _lower_pic=None, _greater_pic=None, _min_language_text=None, _max_language_text=None, _lower_language_text=None, _greater_language_text=None, _min_play_url=None, _max_play_url=None, _lower_play_url=None, _greater_play_url=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None, _min_tags=None, _max_tags=None, _lower_tags=None, _greater_tags=None, _min_duration=None, _max_duration=None, _lower_duration=None, _greater_duration=None, _min_media_url=None, _max_media_url=None, _lower_media_url=None, _greater_media_url=None, _min_category_ids=None, _max_category_ids=None, _lower_category_ids=None, _greater_category_ids=None, _min_tag_ids=None, _max_tag_ids=None, _lower_tag_ids=None, _greater_tag_ids=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        
        ret = self.DB_connection.select1_count([self._table_name], id=id, name=name, date_time=date_time, remarks=remarks, source_site=source_site, pic=pic, language_text=language_text, play_url=play_url, updated=updated, type_id=type_id, tags=tags, duration=duration, media_url=media_url, category_ids=category_ids, tag_ids=tag_ids, order=order, limit=limit,  join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1 and offset:
           ret=ret-offset

        return ret
    def get_first(self, name=None, type_id=None, id=None, date_time=None, remarks=None, source_site=None, pic=None, language_text=None, play_url=None, updated=None, tags=None, duration=None, media_url=None, category_ids=None, tag_ids=None, order=None, offset=None, _min_date_time=None, _max_date_time=None, _lower_date_time=None, _greater_date_time=None, _min_remarks=None, _max_remarks=None, _lower_remarks=None, _greater_remarks=None, _min_source_site=None, _max_source_site=None, _lower_source_site=None, _greater_source_site=None, _min_pic=None, _max_pic=None, _lower_pic=None, _greater_pic=None, _min_language_text=None, _max_language_text=None, _lower_language_text=None, _greater_language_text=None, _min_play_url=None, _max_play_url=None, _lower_play_url=None, _greater_play_url=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None, _min_tags=None, _max_tags=None, _lower_tags=None, _greater_tags=None, _min_duration=None, _max_duration=None, _lower_duration=None, _greater_duration=None, _min_media_url=None, _max_media_url=None, _lower_media_url=None, _greater_media_url=None, _min_category_ids=None, _max_category_ids=None, _lower_category_ids=None, _greater_category_ids=None, _min_tag_ids=None, _max_tag_ids=None, _lower_tag_ids=None, _greater_tag_ids=None,  what=None,  join=None, _condition=""):
        """
        获取第一个参数满足条件的情况下的数据列。
        \return -1 database error, 0 no data or util.Storages        """
        
        ret=self.DB_connection.select1([self._table_name], id=id, name=name, date_time=date_time, remarks=remarks, source_site=source_site, pic=pic, language_text=language_text, play_url=play_url, updated=updated, type_id=type_id, tags=tags, duration=duration, media_url=media_url, category_ids=category_ids, tag_ids=tag_ids, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

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

    def search(self, name=None, type_id=None, id=None, date_time=None, remarks=None, source_site=None, pic=None, language_text=None, play_url=None, updated=None, tags=None, duration=None, media_url=None, category_ids=None, tag_ids=None, order=None, limit=None, offset=None, _min_date_time=None, _max_date_time=None, _lower_date_time=None, _greater_date_time=None, _min_remarks=None, _max_remarks=None, _lower_remarks=None, _greater_remarks=None, _min_source_site=None, _max_source_site=None, _lower_source_site=None, _greater_source_site=None, _min_pic=None, _max_pic=None, _lower_pic=None, _greater_pic=None, _min_language_text=None, _max_language_text=None, _lower_language_text=None, _greater_language_text=None, _min_play_url=None, _max_play_url=None, _lower_play_url=None, _greater_play_url=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None, _min_tags=None, _max_tags=None, _lower_tags=None, _greater_tags=None, _min_duration=None, _max_duration=None, _lower_duration=None, _greater_duration=None, _min_media_url=None, _max_media_url=None, _lower_media_url=None, _greater_media_url=None, _min_category_ids=None, _max_category_ids=None, _lower_category_ids=None, _greater_category_ids=None, _min_tag_ids=None, _max_tag_ids=None, _lower_tag_ids=None, _greater_tag_ids=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        return self.DB_connection.select1([self._table_name], id=id, name=name, date_time=date_time, remarks=remarks, source_site=source_site, pic=pic, language_text=language_text, play_url=play_url, updated=updated, type_id=type_id, tags=tags, duration=duration, media_url=media_url, category_ids=category_ids, tag_ids=tag_ids, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def search_first(self, name=None, type_id=None, id=None, date_time=None, remarks=None, source_site=None, pic=None, language_text=None, play_url=None, updated=None, tags=None, duration=None, media_url=None, category_ids=None, tag_ids=None, order=None, limit=None, offset=None, _min_date_time=None, _max_date_time=None, _lower_date_time=None, _greater_date_time=None, _min_remarks=None, _max_remarks=None, _lower_remarks=None, _greater_remarks=None, _min_source_site=None, _max_source_site=None, _lower_source_site=None, _greater_source_site=None, _min_pic=None, _max_pic=None, _lower_pic=None, _greater_pic=None, _min_language_text=None, _max_language_text=None, _lower_language_text=None, _greater_language_text=None, _min_play_url=None, _max_play_url=None, _lower_play_url=None, _greater_play_url=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None, _min_tags=None, _max_tags=None, _lower_tags=None, _greater_tags=None, _min_duration=None, _max_duration=None, _lower_duration=None, _greater_duration=None, _min_media_url=None, _max_media_url=None, _lower_media_url=None, _greater_media_url=None, _min_category_ids=None, _max_category_ids=None, _lower_category_ids=None, _greater_category_ids=None, _min_tag_ids=None, _max_tag_ids=None, _lower_tag_ids=None, _greater_tag_ids=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        ret = self.DB_connection.select1([self._table_name], id=id, name=name, date_time=date_time, remarks=remarks, source_site=source_site, pic=pic, language_text=language_text, play_url=play_url, updated=updated, type_id=type_id, tags=tags, duration=duration, media_url=media_url, category_ids=category_ids, tag_ids=tag_ids, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def search_count(self, name=None, type_id=None, id=None, date_time=None, remarks=None, source_site=None, pic=None, language_text=None, play_url=None, updated=None, tags=None, duration=None, media_url=None, category_ids=None, tag_ids=None, order=None, limit=None, offset=None, _min_date_time=None, _max_date_time=None, _lower_date_time=None, _greater_date_time=None, _min_remarks=None, _max_remarks=None, _lower_remarks=None, _greater_remarks=None, _min_source_site=None, _max_source_site=None, _lower_source_site=None, _greater_source_site=None, _min_pic=None, _max_pic=None, _lower_pic=None, _greater_pic=None, _min_language_text=None, _max_language_text=None, _lower_language_text=None, _greater_language_text=None, _min_play_url=None, _max_play_url=None, _lower_play_url=None, _greater_play_url=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None, _min_tags=None, _max_tags=None, _lower_tags=None, _greater_tags=None, _min_duration=None, _max_duration=None, _lower_duration=None, _greater_duration=None, _min_media_url=None, _max_media_url=None, _lower_media_url=None, _greater_media_url=None, _min_category_ids=None, _max_category_ids=None, _lower_category_ids=None, _greater_category_ids=None, _min_tag_ids=None, _max_tag_ids=None, _lower_tag_ids=None, _greater_tag_ids=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def delete(self, id=None, name=None, type_id=None, date_time=None, remarks=None, source_site=None, pic=None, language_text=None, play_url=None, updated=None, tags=None, duration=None, media_url=None, category_ids=None, tag_ids=None, where=""):
        
        
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", name, _parent_self=self)
        where=self.DB_connection.condition_and(where, "type_id", type_id, _parent_self=self)

        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=self._table_name, seqname="%s_id_seq" % self._table_name)
        
        return ret

    def clauses_set(self, name=None, type_id=None, id=None, date_time=None, remarks=None, source_site=None, pic=None, language_text=None, play_url=None, updated=None, tags=None, duration=None, media_url=None, category_ids=None, tag_ids=None, order=None, limit=None, offset=None, _min_date_time=None, _max_date_time=None, _lower_date_time=None, _greater_date_time=None, _min_remarks=None, _max_remarks=None, _lower_remarks=None, _greater_remarks=None, _min_source_site=None, _max_source_site=None, _lower_source_site=None, _greater_source_site=None, _min_pic=None, _max_pic=None, _lower_pic=None, _greater_pic=None, _min_language_text=None, _max_language_text=None, _lower_language_text=None, _greater_language_text=None, _min_play_url=None, _max_play_url=None, _lower_play_url=None, _greater_play_url=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None, _min_tags=None, _max_tags=None, _lower_tags=None, _greater_tags=None, _min_duration=None, _max_duration=None, _lower_duration=None, _greater_duration=None, _min_media_url=None, _max_media_url=None, _lower_media_url=None, _greater_media_url=None, _min_category_ids=None, _max_category_ids=None, _lower_category_ids=None, _greater_category_ids=None, _min_tag_ids=None, _max_tag_ids=None, _lower_tag_ids=None, _greater_tag_ids=None,  join="", _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        """
        
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)

        return self._sql_clauses

    def _test(self):
        
        ret_del=self.delete(id=79860, name=7777, type_id=7777, date_time="2016-03-07 13:25:32.954272", remarks='超级欢迎你2', source_site='超级欢迎你3', pic='超级欢迎你4', language_text='超级欢迎你5', play_url='超级欢迎你6', updated="2016-03-07 13:25:32.954272", tags='超级欢迎你8', duration='超级欢迎你9', category_ids='{66782, 66783}', tag_ids='{66782, 66783}')

        ret_id=self.add(name=7777, type_id=7777, date_time="2016-03-07 13:25:32.954272", remarks='超级欢迎你2', source_site='超级欢迎你3', pic='超级欢迎你4', language_text='超级欢迎你5', play_url='超级欢迎你6', updated="2016-03-07 13:25:32.954272", tags='超级欢迎你8', duration='超级欢迎你9', category_ids='{66782, 66783}', tag_ids='{66782, 66783}')
        ret_get=self.get(name=7777, type_id=7777, date_time="2016-03-07 13:25:32.954272", remarks='超级欢迎你2', source_site='超级欢迎你3', pic='超级欢迎你4', language_text='超级欢迎你5', play_url='超级欢迎你6', updated="2016-03-07 13:25:32.954272", tags='超级欢迎你8', duration='超级欢迎你9', category_ids='{66782, 66783}', tag_ids='{66782, 66783}')

        ret_set=self.set(ret_id, type_id=7777, operation="",date_time="2016-03-07 13:25:32.954272", remarks='超级欢迎你2', source_site='超级欢迎你3', pic='超级欢迎你4', language_text='超级欢迎你5', play_url='超级欢迎你6', updated="2016-03-07 13:25:32.954272", tags='超级欢迎你8', duration='超级欢迎你9', category_ids='{66782, 66783}', tag_ids='{66782, 66783}')

        ret_del=self.delete(ret_id, type_id=7777, date_time="2016-03-07 13:25:32.954272", remarks='超级欢迎你2', source_site='超级欢迎你3', pic='超级欢迎你4', language_text='超级欢迎你5', play_url='超级欢迎你6', updated="2016-03-07 13:25:32.954272", tags='超级欢迎你8', duration='超级欢迎你9', category_ids='{66782, 66783}', tag_ids='{66782, 66783}')

        if ret_set!=1:
            print ("insert-result: %s" % ret_id)
            print ("data: %s" % ret_get.first())

