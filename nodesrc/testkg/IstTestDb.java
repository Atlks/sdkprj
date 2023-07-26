package testkg;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.concurrent.*;

import org.apache.commons.dbutils.QueryRunner;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

public class IstTestDb {

	public static void main(String[] args) throws ClassNotFoundException, SQLException, InterruptedException {

		Logger logger = LoggerFactory.getLogger(IstTestDb.class);
		System.out.println("====>db:");
		String JDBC_DRIVER = "com.mysql.jdbc.Driver";
		String DB_URL = "jdbc:mysql://localhost/test?allowMultiQueries=true&max_allowed_packet=50M";

		String USER = "root";
		String PASS = "root";
		Class.forName(JDBC_DRIVER);
		Connection conn = DriverManager.getConnection(DB_URL, USER, PASS);
		QueryRunner queryRunner = new QueryRunner();
		// int n=0;
		
		queryRunner.execute(conn, "SET FOREIGN_KEY_CHECKS = 0;");
		queryRunner.execute(conn, "	SET UNIQUE_CHECKS = 0;");
		 queryRunner.execute(conn, "SET AUTOCOMMIT = 0;");
		queryRunner.execute(conn, "SET check_constraint_checks = 0;");


		// 创建固定大小的线程池:
		ExecutorService executor = Executors.newFixedThreadPool(24);
// 提交任务:


		logger.info("=============start.....");
		for (int n = 0; n <90000; n++) {

			try {
				String sql = "insert   im_admin.tb set txt='aaaaaaaaaaaaaaaaaaaaaaaaadkjflkdsjfklasjfkld jfkdsajfkldsjfkldsjafklsdjafkljadkslfjdkl'";
			//	sql="CALL  im_admin.ist()";
				queryRunner.execute(conn, sql);

//				Future f=	executor.submit(new Callable<Object>() {
//					@Override
//					public Object call() throws Exception {
//
//						return null;
//					}
//				});
			} catch (Throwable e) {
				System.out.println(e);
			}
			//queryRunner.execute(conn, "commit" );
		}
//		executor.shutdown();
//		executor.awaitTermination(30, TimeUnit.SECONDS);
		logger.info("===================end.....");
	}

}
