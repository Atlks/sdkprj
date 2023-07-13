# -*- coding: utf-8 -*-

from config import *

class domain_deleted_search_engine(db_check):


    """
        \param id **bigint**
        \param domain **text**
        \param back_links **bigint**
        \param domain_pops **bigint**
        \param birth_year_archieve_org **timestamp with time zone**
        \param archieve_numbers_of_crawl_results **bigint**
        \param alexa_traffic_rank_3m **bigint**
        \param status_dmoz_org **text**
        \param DNS_Status__com_of_Domain_Name **integer**
        \param DNS_Status__net_of_Domain_Name **integer**
        \param DNS_Status__org_of_Domain_Name **integer**
        \param DNS_Status__de_of_Domain_Name **integer**
        \param Number_of_TLDs_the_Domain_Name_is_Registered **bigint**
        \param Number_of_Related_Domains_in__com__net__org__biz__info **bigint**
        \param dropped **timestamp with time zone**
        \param Status **text**
    """

    cache = list() #cache content of table

    _table_name='table_domain_deleted_search_engine'
    _table_keys = ['id', 'domain', 'back_links', 'domain_pops', 'birth_year_archieve_org', 'archieve_numbers_of_crawl_results', 'alexa_traffic_rank_3m', 'status_dmoz_org', 'DNS_Status__com_of_Domain_Name', 'DNS_Status__net_of_Domain_Name', 'DNS_Status__org_of_Domain_Name', 'DNS_Status__de_of_Domain_Name', 'Number_of_TLDs_the_Domain_Name_is_Registered', 'Number_of_Related_Domains_in__com__net__org__biz__info', 'dropped', 'Status']
    _table_Struktur = {'id' : 'bigint', 'domain' : 'text', 'back_links' : 'bigint', 'domain_pops' : 'bigint', 'birth_year_archieve_org' : 'timestamp with time zone', 'archieve_numbers_of_crawl_results' : 'bigint', 'alexa_traffic_rank_3m' : 'bigint', 'status_dmoz_org' : 'text', 'DNS_Status__com_of_Domain_Name' : 'integer', 'DNS_Status__net_of_Domain_Name' : 'integer', 'DNS_Status__org_of_Domain_Name' : 'integer', 'DNS_Status__de_of_Domain_Name' : 'integer', 'Number_of_TLDs_the_Domain_Name_is_Registered' : 'bigint', 'Number_of_Related_Domains_in__com__net__org__biz__info' : 'bigint', 'dropped' : 'timestamp with time zone', 'Status' : 'text'}
    _table_Kommentar = {"table_domain_deleted_search_engine" : "", "id" : "\n失踪范围：后端", "domain" : "组名", "back_links" : "BL", "domain_pops" : "DP", "birth_year_archieve_org" : "ABY", "archieve_numbers_of_crawl_results" : "ACR", "alexa_traffic_rank_3m" : "Alexa", "status_dmoz_org" : "Dmoz", "DNS_Status__com_of_Domain_Name" : "C", "DNS_Status__net_of_Domain_Name" : "N", "DNS_Status__org_of_Domain_Name" : "O", "DNS_Status__de_of_Domain_Name" : "D", "Number_of_TLDs_the_Domain_Name_is_Registered" : "REG", "Number_of_Related_Domains_in__com__net__org__biz__info" : "RDT", "dropped" : "Dropped", "Status" : "Status", };
    _table_atributes = {"domain" : "UNIQUE"};
    _table_default_values = {"id" : "nextval('table_domain_deleted_search_engine_id_seq'::regclass)", };
    

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


    def add(self, domain=None, back_links=None, domain_pops=None, birth_year_archieve_org=None, archieve_numbers_of_crawl_results=None, alexa_traffic_rank_3m=None, status_dmoz_org=None, DNS_Status__com_of_Domain_Name=None, DNS_Status__net_of_Domain_Name=None, DNS_Status__org_of_Domain_Name=None, DNS_Status__de_of_Domain_Name=None, Number_of_TLDs_the_Domain_Name_is_Registered=None, Number_of_Related_Domains_in__com__net__org__biz__info=None, dropped=None, Status=None):
        """
        插入数据的方法
        """
    
        return self.DB_connection.insert(self._table_name, 'table_domain_deleted_search_engine_id_seq', _parent_self=self, domain=domain, back_links=back_links, domain_pops=domain_pops, birth_year_archieve_org=birth_year_archieve_org, archieve_numbers_of_crawl_results=archieve_numbers_of_crawl_results, alexa_traffic_rank_3m=alexa_traffic_rank_3m, status_dmoz_org=status_dmoz_org, DNS_Status__com_of_Domain_Name=DNS_Status__com_of_Domain_Name, DNS_Status__net_of_Domain_Name=DNS_Status__net_of_Domain_Name, DNS_Status__org_of_Domain_Name=DNS_Status__org_of_Domain_Name, DNS_Status__de_of_Domain_Name=DNS_Status__de_of_Domain_Name, Number_of_TLDs_the_Domain_Name_is_Registered=Number_of_TLDs_the_Domain_Name_is_Registered, Number_of_Related_Domains_in__com__net__org__biz__info=Number_of_Related_Domains_in__com__net__org__biz__info, dropped=dropped, Status=Status)


    def set(self, id=None, operation="", domain=None, back_links=None, domain_pops=None, birth_year_archieve_org=None, archieve_numbers_of_crawl_results=None, alexa_traffic_rank_3m=None, status_dmoz_org=None, DNS_Status__com_of_Domain_Name=None, DNS_Status__net_of_Domain_Name=None, DNS_Status__org_of_Domain_Name=None, DNS_Status__de_of_Domain_Name=None, Number_of_TLDs_the_Domain_Name_is_Registered=None, Number_of_Related_Domains_in__com__net__org__biz__info=None, dropped=None, Status=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, domain=domain, back_links=back_links, domain_pops=domain_pops, birth_year_archieve_org=birth_year_archieve_org, archieve_numbers_of_crawl_results=archieve_numbers_of_crawl_results, alexa_traffic_rank_3m=alexa_traffic_rank_3m, status_dmoz_org=status_dmoz_org, DNS_Status__com_of_Domain_Name=DNS_Status__com_of_Domain_Name, DNS_Status__net_of_Domain_Name=DNS_Status__net_of_Domain_Name, DNS_Status__org_of_Domain_Name=DNS_Status__org_of_Domain_Name, DNS_Status__de_of_Domain_Name=DNS_Status__de_of_Domain_Name, Number_of_TLDs_the_Domain_Name_is_Registered=Number_of_TLDs_the_Domain_Name_is_Registered, Number_of_Related_Domains_in__com__net__org__biz__info=Number_of_Related_Domains_in__com__net__org__biz__info, dropped=dropped, Status=Status, id=id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        if not ret:
            ret=self.add(domain, back_links, domain_pops, birth_year_archieve_org, archieve_numbers_of_crawl_results, alexa_traffic_rank_3m, status_dmoz_org, DNS_Status__com_of_Domain_Name, DNS_Status__net_of_Domain_Name, DNS_Status__org_of_Domain_Name, DNS_Status__de_of_Domain_Name, Number_of_TLDs_the_Domain_Name_is_Registered, Number_of_Related_Domains_in__com__net__org__biz__info, dropped, Status)
        return ret


    def update(self, id=None, operation="", domain=None, back_links=None, domain_pops=None, birth_year_archieve_org=None, archieve_numbers_of_crawl_results=None, alexa_traffic_rank_3m=None, status_dmoz_org=None, DNS_Status__com_of_Domain_Name=None, DNS_Status__net_of_Domain_Name=None, DNS_Status__org_of_Domain_Name=None, DNS_Status__de_of_Domain_Name=None, Number_of_TLDs_the_Domain_Name_is_Registered=None, Number_of_Related_Domains_in__com__net__org__biz__info=None, dropped=None, Status=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, domain=domain, back_links=back_links, domain_pops=domain_pops, birth_year_archieve_org=birth_year_archieve_org, archieve_numbers_of_crawl_results=archieve_numbers_of_crawl_results, alexa_traffic_rank_3m=alexa_traffic_rank_3m, status_dmoz_org=status_dmoz_org, DNS_Status__com_of_Domain_Name=DNS_Status__com_of_Domain_Name, DNS_Status__net_of_Domain_Name=DNS_Status__net_of_Domain_Name, DNS_Status__org_of_Domain_Name=DNS_Status__org_of_Domain_Name, DNS_Status__de_of_Domain_Name=DNS_Status__de_of_Domain_Name, Number_of_TLDs_the_Domain_Name_is_Registered=Number_of_TLDs_the_Domain_Name_is_Registered, Number_of_Related_Domains_in__com__net__org__biz__info=Number_of_Related_Domains_in__com__net__org__biz__info, dropped=dropped, Status=Status, id=id, _condition=_condition, _parent_self=self)
        else:
            ret=None
        return ret


    def get(self, id=None, domain=None, back_links=None, domain_pops=None, birth_year_archieve_org=None, archieve_numbers_of_crawl_results=None, alexa_traffic_rank_3m=None, status_dmoz_org=None, DNS_Status__com_of_Domain_Name=None, DNS_Status__net_of_Domain_Name=None, DNS_Status__org_of_Domain_Name=None, DNS_Status__de_of_Domain_Name=None, Number_of_TLDs_the_Domain_Name_is_Registered=None, Number_of_Related_Domains_in__com__net__org__biz__info=None, dropped=None, Status=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_back_links=None, _max_back_links=None, _lower_back_links=None, _greater_back_links=None, _min_domain_pops=None, _max_domain_pops=None, _lower_domain_pops=None, _greater_domain_pops=None, _min_birth_year_archieve_org=None, _max_birth_year_archieve_org=None, _lower_birth_year_archieve_org=None, _greater_birth_year_archieve_org=None, _min_archieve_numbers_of_crawl_results=None, _max_archieve_numbers_of_crawl_results=None, _lower_archieve_numbers_of_crawl_results=None, _greater_archieve_numbers_of_crawl_results=None, _min_alexa_traffic_rank_3m=None, _max_alexa_traffic_rank_3m=None, _lower_alexa_traffic_rank_3m=None, _greater_alexa_traffic_rank_3m=None, _min_status_dmoz_org=None, _max_status_dmoz_org=None, _lower_status_dmoz_org=None, _greater_status_dmoz_org=None, _min_DNS_Status__com_of_Domain_Name=None, _max_DNS_Status__com_of_Domain_Name=None, _lower_DNS_Status__com_of_Domain_Name=None, _greater_DNS_Status__com_of_Domain_Name=None, _min_DNS_Status__net_of_Domain_Name=None, _max_DNS_Status__net_of_Domain_Name=None, _lower_DNS_Status__net_of_Domain_Name=None, _greater_DNS_Status__net_of_Domain_Name=None, _min_DNS_Status__org_of_Domain_Name=None, _max_DNS_Status__org_of_Domain_Name=None, _lower_DNS_Status__org_of_Domain_Name=None, _greater_DNS_Status__org_of_Domain_Name=None, _min_DNS_Status__de_of_Domain_Name=None, _max_DNS_Status__de_of_Domain_Name=None, _lower_DNS_Status__de_of_Domain_Name=None, _greater_DNS_Status__de_of_Domain_Name=None, _min_Number_of_TLDs_the_Domain_Name_is_Registered=None, _max_Number_of_TLDs_the_Domain_Name_is_Registered=None, _lower_Number_of_TLDs_the_Domain_Name_is_Registered=None, _greater_Number_of_TLDs_the_Domain_Name_is_Registered=None, _min_Number_of_Related_Domains_in__com__net__org__biz__info=None, _max_Number_of_Related_Domains_in__com__net__org__biz__info=None, _lower_Number_of_Related_Domains_in__com__net__org__biz__info=None, _greater_Number_of_Related_Domains_in__com__net__org__biz__info=None, _min_dropped=None, _max_dropped=None, _lower_dropped=None, _greater_dropped=None, _min_Status=None, _max_Status=None, _lower_Status=None, _greater_Status=None,  what=None, join=None, _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        \param id **bigint**
        \param domain **text**
        \param back_links **bigint**
        \param domain_pops **bigint**
        \param birth_year_archieve_org **timestamp with time zone**
        \param archieve_numbers_of_crawl_results **bigint**
        \param alexa_traffic_rank_3m **bigint**
        \param status_dmoz_org **text**
        \param DNS_Status__com_of_Domain_Name **integer**
        \param DNS_Status__net_of_Domain_Name **integer**
        \param DNS_Status__org_of_Domain_Name **integer**
        \param DNS_Status__de_of_Domain_Name **integer**
        \param Number_of_TLDs_the_Domain_Name_is_Registered **bigint**
        \param Number_of_Related_Domains_in__com__net__org__biz__info **bigint**
        \param dropped **timestamp with time zone**
        \param Status **text**
        """
        
        return self.DB_connection.select1([self._table_name], id=id, domain=domain, back_links=back_links, domain_pops=domain_pops, birth_year_archieve_org=birth_year_archieve_org, archieve_numbers_of_crawl_results=archieve_numbers_of_crawl_results, alexa_traffic_rank_3m=alexa_traffic_rank_3m, status_dmoz_org=status_dmoz_org, DNS_Status__com_of_Domain_Name=DNS_Status__com_of_Domain_Name, DNS_Status__net_of_Domain_Name=DNS_Status__net_of_Domain_Name, DNS_Status__org_of_Domain_Name=DNS_Status__org_of_Domain_Name, DNS_Status__de_of_Domain_Name=DNS_Status__de_of_Domain_Name, Number_of_TLDs_the_Domain_Name_is_Registered=Number_of_TLDs_the_Domain_Name_is_Registered, Number_of_Related_Domains_in__com__net__org__biz__info=Number_of_Related_Domains_in__com__net__org__biz__info, dropped=dropped, Status=Status, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, id=None, domain=None, back_links=None, domain_pops=None, birth_year_archieve_org=None, archieve_numbers_of_crawl_results=None, alexa_traffic_rank_3m=None, status_dmoz_org=None, DNS_Status__com_of_Domain_Name=None, DNS_Status__net_of_Domain_Name=None, DNS_Status__org_of_Domain_Name=None, DNS_Status__de_of_Domain_Name=None, Number_of_TLDs_the_Domain_Name_is_Registered=None, Number_of_Related_Domains_in__com__net__org__biz__info=None, dropped=None, Status=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_back_links=None, _max_back_links=None, _lower_back_links=None, _greater_back_links=None, _min_domain_pops=None, _max_domain_pops=None, _lower_domain_pops=None, _greater_domain_pops=None, _min_birth_year_archieve_org=None, _max_birth_year_archieve_org=None, _lower_birth_year_archieve_org=None, _greater_birth_year_archieve_org=None, _min_archieve_numbers_of_crawl_results=None, _max_archieve_numbers_of_crawl_results=None, _lower_archieve_numbers_of_crawl_results=None, _greater_archieve_numbers_of_crawl_results=None, _min_alexa_traffic_rank_3m=None, _max_alexa_traffic_rank_3m=None, _lower_alexa_traffic_rank_3m=None, _greater_alexa_traffic_rank_3m=None, _min_status_dmoz_org=None, _max_status_dmoz_org=None, _lower_status_dmoz_org=None, _greater_status_dmoz_org=None, _min_DNS_Status__com_of_Domain_Name=None, _max_DNS_Status__com_of_Domain_Name=None, _lower_DNS_Status__com_of_Domain_Name=None, _greater_DNS_Status__com_of_Domain_Name=None, _min_DNS_Status__net_of_Domain_Name=None, _max_DNS_Status__net_of_Domain_Name=None, _lower_DNS_Status__net_of_Domain_Name=None, _greater_DNS_Status__net_of_Domain_Name=None, _min_DNS_Status__org_of_Domain_Name=None, _max_DNS_Status__org_of_Domain_Name=None, _lower_DNS_Status__org_of_Domain_Name=None, _greater_DNS_Status__org_of_Domain_Name=None, _min_DNS_Status__de_of_Domain_Name=None, _max_DNS_Status__de_of_Domain_Name=None, _lower_DNS_Status__de_of_Domain_Name=None, _greater_DNS_Status__de_of_Domain_Name=None, _min_Number_of_TLDs_the_Domain_Name_is_Registered=None, _max_Number_of_TLDs_the_Domain_Name_is_Registered=None, _lower_Number_of_TLDs_the_Domain_Name_is_Registered=None, _greater_Number_of_TLDs_the_Domain_Name_is_Registered=None, _min_Number_of_Related_Domains_in__com__net__org__biz__info=None, _max_Number_of_Related_Domains_in__com__net__org__biz__info=None, _lower_Number_of_Related_Domains_in__com__net__org__biz__info=None, _greater_Number_of_Related_Domains_in__com__net__org__biz__info=None, _min_dropped=None, _max_dropped=None, _lower_dropped=None, _greater_dropped=None, _min_Status=None, _max_Status=None, _lower_Status=None, _greater_Status=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        
        ret = self.DB_connection.select1_count([self._table_name], id=id, domain=domain, back_links=back_links, domain_pops=domain_pops, birth_year_archieve_org=birth_year_archieve_org, archieve_numbers_of_crawl_results=archieve_numbers_of_crawl_results, alexa_traffic_rank_3m=alexa_traffic_rank_3m, status_dmoz_org=status_dmoz_org, DNS_Status__com_of_Domain_Name=DNS_Status__com_of_Domain_Name, DNS_Status__net_of_Domain_Name=DNS_Status__net_of_Domain_Name, DNS_Status__org_of_Domain_Name=DNS_Status__org_of_Domain_Name, DNS_Status__de_of_Domain_Name=DNS_Status__de_of_Domain_Name, Number_of_TLDs_the_Domain_Name_is_Registered=Number_of_TLDs_the_Domain_Name_is_Registered, Number_of_Related_Domains_in__com__net__org__biz__info=Number_of_Related_Domains_in__com__net__org__biz__info, dropped=dropped, Status=Status, order=order, limit=limit,  join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1 and offset:
           ret=ret-offset

        return ret
    def get_first(self, id=None, domain=None, back_links=None, domain_pops=None, birth_year_archieve_org=None, archieve_numbers_of_crawl_results=None, alexa_traffic_rank_3m=None, status_dmoz_org=None, DNS_Status__com_of_Domain_Name=None, DNS_Status__net_of_Domain_Name=None, DNS_Status__org_of_Domain_Name=None, DNS_Status__de_of_Domain_Name=None, Number_of_TLDs_the_Domain_Name_is_Registered=None, Number_of_Related_Domains_in__com__net__org__biz__info=None, dropped=None, Status=None, order=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_back_links=None, _max_back_links=None, _lower_back_links=None, _greater_back_links=None, _min_domain_pops=None, _max_domain_pops=None, _lower_domain_pops=None, _greater_domain_pops=None, _min_birth_year_archieve_org=None, _max_birth_year_archieve_org=None, _lower_birth_year_archieve_org=None, _greater_birth_year_archieve_org=None, _min_archieve_numbers_of_crawl_results=None, _max_archieve_numbers_of_crawl_results=None, _lower_archieve_numbers_of_crawl_results=None, _greater_archieve_numbers_of_crawl_results=None, _min_alexa_traffic_rank_3m=None, _max_alexa_traffic_rank_3m=None, _lower_alexa_traffic_rank_3m=None, _greater_alexa_traffic_rank_3m=None, _min_status_dmoz_org=None, _max_status_dmoz_org=None, _lower_status_dmoz_org=None, _greater_status_dmoz_org=None, _min_DNS_Status__com_of_Domain_Name=None, _max_DNS_Status__com_of_Domain_Name=None, _lower_DNS_Status__com_of_Domain_Name=None, _greater_DNS_Status__com_of_Domain_Name=None, _min_DNS_Status__net_of_Domain_Name=None, _max_DNS_Status__net_of_Domain_Name=None, _lower_DNS_Status__net_of_Domain_Name=None, _greater_DNS_Status__net_of_Domain_Name=None, _min_DNS_Status__org_of_Domain_Name=None, _max_DNS_Status__org_of_Domain_Name=None, _lower_DNS_Status__org_of_Domain_Name=None, _greater_DNS_Status__org_of_Domain_Name=None, _min_DNS_Status__de_of_Domain_Name=None, _max_DNS_Status__de_of_Domain_Name=None, _lower_DNS_Status__de_of_Domain_Name=None, _greater_DNS_Status__de_of_Domain_Name=None, _min_Number_of_TLDs_the_Domain_Name_is_Registered=None, _max_Number_of_TLDs_the_Domain_Name_is_Registered=None, _lower_Number_of_TLDs_the_Domain_Name_is_Registered=None, _greater_Number_of_TLDs_the_Domain_Name_is_Registered=None, _min_Number_of_Related_Domains_in__com__net__org__biz__info=None, _max_Number_of_Related_Domains_in__com__net__org__biz__info=None, _lower_Number_of_Related_Domains_in__com__net__org__biz__info=None, _greater_Number_of_Related_Domains_in__com__net__org__biz__info=None, _min_dropped=None, _max_dropped=None, _lower_dropped=None, _greater_dropped=None, _min_Status=None, _max_Status=None, _lower_Status=None, _greater_Status=None,  what=None,  join=None, _condition=""):
        """
        获取第一个参数满足条件的情况下的数据列。
        \return -1 database error, 0 no data or util.Storages        """
        
        ret=self.DB_connection.select1([self._table_name], id=id, domain=domain, back_links=back_links, domain_pops=domain_pops, birth_year_archieve_org=birth_year_archieve_org, archieve_numbers_of_crawl_results=archieve_numbers_of_crawl_results, alexa_traffic_rank_3m=alexa_traffic_rank_3m, status_dmoz_org=status_dmoz_org, DNS_Status__com_of_Domain_Name=DNS_Status__com_of_Domain_Name, DNS_Status__net_of_Domain_Name=DNS_Status__net_of_Domain_Name, DNS_Status__org_of_Domain_Name=DNS_Status__org_of_Domain_Name, DNS_Status__de_of_Domain_Name=DNS_Status__de_of_Domain_Name, Number_of_TLDs_the_Domain_Name_is_Registered=Number_of_TLDs_the_Domain_Name_is_Registered, Number_of_Related_Domains_in__com__net__org__biz__info=Number_of_Related_Domains_in__com__net__org__biz__info, dropped=dropped, Status=Status, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

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

    def search(self, id=None, domain=None, back_links=None, domain_pops=None, birth_year_archieve_org=None, archieve_numbers_of_crawl_results=None, alexa_traffic_rank_3m=None, status_dmoz_org=None, DNS_Status__com_of_Domain_Name=None, DNS_Status__net_of_Domain_Name=None, DNS_Status__org_of_Domain_Name=None, DNS_Status__de_of_Domain_Name=None, Number_of_TLDs_the_Domain_Name_is_Registered=None, Number_of_Related_Domains_in__com__net__org__biz__info=None, dropped=None, Status=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_back_links=None, _max_back_links=None, _lower_back_links=None, _greater_back_links=None, _min_domain_pops=None, _max_domain_pops=None, _lower_domain_pops=None, _greater_domain_pops=None, _min_birth_year_archieve_org=None, _max_birth_year_archieve_org=None, _lower_birth_year_archieve_org=None, _greater_birth_year_archieve_org=None, _min_archieve_numbers_of_crawl_results=None, _max_archieve_numbers_of_crawl_results=None, _lower_archieve_numbers_of_crawl_results=None, _greater_archieve_numbers_of_crawl_results=None, _min_alexa_traffic_rank_3m=None, _max_alexa_traffic_rank_3m=None, _lower_alexa_traffic_rank_3m=None, _greater_alexa_traffic_rank_3m=None, _min_status_dmoz_org=None, _max_status_dmoz_org=None, _lower_status_dmoz_org=None, _greater_status_dmoz_org=None, _min_DNS_Status__com_of_Domain_Name=None, _max_DNS_Status__com_of_Domain_Name=None, _lower_DNS_Status__com_of_Domain_Name=None, _greater_DNS_Status__com_of_Domain_Name=None, _min_DNS_Status__net_of_Domain_Name=None, _max_DNS_Status__net_of_Domain_Name=None, _lower_DNS_Status__net_of_Domain_Name=None, _greater_DNS_Status__net_of_Domain_Name=None, _min_DNS_Status__org_of_Domain_Name=None, _max_DNS_Status__org_of_Domain_Name=None, _lower_DNS_Status__org_of_Domain_Name=None, _greater_DNS_Status__org_of_Domain_Name=None, _min_DNS_Status__de_of_Domain_Name=None, _max_DNS_Status__de_of_Domain_Name=None, _lower_DNS_Status__de_of_Domain_Name=None, _greater_DNS_Status__de_of_Domain_Name=None, _min_Number_of_TLDs_the_Domain_Name_is_Registered=None, _max_Number_of_TLDs_the_Domain_Name_is_Registered=None, _lower_Number_of_TLDs_the_Domain_Name_is_Registered=None, _greater_Number_of_TLDs_the_Domain_Name_is_Registered=None, _min_Number_of_Related_Domains_in__com__net__org__biz__info=None, _max_Number_of_Related_Domains_in__com__net__org__biz__info=None, _lower_Number_of_Related_Domains_in__com__net__org__biz__info=None, _greater_Number_of_Related_Domains_in__com__net__org__biz__info=None, _min_dropped=None, _max_dropped=None, _lower_dropped=None, _greater_dropped=None, _min_Status=None, _max_Status=None, _lower_Status=None, _greater_Status=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        return self.DB_connection.select1([self._table_name], id=id, domain=domain, back_links=back_links, domain_pops=domain_pops, birth_year_archieve_org=birth_year_archieve_org, archieve_numbers_of_crawl_results=archieve_numbers_of_crawl_results, alexa_traffic_rank_3m=alexa_traffic_rank_3m, status_dmoz_org=status_dmoz_org, DNS_Status__com_of_Domain_Name=DNS_Status__com_of_Domain_Name, DNS_Status__net_of_Domain_Name=DNS_Status__net_of_Domain_Name, DNS_Status__org_of_Domain_Name=DNS_Status__org_of_Domain_Name, DNS_Status__de_of_Domain_Name=DNS_Status__de_of_Domain_Name, Number_of_TLDs_the_Domain_Name_is_Registered=Number_of_TLDs_the_Domain_Name_is_Registered, Number_of_Related_Domains_in__com__net__org__biz__info=Number_of_Related_Domains_in__com__net__org__biz__info, dropped=dropped, Status=Status, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def search_first(self, id=None, domain=None, back_links=None, domain_pops=None, birth_year_archieve_org=None, archieve_numbers_of_crawl_results=None, alexa_traffic_rank_3m=None, status_dmoz_org=None, DNS_Status__com_of_Domain_Name=None, DNS_Status__net_of_Domain_Name=None, DNS_Status__org_of_Domain_Name=None, DNS_Status__de_of_Domain_Name=None, Number_of_TLDs_the_Domain_Name_is_Registered=None, Number_of_Related_Domains_in__com__net__org__biz__info=None, dropped=None, Status=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_back_links=None, _max_back_links=None, _lower_back_links=None, _greater_back_links=None, _min_domain_pops=None, _max_domain_pops=None, _lower_domain_pops=None, _greater_domain_pops=None, _min_birth_year_archieve_org=None, _max_birth_year_archieve_org=None, _lower_birth_year_archieve_org=None, _greater_birth_year_archieve_org=None, _min_archieve_numbers_of_crawl_results=None, _max_archieve_numbers_of_crawl_results=None, _lower_archieve_numbers_of_crawl_results=None, _greater_archieve_numbers_of_crawl_results=None, _min_alexa_traffic_rank_3m=None, _max_alexa_traffic_rank_3m=None, _lower_alexa_traffic_rank_3m=None, _greater_alexa_traffic_rank_3m=None, _min_status_dmoz_org=None, _max_status_dmoz_org=None, _lower_status_dmoz_org=None, _greater_status_dmoz_org=None, _min_DNS_Status__com_of_Domain_Name=None, _max_DNS_Status__com_of_Domain_Name=None, _lower_DNS_Status__com_of_Domain_Name=None, _greater_DNS_Status__com_of_Domain_Name=None, _min_DNS_Status__net_of_Domain_Name=None, _max_DNS_Status__net_of_Domain_Name=None, _lower_DNS_Status__net_of_Domain_Name=None, _greater_DNS_Status__net_of_Domain_Name=None, _min_DNS_Status__org_of_Domain_Name=None, _max_DNS_Status__org_of_Domain_Name=None, _lower_DNS_Status__org_of_Domain_Name=None, _greater_DNS_Status__org_of_Domain_Name=None, _min_DNS_Status__de_of_Domain_Name=None, _max_DNS_Status__de_of_Domain_Name=None, _lower_DNS_Status__de_of_Domain_Name=None, _greater_DNS_Status__de_of_Domain_Name=None, _min_Number_of_TLDs_the_Domain_Name_is_Registered=None, _max_Number_of_TLDs_the_Domain_Name_is_Registered=None, _lower_Number_of_TLDs_the_Domain_Name_is_Registered=None, _greater_Number_of_TLDs_the_Domain_Name_is_Registered=None, _min_Number_of_Related_Domains_in__com__net__org__biz__info=None, _max_Number_of_Related_Domains_in__com__net__org__biz__info=None, _lower_Number_of_Related_Domains_in__com__net__org__biz__info=None, _greater_Number_of_Related_Domains_in__com__net__org__biz__info=None, _min_dropped=None, _max_dropped=None, _lower_dropped=None, _greater_dropped=None, _min_Status=None, _max_Status=None, _lower_Status=None, _greater_Status=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        ret = self.DB_connection.select1([self._table_name], id=id, domain=domain, back_links=back_links, domain_pops=domain_pops, birth_year_archieve_org=birth_year_archieve_org, archieve_numbers_of_crawl_results=archieve_numbers_of_crawl_results, alexa_traffic_rank_3m=alexa_traffic_rank_3m, status_dmoz_org=status_dmoz_org, DNS_Status__com_of_Domain_Name=DNS_Status__com_of_Domain_Name, DNS_Status__net_of_Domain_Name=DNS_Status__net_of_Domain_Name, DNS_Status__org_of_Domain_Name=DNS_Status__org_of_Domain_Name, DNS_Status__de_of_Domain_Name=DNS_Status__de_of_Domain_Name, Number_of_TLDs_the_Domain_Name_is_Registered=Number_of_TLDs_the_Domain_Name_is_Registered, Number_of_Related_Domains_in__com__net__org__biz__info=Number_of_Related_Domains_in__com__net__org__biz__info, dropped=dropped, Status=Status, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def search_count(self, id=None, domain=None, back_links=None, domain_pops=None, birth_year_archieve_org=None, archieve_numbers_of_crawl_results=None, alexa_traffic_rank_3m=None, status_dmoz_org=None, DNS_Status__com_of_Domain_Name=None, DNS_Status__net_of_Domain_Name=None, DNS_Status__org_of_Domain_Name=None, DNS_Status__de_of_Domain_Name=None, Number_of_TLDs_the_Domain_Name_is_Registered=None, Number_of_Related_Domains_in__com__net__org__biz__info=None, dropped=None, Status=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_back_links=None, _max_back_links=None, _lower_back_links=None, _greater_back_links=None, _min_domain_pops=None, _max_domain_pops=None, _lower_domain_pops=None, _greater_domain_pops=None, _min_birth_year_archieve_org=None, _max_birth_year_archieve_org=None, _lower_birth_year_archieve_org=None, _greater_birth_year_archieve_org=None, _min_archieve_numbers_of_crawl_results=None, _max_archieve_numbers_of_crawl_results=None, _lower_archieve_numbers_of_crawl_results=None, _greater_archieve_numbers_of_crawl_results=None, _min_alexa_traffic_rank_3m=None, _max_alexa_traffic_rank_3m=None, _lower_alexa_traffic_rank_3m=None, _greater_alexa_traffic_rank_3m=None, _min_status_dmoz_org=None, _max_status_dmoz_org=None, _lower_status_dmoz_org=None, _greater_status_dmoz_org=None, _min_DNS_Status__com_of_Domain_Name=None, _max_DNS_Status__com_of_Domain_Name=None, _lower_DNS_Status__com_of_Domain_Name=None, _greater_DNS_Status__com_of_Domain_Name=None, _min_DNS_Status__net_of_Domain_Name=None, _max_DNS_Status__net_of_Domain_Name=None, _lower_DNS_Status__net_of_Domain_Name=None, _greater_DNS_Status__net_of_Domain_Name=None, _min_DNS_Status__org_of_Domain_Name=None, _max_DNS_Status__org_of_Domain_Name=None, _lower_DNS_Status__org_of_Domain_Name=None, _greater_DNS_Status__org_of_Domain_Name=None, _min_DNS_Status__de_of_Domain_Name=None, _max_DNS_Status__de_of_Domain_Name=None, _lower_DNS_Status__de_of_Domain_Name=None, _greater_DNS_Status__de_of_Domain_Name=None, _min_Number_of_TLDs_the_Domain_Name_is_Registered=None, _max_Number_of_TLDs_the_Domain_Name_is_Registered=None, _lower_Number_of_TLDs_the_Domain_Name_is_Registered=None, _greater_Number_of_TLDs_the_Domain_Name_is_Registered=None, _min_Number_of_Related_Domains_in__com__net__org__biz__info=None, _max_Number_of_Related_Domains_in__com__net__org__biz__info=None, _lower_Number_of_Related_Domains_in__com__net__org__biz__info=None, _greater_Number_of_Related_Domains_in__com__net__org__biz__info=None, _min_dropped=None, _max_dropped=None, _lower_dropped=None, _greater_dropped=None, _min_Status=None, _max_Status=None, _lower_Status=None, _greater_Status=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def delete(self, id=None, domain=None, back_links=None, domain_pops=None, birth_year_archieve_org=None, archieve_numbers_of_crawl_results=None, alexa_traffic_rank_3m=None, status_dmoz_org=None, DNS_Status__com_of_Domain_Name=None, DNS_Status__net_of_Domain_Name=None, DNS_Status__org_of_Domain_Name=None, DNS_Status__de_of_Domain_Name=None, Number_of_TLDs_the_Domain_Name_is_Registered=None, Number_of_Related_Domains_in__com__net__org__biz__info=None, dropped=None, Status=None, where=""):
        
        
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)

        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=self._table_name, seqname="%s_id_seq" % self._table_name)
        
        return ret

    def clauses_set(self, id=None, domain=None, back_links=None, domain_pops=None, birth_year_archieve_org=None, archieve_numbers_of_crawl_results=None, alexa_traffic_rank_3m=None, status_dmoz_org=None, DNS_Status__com_of_Domain_Name=None, DNS_Status__net_of_Domain_Name=None, DNS_Status__org_of_Domain_Name=None, DNS_Status__de_of_Domain_Name=None, Number_of_TLDs_the_Domain_Name_is_Registered=None, Number_of_Related_Domains_in__com__net__org__biz__info=None, dropped=None, Status=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_back_links=None, _max_back_links=None, _lower_back_links=None, _greater_back_links=None, _min_domain_pops=None, _max_domain_pops=None, _lower_domain_pops=None, _greater_domain_pops=None, _min_birth_year_archieve_org=None, _max_birth_year_archieve_org=None, _lower_birth_year_archieve_org=None, _greater_birth_year_archieve_org=None, _min_archieve_numbers_of_crawl_results=None, _max_archieve_numbers_of_crawl_results=None, _lower_archieve_numbers_of_crawl_results=None, _greater_archieve_numbers_of_crawl_results=None, _min_alexa_traffic_rank_3m=None, _max_alexa_traffic_rank_3m=None, _lower_alexa_traffic_rank_3m=None, _greater_alexa_traffic_rank_3m=None, _min_status_dmoz_org=None, _max_status_dmoz_org=None, _lower_status_dmoz_org=None, _greater_status_dmoz_org=None, _min_DNS_Status__com_of_Domain_Name=None, _max_DNS_Status__com_of_Domain_Name=None, _lower_DNS_Status__com_of_Domain_Name=None, _greater_DNS_Status__com_of_Domain_Name=None, _min_DNS_Status__net_of_Domain_Name=None, _max_DNS_Status__net_of_Domain_Name=None, _lower_DNS_Status__net_of_Domain_Name=None, _greater_DNS_Status__net_of_Domain_Name=None, _min_DNS_Status__org_of_Domain_Name=None, _max_DNS_Status__org_of_Domain_Name=None, _lower_DNS_Status__org_of_Domain_Name=None, _greater_DNS_Status__org_of_Domain_Name=None, _min_DNS_Status__de_of_Domain_Name=None, _max_DNS_Status__de_of_Domain_Name=None, _lower_DNS_Status__de_of_Domain_Name=None, _greater_DNS_Status__de_of_Domain_Name=None, _min_Number_of_TLDs_the_Domain_Name_is_Registered=None, _max_Number_of_TLDs_the_Domain_Name_is_Registered=None, _lower_Number_of_TLDs_the_Domain_Name_is_Registered=None, _greater_Number_of_TLDs_the_Domain_Name_is_Registered=None, _min_Number_of_Related_Domains_in__com__net__org__biz__info=None, _max_Number_of_Related_Domains_in__com__net__org__biz__info=None, _lower_Number_of_Related_Domains_in__com__net__org__biz__info=None, _greater_Number_of_Related_Domains_in__com__net__org__biz__info=None, _min_dropped=None, _max_dropped=None, _lower_dropped=None, _greater_dropped=None, _min_Status=None, _max_Status=None, _lower_Status=None, _greater_Status=None,  join="", _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        """
        
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)

        return self._sql_clauses

    def _test(self):
        
        ret_del=self.delete(id=79860, domain='超级欢迎你1', back_links=86782, domain_pops=86782, birth_year_archieve_org="2016-03-07 13:25:32.954272", archieve_numbers_of_crawl_results=86782, alexa_traffic_rank_3m=86782, status_dmoz_org='超级欢迎你7', DNS_Status__com_of_Domain_Name=86782, DNS_Status__net_of_Domain_Name=86782, DNS_Status__org_of_Domain_Name=86782, DNS_Status__de_of_Domain_Name=86782, Number_of_TLDs_the_Domain_Name_is_Registered=86782, Number_of_Related_Domains_in__com__net__org__biz__info=86782, dropped="2016-03-07 13:25:32.954272", Status='超级欢迎你15')

        ret_id=self.add(domain='超级欢迎你1', back_links=86782, domain_pops=86782, birth_year_archieve_org="2016-03-07 13:25:32.954272", archieve_numbers_of_crawl_results=86782, alexa_traffic_rank_3m=86782, status_dmoz_org='超级欢迎你7', DNS_Status__com_of_Domain_Name=86782, DNS_Status__net_of_Domain_Name=86782, DNS_Status__org_of_Domain_Name=86782, DNS_Status__de_of_Domain_Name=86782, Number_of_TLDs_the_Domain_Name_is_Registered=86782, Number_of_Related_Domains_in__com__net__org__biz__info=86782, dropped="2016-03-07 13:25:32.954272", Status='超级欢迎你15')
        ret_get=self.get(domain='超级欢迎你1', back_links=86782, domain_pops=86782, birth_year_archieve_org="2016-03-07 13:25:32.954272", archieve_numbers_of_crawl_results=86782, alexa_traffic_rank_3m=86782, status_dmoz_org='超级欢迎你7', DNS_Status__com_of_Domain_Name=86782, DNS_Status__net_of_Domain_Name=86782, DNS_Status__org_of_Domain_Name=86782, DNS_Status__de_of_Domain_Name=86782, Number_of_TLDs_the_Domain_Name_is_Registered=86782, Number_of_Related_Domains_in__com__net__org__biz__info=86782, dropped="2016-03-07 13:25:32.954272", Status='超级欢迎你15')

        ret_set=self.set(ret_id, operation="",domain='超级欢迎你1', back_links=86782, domain_pops=86782, birth_year_archieve_org="2016-03-07 13:25:32.954272", archieve_numbers_of_crawl_results=86782, alexa_traffic_rank_3m=86782, status_dmoz_org='超级欢迎你7', DNS_Status__com_of_Domain_Name=86782, DNS_Status__net_of_Domain_Name=86782, DNS_Status__org_of_Domain_Name=86782, DNS_Status__de_of_Domain_Name=86782, Number_of_TLDs_the_Domain_Name_is_Registered=86782, Number_of_Related_Domains_in__com__net__org__biz__info=86782, dropped="2016-03-07 13:25:32.954272", Status='超级欢迎你15')

        ret_del=self.delete(ret_id, domain='超级欢迎你1', back_links=86782, domain_pops=86782, birth_year_archieve_org="2016-03-07 13:25:32.954272", archieve_numbers_of_crawl_results=86782, alexa_traffic_rank_3m=86782, status_dmoz_org='超级欢迎你7', DNS_Status__com_of_Domain_Name=86782, DNS_Status__net_of_Domain_Name=86782, DNS_Status__org_of_Domain_Name=86782, DNS_Status__de_of_Domain_Name=86782, Number_of_TLDs_the_Domain_Name_is_Registered=86782, Number_of_Related_Domains_in__com__net__org__biz__info=86782, dropped="2016-03-07 13:25:32.954272", Status='超级欢迎你15')

        if ret_set!=1:
            print ("insert-result: %s" % ret_id)
            print ("data: %s" % ret_get.first())

