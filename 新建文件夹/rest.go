//  rest

package main

import (
	"fmt"
	"html"
	"log"
	"net/http"
)

func main44() {
	fmt.Println(" start")
	http.HandleFunc("/", func(w http.ResponseWriter, r *http.Request) {
		fmt.Fprintf(w, "Hello, %q", html.EscapeString(r.URL.Path))
	})

	http.HandleFunc("/a", func(w http.ResponseWriter, r *http.Request) {
		fmt.Fprintf(w, "Hello, aaaaa", html.EscapeString(r.URL.Path))
	})
	log.Fatal(http.ListenAndServe(":8080", nil))

	fmt.Println(" serivert ing..")
}
