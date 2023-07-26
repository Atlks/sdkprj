package testkg;

import org.apache.catalina.LifecycleException;
import org.apache.catalina.core.StandardContext;
import org.apache.catalina.startup.Tomcat;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;

public class tmct {

    public static void main(String[] args) throws LifecycleException {
        System.out.println(11);
        int port = 8088;


        Tomcat tomcat = new Tomcat();
        tomcat.getHost().setAutoDeploy(true);
        tomcat.setPort(port);
        tomcat.setBaseDir("D:\\im-server-core\\im-biz\\target");

                String pwd = "D:\\im-server-core\\im-biz\\target".trim();
                System.out.println(pwd);
                tomcat.addWebapp("/", pwd);
        tomcat.addWebapp("/im-biz", "D:\\im-server-core\\im-biz\\target\\im-biz");


//        StandardContext ctx_webapp = new StandardContext();
//        ctx_webapp.setPath("/");ctx_webapp.setDocBase("D:\\im-server-core\\im-biz\\target");
//        ctx_webapp.addLifecycleListener(new Tomcat.FixContextListener());
//        tomcat.getHost().addChild(ctx_webapp);



//        StandardContext ctx_webapp2 = new StandardContext();
//        ctx_webapp2.setPath("/im-biz");
//        ctx_webapp2.setDocBase("D:\\im-server-core\\im-biz\\target\\im-biz");
//        ctx_webapp2.addLifecycleListener(new Tomcat.FixContextListener());
//        tomcat.getHost().addChild(ctx_webapp2);


        tomcat.start();
        tomcat.getServer().await();
    }
}

/**
 *
 *
 System.out.println(javax.annotation.security.DeclareRoles.class);
 //  javax.annotation.security.DeclareRoles
 System.out.println(javax.servlet.ServletContext.class);
 System.out.println(org.apache.jasper.servlet.JspServlet.class);
 System.out.println(org.apache.tomcat.util.descriptor.tld.TldParser.class);
 System.out.println(javax.el.ExpressionFactory.class);
 System.out.println(org.apache.el.ExpressionFactoryImpl.class);
 System.out.println(org.apache.tools.ant.launch.AntMain.class);
 *   //
 *
 *

 */
