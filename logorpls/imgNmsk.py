
# python d:\aaa\imgNmsk.py

from PIL import Image, ImageDraw, ImageFont

def add_num(im,mark):
    layer = Image.new('RGBA', im.size, (0, 0, 0, 0))
    layer.paste(mark, (im.size[0]-350 , im.size[1]-150 ))
    out = Image.composite(layer, im, layer)
    out.save('d:/aaa/result.png','png')
    out.show()
    return 0

if __name__ == '__main__':
    image = Image.open('d:/aaa/bg.jpg')
    mark = Image.open('d:/aaa/256x88.png')  #mark
    add_num(image,mark)