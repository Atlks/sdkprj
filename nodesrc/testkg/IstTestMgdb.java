package testkg;

import com.mongodb.MongoClient;
import com.mongodb.client.MongoCollection;
import com.mongodb.client.MongoDatabase;
import org.apache.commons.dbutils.QueryRunner;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import org.bson.Document;
public class IstTestMgdb {

	public static void main(String[] args) throws ClassNotFoundException, SQLException {
		String txt="'aaaaaaaaaaaaaaaaaaaaaaaaadkjflkdsjfklasjfkld jfkdsajfkldsjfkldsjafklsdjafkljadkslfjdkl'";
		Logger logger = LoggerFactory.getLogger(IstTestMgdb.class);
		System.out.println("====>db:");


		MongoClient mongoClient = new MongoClient( "localhost" , 27017 );

		// 连接到数据库
		MongoDatabase mongoDatabase = mongoClient.getDatabase("db7");

		//    mongoDatabase.createCollection("col1_tab1");



		MongoCollection<Document> collection = mongoDatabase.getCollection("col1_tab1");
		System.out.println("集合 test 选择成功");
		//插入文档
		/**
		 * 1. 创建文档 org.bson.Document 参数为key-value的格式
		 * 2. 创建文档集合List<Document>
		 * 3. 将文档集合插入数据库集合中 mongoCollection.insertMany(List<Document>) 插入单个文档可以用 mongoCollection.insertOne(Document)
		 * */

		System.out.println("fff");

	
		

		logger.info("=============start.....");
		for (int n = 0; n <9; n++) {

			try {
				Document document = new Document("title", "ttttt").
						append("description",txt).
						append("likes", 100).
						append("by", "Fly");

				collection.insertOne(document);
			} catch (Throwable e) {
				System.out.println(e);
			}

		}

		logger.info("===================end.....");
	}

}
