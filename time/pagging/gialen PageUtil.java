package com.focusx.util;

import javax.servlet.http.HttpServletRequest;

import org.apache.commons.lang3.StringUtils;


/**
 * 分页工具
 * 
 * @author henryyan
 */
public class PageUtil {

  public static int PAGE_SIZE = 10;

  public static int[] init(Page<?> page, HttpServletRequest request) {
    int pageNumber = Integer.parseInt(StringUtils.defaultIfBlank(request.getParameter("p"), "1"));
    page.setPageNo(pageNumber);
    //int pageSize = Integer.parseInt(StringUtils.defaultIfBlank(request.getParameter("ps"), String.valueOf(PAGE_SIZE)));
    int pageSize = PAGE_SIZE;
    page.setPageSize(pageSize);
    int firstResult = page.getFirst();//从那条记录开始
    int maxResults = page.getPageSize();//每页记录数
    return new int[] {firstResult, maxResults};
  }

}
