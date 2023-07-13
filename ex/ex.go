package expkg

import (
	"fmt"
	"html"
	"log"
	"net/http"
)

func main() {

	//---------try catch 1
	defer func() {
		// 获取异常信息
		if err := recover(); err != nil {
			//  输出异常信息
			fmt.Println("error:", err)
		}
	}()

	//---------- try catch 2

	fmt.Println(" serivert ing..")
}
