package testkg;

import com.alibaba.fastjson.JSONObject;
import com.im.action.AbstractAction;
import com.im.action.login.LoginAction;
import com.im.action.sys.GetSmsCodeAction;
import com.im.action.sys.UpdateUserKeyPairAction;
import com.im.filter.SignitureValidFilter;
import com.webkit.web.ActionException;
import com.webkit.web.FilterDispatcher;
import redis.clients.jedis.Jedis;
import spark.Spark;

import static spark.Spark.*;

import java.io.IOException;
import java.util.Enumeration;
import java.util.List;

import javax.servlet.*;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public class spk {

    public static void main(String[] args) {
        Spark.exception(RuntimeException.class, (exception, request, response) -> {
            //exception.printStackTrace();
            throw exception;
        });
        port(8088);
        System.out.println(org.eclipse.jetty.server.Handler.class);
        System.out.println(org.slf4j.helpers.MessageFormatter.class);
        //   System.out.println( org.slf4j.impl.StaticLoggerBinder.class);
        get("/h", (req, res) -> "Hel..");
        get("/hh", (req, res) -> "Hel222.");

        postx("/im-biz/sys/getSmsCode", new GetSmsCodeAction());
        postx("/im-biz/login/login", new LoginAction());
        postx("/im-biz/sys/updateUserKeyPair", new UpdateUserKeyPairAction());

//        post("/im-biz/sys/getSmsCode", (req, res) -> {
//
//
//            HttpServletResponse resps=   res.raw();
//            HttpServletRequest reqst=req.raw();
//
//
//            addFltr( reqst,resps);
//            AbstractAction act1= new GetSmsCodeAction();
//            act1.execute(  resps.getOutputStream() );
//
//            resps.flushBuffer();
//            resps.getOutputStream().close();
//           return resps;
//
//
//
//        });


        // get("/hh", extracted());
        get("/p",

                (req, res) -> {

                    // HttpServletRequest req2 = (HttpServletRequest) req;
                    // spark.http.matching.RequestWrapper req2=req;
//							System.out.println(req2.getSession().getServletContext().getRealPath("/"));
//							;
                    HttpServletRequest req2 = req.raw();

                    String path = req2.getServletContext().getContextPath();
                    System.out.println(path);
                    String realPath = req2.getServletContext().getRealPath("/uploadFile");
                    System.out.println(realPath);
                    return 1;

                });

        get("/m", (req, res) -> {

            //连接本地的 Redis 服务
            Jedis jedis = new Jedis("localhost");
            // 如果 Redis 服务设置了密码，需要下面这行，没有就不需要
            jedis.auth(" ");
            System.out.println("连接成功");
            //查看服务是否运行
            System.out.println("服务正在运行: " + jedis.ping());

            System.out.println(jedis.get("fgfkkk"));

//while(true){
            Object msgx = jedis.brpoplpush("msgx", "msgxHstry", 10);

            String msg = JSONObject.toJSONString(msgx);
            System.out.println(msg);

            return msg;


        });


    }

    static void postx(String path, AbstractAction act1) {
        post(path, (req, res) -> {


            HttpServletResponse resps = res.raw();
            HttpServletRequest reqst = req.raw();


            addFltr(reqst, resps);

            act1.execute(resps.getOutputStream());

            resps.flushBuffer();
            resps.getOutputStream().close();
            return resps;


        });

    }

    private static void addFltr(HttpServletRequest reqst, HttpServletResponse resps) throws IOException, ServletException, ActionException, ClassNotFoundException {
        SignitureValidFilter signitureValidFilter = new SignitureValidFilter();
        signitureValidFilter.exceptURI = "/index.jsp,/tool/scheduleEvent";

        signitureValidFilter.doFilter(reqst, resps, new FilterChain() {

            @Override
            public void doFilter(ServletRequest servletRequest, ServletResponse servletResponse) throws IOException, ServletException {

            }
        });


//        FilterConfig fc = new FilterConfig() {
//            @Override
//            public String getFilterName() {
//                return "fltnm";
//            }
//
//            @Override
//            public ServletContext getServletContext() {
//                return reqst.getServletContext();
//            }
//
//            @Override
//            public String getInitParameter(String s) {
//                if (s.equals("charset"))
//                    return "utf8";
//                return "";
//            }
//
//            @Override
//            public Enumeration<String> getInitParameterNames() {
//                return null;
//            }
//        };
//        FilterDispatcher filterDispatcher = new FilterDispatcher();
//        filterDispatcher.init(fc);
//
//
//        filterDispatcher.doFilter(reqst, resps, new FilterChain() {
//            @Override
//            public void doFilter(ServletRequest servletRequest, ServletResponse servletResponse) throws IOException, ServletException {
//
//            }
//        });


        //add ActionContext.getActionContext()
        //  ActionContext.getActionContext()

        System.out.println(com.webkit.web.ActionContextWrp.class);
        com.webkit.web.ActionContextWrp.createActionContext(reqst.getServletContext(), reqst, resps);
        //  Dispatcher.getInstance(). serviceAction(,, );
        // Dispatcher.getInstance().setActionContext(null);

        //  ActionContext
    }
}
