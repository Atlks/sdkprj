// You can edit this code!
// Click here and start typing.
//   /Users/ati/goprj/goprj tsk.php 2
package main

import (
	"fmt"
	"os"
	"os/exec"
	"path/filepath"
	"time"
)

func main() {
	taskfile := os.Args[1]
	sec := os.Args[2]
	fmt.Println(os.Args[1])
	fmt.Println("Hello, 44")
	fmt.Println(os.Executable())
	//  /Users/ati/goprj/goprj tsk.php 2
	ex, _ := os.Executable()
	fmt.Println(ex)

	curdir := filepath.Dir(ex)
	fmt.Println("cur dir::" + curdir)
	//   /Users/ati/goprj/    /Applications/MxSrvs/bin/php/bin/
	//	cmd := exec.Command("php", "tsk.php")
	//cmd := exec.Command("php", "--version")

	for {
		cmd := exec.Command("php", taskfile)
		cmd.Dir = curdir
		stdoutStderr, err := cmd.CombinedOutput()
		if err != nil {
			fmt.Println(err.Error())

		}
		fmt.Printf("getoup::%s\n", stdoutStderr)
		timedural, _ := time.ParseDuration(sec + "s")
		time.Sleep(timedural)
		//selp  secs
		fmt.Println("..task finish...")

	}

}
