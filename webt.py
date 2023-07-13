#python.exe  D:\0src_cms\acbo_api\dev\src\webc.py
# dft is auto load..if mdyfy file..url file...can auto load..

import web

urls = (
    '/', 'index',
     "/tasks", "tasksCls",
)

class index:
    def GET(self):
        return "Hello, world!"

class tasksCls:
    def GET(self):
        return "Hello, tasksCls!"

if __name__ == "__main__":
    app = web.application(urls, globals())
    app.run()