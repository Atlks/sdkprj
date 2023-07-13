
# cd /d D:\0src\acbo_api\dev\src
# python tlgrm.py


def sendMsgx(botid,chat_id222,text222):
    import telegram

    from telegram import InputMediaPhoto

 
    bot = telegram.Bot(token=botid)

    bot.send_message(chat_id=chat_id222, text=text222, parse_mode=telegram.ParseMode.HTML)

def sendMsg(botid,chat_id222,text222):
    import telegram

    from telegram import InputMediaPhoto





    #chat_id = "-567935287"  #research grp  devgrp


    #token = "5464498785:AAGtLv-M-RKgRoIh5G3XEfkdqkCPiVBB1NA"  # 机器人 TOKEN ati bot

    #bot_token="5178273178:AAE7Ev4HbQa22n9rcrbwZK1_LePgHMXCELI"  #jmb bot

    bot = telegram.Bot(token=botid)



    #发送文本

   # jonbmgrpid="-1001637725289"

   # chat_id222 = "-1001479969649"   #atigrp


    bot.send_message(chat_id=chat_id222, text=text222, parse_mode=telegram.ParseMode.HTML)


bot_token="5178273178:AAE7Ev4HbQa22n9rcrbwZK1_LePgHMXCELI"  #jmb bot  
chat_id222 = "-1001479969649"   #atigrp 
chatid_music='-1001553102139'

jonbmgrpid="-1001637725289"
sendMsg(bot_token,jonbmgrpid,"https://zbm.news/1654250527_2/")
 

//get grpid
https://api.telegram.org/bot5178273178:AAE7Ev4HbQa22n9rcrbwZK1_LePgHMXCELI/getUpdates