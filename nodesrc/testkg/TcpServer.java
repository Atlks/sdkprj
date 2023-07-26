package testkg;

import java.io.*;
import java.net.ServerSocket;
import java.net.Socket;

public class TcpServer {


    public static void main(String[] args) throws  Exception {
        int port = 8099;
        ServerSocket connectionSocket = new ServerSocket(port);
        // 监听端口，accept为阻塞方法
        System.out.println("Get socket successfully, wait for request...");
        while(true)
        {
            Socket communicationSocket = connectionSocket.accept();
            new Thread( hadle(communicationSocket)).start();
        }


    }

    private static Runnable hadle(Socket communicationSocket) throws Exception {

        // 获取输入流，读取数据


        BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(communicationSocket.getInputStream()));
        String message;
        while ((message = bufferedReader.readLine()) != null) {
            System.out.printf("get message from client : %s \r\n",message);
        }

        return null;
    }



    //     communicationSocket.shutdownInput();
    // 获取输出流,返回结果
//        OutputStream outputStream = communicationSocket.getOutputStream();
//        OutputStreamWriter outputStreamWriter = new OutputStreamWriter(outputStream);
//        BufferedWriter bufferedWriter = new BufferedWriter(outputStreamWriter);
//        bufferedWriter.write("I got your message and the communication is over.");
//        bufferedWriter.flush();
    //  communicationSocket.shutdownOutput();
    // 关闭资源
    //   bufferedWriter.close();
    //    bufferedReader.close();
}
