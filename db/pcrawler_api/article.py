# -*- coding: utf-8 -*-

from config import *

class article(db_check):


    """文章表
        \param id **bigint** *标示*
        \param name **text** *文章标题*
        \param text_content **text** *文章内容  使用范围：后端 content-type: tag-clean*
        \param source_site **text** *文章原超链接  使用范围：后端*
        \param source_id **bigint** *爬虫  来源站点的标示  使用范围：后端*
        \param cover_pic **text** *封面  文章封面   content-type: image*
        \param language_id **bigint** *语言标示  使用范围：后端*
        \param category_ids **bigint[]** *分类  分类的数组   link-content-array: category name*
        \param tag_ids **bigint[]** *标签  标签的数组  link-content-array: tag tag_name*
        \param media_url **text[]** *媒体连接  使用范围：后端*
        \param created **timestamp with time zone** *文章创建时间  使用范围：后端*
        \param updated **timestamp with time zone** *更新时间  文章的更新时间*
        \param authors_name **text** *作者*
    """

    cache = list() #cache content of table

    _table_name='table_article'
    _table_keys = ['id', 'name', 'text_content', 'source_site', 'source_id', 'cover_pic', 'language_id', 'category_ids', 'tag_ids', 'media_url', 'created', 'updated', 'authors_name']
    _table_Struktur = {'id' : 'bigint', 'name' : 'text', 'text_content' : 'text', 'source_site' : 'text', 'source_id' : 'bigint', 'cover_pic' : 'text', 'language_id' : 'bigint', 'category_ids' : 'bigint[]', 'tag_ids' : 'bigint[]', 'media_url' : 'text[]', 'created' : 'timestamp with time zone', 'updated' : 'timestamp with time zone', 'authors_name' : 'text'}
    _table_Kommentar = {"table_article" : "文章表", "id" : "标示\n\n", "name" : "文章标题", "text_content" : " 文章内容\n\n使用范围：后端\ncontent-type: tag-clean", "source_site" : "文章原超链接\n\n使用范围：后端", "source_id" : "爬虫\n\n来源站点的标示\n\n使用范围：后端", "cover_pic" : "封面\n\n文章封面\n\n\ncontent-type: image", "language_id" : "语言标示\n\n使用范围：后端", "category_ids" : "分类\n\n分类的数组\n\n\nlink-content-array: category name", "tag_ids" : "标签\n\n标签的数组\n\nlink-content-array: tag tag_name", "media_url" : "媒体连接\n\n使用范围：后端", "created" : "文章创建时间\n\n使用范围：后端", "updated" : "更新时间\n\n文章的更新时间", "authors_name" : "作者", };
    _table_atributes = {'source_site': 'UNIQUE'};
    _table_default_values = {"id" : "nextval('table_article_id_seq'::regclass)", "updated" : "now()", };
    

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


    def add(self, name, source_id, language_id, authors_name, text_content=None, source_site=None, cover_pic=None, category_ids=None, tag_ids=None, media_url=None, created=None, updated=None):
        """
        插入数据的方法
        """
    
        return self.DB_connection.insert(self._table_name, 'table_article_id_seq', _parent_self=self, name=name, source_id=source_id, language_id=language_id, authors_name=authors_name, text_content=text_content, source_site=source_site, cover_pic=cover_pic, category_ids=category_ids, tag_ids=tag_ids, media_url=media_url, created=created, updated=updated)


    def set(self, id=None, condition_name=None, condition_source_id=None, condition_language_id=None, condition_authors_name=None, operation="", name=None, source_id=None, language_id=None, authors_name=None, text_content=None, source_site=None, cover_pic=None, category_ids=None, tag_ids=None, media_url=None, created=None, updated=None,  _condition=""):
        if isinstance(condition_source_id, (tuple, list)):
            ret_loop_result = []
            for loop_item_id in condition_source_id:
                ret_loop_result.append(self.set(row=row, condition_source_id=loop_item_id, operation=operation, article_id=article_id, audit_status=audit_status, _condition=_condition))
            return ret_loop_result

        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", condition_name, _parent_self=self)
        where=self.DB_connection.condition_and(where, "source_id", condition_source_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "language_id", condition_language_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "authors_name", condition_authors_name, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, text_content=text_content, source_site=source_site, cover_pic=cover_pic, category_ids=category_ids, tag_ids=tag_ids, media_url=media_url, created=created, updated=updated, id=id, name=name, source_id=source_id, language_id=language_id, authors_name=authors_name, _condition=_condition, _parent_self=self)
        else:
            ret=None
        if not ret:
            if name==None:
                name=condition_name
            if source_id==None:
                source_id=condition_source_id
            if language_id==None:
                language_id=condition_language_id
            if authors_name==None:
                authors_name=condition_authors_name
            ret=self.add(name, source_id, language_id, authors_name, text_content, source_site, cover_pic, category_ids, tag_ids, media_url, created, updated)
        return ret


    def update(self, id=None, condition_name=None, condition_source_id=None, condition_language_id=None, condition_authors_name=None, operation="", name=None, source_id=None, language_id=None, authors_name=None, text_content=None, source_site=None, cover_pic=None, category_ids=None, tag_ids=None, media_url=None, created=None, updated=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", condition_name, _parent_self=self)
        where=self.DB_connection.condition_and(where, "source_id", condition_source_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "language_id", condition_language_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "authors_name", condition_authors_name, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, text_content=text_content, source_site=source_site, cover_pic=cover_pic, category_ids=category_ids, tag_ids=tag_ids, media_url=media_url, created=created, updated=updated, id=id, name=name, source_id=source_id, language_id=language_id, authors_name=authors_name, _condition=_condition, _parent_self=self)
        else:
            ret=None
        return ret


    def get(self, name=None, source_id=None, language_id=None, authors_name=None, id=None, text_content=None, source_site=None, cover_pic=None, category_ids=None, tag_ids=None, media_url=None, created=None, updated=None, order=None, limit=None, offset=None, _min_text_content=None, _max_text_content=None, _lower_text_content=None, _greater_text_content=None, _min_source_site=None, _max_source_site=None, _lower_source_site=None, _greater_source_site=None, _min_cover_pic=None, _max_cover_pic=None, _lower_cover_pic=None, _greater_cover_pic=None, _min_category_ids=None, _max_category_ids=None, _lower_category_ids=None, _greater_category_ids=None, _min_tag_ids=None, _max_tag_ids=None, _lower_tag_ids=None, _greater_tag_ids=None, _min_media_url=None, _max_media_url=None, _lower_media_url=None, _greater_media_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  what=None, join=None, _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        \param id **bigint** *标示*
        \param name **text** *文章标题*
        \param text_content **text** *文章内容  使用范围：后端 content-type: tag-clean*
        \param source_site **text** *文章原超链接  使用范围：后端*
        \param source_id **bigint** *爬虫  来源站点的标示  使用范围：后端*
        \param cover_pic **text** *封面  文章封面   content-type: image*
        \param language_id **bigint** *语言标示  使用范围：后端*
        \param category_ids **bigint[]** *分类  分类的数组   link-content-array: category name*
        \param tag_ids **bigint[]** *标签  标签的数组  link-content-array: tag tag_name*
        \param media_url **text[]** *媒体连接  使用范围：后端*
        \param created **timestamp with time zone** *文章创建时间  使用范围：后端*
        \param updated **timestamp with time zone** *更新时间  文章的更新时间*
        \param authors_name **text** *作者*
        """
        
        return self.DB_connection.select1([self._table_name], id=id, name=name, text_content=text_content, source_site=source_site, source_id=source_id, cover_pic=cover_pic, language_id=language_id, category_ids=category_ids, tag_ids=tag_ids, media_url=media_url, created=created, updated=updated, authors_name=authors_name, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, name=None, source_id=None, language_id=None, authors_name=None, id=None, text_content=None, source_site=None, cover_pic=None, category_ids=None, tag_ids=None, media_url=None, created=None, updated=None, order=None, limit=None, offset=None, _min_text_content=None, _max_text_content=None, _lower_text_content=None, _greater_text_content=None, _min_source_site=None, _max_source_site=None, _lower_source_site=None, _greater_source_site=None, _min_cover_pic=None, _max_cover_pic=None, _lower_cover_pic=None, _greater_cover_pic=None, _min_category_ids=None, _max_category_ids=None, _lower_category_ids=None, _greater_category_ids=None, _min_tag_ids=None, _max_tag_ids=None, _lower_tag_ids=None, _greater_tag_ids=None, _min_media_url=None, _max_media_url=None, _lower_media_url=None, _greater_media_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        
        ret = self.DB_connection.select1_count([self._table_name], id=id, name=name, text_content=text_content, source_site=source_site, source_id=source_id, cover_pic=cover_pic, language_id=language_id, category_ids=category_ids, tag_ids=tag_ids, media_url=media_url, created=created, updated=updated, authors_name=authors_name, order=order, limit=limit,  join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1 and offset:
           ret=ret-offset

        return ret
    def get_first(self, name=None, source_id=None, language_id=None, authors_name=None, id=None, text_content=None, source_site=None, cover_pic=None, category_ids=None, tag_ids=None, media_url=None, created=None, updated=None, order=None, offset=None, _min_text_content=None, _max_text_content=None, _lower_text_content=None, _greater_text_content=None, _min_source_site=None, _max_source_site=None, _lower_source_site=None, _greater_source_site=None, _min_cover_pic=None, _max_cover_pic=None, _lower_cover_pic=None, _greater_cover_pic=None, _min_category_ids=None, _max_category_ids=None, _lower_category_ids=None, _greater_category_ids=None, _min_tag_ids=None, _max_tag_ids=None, _lower_tag_ids=None, _greater_tag_ids=None, _min_media_url=None, _max_media_url=None, _lower_media_url=None, _greater_media_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  what=None,  join=None, _condition=""):
        """
        获取第一个参数满足条件的情况下的数据列。
        \return -1 database error, 0 no data or util.Storages        """
        
        ret=self.DB_connection.select1([self._table_name], id=id, name=name, text_content=text_content, source_site=source_site, source_id=source_id, cover_pic=cover_pic, language_id=language_id, category_ids=category_ids, tag_ids=tag_ids, media_url=media_url, created=created, updated=updated, authors_name=authors_name, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

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

    def search(self, name=None, source_id=None, language_id=None, authors_name=None, id=None, text_content=None, source_site=None, cover_pic=None, category_ids=None, tag_ids=None, media_url=None, created=None, updated=None, order=None, limit=None, offset=None, _min_text_content=None, _max_text_content=None, _lower_text_content=None, _greater_text_content=None, _min_source_site=None, _max_source_site=None, _lower_source_site=None, _greater_source_site=None, _min_cover_pic=None, _max_cover_pic=None, _lower_cover_pic=None, _greater_cover_pic=None, _min_category_ids=None, _max_category_ids=None, _lower_category_ids=None, _greater_category_ids=None, _min_tag_ids=None, _max_tag_ids=None, _lower_tag_ids=None, _greater_tag_ids=None, _min_media_url=None, _max_media_url=None, _lower_media_url=None, _greater_media_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        return self.DB_connection.select1([self._table_name], id=id, name=name, text_content=text_content, source_site=source_site, source_id=source_id, cover_pic=cover_pic, language_id=language_id, category_ids=category_ids, tag_ids=tag_ids, media_url=media_url, created=created, updated=updated, authors_name=authors_name, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def search_first(self, name=None, source_id=None, language_id=None, authors_name=None, id=None, text_content=None, source_site=None, cover_pic=None, category_ids=None, tag_ids=None, media_url=None, created=None, updated=None, order=None, limit=None, offset=None, _min_text_content=None, _max_text_content=None, _lower_text_content=None, _greater_text_content=None, _min_source_site=None, _max_source_site=None, _lower_source_site=None, _greater_source_site=None, _min_cover_pic=None, _max_cover_pic=None, _lower_cover_pic=None, _greater_cover_pic=None, _min_category_ids=None, _max_category_ids=None, _lower_category_ids=None, _greater_category_ids=None, _min_tag_ids=None, _max_tag_ids=None, _lower_tag_ids=None, _greater_tag_ids=None, _min_media_url=None, _max_media_url=None, _lower_media_url=None, _greater_media_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        ret = self.DB_connection.select1([self._table_name], id=id, name=name, text_content=text_content, source_site=source_site, source_id=source_id, cover_pic=cover_pic, language_id=language_id, category_ids=category_ids, tag_ids=tag_ids, media_url=media_url, created=created, updated=updated, authors_name=authors_name, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def search_count(self, name=None, source_id=None, language_id=None, authors_name=None, id=None, text_content=None, source_site=None, cover_pic=None, category_ids=None, tag_ids=None, media_url=None, created=None, updated=None, order=None, limit=None, offset=None, _min_text_content=None, _max_text_content=None, _lower_text_content=None, _greater_text_content=None, _min_source_site=None, _max_source_site=None, _lower_source_site=None, _greater_source_site=None, _min_cover_pic=None, _max_cover_pic=None, _lower_cover_pic=None, _greater_cover_pic=None, _min_category_ids=None, _max_category_ids=None, _lower_category_ids=None, _greater_category_ids=None, _min_tag_ids=None, _max_tag_ids=None, _lower_tag_ids=None, _greater_tag_ids=None, _min_media_url=None, _max_media_url=None, _lower_media_url=None, _greater_media_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def delete(self, id=None, name=None, source_id=None, language_id=None, authors_name=None, text_content=None, source_site=None, cover_pic=None, category_ids=None, tag_ids=None, media_url=None, created=None, updated=None, where=""):
        
        
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "name", name, _parent_self=self)
        where=self.DB_connection.condition_and(where, "source_id", source_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "language_id", language_id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "authors_name", authors_name, _parent_self=self)

        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=self._table_name, seqname="%s_id_seq" % self._table_name)
        
        return ret

    def clauses_set(self, name=None, source_id=None, language_id=None, authors_name=None, id=None, text_content=None, source_site=None, cover_pic=None, category_ids=None, tag_ids=None, media_url=None, created=None, updated=None, order=None, limit=None, offset=None, _min_text_content=None, _max_text_content=None, _lower_text_content=None, _greater_text_content=None, _min_source_site=None, _max_source_site=None, _lower_source_site=None, _greater_source_site=None, _min_cover_pic=None, _max_cover_pic=None, _lower_cover_pic=None, _greater_cover_pic=None, _min_category_ids=None, _max_category_ids=None, _lower_category_ids=None, _greater_category_ids=None, _min_tag_ids=None, _max_tag_ids=None, _lower_tag_ids=None, _greater_tag_ids=None, _min_media_url=None, _max_media_url=None, _lower_media_url=None, _greater_media_url=None, _min_created=None, _max_created=None, _lower_created=None, _greater_created=None, _min_updated=None, _max_updated=None, _lower_updated=None, _greater_updated=None,  join="", _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        """
        
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)

        return self._sql_clauses

    def _test(self):
        
        ret_del=self.delete(id=79860, name=7777, source_id=7777, language_id=7777, authors_name=7777, text_content='超级欢迎你1', source_site='超级欢迎你2', cover_pic='超级欢迎你3', category_ids='{66782, 66783}', tag_ids='{66782, 66783}', created="2016-03-07 13:25:32.954272", updated="2016-03-07 13:25:32.954272")

        ret_id=self.add(name=7777, source_id=7777, language_id=7777, authors_name=7777, text_content='超级欢迎你1', source_site='超级欢迎你2', cover_pic='超级欢迎你3', category_ids='{66782, 66783}', tag_ids='{66782, 66783}', created="2016-03-07 13:25:32.954272", updated="2016-03-07 13:25:32.954272")
        ret_get=self.get(name=7777, source_id=7777, language_id=7777, authors_name=7777, text_content='超级欢迎你1', source_site='超级欢迎你2', cover_pic='超级欢迎你3', category_ids='{66782, 66783}', tag_ids='{66782, 66783}', created="2016-03-07 13:25:32.954272", updated="2016-03-07 13:25:32.954272")

        ret_set=self.set(ret_id, source_id=7777, language_id=7777, authors_name=7777, operation="",text_content='超级欢迎你1', source_site='超级欢迎你2', cover_pic='超级欢迎你3', category_ids='{66782, 66783}', tag_ids='{66782, 66783}', created="2016-03-07 13:25:32.954272", updated="2016-03-07 13:25:32.954272")

        ret_del=self.delete(ret_id, source_id=7777, language_id=7777, authors_name=7777, text_content='超级欢迎你1', source_site='超级欢迎你2', cover_pic='超级欢迎你3', category_ids='{66782, 66783}', tag_ids='{66782, 66783}', created="2016-03-07 13:25:32.954272", updated="2016-03-07 13:25:32.954272")

        if ret_set!=1:
            print ("insert-result: %s" % ret_id)
            print ("data: %s" % ret_get.first())

