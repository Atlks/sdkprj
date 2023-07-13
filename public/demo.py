#!/usr/bin/env python
# -*- coding: utf-8 -*-
import hashlib
import json
import requests
import json

merchat_sn = "1"
outer_order_sn = "100000000"
sign = hashlib.md5( merchat_sn + "&"+outer_order_sn+  "&"+"e10adc3949ba59abbe56e057f20f883e").hexdigest().upper()

parameter = {"merchant_sn":merchat_sn,"money":1.01,"callback":"http://127.0.0.1:8000","outer_order_sn":outer_order_sn,"channel_code": "wechat","sign":sign}
parameter = json.dumps(parameter).encode(encoding='utf-8')

header_info = {'User-Agent': 'Mozilla/5.0 (Windows NT 6.1; Trident/7.0; rv:11.0) like Gecko',"Content-Type": "application/json"}
url = "http://www.pay915.com/public/getPayWay.php"


#parameter = {"order_sn":"201912111415193850043831"}
#parameter = json.dumps(parameter).encode(encoding='utf-8')
#url = "http://www.pay915.com/public/queryOrder.php"
response = requests.post(url=url, data=parameter, headers=header_info)
print( response.text)



