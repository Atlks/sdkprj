package testkg;

import com.alibaba.fastjson.JSONObject;
import com.google.common.base.Function;
import com.google.common.collect.Maps;
import com.im.action.AbstractAction;
import com.im.action.contacts.*;
import com.im.action.group.GroupContactListAction;
import com.im.action.login.GetUrlsAction;
import com.im.action.login.LoginAction;
import com.im.action.login.LogoutAction;
import com.im.action.login.RegAction;
import com.im.action.news.CategoryAction;
import com.im.action.news.NewsAction;
import com.im.action.news.NewsFlashAction;
import com.im.action.payment.GetOrderDetailAction;
import com.im.action.payment.GetPayTypeAction;
import com.im.action.payment.SendPendingOrderAction;
import com.im.action.redpacket.AddRedPacketAction;
import com.im.action.redpacket.RedPacketTemplateListAction;
import com.im.action.sys.*;
import com.im.action.user.*;
import com.im.action.wallet.AvailableCoinAction;
import com.im.action.wallet.UserBankCardListAction;
import com.im.action.wallet.UserWalletAction;
import com.im.common.constants.GlobalConstants;
import com.im.config.BizConfig;
import com.im.dataaccess.entity.news.NewsTag;
import com.im.domain.pb.PaymentProto;
import com.im.filter.SignitureValidFilter;
import com.webkit.web.FilterDispatcher;

import com.webkit.web.filter.CharacterEncodingFilter;
import lombok.SneakyThrows;
import org.apache.catalina.Context;
import org.apache.catalina.LifecycleException;
import org.apache.catalina.core.StandardContext;
import org.apache.catalina.startup.Tomcat;
import org.apache.tomcat.util.descriptor.web.FilterDef;
import org.apache.tomcat.util.descriptor.web.FilterMap;
import org.quartz.ee.servlet.QuartzInitializerListener;
import redis.clients.jedis.Jedis;
import spark.Request;
import spark.Response;


import javax.servlet.ServletContextEvent;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.util.Map;
import java.util.UUID;


public class TmctEmbd {

