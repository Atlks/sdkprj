
#  cd /d D:\0src\acbo_api\dev\src
#  python.exe  D:\0src\acbo_api\dev\src\main.py
 

import sqlite3
import os
import sys

# conn = sqlite3.connect('%s/../db_test')
print(os.getcwd())
print(sys.path[0])
conn = sqlite3.connect(sys.path[0]+'/../db_test')

print ("数据库打开成功")
c = conn.cursor()
print ("数据库打开成功")

cursor = c.execute("SELECT * from table_option_user")
results = cursor.fetchall()
# print(results)
print('000000000000000000000000000')
# for item in results:
#     print(item)

print(cursor)
num_fields = len(cursor.description)
field_names = [i[0] for i in cursor.description]
  
print(field_names)
 

for item in results:
    print(item[field_names.index('id')])
    print(item[field_names.index('status')])
    print('--------------')  
# for row in cursor:
#    print "ID = ", row[0]
#    print "NAME = ", row[1]
#    print "ADDRESS = ", row[2]
#    print "SALARY = ", row[3], "\n"

print ("数据操作成功")
conn.close()