package mole.common;

import java.util.ArrayList;
import java.util.List;

public class Paging {
	public int PageSize = 0;

	public int Page = 0;

	public int PageCount = 0;

	public List list = null;

	public int listCount = 0;

	public List listCurPage = new ArrayList();

	public void setList(List list, int pagesize, int page) {
		this.list = list;
		this.listCount=list.size();
		this.PageSize = pagesize;
		this.Page = page;
		this.PageCount = this.getPagecount(list.size() , pagesize);
		int passcount = this.getPassCount();
		for (int i = 0; i < this.list.size(); i++) {
			if (i+1 > passcount) {
				this.listCurPage.add(list.get(i));
				if (this.listCurPage.size() == this.PageSize) {
					break;
				}
			}

		}

	}

	int getPassCount() {

		return (this.Page - 1) * this.PageSize;

	}

	int getPagecount(int listlen, int pagesize) {
		int n = 0;
		if (listlen % pagesize == 0)
			n = listlen / pagesize;
		else
			n = listlen / pagesize + 1;
		return n;

	}

	public static void main(String[] args) {

		List list = new ArrayList();
		for (int i = 1; i <= 21; i++)
			list.add(i);
		Paging p = new Paging();
		p.setList(list, 5, 2);
		System.out.print(p.PageCount);

	}

}
