package testkg;

import org.apache.commons.dbutils.QueryRunner;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

public class IstTestDbSqlt {

    public static void main(String[] args) throws ClassNotFoundException, SQLException, InterruptedException {

        Logger logger = LoggerFactory.getLogger(IstTestDbSqlt.class);
        System.out.println("====>db:");
        String JDBC_DRIVER = "org.sqlite.JDBC";
        String DB_URL = "jdbc:sqlite:sqlt2004.db";

        String USER = "root";
        String PASS = "root";
        Class.forName(JDBC_DRIVER);
        Connection conn = DriverManager.getConnection(DB_URL);
        QueryRunner queryRunner = new QueryRunner();
        // int n=0;

//		queryRunner.execute(conn, "SET FOREIGN_KEY_CHECKS = 0;");
//		queryRunner.execute(conn, "	SET UNIQUE_CHECKS = 0;");
//		 queryRunner.execute(conn, "SET AUTOCOMMIT = 0;");
//		queryRunner.execute(conn, "SET check_constraint_checks = 0;");

        try {
            queryRunner.update(conn, "CREATE TABLE t (c  TEXT) ");
        } catch (Throwable t) {
            t.printStackTrace();
        }
        queryRunner.update(conn, "      PRAGMA read_uncommitted = on;"); //loks not tkefk
        queryRunner.update(conn, "PRAGMA synchronous = OFF;");
     //   queryRunner.update(conn, "PRAGMA journal_mode = memory;");  sqlex err



	//	queryRunner.update(conn, "begin");  //very nice usefull ,,trx oopen    //  33w/ps

        // 创建固定大小的线程池:
        ExecutorService executor = Executors.newFixedThreadPool(24);
// 提交任务:

         //def is 1kps ,,loook like mysql
        logger.info("=============start.....");
        for (int n = 0; n < 1 * 10000; n++) {

            try {
                String sql = "insert into  t (c) values('aaaaaaaaaaaaaaaaaaaaaaaaadkjflkdsjfklasjfkld jfkdsajfkldsjfkldsjafklsdjafkljadkslfjdkl')";
                //	sql="CALL  im_admin.ist()";
                queryRunner.update(conn, sql);

        //       queryRunner.batch(conn,sql,      new Object[][] {           });  //if use batch 66w ps  pre sec ,but not insert in file,dont know y

//				if(n%9999==0)
////				{	queryRunner.update(conn, "commit");
////					queryRunner.update(conn, "begin");
//				}
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
