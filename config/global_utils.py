# -*- coding: utf-8 -*-



def convert_to_builtin_type(obj): 
    #print 'default(', repr(obj), ')' # 把Obj对象转换成dict类型的对象
    d = {  }
    if hasattr(obj, "__dict__"):
        d.update(obj.__dict__)
    return d
    

from datetime import datetime
import json

class DateTimeEncoder(json.JSONEncoder):
    def default(self, o):
        if isinstance(o, datetime):
            return o.isoformat()

        return json.JSONEncoder.default(self, o)
        
        
def parseTime(date_date,date_hours):
        '''
        min_hour = int(date_hours[:date_hours.index(":")])       #hour
        date_hours = date_hours[date_hours.index(":")+1:]       
        min_minute = int(date_hours[:date_hours.index(":")])     #minute
        date_hours = date_hours[date_hours.index(":")+1:] 
        min_seconds = int(date_hours[:2])                            #seconds
        date_hours = date_hours[date_hours.index(" ")+1:] 
        min_m_a = date_hours                                    #shangwuxiawu
        if min_m_a=="PM":
            min_hour=min_hour+12
        if min_hour==24:
            min_hour=0
        
        date_date = date_date+" "+date_hours
        
        start = date_date.index(":")-2
        end = date_date.index(":")
        min_hour = int(date_date[start:end])
        min_m_a = date_date[-2:]
        if min_m_a=="PM":
            min_hour=min_hour+12
        if min_hour==24:
            min_hour=0
        '''
        end = date_hours.index(":")
        min_hour = int(date_hours[:end])
        min_m_a = date_hours[-2:].strip()
        if min_m_a=="PM":
            min_hour=min_hour+12
        if min_hour==24:
            min_hour=0
        date_hours = date_date+" "+str(min_hour)+date_hours[end:-3]
        #date_all = datetime.datetime.strptime(date_hours,"%Y-%m-%d %H:%M:%S").date()
        #print min_hour,"---------",date_all,"==============================",end
        return date_hours


