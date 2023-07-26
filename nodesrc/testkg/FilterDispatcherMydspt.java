//package com.im.action;
//
//import com.google.common.collect.Maps;
//
//import javax.servlet.*;
//import javax.servlet.http.HttpServletRequest;
//import javax.servlet.http.HttpServletResponse;
//import java.io.IOException;
//import java.util.Map;
//
//public class FilterDispatcherMydspt   implements Filter  {
//
//    public static void main(String[] args) {
//        System.out.println(11);
//    }
//
//    public static Map pathMap= Maps.newConcurrentMap();
//    @Override
//    public void init(FilterConfig filterConfig) throws ServletException {
//
//    }
//
//    @Override
//    public void doFilter(ServletRequest servletRequest, ServletResponse servletResponse, FilterChain filterChain) throws IOException, ServletException {
//        HttpServletRequest req = (HttpServletRequest) servletRequest;
//String path=req.getRequestURI();
//        HttpServletResponse resp = (HttpServletResponse) servletResponse;
//        AbstractAction act=(AbstractAction)pathMap.get(path);
//        System.out.println("=================>"+req.getRequestURI());
//        act.execute(resp.getOutputStream());
//        resp.getOutputStream().flush();
//        resp.flushBuffer();
//    }
//
//    @Override
//    public void destroy() {
//
//    }
//}
