package testkg;

import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.HttpClients;
import org.apache.http.util.EntityUtils;
import org.joda.time.DateTime;

import java.io.IOException;

public class imtest {

    public static void main(String[] args) throws Exception {
        // http://localhost:8888/reg?uname=ati&pwd=ppp
     //   TmctUtil.setGetM("/reg", regv3(), tomcat, ctx_webapp);

        String host="http://localhost:8888/";

        String url=host+"/reg?uname=ati&pwd=ppp";
        System.out.println(getx(url));


        System.out.println(getx(host+"/login?uname=ati&pwd=ppp" ));


        System.out.println(getx(host+"/addFrd?frd=frd22&uname=ati&pwd=ppp" ));
        System.out.println(getx(host+"/addFrd?frd=frd33&uname=ati&pwd=ppp" ));
        System.out.println(getx(host+"/frdLst?uname=ati&pwd=ppp" ));

        System.out.println(getx(host+"/sendmsgToFrd?frd=frd222&msg=11111msgmsg...&uname=ati&pwd=ppp" ));
        System.out.println(getx(host+"/sendmsgToFrd?frd=frd333&msg=msg2222233333msg...&uname=ati&pwd=ppp" ));
        System.out.println(getx(host+"/showChatMsgWithFrd?frd=frd222&uname=ati&pwd=ppp" ));


    //grp msg
        System.out.println(getx(host+"/sendmsgToGrp?grp=grp111&msg=11111msgmsg...&uname=ati&pwd=ppp" ));
        System.out.println(getx(host+"/sendmsgToGrp?grp=grp111&msg=11111msgmsg...&uname=ati&pwd=ppp" ));
        System.out.println(getx(host+"/showChatMsgFrmGrp?grp=grp111&uname=ati&pwd=ppp" ));



    }

    private static String getx(String url) throws Exception {
        System.out.println("=============================>"+url);
        HttpGet httpGet = new HttpGet(url);

        CloseableHttpResponse resp = HttpClients.createDefault().execute(httpGet);
        return  EntityUtils.toString(resp.getEntity(), "UTF-8");
    }
}
