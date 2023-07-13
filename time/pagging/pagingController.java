package com.attilax.util;


import java.util.List;
import java.util.Map;

import org.apache.log4j.Logger;

//import com.mijie.homi.search.service.index.MoodUserIndexService;

public class pagingController {

	
	
	
	/**
	 * @param args
	 */
	public static void main(String[] args) {
	//List li=	 newPage(int offset,int limit,List li);

	}	public static Logger logger = Logger
	.getLogger(pagingController.class);
	
	public static List  newPage(int offset,int limit,List li){
		
		try {
			int toindex = offset + limit;
			int size = li.size();
			if (offset >= size) {
				offset = size - 1;
				toindex = offset;
			} else {
				if (toindex > size)
					toindex = size;
				//	toindex = size - 1;
			}
			List li3 = li.subList(offset, toindex);
			return li3;
		} catch (Exception e) {
			logger.info(god.getTrace(e));
			int toindex = 19;
			if (li.size() < 20)
				toindex = li.size();
			return li.subList(0, toindex);
		}

	}

}