    public static void main(String[] args) throws LifecycleException {
        System.out.println(org.slf4j.helpers.MessageFormatter.class);
        System.out.println(com.google.protobuf.AbstractMessageLite.class);
        System.out.println(javax.servlet.ServletContext.class);
        System.out.println(org.apache.bcel.util.InstructionFinder.class);
        System.out.println(BizConfig.isDevelop());
        //  D:\im-server-core\im-task\lib\protobuf-java-3.0.0.jar  jeig err..  AvailableCoinAction

        String json = "{\"createTime\":\"Mar 17, 2022 4:15:46 PM\"}";
//        NewsTag x = GlobalConstants.GSON.fromJson(json, NewsTag.class);
//        System.out.println(x); ;
        //slf 1.4 err...1.6.4 err...m yabe only 1.5.6 is ok...
        //1.5.6 also ok for spk
        System.out.println(org.slf4j.impl.StaticLoggerBinder.class);
        System.out.println(11);
        int port = 8080;


        Tomcat tomcat = new Tomcat();
        tomcat.getHost().setAutoDeploy(true);
        tomcat.setPort(port);

        //-------------add ctx

        Context ctx_webapp = tomcat.addContext("/", "D:\\im-server-core\\im-biz\\target\\");
        //  addWEbapp 更麻烦解压缩war包会

        addFltr(ctx_webapp);

        //-----------------------------api 2


        postx("/im-biz/sys/getSmsCode", new GetSmsCodeAction(), tomcat, ctx_webapp);
        postx("/im-biz/sys/updateUserKeyPair", new UpdateUserKeyPairAction(), tomcat, ctx_webapp);
        postx("/im-biz/sys/checkVersion", new CheckVersionAction(), tomcat, ctx_webapp);
        postx("/im-biz/sys/openInstall", new OpenInstallAction(), tomcat, ctx_webapp);
        postx("/im-biz/sys/getKeyPairOfVer", new GetKeyPairOfVerAction(), tomcat, ctx_webapp);
        postx("/im-biz/sys/getEmailCode", new GetEmailCodeAction(), tomcat, ctx_webapp);
        postx("/im-biz/sys/googleAuthQrCode", new GoogleAuthQrCodeAction(), tomcat, ctx_webapp);


        postx("/im-biz/login/login", new LoginAction(), tomcat, ctx_webapp);
        postx("/im-biz/login/getUrls", new GetUrlsAction(), tomcat, ctx_webapp);
        postx("/im-biz/login/reg", new RegAction(), tomcat, ctx_webapp);
        postx("/im-biz/login/logout", new LogoutAction(), tomcat, ctx_webapp);


        postx("/im-biz/contacts/contactsList", new ContactsListAction(), tomcat, ctx_webapp);
        postx("/im-biz/contacts/contactsApplyList", new ContactsApplyListAction(), tomcat, ctx_webapp);
        postx("/im-biz/group/groupContactList", new
                GroupContactListAction(), tomcat, ctx_webapp);
        postx("/im-biz/contacts/findContactsList", new FindContactsListAction(), tomcat, ctx_webapp);
        postx("/im-biz/contacts/mobileContacts", new MobileContactsAction(), tomcat, ctx_webapp);
        postx("/im-biz/contacts/contactsDetail", new ContactsDetailAction(), tomcat, ctx_webapp);
        postx("/im-biz/contacts/contactsRelation", new ContactsRelationAction(), tomcat, ctx_webapp);
        postx("/im-biz/contacts/unAuditDetail", new UnAuditDetailAction(), tomcat, ctx_webapp);
        postx("/im-biz/contacts/updateContactsApply", new UpdateContactsApplyAction(), tomcat, ctx_webapp);


        postx("/im-biz/user/update", new UpdateAction(), tomcat, ctx_webapp);
        postx("/im-biz/user/detail", new DetailAction(), tomcat, ctx_webapp);
        postx("/im-biz/user/getEmoticon", new GetEmoticonAction(), tomcat, ctx_webapp);
        postx("/im-biz/user/bindEmail", new BindEmailAction(), tomcat, ctx_webapp);
        postx("/im-biz/user/tradePassword", new TradePasswordAction(), tomcat, ctx_webapp);


        postx("/im-biz/news/newsFlash", new NewsFlashAction(), tomcat, ctx_webapp);
        postx("/im-biz/news/news", new NewsAction(), tomcat, ctx_webapp);
        postx("/im-biz/news/category", new CategoryAction(), tomcat, ctx_webapp);


        postx("/im-biz/wallet/userWallet", new UserWalletAction(), tomcat, ctx_webapp);
        postx("/im-biz/wallet/availableCoin", new AvailableCoinAction(), tomcat, ctx_webapp);
        postx("/im-biz/wallet/userBankCardList", new UserBankCardListAction(), tomcat, ctx_webapp);
        postx("/im-biz/payment/getPayType", new GetPayTypeAction(), tomcat, ctx_webapp);
        postx("/im-biz/redpacket/addRedPacket", new AddRedPacketAction(), tomcat, ctx_webapp);
        postx("/im-biz/redpacket/redPacketTemplateList", new RedPacketTemplateListAction(), tomcat, ctx_webapp);
        postx("/im-biz/payment/sendPendingOrder", new SendPendingOrderAction(), tomcat, ctx_webapp);
        postx("/im-biz/payment/getOrderDetailAction", new GetOrderDetailAction(), tomcat, ctx_webapp);


        setGetM( "/rcv", (req, res) -> {
            //连接本地的 Redis 服务
            Jedis jedis = new Jedis("localhost");
            // 如果 Redis 服务设置了密码，需要下面这行，没有就不需要
            jedis.auth("");
            System.out.println("连接成功");
            //查看服务是否运行
            System.out.println("服务正在运行: " + jedis.ping());

            System.out.println(jedis.get("fgfkkk"));

//while(true){
            Object msgx = jedis.brpoplpush("msgx", "msgxHstry", 10);

            String msg = JSONObject.toJSONString(msgx);
            System.out.println(msg);

            return msg;
        },tomcat, ctx_webapp);



        setGetM( "/sendmsg", (req, res) -> {
            //连接本地的 Redis 服务
            Jedis jedis = new Jedis("localhost");
            // 如果 Redis 服务设置了密码，需要下面这行，没有就不需要
            jedis.auth("");
            System.out.println("连接成功");
            //查看服务是否运行
            System.out.println("服务正在运行: " + jedis.ping());

            System.out.println(jedis.get("fgfkkk"));


            Object list_len = jedis.lpush("msgx",req.getParameter("msg"));


            System.out.println(list_len);

            return list_len;
        },tomcat, ctx_webapp);




//==>/im-biz/news/category


        //   ActionContext.getActionContext().


        //-------------------------------api1
        //http://localhost:8088/wa/snm
        HttpServlet httpServlet = new HttpServlet() {
            protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
                resp.getWriter().println("  Hello IDEA FOR IM!!!");
            }
        };
        tomcat.addServlet(ctx_webapp, "snm", httpServlet);
        ctx_webapp.addServletMappingDecoded("/", "snm");//must last line

        tomcat.addServlet(ctx_webapp, "snm2", httpServlet);
        ctx_webapp.addServletMappingDecoded("/im-biz/", "snm2");//must last line


        //--------------------------------start

