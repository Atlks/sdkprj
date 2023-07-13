import cv2
# read the QRCODE image
#  python d:\aaa\qr.py 
#img = cv2.imread("d:/aaa/qr.png")
img = cv2.imread("d:/aaa/oldlogo.png")
 
# initialize the cv2 QRCode detector
detector = cv2.QRCodeDetector()

#We have the image and the detector, let’s detect and decode that data:

# detect and decode
data, bbox, straight_qrcode = detector.detectAndDecode(img)
print(data)
if data :
    print(000)
else:
    print(111)
