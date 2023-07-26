package testkg;

import com.alibaba.fastjson.JSONObject;
import com.google.common.collect.Maps;
import io.netty.bootstrap.ServerBootstrap;
import io.netty.buffer.ByteBuf;
import io.netty.channel.ChannelHandlerContext;
import io.netty.channel.ChannelInboundHandlerAdapter;
import io.netty.channel.ChannelInitializer;
import io.netty.channel.ChannelOption;
import io.netty.channel.nio.NioEventLoopGroup;
import io.netty.channel.socket.nio.NioServerSocketChannel;
import io.netty.channel.socket.nio.NioSocketChannel;

import java.io.*;
import java.nio.charset.Charset;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;


class MyBizHandler extends ChannelInboundHandlerAdapter {

    BufferedWriter bw;
    @Override
    public void channelActive(ChannelHandlerContext ctx) throws  Exception {
        //conn finish ,,,save ctx_conn
        // channelActive  method after   connect()  ....
        System.out.println("   conn ok");


        //写入流,设置缓存区大小为1024K
          bw = new BufferedWriter(new OutputStreamWriter(new FileOutputStream("dt2025_90w.txt",true)),1024);


        //save ctx for easy invlk outside
    }
    @Override   // messageReceived
    public void channelRead(ChannelHandlerContext ctx, Object msg) throws  Exception {
        ByteBuf byteBuf = (ByteBuf) msg;
        String msg_str = byteBuf.toString(Charset.forName("utf-8"));
        System.out.println(new Date() + ": 服务端读到数据 -> " + msg_str);
        //here can save ctx chanel conn and uid...

        if (msg_str.trim().startsWith("{")) {
            JSONObject jo = JSONObject.parseObject(msg_str);
            NettyServer.connCtxMap.put(jo.get("uid"), ctx);
        }

        bw.write(msg_str);
        bw.newLine();//输出换行，内部调用System.getProperty("line.separator")


        //3.刷新缓存区 auto by cache size
          bw.flush();
        //if msg to other,forword to another ctx
        //  保留服务段 ctx线程
    }
}

public class NettyServer {

    public static Map connCtxMap = new HashMap();


    public static void main(String[] args) throws  Exception {

        //1.创建BufferedWriter类型的对象与c:/a.txt文件关联，true代表可以追加，
        //写入流,设置缓存区大小为1024K
        BufferedWriter bw = new BufferedWriter(new OutputStreamWriter(new FileOutputStream("dt2024_900w.txt",true)),10240);


        ServerBootstrap serverBootstrap = new ServerBootstrap();
        serverBootstrap.group(new NioEventLoopGroup(),  new NioEventLoopGroup()).channel(NioServerSocketChannel.class).childHandler(new ChannelInitializer<NioSocketChannel>() {
            protected void initChannel(NioSocketChannel ch) {
                ch.pipeline().addLast(new MyBizHandler());
            }
        }).bind(8000);


//        serverBootstrap.handler(new ChannelInitializer<NioServerSocketChannel>() {
//            protected void initChannel(NioServerSocketChannel ch) {
//                System.out.println("svr booting...服务端启动中");
//
//            }
//        });
//
//        serverBootstrap
//                //开启TCP底层心跳机制
//                .childOption(ChannelOption.SO_KEEPALIVE, true)
//                //开启Nagle算法，如果要求高实时性，有数据发送时就马上发送，就关闭，如果需要减少发送次数减少网络交互，就开启。
//                .childOption(ChannelOption.TCP_NODELAY, true);
//
//        serverBootstrap.bind(8000);


    }


    public static void sendMsg(String msg, String connId) {
        new Thread(() -> {
            while (true) {
                try {
                    Thread.sleep(3000);


                    ChannelHandlerContext ctx = (ChannelHandlerContext) connCtxMap.get(connId);

                    ByteBuf buffer = ctx.alloc().buffer();
                    buffer.writeBytes(("from svr msg" + new Date().toString()).getBytes());
                    ctx.channel().writeAndFlush(buffer);
                } catch (Exception e) {
                    e.printStackTrace();
                }

            }

        }).start();
    }


    //                            @Override   //  channel准备就绪，或者说连接完成。  //here should save conn...and uid map
//                            public void channelActive(ChannelHandlerContext ctx) {
//                                // conn ok.. finish .  here should do nothing
//                                System.out.println("svr send msg发送消息...");
//
//
//                                String msg = "msg from svr  " + new Date();
//
//                                ByteBuf buffer = ctx.alloc().buffer();
//                                buffer.writeBytes(msg.getBytes(Charset.forName("utf-8")));
//                                // 2. 写数据
//                                ctx.channel().writeAndFlush(buffer);
//                                System.out.println("svr send msg发送消息 finish...");
//                            }
}