        tomcat.start();
        tomcat.getServer().await();
    }

    private static void postx(String path, AbstractAction act1, Tomcat tomcat, Context ctxWebapp) {
        //  FilterDispatcherMydspt.pathMap.put(path,act1);
        addSvlt(tomcat, ctxWebapp, path, act1);
    }

    private static void addFltr(Context ctx_webapp) {


        //-------add filter   SignitureValidFilter
        FilterDef filter1definition = new FilterDef();

        filter1definition.setFilterName(SignitureValidFilter.class.getSimpleName());
        filter1definition.setFilterClass(SignitureValidFilter.class.getName());
        filter1definition.addInitParameter("exceptURI", "/index.jsp,/tool/scheduleEvent");
        ctx_webapp.addFilterDef(filter1definition);
        FilterMap filter1mapping = new FilterMap();
        filter1mapping.setFilterName(SignitureValidFilter.class.getSimpleName());
        filter1mapping.addURLPattern("/*");
        ctx_webapp.addFilterMap(filter1mapping);


        FilterDef filter1definition_encode = new FilterDef();

        filter1definition_encode.setFilterName(com.webkit.web.filter.CharacterEncodingFilter.class.getSimpleName());
        filter1definition_encode.setFilterClass(com.webkit.web.filter.CharacterEncodingFilter.class.getName());

        ctx_webapp.addFilterDef(filter1definition_encode);
        FilterMap filter1mapping_encode = new FilterMap();
        filter1mapping_encode.setFilterName(CharacterEncodingFilter.class.getSimpleName());
        filter1mapping_encode.addURLPattern("/*");
        ctx_webapp.addFilterMap(filter1mapping_encode);

        //  ctx_webapp.getServletContext().addListener( org.quartz.ee.servlet.QuartzInitializerListener.class);
        // npe addlisnr()

        new QuartzInitializerListener().contextInitialized(new ServletContextEvent(ctx_webapp.getServletContext()));

        ///------------add disptch flter
//        FilterDef filter_disptch = new FilterDef();
//
//        filter_disptch.setFilterName(FilterDispatcher.class.getSimpleName());
//        filter_disptch.setFilterClass(FilterDispatcher.class.getName());
//
//        ctx_webapp.addFilterDef(filter_disptch);
//        FilterMap filter_disptch_map = new FilterMap();
//        filter_disptch_map.setFilterName(FilterDispatcher.class.getSimpleName());
//        filter_disptch_map.addURLPattern("/*");
//        ctx_webapp.addFilterMap(filter_disptch_map);


        ///------------add disptch flter
//        FilterDef filter_disptch_mydspt = new FilterDef();
//
//        filter_disptch_mydspt.setFilterName(FilterDispatcherMydspt.class.getSimpleName());
//        filter_disptch_mydspt.setFilterClass(FilterDispatcherMydspt.class.getName());
//
//        ctx_webapp.addFilterDef(filter_disptch_mydspt);
//        FilterMap filter_disptch_mydspt_map = new FilterMap();
//        filter_disptch_mydspt_map.setFilterName(FilterDispatcherMydspt.class.getSimpleName());
//        filter_disptch_mydspt_map.addURLPattern("/*");
//        ctx_webapp.addFilterMap(filter_disptch_mydspt_map);


    }

    private static void addSvlt(Tomcat tomcat, Context ctx_webapp, String pattern_svltpath, AbstractAction act
    ) {
        String svltname = act.getClass().getName();
        tomcat.addServlet(ctx_webapp, svltname, new HttpServlet() {

            protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws IOException {
                resp.getWriter().write("use post ");
                resp.getWriter().flush();
            }

            protected void doPost(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {

                //  System.out.println("------>ext svlt:"+svltname);
                com.webkit.web.ActionContextWrp.createActionContext(req.getServletContext(), req, resp);

                act.execute(resp.getOutputStream());
                resp.getOutputStream().flush();
                resp.flushBuffer();

            }
        });

        ctx_webapp.addServletMappingDecoded(pattern_svltpath, svltname);
    }


    private static void setGetM( String pattern_svltpath, Route route,
    Tomcat tomcat, Context ctx_webapp) {
        String svltname = UUID.randomUUID().toString();
        tomcat.addServlet(ctx_webapp, svltname, new HttpServlet() {

            @SneakyThrows
            protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws IOException {


                resp.getWriter().write(  route.handle(req, resp).toString());
                resp.getWriter().flush();

            }

        });

        ctx_webapp.addServletMappingDecoded(pattern_svltpath, svltname);
    }
}

//    addSvlt(tomcat, ctx_webapp, "/im-biz/sys/getSmsCode", new GetSmsCodeAction());
//
//        addSvlt(tomcat, ctx_webapp, "/im-biz/login/login", new LoginAction());
//        addSvlt(tomcat, ctx_webapp, "/im-biz/sys/updateUserKeyPair", new UpdateUserKeyPairAction());


/**
 * System.out.println(javax.annotation.security.DeclareRoles.class);
 * //  javax.annotation.security.DeclareRoles
 * System.out.println(javax.servlet.ServletContext.class);
 * System.out.println(org.apache.jasper.servlet.JspServlet.class);
 * System.out.println(org.apache.tomcat.util.descriptor.tld.TldParser.class);
 * System.out.println(javax.el.ExpressionFactory.class);
 * System.out.println(org.apache.el.ExpressionFactoryImpl.class);
 * System.out.println(org.apache.tools.ant.launch.AntMain.class);
 * //  tomcat.setBaseDir("D:\\im-server-core\\im-biz\\target");
 * <p>
 * <p>
 * //        String pwd = "D:\\im-server-core\\im-biz\\target".trim();
 * //        System.out.println(pwd);
 * //        tomcat.addWebapp("/", pwd);
 */
