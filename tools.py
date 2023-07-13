# 生成ID   
import urllib.request
import requests
class SysTool:
    def __init__(self):
        self.getKey_url = "http://112.121.163.125:9600/movie/player/submovie/getWorkId"
        self.headers = {
            'Content-Type':'application/json;charset=UTF-8',
            'Cookie': 'td_cookie=2588452474; JSESSIONID=7A2E2EBDAB5976B7E623CC872ABA9972'
        }

    def generate_id(self):
        response = requests.get(self.getKey_url, headers=self.headers, verify=False)
        return int(response.text.replace('"', ''))

 
sTools = SysTool()

def generate_id():


      movie_id = sTools.generate_id()
      return movie_id