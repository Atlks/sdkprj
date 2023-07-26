package testkg;
import java.io.*;
import java.net.ServerSocket;
import java.net.Socket;
public class TcpClient {


    public static void main(String[] args) throws IOException {
        // 指定ip 端口，创建socket
        String host = "127.0.0.1";
        int port = 8099;
        Socket communicationSocket = new Socket(host, port);
        // 获取输出流,写入数据
        OutputStream outputStream = communicationSocket.getOutputStream();
        OutputStreamWriter outputStreamWriter = new OutputStreamWriter(outputStream);
        BufferedWriter bufferedWriter = new BufferedWriter(outputStreamWriter);
        bufferedWriter.write("hello world\r\n");
        bufferedWriter.flush();
        communicationSocket.shutdownOutput();
        // 获取输入流,读取服务器返回信息
//        InputStream inputStream = communicationSocket.getInputStream();
//        InputStreamReader inputStreamReader = new InputStreamReader(inputStream);
//        BufferedReader bufferedReader = new BufferedReader(inputStreamReader);
//        String message;
//        while ((message = bufferedReader.readLine()) != null) {
//            System.out.printf("get message from server : %s", message);
//        }
        communicationSocket.shutdownInput();
        // 关闭资源
        bufferedWriter.close();
     //   bufferedReader.close();
    }
}
