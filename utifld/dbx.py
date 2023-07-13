
def query_fetchall(db,sql):
    import sqlite3
    import os
    import sys

    # conn = sqlite3.connect('%s/../db_test')
    print(os.getcwd())
    print(sys.path[0])
    conn = sqlite3.connect(sys.path[0]+'/../db_test')
    #D:\0src\acbo_api\dev\src main scrpt  boot path

    print ("数据库打开成功")
    c = conn.cursor()
    print ("数据库打开成功")

    cursor = c.execute(sql)
    results = cursor.fetchall()
    # print(results)
    print('000000000000000000000000000')
    # for item in results:
    #     print(item)

    print(cursor)
    num_fields = len(cursor.description)
    field_names = [i[0] for i in cursor.description]
    
    print(field_names)
    return results,field_names
def updt(db,sql):
    import sqlite3
    import os
    import sys

    # conn = sqlite3.connect('%s/../db_test')
    print(os.getcwd())
    print(sys.path[0])
    conn = sqlite3.connect(sys.path[0]+'/../db_test')
    #D:\0src\acbo_api\dev\src main scrpt  boot path

    print ("数据库打开成功")
    c = conn.cursor()
    print ("数据库打开成功")

    cursor = c.execute(sql)
    conn.commit()
    print('---db exe rzt::')
    print(cursor)
    return cursor;
def query(db,sql):
    import sqlite3
    import os
    import sys

    # conn = sqlite3.connect('%s/../db_test')
    print(os.getcwd())
    print(sys.path[0])
    conn = sqlite3.connect(sys.path[0]+'/../db_test')
    #D:\0src\acbo_api\dev\src main scrpt  boot path

    print ("数据库打开成功")
    c = conn.cursor()
    print ("数据库打开成功")

    cursor = c.execute(sql)
    results = cursor.fetchall()
    # print(results)
    print('000000000000000000000000000')
    # for item in results:
    #     print(item)

    print(cursor)
    num_fields = len(cursor.description)
    field_names = [i[0] for i in cursor.description]
    
    print(field_names)
    return results,field_names