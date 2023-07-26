package testkg;

import com.alibaba.fastjson.JSONObject;
import com.google.common.collect.Lists;
import com.google.common.collect.Maps;
import org.apache.catalina.Context;
import org.apache.catalina.startup.Tomcat;
import org.apache.commons.io.FileUtils;
import org.apache.commons.io.input.ReversedLinesFileReader;

import java.io.File;
import java.io.IOException;
import java.nio.charset.Charset;
import java.util.*;

import static testkg.ImUtil.*;

public class imCls_codlib {
    //shiti user msg grp

    public static String storeFldr = "d:/dbstore_codelib";

    public static void main(String[] args) throws Exception {

        Tomcat tomcat = new Tomcat();
        tomcat.getHost().setAutoDeploy(true);
        tomcat.setPort(8888);

        //-------------add ctx

        Context ctx_webapp = tomcat.addContext("/", "D:\\im-server-core\\im-biz\\target\\");
        //  addWEbapp 更麻烦解压缩war包会


        // http://localhost:8888/reg?uname=ati&pwd=ppp
        TmctUtil.setGetM("/reg", regv3(), tomcat, ctx_webapp);

        // http://localhost:8888/login?uname=ati&pwd=ppp
        TmctUtil.setGetM("/login", loginv3(), tomcat, ctx_webapp);

        // http://localhost:8888/login?uname=ati&pwd=ppp
        TmctUtil.setGetM("/addFrd", addFrdv2(), tomcat, ctx_webapp);
        TmctUtil.setGetM("/frdLst", frdLst(), tomcat, ctx_webapp);

        TmctUtil.setGetM("/sendmsgToFrd", sendmsgToFrd(), tomcat, ctx_webapp);
        TmctUtil.setGetM("/showChatMsgWithFrd", showChatMsgWithFrd(), tomcat, ctx_webapp);

        TmctUtil.setGetM("/sendmsgToGrp", sendmsgToGrp(), tomcat, ctx_webapp);
        TmctUtil.setGetM("/showChatMsgFrmGrp", showChatMsgFrmGrp(), tomcat, ctx_webapp);


        tomcat.start();
        tomcat.getServer().await();




    }

    private static Route showChatMsgFrmGrp() {


        return (req, res) -> {



            String coll = "msg_grpmsg_" +  req.getParameter("grp")+"/"+getDate();



            String accpath = storeFldr + "/" + coll ;
            return getListFrmCollpath(   accpath   );



        };
    }

    private static Route showChatMsgWithFrd() {




        return (req, res) -> {

            String curUname = req.getParameter("uname");     //aesDecode_cookie();

            checkAuth(curUname, req.getParameter("pwd"));

            String frd = req.getParameter("frd");


         return getListFrmCollpath(      wzFrdMsgDir(curUname, frd));



        };
    }

    private static Route sendmsgToFrd() {




        return (req, res) -> {

            String curUname = req.getParameter("uname");     //aesDecode_cookie();

            checkAuth(curUname, req.getParameter("pwd"));


            String toFrd = req.getParameter("frd");






            String msgFilename = "msg_" + filNameTimebase();


            // send and rvcv same msg dir..
            String dir = wzFrdMsgDir(curUname, toFrd);

            String accpath =dir+ "/" + msgFilename + ".json";

            writeStrToFilFrmObj(accpath,new HashMap(){{

                put("from", curUname);
                put("to", toFrd);
                put("msg", req.getParameter("msg"));
                put("time", new Date());
                put("addTime_rdable", getDatetimex());

            }});
return 0;

        };
    }

    private static String filNameTimebase() {
        return new Date().toString().replaceAll(":", ".") + " " + System.currentTimeMillis();
    }

    private static String wzFrdMsgDir(String curUname, String toFrd) {
        String dir=storeFldr + "/msgs_" + toFrd + "_wz_"+ curUname +"_msgs";
        if(!new File((dir)).exists())
            dir =storeFldr + "/msgs_" + curUname + "_wz_"+ toFrd +"_msgs" ;
        return dir;
    }

    private static Route frdLst() {


        return (req, res) -> {

            String curUname = req.getParameter("uname");     //aesDecode_cookie();

            checkAuth(curUname, req.getParameter("pwd"));



            String accpath = storeFldr + "/" + "user_" + curUname + "_frds";
            return    getListFrmCollpath(accpath);
        };


    }

