package testkg;

import com.alibaba.fastjson.JSONObject;
import org.apache.commons.io.FileUtils;

import java.io.File;
import java.io.IOException;
import java.text.DateFormat;
import java.util.Arrays;
import java.util.Date;
import java.util.List;
import java.util.Locale;
import java.util.stream.Collectors;

public class ImUtil {



    public static List getListFrmCollpath(String collpath) {

        File[] lst_fls = new File(collpath).listFiles();

        return Arrays.stream(lst_fls).map((File f) -> {
            return readFileToJsonobj_safe(f.getAbsolutePath());


        }).collect(Collectors.toList());
    }


    public static String getDatetimex() {
        DateFormat df3 = DateFormat.getDateInstance(DateFormat.MEDIUM, Locale.CHINA);

        DateFormat df7 = DateFormat.getTimeInstance(DateFormat.MEDIUM, Locale.CHINA);
        String date3 = df3.format(new Date());
        String time3 = df7.format(new Date());

        String dttm = date3 + " " + time3;
        return dttm;
    }
    public static String getDate() {
        DateFormat df3 = DateFormat.getDateInstance(DateFormat.MEDIUM, Locale.CHINA);

        DateFormat df7 = DateFormat.getTimeInstance(DateFormat.MEDIUM, Locale.CHINA);
        String date3 = df3.format(new Date());



        return date3;
    }


    public static Object writeStrToFilFrmObj(String f, Object o) throws IOException {

        FileUtils.writeStringToFile(new File(f), JSONObject.toJSONString(o) + "\r\n");
        return o;
    }

    public static JSONObject readFileToJsonobj(String f) throws IOException {
        String txt = FileUtils.readFileToString(new File(f), "utf8");
        JSONObject jo = JSONObject.parseObject(txt);
        return jo;
    }

    public static JSONObject readFileToJsonobj_safe(String f) {
        try {

            return readFileToJsonobj(f);
        } catch (IOException e) {
            throw new RuntimeException(e);
        }
    }
}
