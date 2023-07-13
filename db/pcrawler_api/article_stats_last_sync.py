from config import *


from .article_stats import article_stats 

class article_stats_last_sync(article_stats):
    cache = list()
    _table_name = 'table_article_stats_last_sync'
