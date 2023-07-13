# -*- coding: utf-8 -*-

"""
Created on 2018-02-24 12:02:24.839872

@author: dev

Datei: src/paymentgateway/settings/options_user

"""

"""
TODO    
"""


from config import *


class html():
    
    
    def GET(self, msg=""):
        
        
        limit=100
        
        page=getdata("page", 1, val_type=int)
        order=getdata("order", None)
        
        user_id = 0
        db_option_user = db.option_user()
          
        condition_search="user_id=%s OR user_id IS NULL" % user_id
        
        count=0
        total=0
        pages=0
        
            
        data=db_option_user.get(
            #user_id=user_id,
            offset=(page-1)*limit, 
            limit=limit,
            _condition=condition_search,
            order=order,
            join="   table_option ON table_option.id = table_option_user.id"
            )
        
        if data == -1:
            print("### DB Error")
        
        count=db_option_user.get_count(
            #user_id=user_id,
            _condition=condition_search
            )
            
        print('@@@@@')
        print(str(count))  ##0
        total=db_option_user.count()

        

        pages = pages_calc_count(count, limit) or 0     #计算总的页数
            
        
        
        return render(data=data, pages=pages, page=page, order=order, msg=msg)
  
  
    def POST(self):
        user_id = 0
        
        msg = ""
        
        data_option_user = db.option_user()

        input=getdata(None)
        print ("option input: %s" % input)
        
        action = input.get("action", None)
        
        if action:
            if  (action == "create" or action == "save"):
                if not input.id:
                    print("# ERROR no id", input)
                else:
                    ret=data_option_user.set(condition_id=input.id, condition_user_id=user_id, value=input.value, content=input.content, status=input.status, )
                    print("data_option_user.set:", ret)
    
    
            elif action == "test":
                print("options_user: test...")            
                test_data=Storage({'orderTime': u'20180227052952', 
                                   #'payKey': u'fca47079348142a6a6ec08fb5d05c887',
                                   'sign': u'EBE886C24ADA990B67061833B30D2833', 'orderPrice': u'0.50', 'productName' : u'test', 'outTradeNo': u'p105000010302018022705295', 'successTime': u'20180226133133', 'productType': u'1', 'trxNo': u'P77772018022612228691', 'tradeStatus': u'SUCCESS',
                                   "merchant_id" : 1
                                   })
                target_url=input.content
                stat=0; output=""
                #stat, output=self._test(target_url=target_url, post_data=test_data)
                msg="回调函数的测试结果：<br><table><tr><td><B>target_url</B><td><B> : </B><td> %s<tr><td><B>return code</B><td><B> : </B><td> %s<br>\n" % (target_url, stat)
                    
                if output == None:
                    msg+="<tr><td><B>return data</B><td><B> : </B><td> 无"
                else:
                    if isinstance(output, bytes):
                        output=output.decode("utf-8")
                    msg+="<tr><td><B>return data</B><td><B> : </B><td>%s" % (output)
                
                msg+="</table>"
                
        return self.GET(msg=msg)
    
    
    def _test(self, target_url="127.0.0.1:8080", post_data=None):
        
        
        stat, output = read_url(target_url, post_data)
        
        return stat, output
    
        import pycurl
        try:
            from StringIO import StringIO
        except:
            from io import StringIO
        try:
            # python 3
            from urllib.parse import urlencode
        except ImportError:
            # python 2
            from urllib import urlencode
        
    
           
        origin="http://adalpay.com/"
        referr=web.ctx.get("env", {}).get('HTTP_REFERER', "")#.replace(web.ctx.environ['SERVER_NAME'], "adaloay.com")
        
        try:
            if post_data and len(post_data) > 1:
                post_data=urlencode(post_data)
        except:
            pass
        
        
        buffer = StringIO()
        cookies = StringIO()
        headers = StringIO()
        c = pycurl.Curl()
        try:
            c.setopt(c.WRITEFUNCTION, buffer.write)
        except:
           c.setopt(c.WRITEDATA, buffer)
        c.setopt(c.URL, target_url)            
        c.setopt(pycurl.HTTPHEADER, 		[#'Cookie: %s' % cookie_data, 
                                                'origin: %s' % origin, "User-Agent: %s" % web.ctx.get("environ", {}).get('HTTP_USER_AGENT', ""), 'Referer: %s' % referr, 
                                                #xrequest
                                            ])
        c.setopt(c.FOLLOWLOCATION, True)
        #c.setopt(pycurl.COOKIEJAR, tmp_cookie_file)
        if post_data: c.setopt(c.POSTFIELDS, post_data)
        ret=c.perform()
        c.close()
        
        print ("\n@curl-ret:", ret)

        
        
        return self.POST()


#html()._test()
#sys.exit(0)
