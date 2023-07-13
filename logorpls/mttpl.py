#   python d:\aaa\mttpl.py  
# 参数 pic orilogo  newlogo  newpic
#  python d:\aaa\mttpl.py
# pip install opencv-python
from cgi import print_arguments
import cv2 as cv
import numpy as np
from matplotlib import pyplot as plt
# img = cv.imread('d:/aaa/logo.png',0)
oldpic="d:/aaa/oldpic.jpg"
oldlogo="d:/aaa/oldlogo.png"
# newlogo=sys.argv[3]
# newpic=sys.argv[4]
img = cv.imread(oldlogo,0)
img2 = img.copy()
# template = cv.imread('d:/aaa/tmplt.png',0)
template = cv.imread(oldpic,0)
w, h = template.shape[::-1]
# All the 6 methods for comparison in a list
methods = ['cv.TM_CCOEFF_NORMED']
#  TM_CCOEFF, 'cv.TM_CCOEFF_NORMED', 'cv.TM_CCORR',
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

    print (top_left[0])   #top523
    print (top_left[1])   #left408
    # return
    bottom_right = (top_left[0] + w, top_left[1] + h)
    cv.rectangle(img,top_left, bottom_right, 255, 2)
    plt.subplot(121),plt.imshow(res,cmap = 'gray')
    plt.title('Matching Result'), plt.xticks([]), plt.yticks([])
    plt.subplot(122),plt.imshow(img,cmap = 'gray')
    plt.title('Detected Point'), plt.xticks([]), plt.yticks([])
    plt.suptitle(meth)
    plt.show()