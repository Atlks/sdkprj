
import pymysql
def exeSqlQry(sql,conn):
    cursor = conn.cursor()
    # 执行SQL语句
    cursor.execute(sql)
    # 获取所有记录列表
    results = cursor.fetchall()
    return results

def exeSqlUpdt(sql,conn):
    cursor = conn.cursor()
    # 执行SQL语句
    cursor.execute(sql)
    # 获取所有记录列表
    # 提交到数据库执行
    conn.commit()
    return cursor

def uniqueIdx(tab, col, val,conn):
    

    sql = "select * from " + tab + " where " + col + "='" + val + "'";
    rzt = exeSqlQry( sql,conn)
    if ( len(rzt) > 0) :
        # ex = {};
        # ex.sql = sql
        # ex.name = 'uniqueEx';

        raise Exception("抛出一个异常uniqueEx:"+sql)