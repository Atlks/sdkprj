package testkg;

import com.alibaba.fastjson.JSONObject;
import com.google.common.collect.Maps;
import io.netty.bootstrap.Bootstrap;
import io.netty.buffer.ByteBuf;
import io.netty.channel.ChannelHandlerContext;
import io.netty.channel.ChannelInboundHandlerAdapter;
import io.netty.channel.ChannelInitializer;
import io.netty.channel.nio.NioEventLoopGroup;
import io.netty.channel.socket.SocketChannel;
import io.netty.channel.socket.nio.NioSocketChannel;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import java.nio.charset.Charset;
import java.util.Date;
import java.util.Map;
class MyBizHandler33 extends ChannelInboundHandlerAdapter {
    Logger logger = LoggerFactory.getLogger(IstTestFl.class);
    @Override
    public void channelActive(ChannelHandlerContext ctx) {
        //conn finish ,,,save ctx_conn
        // channelActive  method after   connect()  ....
        System.out.println(" client conn ok");
        NettyClient.curConn_ctx = ctx;


        String txt="'aaaaaaaaaaaaaaaaaaaaaaaaadkjflkdsjfklasjfkld jfkdsajfkldsjfkldsjafklsdjafkljadkslfjdkl'\r\n";
        byte[] bytes = txt.getBytes();




        //save ctx for easy invlk outside



        logger.info("=============start.....");
        for (int n = 0; n <90*10000; n++) {

            try {
                ByteBuf buffer =NettyClient. curConn_ctx.alloc().buffer();
                // 2. 准备数据，指定字符串的字符集为 utf-8
                // 3. 填充数据到 ByteBuf
                buffer.writeBytes(bytes);
                // 2. 写数据
                NettyClient.curConn_ctx.channel().writeAndFlush(buffer);
            } catch (Throwable e) {
                System.out.println(e);
            }

        }

        // ctx.close()



        logger.info("===================end.....");
    }


    @Override
    public void channelRead(ChannelHandlerContext ctx, Object msg) {
        ByteBuf byteBuf = (ByteBuf) msg;
        //接收服务端的消息并打印 rcv msg
        System.out.println(byteBuf.toString(Charset.forName("utf-8")));
    }

}

public class NettyClient {

    public   static ChannelHandlerContext curConn_ctx;

    public static void main(String[] args) {
        NioEventLoopGroup workerGroup = new NioEventLoopGroup();
        Bootstrap bootstrap = new Bootstrap();
        bootstrap
                // 1.指定线程模型
                .group(workerGroup)
                // 2.指定 IO 类型为 NIO
                .channel(NioSocketChannel.class)
                // 3.IO 处理逻辑
                .handler(new ChannelInitializer<SocketChannel>() {


                             @Override
                             public void initChannel(SocketChannel ch) {
                                 ch.pipeline().addLast(new MyBizHandler33());
                             }
                         }

                );
        // 4.建立连接
        bootstrap.connect("127.0.0.1", 8000).addListener(future -> {
            if (future.isSuccess()) {
                System.out.println("连接成功!");


            } else {
                System.err.println("连接失败!");
                //重新连接
            }
        });
    }
}


class sendMsgCls{
    public static void main(String[] args) {
        new Thread(() -> {
            try {
                Thread.sleep(3000);
            } catch (InterruptedException e) {
                throw new RuntimeException(e);
            }

            System.out.println("客户端发送消息...");
            // 1. 获取数据
            ByteBuf buffer =NettyClient. curConn_ctx.alloc().buffer();
            // 2. 准备数据，指定字符串的字符集为 utf-8
            Map m = Maps.newConcurrentMap();
            m.put("dt", new Date());
            m.put("uid", 2);
            byte[] bytes = JSONObject.toJSONString(m).getBytes();
            // 3. 填充数据到 ByteBuf
            buffer.writeBytes(bytes);
            // 2. 写数据
            NettyClient.curConn_ctx.channel().writeAndFlush(buffer);
        }).start();
    }
}