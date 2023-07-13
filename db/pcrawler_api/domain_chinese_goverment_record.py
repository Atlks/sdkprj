# -*- coding: utf-8 -*-

from config import *

class domain_chinese_goverment_record(db_check):


    """
        \param id **bigint**
        \param domain **text**
        \param unit_name **text**
        \param unit_type **text**
        \param company_domain **character(1)**
        \param registration_number **text**
        \param audit_datetime **text**
    """

    cache = list() #cache content of table

    _table_name='table_domain_chinese_goverment_record'
    _table_keys = ['id', 'domain', 'unit_name', 'unit_type', 'company_domain', 'registration_number', 'audit_datetime']
    _table_Struktur = {'id' : 'bigint', 'domain' : 'text', 'unit_name' : 'text', 'unit_type' : 'text', 'company_domain' : 'character(1)', 'registration_number' : 'text', 'audit_datetime' : 'text'}
    _table_Kommentar = {"table_domain_chinese_goverment_record" : "", "id" : "", "domain" : "", "unit_name" : "", "unit_type" : "", "company_domain" : "", "registration_number" : "", "audit_datetime" : "", };
    _table_atributes = {'domain': 'UNIQUE'};
    _table_default_values = {"id" : "nextval('table_domain_chinese_goverment_record_id_seq'::regclass)", };
    

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


    def add(self, unit_name=None, domain=None, unit_type=None, company_domain=None, registration_number=None, audit_datetime=None):
        """
        插入数据的方法
        """
    
        return self.DB_connection.insert(self._table_name, 'table_domain_chinese_goverment_record_id_seq', _parent_self=self, unit_name=unit_name, domain=domain, unit_type=unit_type, company_domain=company_domain, registration_number=registration_number, audit_datetime=audit_datetime)


    def set(self, id=None, condition_unit_name=None, operation="", unit_name=None, domain=None, unit_type=None, company_domain=None, registration_number=None, audit_datetime=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "unit_name", condition_unit_name, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, domain=domain, unit_type=unit_type, company_domain=company_domain, registration_number=registration_number, audit_datetime=audit_datetime, id=id, unit_name=unit_name, _condition=_condition, _parent_self=self)
        else:
            ret=None
        if not ret:
            if unit_name==None:
                unit_name=condition_unit_name
            ret=self.add(unit_name, domain, unit_type, company_domain, registration_number, audit_datetime)
        return ret


    def update(self, id=None, condition_unit_name=None, operation="", unit_name=None, domain=None, unit_type=None, company_domain=None, registration_number=None, audit_datetime=None,  _condition=""):
        where=""
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "unit_name", condition_unit_name, _parent_self=self)

        if where or _condition:
            ret = self.DB_connection.update1(self._table_name, where, operation, domain=domain, unit_type=unit_type, company_domain=company_domain, registration_number=registration_number, audit_datetime=audit_datetime, id=id, unit_name=unit_name, _condition=_condition, _parent_self=self)
        else:
            ret=None
        return ret


    def get(self, unit_name=None, id=None, domain=None, unit_type=None, company_domain=None, registration_number=None, audit_datetime=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_unit_type=None, _max_unit_type=None, _lower_unit_type=None, _greater_unit_type=None, _min_company_domain=None, _max_company_domain=None, _lower_company_domain=None, _greater_company_domain=None, _min_registration_number=None, _max_registration_number=None, _lower_registration_number=None, _greater_registration_number=None, _min_audit_datetime=None, _max_audit_datetime=None, _lower_audit_datetime=None, _greater_audit_datetime=None,  what=None, join=None, _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        \param id **bigint**
        \param domain **text**
        \param unit_name **text**
        \param unit_type **text**
        \param company_domain **character(1)**
        \param registration_number **text**
        \param audit_datetime **text**
        """
        
        return self.DB_connection.select1([self._table_name], id=id, domain=domain, unit_name=unit_name, unit_type=unit_type, company_domain=company_domain, registration_number=registration_number, audit_datetime=audit_datetime, order=order, limit=limit, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

    def get_count(self, unit_name=None, id=None, domain=None, unit_type=None, company_domain=None, registration_number=None, audit_datetime=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_unit_type=None, _max_unit_type=None, _lower_unit_type=None, _greater_unit_type=None, _min_company_domain=None, _max_company_domain=None, _lower_company_domain=None, _greater_company_domain=None, _min_registration_number=None, _max_registration_number=None, _lower_registration_number=None, _greater_registration_number=None, _min_audit_datetime=None, _max_audit_datetime=None, _lower_audit_datetime=None, _greater_audit_datetime=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量

        """
        
        ret = self.DB_connection.select1_count([self._table_name], id=id, domain=domain, unit_name=unit_name, unit_type=unit_type, company_domain=company_domain, registration_number=registration_number, audit_datetime=audit_datetime, order=order, limit=limit,  join=join, _condition=_condition, _parent_self=self)

        if ret and ret != -1 and offset:
           ret=ret-offset

        return ret
    def get_first(self, unit_name=None, id=None, domain=None, unit_type=None, company_domain=None, registration_number=None, audit_datetime=None, order=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_unit_type=None, _max_unit_type=None, _lower_unit_type=None, _greater_unit_type=None, _min_company_domain=None, _max_company_domain=None, _lower_company_domain=None, _greater_company_domain=None, _min_registration_number=None, _max_registration_number=None, _lower_registration_number=None, _greater_registration_number=None, _min_audit_datetime=None, _max_audit_datetime=None, _lower_audit_datetime=None, _greater_audit_datetime=None,  what=None,  join=None, _condition=""):
        """
        获取第一个参数满足条件的情况下的数据列。
        \return -1 database error, 0 no data or util.Storages        """
        
        ret=self.DB_connection.select1([self._table_name], id=id, domain=domain, unit_name=unit_name, unit_type=unit_type, company_domain=company_domain, registration_number=registration_number, audit_datetime=audit_datetime, order=order, limit=1, offset=offset, what=what, join=join, _condition=_condition, _parent_self=self)

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

    def search(self, unit_name=None, id=None, domain=None, unit_type=None, company_domain=None, registration_number=None, audit_datetime=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_unit_type=None, _max_unit_type=None, _lower_unit_type=None, _greater_unit_type=None, _min_company_domain=None, _max_company_domain=None, _lower_company_domain=None, _greater_company_domain=None, _min_registration_number=None, _max_registration_number=None, _lower_registration_number=None, _greater_registration_number=None, _min_audit_datetime=None, _max_audit_datetime=None, _lower_audit_datetime=None, _greater_audit_datetime=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        return self.DB_connection.select1([self._table_name], id=id, domain=domain, unit_name=unit_name, unit_type=unit_type, company_domain=company_domain, registration_number=registration_number, audit_datetime=audit_datetime, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def search_first(self, unit_name=None, id=None, domain=None, unit_type=None, company_domain=None, registration_number=None, audit_datetime=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_unit_type=None, _max_unit_type=None, _lower_unit_type=None, _greater_unit_type=None, _min_company_domain=None, _max_company_domain=None, _lower_company_domain=None, _greater_company_domain=None, _min_registration_number=None, _max_registration_number=None, _lower_registration_number=None, _greater_registration_number=None, _min_audit_datetime=None, _max_audit_datetime=None, _lower_audit_datetime=None, _greater_audit_datetime=None,  join=None, _condition=""):
        """
        获取至少一个参数满足条件的情况下的数据
        """
        
        ret = self.DB_connection.select1([self._table_name], id=id, domain=domain, unit_name=unit_name, unit_type=unit_type, company_domain=company_domain, registration_number=registration_number, audit_datetime=audit_datetime, order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

        if ret and ret != -1:
           ret=ret.first()
        else:
            ret=0
        return ret


    def search_count(self, unit_name=None, id=None, domain=None, unit_type=None, company_domain=None, registration_number=None, audit_datetime=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_unit_type=None, _max_unit_type=None, _lower_unit_type=None, _greater_unit_type=None, _min_company_domain=None, _max_company_domain=None, _lower_company_domain=None, _greater_company_domain=None, _min_registration_number=None, _max_registration_number=None, _lower_registration_number=None, _greater_registration_number=None, _min_audit_datetime=None, _max_audit_datetime=None, _lower_audit_datetime=None, _greater_audit_datetime=None,  join=None, _condition=""):
        """
        根据搜索条件获取本数据库表的信息数量
        """
        
        return self.DB_connection.select1_count([self._table_name], order=order, limit=limit, offset=offset, _condition=_condition, join=join, condition_operation=" OR ", _parent_self=self)

    def delete(self, id=None, unit_name=None, domain=None, unit_type=None, company_domain=None, registration_number=None, audit_datetime=None, where=""):
        
        
        where=self.DB_connection.condition_and(where, "id", id, _parent_self=self)
        where=self.DB_connection.condition_and(where, "unit_name", unit_name, _parent_self=self)

        return self.DB_connection.delete(self._table_name, where)

    def current_index(self):
        ret = ret = self.DB_connection.current_index(tablename=self._table_name, seqname="%s_id_seq" % self._table_name)
        
        return ret

    def clauses_set(self, unit_name=None, id=None, domain=None, unit_type=None, company_domain=None, registration_number=None, audit_datetime=None, order=None, limit=None, offset=None, _min_domain=None, _max_domain=None, _lower_domain=None, _greater_domain=None, _min_unit_type=None, _max_unit_type=None, _lower_unit_type=None, _greater_unit_type=None, _min_company_domain=None, _max_company_domain=None, _lower_company_domain=None, _greater_company_domain=None, _min_registration_number=None, _max_registration_number=None, _lower_registration_number=None, _greater_registration_number=None, _min_audit_datetime=None, _max_audit_datetime=None, _lower_audit_datetime=None, _greater_audit_datetime=None,  join="", _condition=""):
        """
        获取所有的参数满足条件的情况下的数据
        """
        
        self._sql_clauses = self.DB_connection.select1([self._table_name], order=order, limit=limit, offset=offset, join=join, _condition=_condition, _test=2, _parent_self=self)

        return self._sql_clauses

    def _test(self):
        
        ret_del=self.delete(id=79860, unit_name=7777, domain='超级欢迎你1', unit_type='超级欢迎你2', company_domain=86782, registration_number='超级欢迎你4', audit_datetime='超级欢迎你5')

        ret_id=self.add(unit_name=7777, domain='超级欢迎你1', unit_type='超级欢迎你2', company_domain=86782, registration_number='超级欢迎你4', audit_datetime='超级欢迎你5')
        ret_get=self.get(unit_name=7777, domain='超级欢迎你1', unit_type='超级欢迎你2', company_domain=86782, registration_number='超级欢迎你4', audit_datetime='超级欢迎你5')

        ret_set=self.set(ret_id, operation="",domain='超级欢迎你1', unit_type='超级欢迎你2', company_domain=86782, registration_number='超级欢迎你4', audit_datetime='超级欢迎你5')

        ret_del=self.delete(ret_id, domain='超级欢迎你1', unit_type='超级欢迎你2', company_domain=86782, registration_number='超级欢迎你4', audit_datetime='超级欢迎你5')

        if ret_set!=1:
            print ("insert-result: %s" % ret_id)
            print ("data: %s" % ret_get.first())

