"""
Quelldatei zur API Schnittstelle

Created on 2022-03-26 17:23:46.363437

@author: dev@debian

Datei: src/api/pay

"""
from config import *
import moneropay.pay

class api:

    def POST(self):
        web.header("Access-Control-Allow-Origin", "*")
        web.header("Access-Control-Allow-Credentials", "true")
        web.header("Content-Type", "text/html; charset=utf-8", unique=True)
        print("POST:", getdata(None))
        status = 0
        msg = ""
        ret_data = {}
        user_id = cookie("user_id")
        action = getdata("action")
        payment_amount = getdata("payment_amount", val_type=int)
        if not user_id:
            ret_data.update(dict(error_msg="Please login first, before you pay."))
            status = -1131
        else:
            pass
        if not payment_amount:
            ret_data.update(dict(error_msg="No amount entered. Please enter amount."))
            status = -666
        else:
            if action == "get":
                pass
            data = moneropay.pay.html().create_transaction(currency=0, amount=payment_amount, order_id=user_id, db_module=db)
            print("data:", data)
            if data[0] != -1 and data[1]:
                ret_data.update(dict(data=data))
            else:
                if not data[1]:
                    ret_data.update(dict(error_msg="Can not create Wallet. Please contact the Sysadmin."))
                    status = -6667
        ret_data.update({"status":status,  "msg":msg})
        print("ret_data:", ret_data)
        return ret_data

    def _test(self):
        print("[src/api/pay] index:_test()")
        ctx.data = Storage({"action":"get",  "money_min":1,  "money_max":30})
        return self.POST()
