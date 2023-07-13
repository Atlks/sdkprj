
# python tlg.py
import pyautogui
import time
print(pyautogui.position())   # 当前鼠标 x， y坐标
pyautogui.moveTo(131, 1057  ) 
time.sleep(1)
pyautogui.click(131, 1057)
time.sleep(1)
pyautogui.click(889, 1000)    #active input txt
print("1111")
time.sleep(1)
pyautogui.write('test send\n')  # 用于输入文本，回车换行l
time.sleep(1)
pyautogui.write('https://zbm.news/1654255458_1/\n') 
pyautogui.write('https://zbm.news/1654250527_2/\n') 
 
 