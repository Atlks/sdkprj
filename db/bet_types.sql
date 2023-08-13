/*
 Navicat Premium Data Transfer

 Source Server         : locx
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : jbdb

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 12/08/2023 12:07:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bet_types
-- ----------------------------
DROP TABLE IF EXISTS `bet_types`;
CREATE TABLE `bet_types`  (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Display` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '显示名称',
  `Regex` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '下注指令名称',
  `Bet_Min` int(11) NULL DEFAULT NULL COMMENT '最小下注',
  `Bet_Max` int(11) NULL DEFAULT NULL COMMENT '最大下注',
  `Bet_Max_Total` int(11) NULL DEFAULT NULL COMMENT '最大总下注',
  `Odds` decimal(11, 2) NULL DEFAULT NULL COMMENT '赔率',
  `Create_Date` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  `Update_Date` timestamp NULL DEFAULT NULL COMMENT '更新日期\r\n',
  `type` int(11) NULL DEFAULT 0 COMMENT '代码逻辑里的type,详细内容参考代码',
  `value` int(11) NULL DEFAULT 0 COMMENT '扩展值,用来表示和值',
  `玩法` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `赔率类型` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `业务玩法` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE,
  INDEX `Id`(`Id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of bet_types
-- ----------------------------
INSERT INTO `bet_types` VALUES (1, 'a', 'a([1-9][0-9]*)', 100, 10000000, 100000000, 1.00, '2023-03-04 14:09:55', '2023-04-11 21:01:29', 0, 0, 'xxxx', NULL, NULL);
INSERT INTO `bet_types` VALUES (5, NULL, '\\d\\/\\d\\/\\d+', 100, 10000000, 10000000, 9.50, '2023-08-03 20:09:28', NULL, 0, 0, '特码球玩法', '特码球赔率', '特码球玩法');
INSERT INTO `bet_types` VALUES (6, NULL, '\\d\\/[大小单双]\\/\\d+', 100, 10000000, 10000000, 1.98, '2023-08-03 20:11:35', NULL, 0, 0, '特码球大小单双玩法', '特码球大小单双赔率', '特码球玩法');
INSERT INTO `bet_types` VALUES (8, NULL, '[龙虎]\\d+', 100, 10000000, 10000000, 1.98, '2023-08-04 13:38:07', NULL, 0, 0, '龙虎和玩法龙虎', '龙虎赔率', '龙虎和玩法');
INSERT INTO `bet_types` VALUES (9, NULL, '[大小单双]\\d+', 100, 10000000, 10000000, 1.98, '2023-08-04 13:38:41', NULL, 0, 0, '和值大小单双玩法', '和值大小单双赔率', '和值大小单双玩法');
INSERT INTO `bet_types` VALUES (11, NULL, '和\\d+', 100, 10000000, 10000000, 9.50, '2023-08-11 13:24:11', NULL, 0, 0, '龙虎和玩法和', '和赔率', '龙虎和玩法');
INSERT INTO `bet_types` VALUES (12, '', '', 100, 10000000, 10000000, 72.00, '2023-08-11 13:31:13', '2023-08-11 13:31:15', 0, 0, '前后三玩法豹子', '豹子赔率', '前后三玩法');
INSERT INTO `bet_types` VALUES (13, NULL, NULL, 100, 10000000, 10000000, 12.00, '2023-08-11 13:28:44', NULL, 0, 0, '前后三玩法顺子', '顺子赔率', '前后三玩法');
INSERT INTO `bet_types` VALUES (14, NULL, NULL, 100, 10000000, 10000000, 3.30, '2023-08-11 13:29:02', NULL, 0, 0, '前后三玩法对子', '对子赔率', '前后三玩法');
INSERT INTO `bet_types` VALUES (15, NULL, NULL, 100, 10000000, 10000000, 2.50, '2023-08-11 13:29:09', NULL, 0, 0, '前后三玩法半顺', '半顺赔率', '前后三玩法');
INSERT INTO `bet_types` VALUES (16, '', '前后三玩法', 100, 10000000, 10000000, 3.20, '2023-08-11 13:30:15', '2023-08-11 13:30:18', 0, 0, '前后三玩法杂六', '杂六赔率', '前后三玩法');

SET FOREIGN_KEY_CHECKS = 1;
