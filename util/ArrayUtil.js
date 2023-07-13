/**
 * Created by Administrator on 2017/6/1.
 *
 *
 * D:\0workspace\atiplat_eeJS\com.attilax\util\ArrayUtil.js
 */

function concat(urls2,urls_tmp)
{
    for( u of urls_tmp)
    {
        urls2.push(u);
    }
    return urls2;

}

exports.concat = concat;

function sortRandom(arr)
{
	var arr2=[];
	arr2 =arr2.concat(arr);
	//for(a of arr)
	
  //  var arr=[];
  //  for(var i=0;i<100;i++){
  //          arr[i]=i;
  //      }
    arr2.sort(function(){ return 0.5 - Math.random() })
return arr2;	
}