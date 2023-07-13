# -*- coding: utf-8 -*-

print("establisch Database connection...")
from web import *

#DB_wordpress = database(dbn='mysql', db='wordpress_ttys8_', user='wordpress_ttys8_', host="154.39.238.79", pw='tXtGtH2WH5a7Gjhf')


def create_connection():  
    return database(dbn='postgres', db='db_pcrawler', user='user_pcrawler', host="127.0.0.1", pw='VMAh1bKgoZBziIWphqTEt8pfjEqb6FGqb/qPKILJvlTzO2eTqK9VpC79QHcUH/zm')

DB = database(dbn='sqlite', db='%s/../db_test' % application_path_g)
print("establisch Database connection... done:", DB)
#DB = create_connection()
#print("DB", DB)



