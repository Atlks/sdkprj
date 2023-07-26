package testkg;

import org.apache.http.client.methods.CloseableHttpResponse;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.CloseableHttpClient;
import org.apache.http.impl.client.HttpClients;
import org.apache.http.util.EntityUtils;

import java.io.IOException;

public class imclit {
    public static void main(String[] args) throws IOException, InterruptedException {
        while (true) {

            Thread.sleep(20);
            try {


    String content = EntityUtils.toString(HttpClients.createDefault().execute(new HttpGet("http://localhost:8080/rcv")).getEntity(), "UTF-8");


                System.out.println(content);
            } catch (Exception e) {
                e.printStackTrace();
            }


        }
    }
}
