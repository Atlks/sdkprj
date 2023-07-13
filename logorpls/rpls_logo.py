#   python d:\aaa\rpls_logo.py  "d:/aaa/oldpic.jpg" "d:/aaa/oldlogo.png"  "d:/aaa/newlogo.png"   "d:/aaa/newpic.png" 
# python d:\aaa\rpls_logo.py  "d:/aaa/qr.png" "d:/aaa/oldlogo.png"  "d:/aaa/newlogo.png"   "d:/aaa/newpic.png" 
# 参数 oldpic orilogo  newlogo  newpic
#  python d:\aaa\mttpl.py
# pip install opencv-python

import cv2 as cv
import sys
from cgi import print_arguments
import shutil


import numpy as np
from matplotlib import pyplot as plt
from PIL import Image, ImageDraw, ImageFont
def add_mark(im,mark,top,lft,newpic):
    layer = Image.new('RGBA', im.size, (0, 0, 0, 0))
    layer.paste(mark, ( top-70,lft-30))
    out = Image.composite(layer, im, layer)
    out.save(newpic,'png')
    out.show()
    return 0
def add_mark_no_offset(im,mark,top,lft,newpic):
    layer = Image.new('RGBA', im.size, (0, 0, 0, 0))
    print('tp:'+str(top))
    print('lft:'+str(lft));
    layer.paste(mark, ( top,lft))
    out = Image.composite(layer, im, layer)
    out.save(newpic,'png')
    out.show()
    return 0    


print(sys.argv[0])  #xxx.py path
print(sys.argv[1])   # true first param
oldpic=sys.argv[1]
oldlogo=sys.argv[2]
newlogo=sys.argv[3]
newpic=sys.argv[4]

##---------------二维码判断 如果二维码白色填充
import cv2 as cv
img = cv.imread(oldpic)
 
# initialize the cv2 QRCode detector
detector = cv.QRCodeDetector()

#We have the image and the detector, let’s detect and decode that data:

# detect and decode
data, bbox, straight_qrcode = detector.detectAndDecode(img)
print(data)
if data :
    print(9999)
    # ---------------使用Numpy创建一张A4(2105×1487)纸
    img99 = np.zeros((100,100,3), np.uint8)
    # 使用白色填充图片区域,默认为黑色
    img99.fill(255)
    cv.imwrite('wht.jpg',img99)
    shutil.copyfile("wht.jpg", newpic)
    quit()
else:
   print(000)

## 创建空白图案






##-------------查找位置logo
# img = cv.imread('d:/aaa/logo.png',0)
img = cv.imread(oldlogo,0)
img2 = img.copy()
# template = cv.imread('d:/aaa/tmplt.png',0)
template = cv.imread(oldpic,0)
w, h = template.shape[::-1]
# All the 6 methods for comparison in a list
methods = ['cv.TM_CCOEFF_NORMED']
#, 'cv.TM_CCOEFF_NORMED', 'cv.TM_CCORR',
#            'cv.TM_CCORR_NORMED', 'cv.TM_SQDIFF', 'cv.TM_SQDIFF_NORMED']
for meth in methods:
    img = img2.copy()
    method = eval(meth)
    # Apply template Matching
    res = cv.matchTemplate(img,template,method)
    min_val, max_val, min_loc, max_loc = cv.minMaxLoc(res)

    print( min_val,max_val,min_loc,max_loc,sep='@@@')
    ##  -5034617.0@@@7008610.0@@@(29, 65)@@@(0, 37)
    # if jonbenmao  @@@(514, 367)@@@(523, 408)
    # If the method is TM_SQDIFF or TM_SQDIFF_NORMED, take minimum
    if method in [cv.TM_SQDIFF, cv.TM_SQDIFF_NORMED]:
        top_left = min_loc
    else:
        top_left = max_loc

    print (top_left[0])   #lft
    print (top_left[1])   #top
    lft=top_left[0]
    tp=top_left[1]
    # return
    # bottom_right = (top_left[0] + w, top_left[1] + h)
    # cv.rectangle(img,top_left, bottom_right, 255, 2)
    # plt.subplot(121),plt.imshow(res,cmap = 'gray')
    # plt.title('Matching Result'), plt.xticks([]), plt.yticks([])
    # plt.subplot(122),plt.imshow(img,cmap = 'gray')
    # plt.title('Detected Point'), plt.xticks([]), plt.yticks([])
    # plt.suptitle(meth)
    # plt.show()
  
image = Image.open(oldpic)
mark = Image.open(newlogo)  #mark



##--------------生成模糊后的logo贴纸
src = cv.imread(oldlogo)
#第二个参数：高斯核的宽和高（建议是奇数）
#第三个参数：x和y轴的标准差
result=cv.GaussianBlur(src,(15,15),5)
cv.imwrite(oldlogo+'.blur.jpg',result)

#---- 合成logo模糊与原图片
blurlogo= oldlogo+'.blur.jpg' 
# d:/aaa/oldlogo.png.blur.jpg
print(blurlogo)
mark_blurlogo = Image.open(blurlogo) 
add_mark_no_offset(image,mark_blurlogo,lft,tp,oldpic+'.addblurlogo.jpg')

#====== 与新logo合成
image = Image.open(oldpic+'.addblurlogo.jpg')
add_mark(image,mark,lft,tp,newpic)
   



#if __name__ == '__main__':
   