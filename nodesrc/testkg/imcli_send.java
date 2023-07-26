package testkg;
import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.impl.client.HttpClients;
import org.apache.http.util.EntityUtils;
import org.joda.time.DateTime;

import java.io.IOException;
public class imcli_send {


    public static void main(String[] args) throws IOException, InterruptedException {
        while (true) {

            Thread.sleep(3000);
            try {


                String content = EntityUtils.toString(HttpClients.createDefault().execute(new HttpGet("http://localhost:8080/sendmsg?msg="+new DateTime())).getEntity(), "UTF-8");


                System.out.println("========>lst len:"+content);
            } catch (Exception e) {
                e.printStackTrace();
            }


        }
    }


}
