package testkg;

import com.alibaba.fastjson.JSONObject;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import redis.clients.jedis.Jedis;

public class rdssTst {

    public static void main(String[] args) {

        Logger logger = LoggerFactory.getLogger(rdssTst.class);
        String txt="'aaaaaaaaaaaaaaaaaaaaaaaaadkjflkdsjfklasjfkld jfkdsajfkldsjfkldsjafklsdjafkljadkslfjdkl'";
        //连接本地的 Redis 服务
        Jedis jedis = new Jedis("localhost");
        // 如果 Redis 服务设置了密码，需要下面这行，没有就不需要
        jedis.auth("");
        System.out.println("连接成功");
        //查看服务是否运行
        System.out.println("服务正在运行: " + jedis.ping());

        System.out.println(jedis.get("fgfkkk"));


        logger.info("=============start.....");
        for (int n = 0; n <90000; n++) {

            try {
                jedis.lpush("msgx",txt) ;
            } catch (Throwable e) {
                System.out.println(e);
            }

        }

        logger.info("===================end.....");


    }
}
