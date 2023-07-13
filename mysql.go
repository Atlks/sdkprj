// mysql
//  go get -u github.com/go-sql-driver/mysql

package main

// "encoding/json"
import (
	"database/sql"

	"fmt"
	"strconv"

	_ "github.com/Go-SQL-Driver/MySQL"
)

//Db数据库连接池
var DB *sql.DB

func main() {
	//连接至数据库

	// sql.Open()中的数据库连接串格式为："用户名:密码@tcp(IP:端口)/数据库?charset=utf8"。
	db, _ := sql.Open("mysql", "root:kdf2016@tcp(10.0.1.13:3306)/cp")

	//Query(db)
	insert(db)
	//关闭数据库连接
	db.Close()
}

//查询操作
func Query(db *sql.DB) {

	rows, _ := db.Query("select name from mysql.help_topic where name >'a' limit 3  ")

	//cols, _ := rows.Columns()

	for rows.Next() {

		var name string
		rows.Scan(&name)
		fmt.Println(name)
		fmt.Println(777)
		//fmt.Println(json.Marshal()

	}

}

//插入demo
func insert(db *sql.DB) {
	//准备插入操作
	//

	for i := 0; i <= 10; i++ {

		func() {

			//  处理异常的函数 same   befFunExit()
			defer func() {
				fmt.Println("开始处理异常")
				// 获取异常信息
				err := recover()
				if err != nil {

					fmt.Println("error:", err)
				}
				fmt.Println("结束异常处理")
			}()
			//	sql := "drop  database db" + strconv.Itoa(i)
			//			sql := "create database db" + strconv.Itoa(i)
			sql := "insert logx set log=9999" + strconv.Itoa(i)
			res, _ := db.Exec(sql)

			num, _ := res.RowsAffected()

			fmt.Println(num) //1  if creted database ok ..

		}()

	}

}

//dep
func insertOne(db *sql.DB, i int) {

	//  处理异常的函数 same   befFunExit()
	defer func() {
		fmt.Println("开始处理异常")
		// 获取异常信息
		if err := recover(); err != nil {
			//  输出异常信息
			fmt.Println("error:", err)
		}
		fmt.Println("结束异常处理")
	}()
	sql := "drop  database db" + strconv.Itoa(i)
	//	sql := "create database db" + strconv.Itoa(i)
	res, _ := db.Exec(sql)

	//	CheckErr(err)
	//查询删除多少条信息
	// if(res)
	// {
	num, _ := res.RowsAffected()
	//	CheckErr(err)
	fmt.Println(num) //1  if creted database ok ..
	//	}

}
