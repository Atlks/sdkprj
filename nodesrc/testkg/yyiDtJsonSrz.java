package testkg;


import com.alibaba.fastjson.JSONArray;
import com.alibaba.fastjson.JSONObject;
import org.apache.commons.io.FileUtils;

import java.io.File;
import java.io.IOException;

public class yyiDtJsonSrz {

    public static void main(String[] args) throws IOException {

        System.out.println();
        JSONArray ja=new JSONArray();

        for(int i=0;i<1000*10000;i++)
        {
            JSONObject jo=new JSONObject();
            jo.put("prk",1);
            jo.put("linenmgL",9999);
            ja.add(jo);
        }

        FileUtils.writeStringToFile(new File("yyiDt.txt"),ja.toJSONString());
    }

}