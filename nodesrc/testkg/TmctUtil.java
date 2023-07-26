package testkg;

import com.alibaba.fastjson.JSONObject;
import org.apache.catalina.Context;
import org.apache.catalina.startup.Tomcat;

import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.util.UUID;

public class TmctUtil {

    public static void setGetM(String pattern_svltpath, Route route,
                               Tomcat tomcat, Context ctx_webapp) {
        String svltname = UUID.randomUUID().toString();
        tomcat.addServlet(ctx_webapp, svltname, new HttpServlet() {

            protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws IOException {


                Object handle = null;
                try {
                    handle = route.handle(req, resp);
                    if (handle instanceof String)
                        resp.getWriter().write(handle.toString());
                    else
                        resp.getWriter().write(JSONObject.toJSONString(handle, true));
                    resp.getWriter().flush();
                } catch (Exception e) {
                    throw new RuntimeException(e);
                }


            }

        });

        ctx_webapp.addServletMappingDecoded(pattern_svltpath, svltname);
    }
}