    private static Route regv3() {
        return (req, res) -> {

            String uname = req.getParameter("uname");
            String pwd = req.getParameter("pwd");

            String accpath = storeFldr + "/" + "user_" + uname + ".json";
            if (new File(accpath).exists())
                throw new RuntimeException("alread reged");

            writeStrToFilFrmObj(accpath, new HashMap() {{
                put("uname", uname);

                put("pwd", pwd);
            }});
            return 0;
        };
    }

    private static Route loginv3() {
        return (req, res) -> {

            String uname = req.getParameter("uname");
            String pwd = req.getParameter("pwd");

            // db/shititype
            String accpath = storeFldr + "/" + "user_" + uname + ".json";
            ReversedLinesFileReader reversedLinesReader = new ReversedLinesFileReader(new File(accpath), Charset.defaultCharset());
            String uinfo_str = reversedLinesReader.readLine();
            JSONObject jo = JSONObject.parseObject(uinfo_str);
            if (!pwd.equals(jo.get("pwd")))
                throw new RuntimeException("pwd err");
            //gene token  uname,id,date,,exprise date
            //login dont need gene token,just use uname_pwd  as key to acc another api just ok..

            return 0;
        };
    }

    private static Route addFrdv2() {
        return (req, res) -> {


            String curUname = req.getParameter("uname");     //aesDecode_cookie();

            checkAuth(curUname, req.getParameter("pwd"));

            //add rlt ...is use jo obj txt too troulbe  ,,fldr mode is better easy

            String frdName = req.getParameter("frd");
            String accpath = storeFldr + "/user_" + curUname + "_frds" + "/" + frdName + ".json";

            return  writeStrToFilFrmObj(accpath, new HashMap() {{

                put("uname", frdName);
                put("addFrdTime", new Date());
                put("addFrdTime_rdable", getDatetimex());

            }});
        };
    }

    private static void checkAuth(String uname, String pwd) throws Exception {

        // db/shititype
        String accpath = storeFldr + "/" + "user_" + uname + ".json";
        ReversedLinesFileReader reversedLinesReader = new ReversedLinesFileReader(new File(accpath), Charset.defaultCharset());
        String uinfo_str = reversedLinesReader.readLine();
        JSONObject jo = JSONObject.parseObject(uinfo_str);
        if (!pwd.equals(jo.get("pwd")))
            throw new RuntimeException("pwd err");
        //gene token  uname,id,date,,exprise date
        //login dont need gene token,just use uname_pwd  as key to acc another api just ok..


    }


    private static Route sendmsgToGrp() throws IOException {



        return (req, res) -> {


            String curUname = req.getParameter("uname");     //aesDecode_cookie();

            checkAuth(curUname, req.getParameter("pwd"));

            //add rlt ...is use jo obj txt too troulbe  ,,fldr mode is better easy

            String grp1 = req.getParameter("grp");
            String msgFilename = "msg_" +filNameTimebase();

            String coll = "msg_grpmsg_" + grp1+"/"+getDate();
            String accpath = storeFldr + "/" + coll + "/" + msgFilename + ".json";



            return  writeStrToFilFrmObj(accpath, new HashMap() {{

                put("msg", req.getParameter("msg"));
                put("from", curUname);
                put("to", "_grp_" + grp1);
                put("time", new Date());
                put("addTime_rdable", getDatetimex());

            }});
        };
    }



    private static void addGrp(String grp12) throws IOException {

        String curUname = "ati";     //aesDecode_cookie();


        Map m = Maps.newConcurrentMap();
        m.put("grpname", grp12);
        m.put("addTime", new Date());
        m.put("addTime_rdable", getDatetimex());

        String accpath = storeFldr + "/" + curUname + "/grpLst" + "/" + grp12 + ".txt";
        FileUtils.writeStringToFile(new File(accpath), JSONObject.toJSONString(m) + "\r\n");
    }



    private static List showGrpList() {


        String curUname = "ati";     //aesDecode_cookie();

        String coll = "grpLst";
        List li = Lists.newArrayList();
        String accpath = storeFldr + "/" + curUname + "/" + coll;
        li = getListFrmCollpath(accpath);
        //  System.out.println( JSONObject.toJSONString(li) );
        return li;
    }




}

