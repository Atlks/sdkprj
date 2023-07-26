package testkg;

import com.alibaba.fastjson.JSONObject;
import com.google.common.collect.Lists;
import com.google.common.collect.Maps;
import org.apache.commons.io.FileUtils;
import org.apache.commons.io.input.ReversedLinesFileReader;

import java.io.File;
import java.io.IOException;
import java.nio.charset.Charset;
import java.text.DateFormat;
import java.util.*;
import java.util.stream.Collectors;

public class imCls_netdb {
    //shiti user msg grp

    public static String storeFldr = "d:/dbstore_netmode";

    public static void main(String[] args) throws Exception {
        //    reg("ati", "pwd123");
        login("ati", "pwd123");


        addFrdList("frd1");
        addFrdList("frd2");
        addFrdList("frd3");

        System.out.println("============> show flrlst:");
        System.out.println(JSONObject.toJSONString(showFrdList(), true));

        System.out.println("============> send msg:");
        sendmsg("duifeo1", "msg11");
        sendmsg("duifeo1", "msg12222");
        sendmsg("duifeo2", "msg11");

        System.out.println("============> show frd msgs:");
        System.out.println(JSONObject.toJSONString(showChatMsg("duifeo1"), true));
        //       System.out.println(JSONObject.toJSONString(showChatMsg("duifeo2")));


//        //        addGrp("grp11");
////        addGrp("grp12");
////
////        System.out.println(JSONObject.toJSONString(showGrpList()));
//        sendmsgToGrp("grp1","msgx......");
//        System.out.println(JSONObject.toJSONString(showChatMsgGroup("grp1")));


    }

    private static void sendmsgToGrp(String grp1, String msg11) throws IOException {

        String curUname = "ati";     //aesDecode_cookie();
        String db = storeFldr + "/" + curUname;


        Map m = Maps.newConcurrentMap();
        m.put("msg", msg11);
        m.put("from", curUname);
        m.put("to", "_grp_" + grp1);
        m.put("time", new Date());
        m.put("addTime_rdable", getDatetimex());

        String msgFilename = "msg_" + new Date().toString().replaceAll(":", ".");
        String coll_biz = "msg_grp_" + grp1;
        String accpath = storeFldr + "/" + curUname + "/" + coll_biz + "/" + msgFilename + ".txt";
        FileUtils.writeStringToFile(new File(accpath), JSONObject.toJSONString(m) + "\r\n");
    }

    private static void sendmsg(String duifeo1, String msg11) throws IOException {
        String curUname = "ati";     //aesDecode_cookie();


        Map m = Maps.newConcurrentMap();
        m.put("msg", msg11);
        m.put("from", curUname);
        m.put("to", duifeo1);
        m.put("time", new Date());
        m.put("addTime_rdable", getDatetimex());


        String node = "msgFrom_rlt_ati_" + duifeo1;
        String msgFilename = "msg_" + new Date().toString().replaceAll(":", ".") + " " + System.currentTimeMillis();

        String accpath = storeFldr + "/" + node + "/" + msgFilename + ".json";
        FileUtils.writeStringToFile(new File(accpath), JSONObject.toJSONString(m) + "\r\n");

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

    private static void addFrdList(String frd2) throws IOException {
        String curUname = "ati";     //aesDecode_cookie();


        Map m = Maps.newConcurrentMap();
        m.put("uname", frd2);
        m.put("addFrdTime", new Date());
        String dttm = getDatetimex();
        m.put("addFrdTime_rdable", dttm);

        //add rlt ...is use jo obj txt too troulbe  ,,fldr mode is better easy

        String path = storeFldr + "/user_" + curUname + "_rlts";
        String accpath = path + "/" + frd2 + ".json";
        writeStrToFilFrmObj(accpath, m);


    }


    private static Object showChatMsgGroup(String grpName) {

        String curUname = "ati";     //aesDecode_cookie();
        String coll = "msg_grp_" + grpName;
        String accpath = storeFldr + "/" + curUname + "/" + coll;
        List li = getListFrmCollpath(accpath);


        //   System.out.println( JSONObject.toJSONString(li) );
        return li;
    }

    private static Object showChatMsg(String duifeoUname) {


        String curUname = "ati";     //aesDecode_cookie();


        String node = "msgFrom_rlt_ati_" + duifeoUname;

        List li = getListFrmCollpath(storeFldr + "/" + node);


        //   System.out.println( JSONObject.toJSONString(li) );
        return li;
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


    private static Object showFrdList() throws IOException {

        String curUname = "ati";     //aesDecode_cookie();

        String coll = "frdLst";
        String accpath = storeFldr + "/user_" + curUname + "_rlts";

        List li = getListFrmCollpath(accpath);


        //   System.out.println( JSONObject.toJSONString(li) );
        return li;
    }

    private static void login(String uname, String pwdd) throws Exception {

        // db/shititype
        String accpath = storeFldr + "/" + "user_" + uname + ".json";
        ReversedLinesFileReader reversedLinesReader = new ReversedLinesFileReader(new File(accpath), Charset.defaultCharset());
        String uinfo_str = reversedLinesReader.readLine();
        JSONObject jo = JSONObject.parseObject(uinfo_str);
        if (!pwdd.equals(jo.get("pwd")))
            throw new RuntimeException("pwd err");
        //gene token  uname,id,date,,exprise date

    }

    private static void reg(String uname, String pwd) throws Exception {

        // db/shititype
        String accpath = storeFldr + "/" + "user_" + uname + ".json";
        if (new File(accpath).exists())
            throw new RuntimeException("alread reged");
        Map m = Maps.newConcurrentMap();
        m.put("uname", uname);
        m.put("pwd", pwd);

        // uid/biz

        FileUtils.writeStringToFile(new File(accpath), JSONObject.toJSONString(m));
    }


    private static List getListFrmCollpath(String collpath) {

        File[] lst_fls = new File(collpath).listFiles();

        return Arrays.stream(lst_fls).map((File f) -> {
            return readFileToJsonobj_safe(f.getAbsolutePath());


        }).collect(Collectors.toList());
    }


    private static String getDatetimex() {
        DateFormat df3 = DateFormat.getDateInstance(DateFormat.MEDIUM, Locale.CHINA);

        DateFormat df7 = DateFormat.getTimeInstance(DateFormat.MEDIUM, Locale.CHINA);
        String date3 = df3.format(new Date());
        String time3 = df7.format(new Date());

        String dttm = date3 + " " + time3;
        return dttm;
    }


    private static void writeStrToFilFrmObj(String f, Object o) throws IOException {

        FileUtils.writeStringToFile(new File(f), JSONObject.toJSONString(o) + "\r\n");
    }

    private static JSONObject readFileToJsonobj(String f) throws IOException {
        String txt = FileUtils.readFileToString(new File(f), "utf8");
        JSONObject jo = JSONObject.parseObject(txt);
        return jo;
    }

    private static JSONObject readFileToJsonobj_safe(String f) {
        try {

            return readFileToJsonobj(f);
        } catch (IOException e) {
            throw new RuntimeException(e);
        }
    }
}

