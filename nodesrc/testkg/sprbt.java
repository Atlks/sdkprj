//package com.im.action;
//
//import com.im.action.sys.GetSmsCodeAction;
//import org.springframework.boot.SpringApplication;
//import org.springframework.boot.autoconfigure.SpringBootApplication;
//import org.springframework.web.bind.annotation.RequestMapping;
//import org.springframework.web.bind.annotation.RestController;
//
//import javax.servlet.http.HttpServletRequest;
//import javax.servlet.http.HttpServletResponse;
//import java.io.IOException;
//
//@SpringBootApplication
//public class sprbt {
//	public static void main(String[] args) {
//		System.out.println(org.springframework.context.ConfigurableApplicationContext.class);
//	 	System.out.println(org.slf4j.spi.LocationAwareLogger.class);
//		SpringApplication.run(sprbt.class, args);
//	}
//}
//
//@RestController
//class ctrlr {
//	@RequestMapping("/im-biz/sys/getSmsCode")
//	public void  getSmsCode(HttpServletRequest req, HttpServletResponse resp) throws Exception {
//        	 	resp.getOutputStream().write(   new GetSmsCodeAction().doService());
//	}
//}