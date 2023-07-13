/**
 * Created by Administrator on 2017/1/15.
 */

BinaryArrayFromImage("C:\ati\pic_info\#1143434.JPG",100,100);
function BinaryArrayFromImage(imagePath, width, height)
{
    var cv = require('../opencv/lib/opencv');
    cv.readImage(imagePath, function(err, im) {
        if (err) throw err;
        var w = im.width();
        var h = im.height();
        if (w < 1 || h < 1) throw new Error('Image has no size');

        var binaryImage = im.threshold(200, 255, "Binary");
        console.log("image converted to binary image");

        binaryImage.resize(width,height);

        //  binaryImage.convertGrayscale();
        console.log(binaryImage.channels());

        var imageMatrix = new Array();

        for(i=0;i<height;i++)
        {
            imageMatrix[i] = new Array();
            var index = 0;
            for(j=0;j<width*3;j+=3)
            {
                if(binaryImage.pixelRow(i)[j]<100)
                {
                    imageMatrix[i][index]=1;
                }
                else
                {
                    imageMatrix[i][index]=0;
                }
                index++;
            }

        }
        binaryImage.save('./convertedImage.jpg');

        return imageMatrix;
    });
}