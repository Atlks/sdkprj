def tlgrm_sendMsgx(botid_token,chat_id222,text222):
    import telegram

    from telegram import InputMediaPhoto

 
    bot = telegram.Bot(token=botid_token)

    bot.send_message(chat_id=chat_id222, text=text222, parse_mode=telegram.ParseMode.HTML)
def sendMsgx(botid,chat_id222,text222):
    import telegram

    from telegram import InputMediaPhoto

 
    bot = telegram.Bot(token=botid)

    bot.send_message(chat_id=chat_id222, text=text222, parse_mode=telegram.ParseMode.HTML)