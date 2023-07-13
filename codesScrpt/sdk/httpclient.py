#sdk.httpclient.getUrl()

import urllib.request
def getUrl(url):
        #网址
  
    
    #请求
    request = urllib.request.Request(url)
    
    #爬取结果
    response = urllib.request.urlopen(request)
    
    data = response.read()
    
    #设置解码方式
    data = data.decode('utf-8')
    
    #打印结果
    #print(data)
    
    #打印爬取网页的各类信息


    
    
    print("----------------\r\n\r\n\n\n\n")
    return data
    # print(type(response))
    # print(response.geturl())
    # print(response.info())
    # print(response.getcode())