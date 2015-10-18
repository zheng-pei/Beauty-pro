/*
Navicat MySQL Data Transfer

Source Server         : root
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : beauty

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-10-18 11:10:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `sk_area`
-- ----------------------------
DROP TABLE IF EXISTS `sk_area`;
CREATE TABLE `sk_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areaname` varchar(100) DEFAULT NULL COMMENT '地区名称',
  `pic` varchar(100) DEFAULT NULL COMMENT '城市图片',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `sort` int(4) DEFAULT NULL COMMENT '排序号',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '1启用 0禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='地区表';

-- ----------------------------
-- Records of sk_area
-- ----------------------------
INSERT INTO `sk_area` VALUES ('1', '武汉', '/Uploads/image/20150907/55ece10497589.jpg', '1441587463', '1', '1');
INSERT INTO `sk_area` VALUES ('2', '信阳', '/Uploads/image/20150907/55ed2e61be2b9.jpg', '1441607267', '2', '1');
INSERT INTO `sk_area` VALUES ('3', '成都', null, '1441587463', '3', '1');
INSERT INTO `sk_area` VALUES ('4', '安徽', null, '1441587463', '4', '1');
INSERT INTO `sk_area` VALUES ('5', '南燕', null, '1441587463', '5', '1');
INSERT INTO `sk_area` VALUES ('6', '深圳', null, '1441587463', '6', '1');
INSERT INTO `sk_area` VALUES ('7', '南京', null, '1441587463', '7', '1');
INSERT INTO `sk_area` VALUES ('8', '江苏', null, '1441587463', '8', '1');
INSERT INTO `sk_area` VALUES ('9', '北京', null, '1441587463', '9', '1');
INSERT INTO `sk_area` VALUES ('10', '上海', null, '1441587463', '10', '1');
INSERT INTO `sk_area` VALUES ('11', '长沙', null, '1441587463', '11', '1');
INSERT INTO `sk_area` VALUES ('12', '湖南', '/beautya/Uploads/image/20150922/5600d50231f30.jpg', '1441587463', '12', '1');

-- ----------------------------
-- Table structure for `sk_beautician`
-- ----------------------------
DROP TABLE IF EXISTS `sk_beautician`;
CREATE TABLE `sk_beautician` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areaid` int(6) DEFAULT NULL,
  `bsid` int(8) DEFAULT NULL COMMENT '商家ID',
  `name` varchar(30) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL COMMENT '头像',
  `comment` varchar(255) DEFAULT NULL COMMENT '个人介绍',
  `lab` varchar(100) DEFAULT NULL COMMENT '标签（逗号分隔）',
  `serviceid` varchar(255) DEFAULT NULL COMMENT '可服务项目（逗号分隔）',
  `tech` decimal(2,1) DEFAULT NULL COMMENT '手法评分',
  `att` decimal(2,1) DEFAULT NULL COMMENT '服务评分',
  `manner` decimal(2,1) DEFAULT NULL COMMENT '礼貌评分',
  `isrecom` int(1) DEFAULT NULL COMMENT '是否推荐',
  `createtime` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='美容师表';

-- ----------------------------
-- Records of sk_beautician
-- ----------------------------
INSERT INTO `sk_beautician` VALUES ('3', '1', '5', '美容师22', './Uploads/image/20150912/55f39973bd4fd.png', '很好的美容师,本人是很活泼开朗的人，对任何人的服务很好。,本人是很活泼开朗的人，对任何人的服务很好。本人是很活泼开朗的人，对任何人的服务很好。本人是很活泼开朗的人，对任何人的服务很好。本人是很活泼开朗的人，对任何人的服务很好。对任何人的服务很好对任何人的服务很好对任何人的服务很好对任何人的服务很好对任何人的服务很好对任何人的服务很好对任何人的服务很好对任何人的服务很好对任何人的服务很好对任何人的服务很好对任何人的服务很好对任何人的服务很好.', '服务1很好,非常1不错,耐1心', '1,2,3,4,5,6,7,8,9,11,10,12,13', '3.3', '5.5', '1.0', '0', '1441878844', '1');
INSERT INTO `sk_beautician` VALUES ('4', '1', '5', '王11', './Uploads/image/20150912/55f3dea822c7d.png', '本人是很活泼开朗的人，222对任何人的服务很好。', '服务2很好,非常3不错,耐4心', '1,5', '1.0', '1.0', '1.0', '0', '1441933263', '1');
INSERT INTO `sk_beautician` VALUES ('5', '1', '6', '张小米', './Uploads/image/20150912/55f397d9b7bb2.jpg', '本人是很活泼开朗的人，对任何人的服务很好。', '服务3很好,非常4不错,耐2心', '1,2,5,6', '3.0', '1.0', '1.0', '1', '1441937178', '1');
INSERT INTO `sk_beautician` VALUES ('6', '1', '6', '张小5', './Uploads/image/20150912/55f397d9b7bb2.jpg', '本人是很活泼开朗的人，对任何人的服务很好。', '服务4很好,非常6不错,耐3心', '1,5,6', '3.0', '3.0', '4.0', '1', '1441937179', '1');
INSERT INTO `sk_beautician` VALUES ('7', '1', '5', '张1', './Uploads/image/20150912/55f397d9b7bb2.jpg', '本人是很活泼开朗的人，222对任何人的服务很好。', '服务11很好,非常1不错,耐1心', '1,2,3,4,7,8,9,5,11', '4.0', '2.0', '4.0', '0', '1441937179', '1');
INSERT INTO `sk_beautician` VALUES ('8', '1', '5', '张小2', './Uploads/image/20150912/55f3dea822c7d.png', '本人是很活泼开朗的人，222对任何人的服务很好。', '服务12很好,非常1不错,耐1心', '1,5,6', '2.0', '3.0', '2.0', '1', '1441937179', '1');
INSERT INTO `sk_beautician` VALUES ('9', '1', '6', '张小3', './Uploads/image/20150912/55f3dea822c7d.png', '本人是很活泼开朗的人，222对任何人的服务很好。', '服务13很好,非常1不错,耐1心', '1,5,6', '3.0', '1.0', '1.0', '1', '1441937179', '1');
INSERT INTO `sk_beautician` VALUES ('10', '1', '6', '李33', './Uploads/image/20150912/55f3dea822c7d.png', '本人是很活泼开朗的人，222对任何人的服务很好。', '服务14很好,非常1不错,耐1心', '1,5,11', '4.0', '2.0', '2.0', '1', '1441937179', '1');
INSERT INTO `sk_beautician` VALUES ('11', '1', '6', '李晓', './Uploads/image/20150912/55f3dea822c7d.png', '', '服务15很好,非常1不错,耐1心', '1,3,5,6', '2.0', '1.0', '3.0', '1', '1441937179', '1');
INSERT INTO `sk_beautician` VALUES ('12', '1', '5', '熊大', './Uploads/image/20150912/55f3dea822c7d.png', '本人是很活泼开朗的人，222对任何人的服务很好。', '服务16很好,非常1不错,耐1心', '5,7,8,10', '3.0', '2.0', '2.0', '1', '1441937179', '1');
INSERT INTO `sk_beautician` VALUES ('13', '1', '5', '李晓2', './Uploads/image/20150912/55f3dea822c7d.png', '本人是很活泼开朗的人，222对任何人的服务很好。', '服务17很好,非常1不错,耐1心', '6,7,4,6', '5.0', '3.0', '2.0', '0', '1441937179', '1');
INSERT INTO `sk_beautician` VALUES ('14', '1', '5', '李4', './Uploads/image/20150912/55f3dea822c7d.png', '本人是很活泼开朗的人，222对任何人的服务很好。', '服务18很好,非常1不错,耐1心', '3,4,7', '4.0', '2.0', '1.0', '0', '1441937179', '1');
INSERT INTO `sk_beautician` VALUES ('15', '1', '6', '李6', './Uploads/image/20150912/55f3dea822c7d.png', '本人是很活泼开朗的人，222对任何人的服务很好。', '服务19很好,非常1不错,耐1心', '5', '3.0', '3.0', '2.0', '0', '1441937179', '1');
INSERT INTO `sk_beautician` VALUES ('16', '1', '6', '李9', './Uploads/image/20150912/55f3dea822c7d.png', '本人是很活泼开朗的人，222对任何人的服务很好。', '服务112很好,非常1不错,耐1心', '6', '2.0', '3.0', '3.0', '0', '1441937179', '1');
INSERT INTO `sk_beautician` VALUES ('17', '1', '6', '李10', './Uploads/image/20150912/55f3dea822c7d.png', '很活泼开朗的人，222对任何人的服务很好。', '服务14很好,非常1不错,耐1心', '1,2,3,4', '3.0', '2.0', '2.0', '0', '1441937179', '1');
INSERT INTO `sk_beautician` VALUES ('18', '1', '5', '熊大1', './Uploads/image/20150912/55f3dea822c7d.png', '很活泼开朗的人，222对任何人的服务很好。', '服务134很好,非常1不错,耐1心', '2,3,4', '2.0', '2.0', '3.0', '0', '1441937179', '1');
INSERT INTO `sk_beautician` VALUES ('19', '1', '6', '熊大2', './Uploads/image/20150912/55f3dea822c7d.png', '很活泼开朗的人，222对任何人的服务很好。', '服务17很好,非常1不错,耐1心', '2,5,7', '3.0', '2.0', '1.0', '0', '1441937179', '1');
INSERT INTO `sk_beautician` VALUES ('20', '1', '6', '熊大3', './Uploads/image/20150912/55f3dea822c7d.png', '很活泼开朗的人，222对任何人的服务很好。', '服务18很好,非常1不错,耐1心', '4,5,8', '4.0', '4.0', '3.0', '0', '1441937179', '1');
INSERT INTO `sk_beautician` VALUES ('21', '2', '3', '吖吖', '/beautya/Uploads/image/20150925/5604e7526714e.jpg', '你好', '', '0,1,2,3,4,5,6,7,9,10,11', '0.0', '0.0', '0.0', '0', '1443161939', '1');

-- ----------------------------
-- Table structure for `sk_beautyreview`
-- ----------------------------
DROP TABLE IF EXISTS `sk_beautyreview`;
CREATE TABLE `sk_beautyreview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `beautyid` int(8) DEFAULT NULL COMMENT '美容师ID',
  `serviceid` int(4) DEFAULT NULL COMMENT '服务项目ID',
  `orderid` int(8) DEFAULT NULL COMMENT '订单ID',
  `memberid` int(8) DEFAULT NULL COMMENT '评论人',
  `comment` varchar(255) DEFAULT NULL COMMENT '评论内容',
  `tech` decimal(2,1) DEFAULT NULL COMMENT '手法评分',
  `att` decimal(2,1) DEFAULT NULL COMMENT '服务评分',
  `manner` decimal(2,1) DEFAULT NULL COMMENT '礼貌评分',
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COMMENT='美容师评价表';

-- ----------------------------
-- Records of sk_beautyreview
-- ----------------------------
INSERT INTO `sk_beautyreview` VALUES ('1', '11', '5', '24', '1', '很好', '2.0', '3.0', '4.0', '1442213659');
INSERT INTO `sk_beautyreview` VALUES ('2', '11', '7', '28', '1', '很好', '5.0', '4.0', '4.0', '1442294227');
INSERT INTO `sk_beautyreview` VALUES ('3', '11', '11', '26', '1', '很好', '3.0', '3.0', '3.0', '1442294747');
INSERT INTO `sk_beautyreview` VALUES ('4', '11', '5', '24', '1', '我很喜欢这服务', '3.0', '3.0', '4.0', '1442310389');
INSERT INTO `sk_beautyreview` VALUES ('5', '19', '7', '4', '1', '', '1.0', '1.0', '1.0', '1442759166');
INSERT INTO `sk_beautyreview` VALUES ('6', '5', '2', '23', '1', '很不错', '4.0', '4.0', '4.0', '1441422173');
INSERT INTO `sk_beautyreview` VALUES ('7', '5', '2', '23', '1', '很不错', '4.0', '4.0', '4.0', '1441422281');
INSERT INTO `sk_beautyreview` VALUES ('15', '10', '1', '22', '1', '', '3.0', '3.0', '3.0', '1441425230');
INSERT INTO `sk_beautyreview` VALUES ('17', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441425283');
INSERT INTO `sk_beautyreview` VALUES ('18', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441425295');
INSERT INTO `sk_beautyreview` VALUES ('19', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441425420');
INSERT INTO `sk_beautyreview` VALUES ('20', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441425421');
INSERT INTO `sk_beautyreview` VALUES ('21', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441425422');
INSERT INTO `sk_beautyreview` VALUES ('22', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441425423');
INSERT INTO `sk_beautyreview` VALUES ('23', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441425424');
INSERT INTO `sk_beautyreview` VALUES ('24', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441425426');
INSERT INTO `sk_beautyreview` VALUES ('25', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441425452');
INSERT INTO `sk_beautyreview` VALUES ('26', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441425497');
INSERT INTO `sk_beautyreview` VALUES ('27', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441425500');
INSERT INTO `sk_beautyreview` VALUES ('28', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441425501');
INSERT INTO `sk_beautyreview` VALUES ('29', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441425503');
INSERT INTO `sk_beautyreview` VALUES ('30', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441425504');
INSERT INTO `sk_beautyreview` VALUES ('31', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441425576');
INSERT INTO `sk_beautyreview` VALUES ('32', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441425578');
INSERT INTO `sk_beautyreview` VALUES ('33', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441425586');
INSERT INTO `sk_beautyreview` VALUES ('34', '10', '1', '22', '1', '', '1.0', '1.0', '1.0', '1441426876');
INSERT INTO `sk_beautyreview` VALUES ('35', '10', '1', '22', '1', '', '0.0', '0.0', '0.0', '1441427165');
INSERT INTO `sk_beautyreview` VALUES ('36', '11', '1', '21', '1', '', '0.0', '0.0', '0.0', '1441427285');
INSERT INTO `sk_beautyreview` VALUES ('37', '11', '1', '21', '1', '', '0.0', '0.0', '0.0', '1441427369');
INSERT INTO `sk_beautyreview` VALUES ('38', '11', '1', '21', '1', '', '0.0', '0.0', '0.0', '1441432065');
INSERT INTO `sk_beautyreview` VALUES ('39', '10', '1', '19', '1', '', '0.0', '0.0', '0.0', '1441432100');
INSERT INTO `sk_beautyreview` VALUES ('40', '10', '1', '20', '1', '', '0.0', '0.0', '0.0', '1441432416');
INSERT INTO `sk_beautyreview` VALUES ('42', '10', '1', '18', '1', '', '0.0', '0.0', '0.0', '1441432473');
INSERT INTO `sk_beautyreview` VALUES ('43', '10', '1', '18', '1', '', '0.0', '0.0', '0.0', '1441432691');
INSERT INTO `sk_beautyreview` VALUES ('44', '5', '1', '17', '1', '很好', '2.0', '2.0', '2.0', '1441433824');
INSERT INTO `sk_beautyreview` VALUES ('45', '5', '1', '17', '1', '很好', '2.0', '2.0', '2.0', '1441433913');
INSERT INTO `sk_beautyreview` VALUES ('46', '5', '1', '16', '1', '很', '2.0', '2.0', '2.0', '1441433947');
INSERT INTO `sk_beautyreview` VALUES ('47', '5', '1', '16', '1', '很', '2.0', '2.0', '2.0', '1441433998');
INSERT INTO `sk_beautyreview` VALUES ('48', '5', '1', '16', '1', '很', '2.0', '2.0', '2.0', '1441434019');
INSERT INTO `sk_beautyreview` VALUES ('49', '5', '1', '16', '1', '很', '2.0', '2.0', '2.0', '1441434023');
INSERT INTO `sk_beautyreview` VALUES ('50', '5', '1', '16', '1', '很', '2.0', '2.0', '2.0', '1441434029');
INSERT INTO `sk_beautyreview` VALUES ('51', '5', '1', '16', '1', '很', '2.0', '2.0', '2.0', '1441434056');
INSERT INTO `sk_beautyreview` VALUES ('52', '5', '1', '16', '1', '很', '2.0', '2.0', '2.0', '1441434083');
INSERT INTO `sk_beautyreview` VALUES ('53', '5', '1', '16', '1', '很', '2.0', '2.0', '2.0', '1441434102');
INSERT INTO `sk_beautyreview` VALUES ('54', '5', '1', '16', '1', '很', '2.0', '2.0', '2.0', '1441434434');
INSERT INTO `sk_beautyreview` VALUES ('55', '5', '1', '16', '1', '很', '2.0', '2.0', '2.0', '1441434443');
INSERT INTO `sk_beautyreview` VALUES ('56', '5', '1', '16', '1', '很', '2.0', '2.0', '2.0', '1441434470');
INSERT INTO `sk_beautyreview` VALUES ('57', '5', '2', '15', '1', '', '2.0', '3.0', '3.0', '1441434494');
INSERT INTO `sk_beautyreview` VALUES ('58', '4', '5', '27', '1', '', '3.0', '4.0', '4.0', '1443166942');
INSERT INTO `sk_beautyreview` VALUES ('59', '5', '2', '13', '1', '', '4.0', '4.0', '4.0', '1443166950');
INSERT INTO `sk_beautyreview` VALUES ('60', '5', '2', '12', '1', '', '5.0', '5.0', '5.0', '1443166957');
INSERT INTO `sk_beautyreview` VALUES ('61', '5', '2', '11', '1', '', '4.0', '4.0', '4.0', '1443166964');
INSERT INTO `sk_beautyreview` VALUES ('62', '5', '2', '10', '1', '', '4.0', '4.0', '4.0', '1443166971');
INSERT INTO `sk_beautyreview` VALUES ('63', '12', '10', '9', '1', '', '4.0', '4.0', '5.0', '1443166979');
INSERT INTO `sk_beautyreview` VALUES ('64', '12', '10', '8', '1', '', '4.0', '4.0', '4.0', '1443166987');
INSERT INTO `sk_beautyreview` VALUES ('65', '12', '10', '7', '30', '', '3.0', '3.0', '3.0', '1443319365');

-- ----------------------------
-- Table structure for `sk_beautytime`
-- ----------------------------
DROP TABLE IF EXISTS `sk_beautytime`;
CREATE TABLE `sk_beautytime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `beautyid` int(8) DEFAULT NULL COMMENT '美容师ID',
  `memberid` int(8) DEFAULT NULL,
  `serviceid` int(6) DEFAULT NULL COMMENT '服务ID',
  `orderid` int(8) DEFAULT NULL COMMENT '订单ID',
  `ordertime` varchar(30) DEFAULT NULL COMMENT '占用时间点',
  `orderymd` varchar(20) DEFAULT NULL COMMENT '存放时分秒',
  `date` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COMMENT='美容师占用时间表';

-- ----------------------------
-- Records of sk_beautytime
-- ----------------------------
INSERT INTO `sk_beautytime` VALUES ('1', '17', '1', '2', '6', '2015-9-23 09:00', '2015-9-23', '09:00');
INSERT INTO `sk_beautytime` VALUES ('2', '17', '1', '2', '6', '2015-9-23 09:00', '2015-9-23', '09:00');
INSERT INTO `sk_beautytime` VALUES ('3', '12', '1', '10', '7', '2015-9-23 10:00', '2015-9-23', '10:00');
INSERT INTO `sk_beautytime` VALUES ('4', '12', '1', '10', '7', '2015-9-23 10:00', '2015-9-23', '10:30');
INSERT INTO `sk_beautytime` VALUES ('5', '12', '1', '10', '7', '2015-9-23 10:00', '2015-9-23', '11:00');
INSERT INTO `sk_beautytime` VALUES ('6', '12', '1', '10', '7', '2015-9-23 10:00', '2015-9-23', '11:30');
INSERT INTO `sk_beautytime` VALUES ('7', '12', '1', '10', '7', '2015-9-23 10:00', '2015-9-23', '12:00');
INSERT INTO `sk_beautytime` VALUES ('8', '12', '1', '10', '8', '2015-9-22 09:30', '2015-9-22', '09:30');
INSERT INTO `sk_beautytime` VALUES ('9', '12', '1', '10', '8', '2015-9-22 09:30', '2015-9-22', '10:00');
INSERT INTO `sk_beautytime` VALUES ('10', '12', '1', '10', '8', '2015-9-22 09:30', '2015-9-22', '10:30');
INSERT INTO `sk_beautytime` VALUES ('11', '12', '1', '10', '8', '2015-9-22 09:30', '2015-9-22', '11:00');
INSERT INTO `sk_beautytime` VALUES ('12', '12', '1', '10', '8', '2015-9-22 09:30', '2015-9-22', '11:30');
INSERT INTO `sk_beautytime` VALUES ('13', '12', '1', '10', '9', '2015-9-21 09:00', '2015-9-21', '09:00');
INSERT INTO `sk_beautytime` VALUES ('14', '12', '1', '10', '9', '2015-9-21 09:00', '2015-9-21', '09:30');
INSERT INTO `sk_beautytime` VALUES ('15', '12', '1', '10', '9', '2015-9-21 09:00', '2015-9-21', '10:00');
INSERT INTO `sk_beautytime` VALUES ('16', '12', '1', '10', '9', '2015-9-21 09:00', '2015-9-21', '10:30');
INSERT INTO `sk_beautytime` VALUES ('17', '5', '1', '2', '15', '2015-9-22 09:30', '2015-9-22', '09:30');
INSERT INTO `sk_beautytime` VALUES ('18', '5', '1', '1', '16', '2015-9-22 09:30', '2015-9-22', '09:30');
INSERT INTO `sk_beautytime` VALUES ('19', '5', '1', '1', '16', '2015-9-22 09:30', '2015-9-22', '10:00');
INSERT INTO `sk_beautytime` VALUES ('20', '5', '1', '1', '16', '2015-9-22 09:30', '2015-9-22', '10:30');
INSERT INTO `sk_beautytime` VALUES ('21', '5', '1', '1', '16', '2015-9-22 09:30', '2015-9-22', '11:00');
INSERT INTO `sk_beautytime` VALUES ('22', '5', '1', '1', '17', '2015-9-22 09:30', '2015-9-22', '09:30');
INSERT INTO `sk_beautytime` VALUES ('23', '5', '1', '1', '17', '2015-9-22 09:30', '2015-9-22', '09:30');
INSERT INTO `sk_beautytime` VALUES ('24', '5', '1', '1', '17', '2015-9-22 09:30', '2015-9-22', '09:30');
INSERT INTO `sk_beautytime` VALUES ('25', '5', '1', '1', '17', '2015-9-22 09:30', '2015-9-22', '09:30');
INSERT INTO `sk_beautytime` VALUES ('26', '10', '1', '1', '18', '2015-9-22 09:30', '2015-9-22', '09:30');
INSERT INTO `sk_beautytime` VALUES ('27', '10', '1', '1', '18', '2015-9-22 09:30', '2015-9-22', '09:30');
INSERT INTO `sk_beautytime` VALUES ('28', '10', '1', '1', '18', '2015-9-22 09:30', '2015-9-22', '09:30');
INSERT INTO `sk_beautytime` VALUES ('29', '10', '1', '1', '18', '2015-9-22 09:30', '2015-9-22', '09:30');
INSERT INTO `sk_beautytime` VALUES ('30', '10', '1', '1', '19', '2015-9-22 09:30', '2015-9-22', '09:30');
INSERT INTO `sk_beautytime` VALUES ('31', '10', '1', '1', '19', '2015-9-22 09:30', '2015-9-22', '10:00');
INSERT INTO `sk_beautytime` VALUES ('32', '10', '1', '1', '19', '2015-9-22 09:30', '2015-9-22', '10:30');
INSERT INTO `sk_beautytime` VALUES ('33', '10', '1', '1', '20', '2015-9-22 09:30', '2015-9-22', '09:30');
INSERT INTO `sk_beautytime` VALUES ('34', '10', '1', '1', '20', '2015-9-22 09:30', '2015-9-22', '10:00');
INSERT INTO `sk_beautytime` VALUES ('35', '10', '1', '1', '20', '2015-9-22 09:30', '2015-9-22', '10:30');
INSERT INTO `sk_beautytime` VALUES ('36', '11', '1', '1', '21', '2015-9-22 09:30', '2015-9-22', '09:30');
INSERT INTO `sk_beautytime` VALUES ('37', '11', '1', '1', '21', '2015-9-22 09:30', '2015-9-22', '10:00');
INSERT INTO `sk_beautytime` VALUES ('38', '11', '1', '1', '21', '2015-9-22 09:30', '2015-9-22', '10:30');
INSERT INTO `sk_beautytime` VALUES ('39', '10', '1', '1', '22', '2015-9-23 09:30', '2015-9-23', '09:30');
INSERT INTO `sk_beautytime` VALUES ('40', '10', '1', '1', '22', '2015-9-23 09:30', '2015-9-23', '10:00');
INSERT INTO `sk_beautytime` VALUES ('41', '10', '1', '1', '22', '2015-9-23 09:30', '2015-9-23', '10:30');
INSERT INTO `sk_beautytime` VALUES ('42', '5', '1', '2', '23', '2015-9-22 09:30', '2015-9-22', '09:30');
INSERT INTO `sk_beautytime` VALUES ('43', '19', '1', '7', '2', '2015-9-21 09:00', '2015-9-21', '09:00');
INSERT INTO `sk_beautytime` VALUES ('44', '19', '1', '7', '2', '2015-9-21 09:00', '2015-9-21', '09:30');
INSERT INTO `sk_beautytime` VALUES ('45', '4', '1', '5', '27', '2015-9-21 09:30', '2015-9-21', '09:30');
INSERT INTO `sk_beautytime` VALUES ('46', '4', '1', '5', '27', '2015-9-21 09:30', '2015-9-21', '10:00');
INSERT INTO `sk_beautytime` VALUES ('47', '4', '1', '5', '27', '2015-9-21 09:30', '2015-9-21', '10:30');
INSERT INTO `sk_beautytime` VALUES ('48', '4', '1', '5', '27', '2015-9-21 09:30', '2015-9-21', '11:00');
INSERT INTO `sk_beautytime` VALUES ('49', '4', '1', '5', '27', '2015-9-21 09:30', '2015-9-21', '11:30');

-- ----------------------------
-- Table structure for `sk_business`
-- ----------------------------
DROP TABLE IF EXISTS `sk_business`;
CREATE TABLE `sk_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areaid` int(6) DEFAULT NULL COMMENT '区域ID',
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL COMMENT '开始合作时间（选择）',
  `status` int(1) DEFAULT NULL COMMENT '状态  1 启用 0禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='商家表';

-- ----------------------------
-- Records of sk_business
-- ----------------------------
INSERT INTO `sk_business` VALUES ('2', '3', '商家5', 'bbb2', '我是第二个商家', '1442192600', '0');
INSERT INTO `sk_business` VALUES ('3', '2', '商家3', 'bbb3', '88 ', '1442192601', '1');
INSERT INTO `sk_business` VALUES ('4', '2', '商家4', '11111', '555', '1442192602', '1');
INSERT INTO `sk_business` VALUES ('5', '1', '商家2', '武汉关山3', ' 1111                  ', '1442192603', '0');
INSERT INTO `sk_business` VALUES ('6', '1', '美容2', '武汉关山', '岁到范德萨范德萨分', '1442192604', '1');
INSERT INTO `sk_business` VALUES ('7', '1', '美容商家4', '商家地址2', '发送大夫三大范德萨发送大', '1442192605', '0');
INSERT INTO `sk_business` VALUES ('8', '1', '美容3', '范德萨发', ' 22', '1442192607', '1');
INSERT INTO `sk_business` VALUES ('9', '1', '美容4', '武汉关山', '飞洒范德萨分范德萨啊', '1442192700', '1');
INSERT INTO `sk_business` VALUES ('10', '1', '美容1', '武汉', 'fsdfsadfdasfasdf', '1441209701', '1');

-- ----------------------------
-- Table structure for `sk_member`
-- ----------------------------
DROP TABLE IF EXISTS `sk_member`;
CREATE TABLE `sk_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` varchar(20) DEFAULT NULL COMMENT '编号(自动生成)',
  `nickname` varchar(100) DEFAULT NULL COMMENT '昵称（取自微信，可以改）',
  `truename` varchar(100) DEFAULT NULL COMMENT '用户姓名',
  `phone` varchar(20) DEFAULT NULL COMMENT '电话号码',
  `openid` varchar(20) DEFAULT NULL COMMENT '微信号',
  `pic` varchar(50) DEFAULT NULL COMMENT '头像(微信)链接地址',
  `point` int(8) DEFAULT NULL COMMENT '积分数',
  `createtime` int(11) NOT NULL COMMENT '会员注册时间',
  `yuyuename` varchar(100) DEFAULT NULL,
  `yuyuephone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Records of sk_member
-- ----------------------------
INSERT INTO `sk_member` VALUES ('1', 'A001', '我是Nick112', '张三', '138001309282', 'admin123', '/Uploads/image/20150906/55ebaf6ea66eb.jpg', '91', '1441526786', null, null);
INSERT INTO `sk_member` VALUES ('2', 'A002', '管理员', '李四', '13800138000', 'admin456', '/Uploads/image/20150906/55eb9fc434ca5.jpg', '10000', '1441526786', null, null);
INSERT INTO `sk_member` VALUES ('3', 'A001', '管理员', '张三2', '13800138000', 'admin123', '/Uploads/image/20150906/55eb9fc434ca5.jpg', '10000', '1441526786', null, null);
INSERT INTO `sk_member` VALUES ('4', null, null, null, null, 'abcdefg', null, null, '1442828063', null, null);

-- ----------------------------
-- Table structure for `sk_message`
-- ----------------------------
DROP TABLE IF EXISTS `sk_message`;
CREATE TABLE `sk_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(8) DEFAULT NULL COMMENT '会员ID',
  `comment` varchar(100) DEFAULT NULL COMMENT '消息内容',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `status` int(1) DEFAULT NULL COMMENT '0未读 1已读',
  `orderid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='消息表';

-- ----------------------------
-- Records of sk_message
-- ----------------------------
INSERT INTO `sk_message` VALUES ('1', '1', '支付成功', '1442759717', '1', '3');
INSERT INTO `sk_message` VALUES ('2', '1', '支付成功', '1442759990', '1', '4');
INSERT INTO `sk_message` VALUES ('3', '1', '支付成功', '1442759992', '1', '2');
INSERT INTO `sk_message` VALUES ('4', '1', '支付成功', '1442759995', '1', '5');
INSERT INTO `sk_message` VALUES ('5', '1', '支付成功', '1442761676', '1', '3');
INSERT INTO `sk_message` VALUES ('6', '1', '支付成功', '1442797003', '0', '6');
INSERT INTO `sk_message` VALUES ('7', '1', '支付成功', '1442797283', '0', '6');
INSERT INTO `sk_message` VALUES ('8', '1', '支付成功', '1442797563', '0', '7');
INSERT INTO `sk_message` VALUES ('9', '1', '支付成功', '1442798004', '0', '8');
INSERT INTO `sk_message` VALUES ('10', '1', '支付成功', '1442798396', '1', '9');
INSERT INTO `sk_message` VALUES ('11', '1', '支付成功', '1442798593', '0', '10');
INSERT INTO `sk_message` VALUES ('12', '1', '支付成功', '1442798701', '0', '11');
INSERT INTO `sk_message` VALUES ('13', '1', '支付成功', '1442798794', '0', '12');
INSERT INTO `sk_message` VALUES ('14', '1', '支付成功', '1442798825', '0', '13');
INSERT INTO `sk_message` VALUES ('15', '1', '支付成功', '1442798919', '0', '14');
INSERT INTO `sk_message` VALUES ('16', '1', '支付成功', '1442798999', '0', '15');
INSERT INTO `sk_message` VALUES ('17', '1', '支付成功', '1442799190', '0', '16');
INSERT INTO `sk_message` VALUES ('18', '1', '支付成功', '1442799300', '0', '17');
INSERT INTO `sk_message` VALUES ('19', '1', '支付成功', '1442799366', '0', '18');
INSERT INTO `sk_message` VALUES ('20', '1', '支付成功', '1442799407', '0', '19');
INSERT INTO `sk_message` VALUES ('21', '1', '支付成功', '1442799504', '0', '20');
INSERT INTO `sk_message` VALUES ('22', '1', '支付成功', '1442799545', '0', '21');
INSERT INTO `sk_message` VALUES ('23', '1', '支付成功', '1442800016', '0', '22');
INSERT INTO `sk_message` VALUES ('24', '1', '支付成功', '1442800197', '0', '23');
INSERT INTO `sk_message` VALUES ('25', '1', '支付成功', '1441434518', '0', '2');
INSERT INTO `sk_message` VALUES ('26', '1', '支付成功', '1442819185', '0', '27');

-- ----------------------------
-- Table structure for `sk_node`
-- ----------------------------
DROP TABLE IF EXISTS `sk_node`;
CREATE TABLE `sk_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nodename` varchar(20) DEFAULT NULL COMMENT '菜单名',
  `title` varchar(20) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL COMMENT '链接地址',
  `pid` int(2) DEFAULT NULL COMMENT '父级ID',
  `sort` int(4) DEFAULT NULL COMMENT '排序号',
  `level` int(4) DEFAULT NULL COMMENT '级别',
  `module` varchar(50) DEFAULT NULL COMMENT '控制器',
  `action` varchar(50) DEFAULT NULL COMMENT '方法名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='菜单表';

-- ----------------------------
-- Records of sk_node
-- ----------------------------
INSERT INTO `sk_node` VALUES ('1', '系统设置', null, null, '0', '1', '1', null, null);
INSERT INTO `sk_node` VALUES ('2', '业务管理', null, null, '0', '2', '1', null, null);
INSERT INTO `sk_node` VALUES ('3', '会员管理', null, null, '0', '3', '1', null, null);
INSERT INTO `sk_node` VALUES ('4', '数据中心', null, null, '0', '4', '1', null, null);
INSERT INTO `sk_node` VALUES ('6', '管理员设置', null, null, '1', '1', '2', null, null);
INSERT INTO `sk_node` VALUES ('7', '服务项目', null, null, '2', '1', '2', null, null);
INSERT INTO `sk_node` VALUES ('9', '系统设置', null, null, '1', '2', '2', null, null);
INSERT INTO `sk_node` VALUES ('10', '订单管理', null, null, '2', '2', '2', null, null);
INSERT INTO `sk_node` VALUES ('11', '会员管理', null, null, '3', '1', '2', null, null);
INSERT INTO `sk_node` VALUES ('12', '订单数据', null, null, '4', '1', '2', null, null);
INSERT INTO `sk_node` VALUES ('13', '管理员管理', null, null, '6', '1', '3', 'Flaguser', 'index');
INSERT INTO `sk_node` VALUES ('14', '管理员角色管理', null, null, '6', '2', '3', 'Flagrole', 'index');
INSERT INTO `sk_node` VALUES ('15', '综合设置', null, null, '9', '1', '3', 'Setting', 'index');
INSERT INTO `sk_node` VALUES ('16', '轮播图设置', null, null, '9', '2', '3', 'Scrollad', 'index');
INSERT INTO `sk_node` VALUES ('17', '地区设置', null, null, '9', '3', '3', 'Area', 'index');
INSERT INTO `sk_node` VALUES ('18', '服务类型设置', null, null, '9', '4', '3', 'Servicetype', 'index');
INSERT INTO `sk_node` VALUES ('19', '服务特点设置', null, null, '9', '5', '3', 'Servicelab', 'index');
INSERT INTO `sk_node` VALUES ('20', '服务项目管理', null, null, '7', '1', '3', 'Service', 'index');
INSERT INTO `sk_node` VALUES ('21', '商家管理', null, null, '7', '2', '3', 'Business', 'index');
INSERT INTO `sk_node` VALUES ('22', '美容师管理', null, null, '7', '3', '3', 'Beautician', 'index');
INSERT INTO `sk_node` VALUES ('23', '订单管理', null, null, '10', '1', '3', 'Order', 'index');
INSERT INTO `sk_node` VALUES ('24', '会员管理', null, null, '11', '1', '3', 'Member', 'index');
INSERT INTO `sk_node` VALUES ('26', '商家订单统计', null, null, '12', '1', '3', 'Shoporder', 'index');
INSERT INTO `sk_node` VALUES ('29', '会员积分管理', null, null, '11', '6', '3', 'Pointevent', 'index');

-- ----------------------------
-- Table structure for `sk_order`
-- ----------------------------
DROP TABLE IF EXISTS `sk_order`;
CREATE TABLE `sk_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` varchar(20) DEFAULT NULL COMMENT '订单编号',
  `orderid` int(8) DEFAULT NULL,
  `beautyid` int(8) DEFAULT NULL COMMENT '美容师ID',
  `serviceid` int(6) DEFAULT NULL,
  `memberid` int(8) DEFAULT NULL,
  `ordertime` char(20) NOT NULL COMMENT '预定时间',
  `orderprice` decimal(8,2) DEFAULT NULL COMMENT '订单金额',
  `trueprice` decimal(8,2) DEFAULT NULL COMMENT '实付金额',
  `truename` varchar(30) DEFAULT NULL COMMENT '预约人姓名',
  `phone` varchar(15) DEFAULT NULL COMMENT '预约人电话',
  `createtime` int(11) DEFAULT NULL,
  `status` int(2) DEFAULT NULL COMMENT '状态 2取消 10待支付 20已支付(待评价) 30评价完成',
  `usepoint` int(11) NOT NULL DEFAULT '0' COMMENT '使用积分抵扣',
  `isread` int(1) NOT NULL DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='订单表';

-- ----------------------------
-- Records of sk_order
-- ----------------------------
INSERT INTO `sk_order` VALUES ('1', 'C09201921083609', '1', '19', '7', '1', '2015-9-21 09:00', '104.40', '111.00', '张三', '138001309282', '1442748068', '10', '33', '1', null);
INSERT INTO `sk_order` VALUES ('2', 'C09201925291361', '2', '19', '7', '1', '2015-9-21 09:00', '104.40', '111.00', '张三', '138001309282', '1442748329', '20', '33', '1', null);
INSERT INTO `sk_order` VALUES ('3', 'C09201938208120', '3', '19', '7', '1', '2015-9-21 09:30', '102.20', '111.00', '张三', '138001309282', '1442749100', '20', '44', '1', null);
INSERT INTO `sk_order` VALUES ('4', 'C09201939281434', '4', '19', '7', '1', '2015-9-21 09:30', '102.20', '111.00', '张三', '138001309282', '1442749168', '30', '44', '1', null);
INSERT INTO `sk_order` VALUES ('5', 'C09202130404562', '5', '8', '1', '1', '2015-9-21 09:30', '196.80', '210.00', '张三', '138001309282', '1442755840', '20', '66', '1', null);
INSERT INTO `sk_order` VALUES ('6', 'C09210856332680', '6', '17', '2', '1', '2015-9-23 09:00', '90.20', '99.00', '张三', '138001309282', '1442796993', '10', '44', '1', '');
INSERT INTO `sk_order` VALUES ('7', 'C09210905548873', '7', '12', '10', '1', '2015-9-23 10:00', '40.20', '49.00', '张三', '138001309282', '1442797554', '10', '44', '1', '');
INSERT INTO `sk_order` VALUES ('8', 'C09210913203708', '8', '12', '10', '1', '2015-9-22 09:30', '49.00', '49.00', '张三', '138001309282', '1442798000', '2', '0', '1', '');
INSERT INTO `sk_order` VALUES ('9', 'C09210919525144', '9', '12', '10', '1', '2015-9-21 09:00', '48.56', '49.00', '张三', '138001309282', '1442798392', '2', '4', '1', '打发');
INSERT INTO `sk_order` VALUES ('10', 'C09210923085470', '10', '5', '2', '1', '2015-9-21 09:30', '98.80', '99.00', '张三', '138001309282', '1442798588', '10', '1', '1', '');
INSERT INTO `sk_order` VALUES ('11', 'C09210924597344', '11', '5', '2', '1', '2015-9-22 09:30', '98.80', '99.00', '张三', '138001309282', '1442798699', '30', '1', '1', null);
INSERT INTO `sk_order` VALUES ('12', 'C09210926324529', '12', '5', '2', '1', '2015-9-22 09:30', '98.80', '99.00', '张三', '138001309282', '1442798792', '2', '1', '1', '额额额11');
INSERT INTO `sk_order` VALUES ('13', 'C09210927043028', '13', '5', '2', '1', '2015-9-22 09:30', '98.80', '99.00', '张三', '138001309282', '1442798824', '2', '1', '1', 'hao ');
INSERT INTO `sk_order` VALUES ('14', 'C09210928374623', '14', '5', '2', '1', '2015-9-22 09:30', '98.80', '99.00', '张三', '138001309282', '1442798917', '2', '1', '1', '');
INSERT INTO `sk_order` VALUES ('15', 'C09210929584484', '15', '5', '2', '1', '2015-9-22 09:30', '98.80', '99.00', '张三', '138001309282', '1442798998', '30', '1', '1', null);
INSERT INTO `sk_order` VALUES ('16', 'C09210933076309', '16', '5', '1', '1', '2015-9-22 09:30', '208.20', '210.00', '张三', '138001309282', '1442799187', '2', '9', '1', '55');
INSERT INTO `sk_order` VALUES ('17', 'C09210934585570', '17', '5', '1', '1', '2015-9-22 09:30', '208.20', '210.00', '张三', '138001309282', '1442799298', '30', '9', '1', null);
INSERT INTO `sk_order` VALUES ('18', 'C09210935598104', '18', '10', '1', '1', '2015-9-22 09:30', '208.40', '210.00', '张三', '138001309282', '1442799359', '30', '8', '1', 'vvv11');
INSERT INTO `sk_order` VALUES ('19', 'C09210936402118', '19', '10', '1', '1', '2015-9-22 09:30', '208.40', '210.00', '张三', '138001309282', '1442799400', '30', '8', '1', 'hao 55');
INSERT INTO `sk_order` VALUES ('20', 'C09210938231962', '20', '10', '1', '1', '2015-9-22 09:30', '208.40', '210.00', '张三', '138001309282', '1442799503', '30', '8', '1', 'hao ');
INSERT INTO `sk_order` VALUES ('21', 'C09210939032204', '21', '11', '1', '1', '2015-9-22 09:30', '100.00', '210.00', '张三', '138001309282', '1442799543', '2', '1', '1', '等待支付 的订单要取消');
INSERT INTO `sk_order` VALUES ('22', 'C09210946547554', '22', '10', '1', '1', '2015-9-23 09:30', '209.80', '210.00', '张三', '138001309282', '1442800014', '2', '1', '1', '支付成功的订单要取消');

-- ----------------------------
-- Table structure for `sk_payorder`
-- ----------------------------
DROP TABLE IF EXISTS `sk_payorder`;
CREATE TABLE `sk_payorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(8) DEFAULT NULL,
  `paynum` varchar(20) DEFAULT NULL COMMENT '支付订单号',
  `payamount` decimal(8,2) DEFAULT NULL COMMENT '支付金额',
  `paystatus` int(1) DEFAULT NULL COMMENT '支付状态 0支付失败 1支付成功 2退费',
  `fundnum` varchar(20) DEFAULT NULL COMMENT '退费单号',
  `fundstatus` int(1) DEFAULT NULL COMMENT '退费状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支付信息表';

-- ----------------------------
-- Records of sk_payorder
-- ----------------------------

-- ----------------------------
-- Table structure for `sk_pointrecord`
-- ----------------------------
DROP TABLE IF EXISTS `sk_pointrecord`;
CREATE TABLE `sk_pointrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mathtype` int(2) DEFAULT NULL COMMENT '计算方式 1 增加 0 减少',
  `eventtype` int(2) DEFAULT NULL COMMENT '1消费获得积分 2积分抵扣 3签到获得积分',
  `comment` varchar(100) DEFAULT NULL COMMENT '积分说明',
  `point` int(8) DEFAULT NULL COMMENT '积分',
  `memberid` int(8) DEFAULT NULL COMMENT '会员ID',
  `createtime` int(11) DEFAULT NULL COMMENT '建立时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='积分变更记录';

-- ----------------------------
-- Records of sk_pointrecord
-- ----------------------------
INSERT INTO `sk_pointrecord` VALUES ('1', '1', '3', '签到获得积分', '1', '1', '1442670875');
INSERT INTO `sk_pointrecord` VALUES ('3', '1', '3', '签到获得积分', '1', '1', '1442755045');
INSERT INTO `sk_pointrecord` VALUES ('4', '0', '2', '订单编号：C09202130404562使用积分', '66', '1', '1442755840');
INSERT INTO `sk_pointrecord` VALUES ('5', '0', '2', '订单编号：C09202130404562使用积分', '66', '1', '1442755840');
INSERT INTO `sk_pointrecord` VALUES ('6', '0', '2', '订单编号：C09202130404562使用积分', '66', '1', '1442755840');
INSERT INTO `sk_pointrecord` VALUES ('7', '0', '2', '订单编号：C09202130404562使用积分', '66', '1', '1442755840');
INSERT INTO `sk_pointrecord` VALUES ('8', '0', '2', '订单编号：C09201938208120使用积分', '44', '1', '1442749100');
INSERT INTO `sk_pointrecord` VALUES ('9', '0', '2', '订单编号：C09210856332680使用积分', '44', '1', '1442796993');
INSERT INTO `sk_pointrecord` VALUES ('10', '0', '2', '订单编号：C09210856332680使用积分', '44', '1', '1442796993');
INSERT INTO `sk_pointrecord` VALUES ('11', '1', '3', '签到获得积分', '1', '1', '1442797344');
INSERT INTO `sk_pointrecord` VALUES ('12', '0', '2', '订单编号：C09210905548873使用积分', '44', '1', '1442797554');
INSERT INTO `sk_pointrecord` VALUES ('13', '0', '2', '订单编号：C09210913203708使用积分', '0', '1', '1442798000');
INSERT INTO `sk_pointrecord` VALUES ('14', '0', '2', '订单编号：C09210919525144使用积分', '4', '1', '1442798392');
INSERT INTO `sk_pointrecord` VALUES ('15', '0', '2', '订单编号：C09210923085470使用积分', '1', '1', '1442798588');
INSERT INTO `sk_pointrecord` VALUES ('16', '0', '2', '订单编号：C09210924597344使用积分', '1', '1', '1442798699');
INSERT INTO `sk_pointrecord` VALUES ('17', '0', '2', '订单编号：C09210926324529使用积分', '1', '1', '1442798792');
INSERT INTO `sk_pointrecord` VALUES ('18', '0', '2', '订单编号：C09210927043028使用积分', '1', '1', '1442798824');
INSERT INTO `sk_pointrecord` VALUES ('19', '0', '2', '订单编号：C09210928374623使用积分', '1', '1', '1442798917');
INSERT INTO `sk_pointrecord` VALUES ('20', '0', '2', '订单编号：C09210929584484使用积分', '1', '1', '1442798998');
INSERT INTO `sk_pointrecord` VALUES ('21', '0', '2', '订单编号：C09210933076309使用积分', '9', '1', '1442799187');
INSERT INTO `sk_pointrecord` VALUES ('22', '0', '2', '订单编号：C09210934585570使用积分', '9', '1', '1442799298');
INSERT INTO `sk_pointrecord` VALUES ('23', '0', '2', '订单编号：C09210935598104使用积分', '8', '1', '1442799359');
INSERT INTO `sk_pointrecord` VALUES ('24', '0', '2', '订单编号：C09210936402118使用积分', '8', '1', '1442799400');
INSERT INTO `sk_pointrecord` VALUES ('25', '0', '2', '订单编号：C09210938231962使用积分', '8', '1', '1442799503');
INSERT INTO `sk_pointrecord` VALUES ('26', '0', '2', '订单编号：C09210939032204使用积分', '1', '1', '1442799543');
INSERT INTO `sk_pointrecord` VALUES ('27', '0', '2', '订单编号：C09210946547554使用积分', '1', '1', '1442800014');
INSERT INTO `sk_pointrecord` VALUES ('28', '0', '2', '订单编号：C09210949549155使用积分', '0', '1', '1442800194');
INSERT INTO `sk_pointrecord` VALUES ('29', '1', '3', '签到获得积分', '1', '1', '1441072664');
INSERT INTO `sk_pointrecord` VALUES ('30', '1', '3', '签到获得积分', '1', '1', '1441245584');
INSERT INTO `sk_pointrecord` VALUES ('31', '1', '3', '签到获得积分', '1', '1', '1441418440');
INSERT INTO `sk_pointrecord` VALUES ('32', '0', '2', '订单编号：C09201925291361使用积分', '33', '1', '1442748329');
INSERT INTO `sk_pointrecord` VALUES ('33', '0', '2', '订单编号：C09211506207416使用积分', '0', '1', '1442819180');
INSERT INTO `sk_pointrecord` VALUES ('34', '1', '3', '签到获得积分', '1', '1', '1442924637');
INSERT INTO `sk_pointrecord` VALUES ('35', '1', '3', '签到获得积分', '1', '1', '1443319383');

-- ----------------------------
-- Table structure for `sk_role`
-- ----------------------------
DROP TABLE IF EXISTS `sk_role`;
CREATE TABLE `sk_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(30) DEFAULT NULL COMMENT '角色名',
  `remark` varchar(30) DEFAULT NULL COMMENT '备注',
  `node` varchar(500) DEFAULT NULL COMMENT '角色权限',
  `operation` varchar(255) DEFAULT NULL,
  `issystem` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员角色表';

-- ----------------------------
-- Records of sk_role
-- ----------------------------
INSERT INTO `sk_role` VALUES ('1', '系统管理员', '系统管理员', '13,14,15,16,17,18,19,20,21,22,23,24,25,26', '1,2,3,4,5,6,7,10,11,12', '1');
INSERT INTO `sk_role` VALUES ('2', '自定义角色一', '自定义角色一', '20,21,22,23,24,29,26', null, '0');

-- ----------------------------
-- Table structure for `sk_scrollad`
-- ----------------------------
DROP TABLE IF EXISTS `sk_scrollad`;
CREATE TABLE `sk_scrollad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adname` varchar(30) DEFAULT NULL COMMENT '名称',
  `pic` varchar(50) DEFAULT NULL COMMENT '轮播图片',
  `url` varchar(100) DEFAULT NULL COMMENT '链接地址',
  `sort` int(6) NOT NULL DEFAULT '0' COMMENT '排序号',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '0禁用 1启用',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='轮播广告';

-- ----------------------------
-- Records of sk_scrollad
-- ----------------------------
INSERT INTO `sk_scrollad` VALUES ('7', 'mmm', './Uploads/image/20150911/55f29b868059f.jpg', 'mmm', '50', '1', null);
INSERT INTO `sk_scrollad` VALUES ('9', 'zzzz', './Uploads/image/20150911/55f29b794d55f.jpg', 'zzzzz', '50', '1', null);
INSERT INTO `sk_scrollad` VALUES ('10', 'ggggggggwww', './Uploads/image/20150911/55f29b6a04a9b.jpg', 'gggggwwwww', '50', '1', null);
INSERT INTO `sk_scrollad` VALUES ('12', '99999', './Uploads/image/20150911/55f29b54c068a.jpg', '999999', '50', '1', null);
INSERT INTO `sk_scrollad` VALUES ('13', 'banner2', './Uploads/image/20150911/55f29b47ad362.jpg', 'bbbbbbbbbbbfffffff', '2', '1', '1441514633');
INSERT INTO `sk_scrollad` VALUES ('14', 'banner1', './Uploads/image/20150911/55f29b2d51471.jpg', 'http://www.baidu.com', '1', '1', '1441533875');
INSERT INTO `sk_scrollad` VALUES ('15', '333', '/beautya/Uploads/image/20151008/5615fedbcfa74.png', 'http://www.cdd.com', '7', '1', '1444282077');

-- ----------------------------
-- Table structure for `sk_service`
-- ----------------------------
DROP TABLE IF EXISTS `sk_service`;
CREATE TABLE `sk_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `areaid` int(4) DEFAULT NULL COMMENT '区域ID',
  `classid` int(2) DEFAULT NULL COMMENT '分类ID',
  `smallpic` varchar(100) DEFAULT NULL COMMENT '服务图标（列表）',
  `coverpic` varchar(100) DEFAULT NULL COMMENT '服务封面',
  `name` varchar(50) DEFAULT NULL COMMENT '服务名称',
  `lab` varchar(30) DEFAULT NULL COMMENT '服务标签',
  `summary` varchar(100) DEFAULT NULL COMMENT '服务概要',
  `servicetime` int(11) DEFAULT NULL COMMENT '服务时间（单位：分钟）',
  `origprice` decimal(8,2) DEFAULT NULL COMMENT '院线价格',
  `trueprice` decimal(8,2) DEFAULT NULL COMMENT '服务价格',
  `comment` varchar(200) DEFAULT NULL COMMENT '项目介绍',
  `appuser` varchar(100) DEFAULT NULL COMMENT '适用人群',
  `product` varchar(500) DEFAULT NULL COMMENT '使用产品步骤（逗号分隔）',
  `attention` varchar(500) DEFAULT NULL COMMENT '注意事项（逗号分隔）',
  `isrecom` int(1) NOT NULL DEFAULT '0' COMMENT '是否推荐 1是 0不是',
  `createtime` int(11) DEFAULT NULL,
  `sort` int(4) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '状态 1启用  0禁用',
  `subname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='服务项目表';

-- ----------------------------
-- Records of sk_service
-- ----------------------------
INSERT INTO `sk_service` VALUES ('1', '1', '1', './Uploads/image/20150911/55f2a02146b28.png', './Uploads/image/20150911/55f2a025ccc4b.jpg', '面部spa', '2,3', '服务很好1', '86', '222.00', '210.00', '关于肌肤问题，有个著名的“苹果理论”，肌肤问题像一只苹果的腐烂当第一块变质发生，总是以加速度迅速发展、蔓延，当腐烂到一定程度时，苹果的腐烂速度会减缓，但这时候的苹果已经发酸、发臭了。如果在苹果刚开始出问题时，就将变质部分清理掉，苹果的变质会大大延缓这就是女人肌肤保养中的“苹果理论”。', '任何女性肌肤，是一个基础保养', '双层眼部卸妆水,脂质囊修复眼霜,豆蔻素洁肤水', '双层眼部卸妆水,脂质囊修复眼霜,豆蔻素洁肤水', '1', '1441964072', '1', '1', '缓解快节奏生活带给您的身心压力');
INSERT INTO `sk_service` VALUES ('2', '1', '1', './Uploads/image/20150912/55f392e287d7b.png', './Uploads/image/20150912/55f392ecdd46a.jpg', '海藻啫喱玫瑰养润', '2,3', '服务很好1', '30', '100.00', '99.00', '关于肌肤问题，有个著名的“苹果理论”，肌肤问题像一只苹果的腐烂当第一块变质发生，总是以加速度迅速发展、蔓延，当腐烂到一定程度时，苹果的腐烂速度会减缓，但这时候的苹果已经发酸、发臭了。如果在苹果刚开始出问题时，就将变质部分清理掉，苹果的变质会大大延缓这就是女人肌肤保养中的“苹果理论”。', '强润补水，敏感肌肤同样适用', '双层眼部卸妆水,脂质囊修复眼霜，天然净白收缩水', '双层眼部卸妆水,脂质囊修复眼霜，天然净白收缩水', '1', '1441964086', '2', '1', '缓解快节奏生活带给您的身心压力');
INSERT INTO `sk_service` VALUES ('3', '1', '2', './Uploads/image/20150911/55f29f2e14410.png', './Uploads/image/20150911/55f29f330fac1.jpg', 'spa333', '3', '服务很好1', '68', '300.00', '290.00', '关于肌肤问题，有个著名的“苹果理论”，肌肤问题像一只苹果的腐烂当第一块变质发生，总是以加速度迅速发展、蔓延，当腐烂到一定程度时，苹果的腐烂速度会减缓，但这时候的苹果已经发酸、发臭了。如果在苹果刚开始出问题时，就将变质部分清理掉，苹果的变质会大大延缓这就是女人肌肤保养中的“苹果理论”。', '强润补水，敏感肌肤同样适用', '双层眼部卸妆水,脂质囊修复眼霜，天然净白收缩水', '双层眼部卸妆水,脂质囊修复眼霜，天然净白收缩水', '1', '1441963830', '3', '1', '缓解快节奏生活带给您的身心压力');
INSERT INTO `sk_service` VALUES ('4', '1', '1', './Uploads/image/20150911/55f2a150855d1.png', './Uploads/image/20150911/55f2a158b6168.png', '面部spa55', '4', '服务很好1', '120', '160.00', '140.00', '关于肌肤问题，有个著名的“苹果理论”，肌肤问题像一只苹果的腐烂当第一块变质发生，总是以加速度迅速发展、蔓延，当腐烂到一定程度时，苹果的腐烂速度会减缓，但这时候的苹果已经发酸、发臭了。如果在苹果刚开始出问题时，就将变质部分清理掉，苹果的变质会大大延缓这就是女人肌肤保养中的“苹果理论”。', '强润补水，敏感肌肤同样适用', '双层眼部卸妆水,脂质囊修复眼霜，天然净白收缩水', '双层眼部卸妆水,脂质囊修复眼霜，天然净白收缩水', '0', '1441964378', '4', '1', '缓解快节奏生活带给您的身心压力');
INSERT INTO `sk_service` VALUES ('5', '1', '2', './Uploads/image/20150911/55f2a19ed959d.png', './Uploads/image/20150911/55f2a1a81f4b7.jpg', 'spa44', '3', '服务概要的是很好1', '122', '260.00', '220.00', '关于肌肤问题，有个著名的“苹果理论”，肌肤问题像一只苹果的腐烂当第一块变质发生，总是以加速度迅速发展、蔓延，当腐烂到一定程度时，苹果的腐烂速度会减缓，但这时候的苹果已经发酸、发臭了。如果在苹果刚开始出问题时，就将变质部分清理掉，苹果的变质会大大延缓这就是女人肌肤保养中的“苹果理论”。', '强润补水，敏感肌肤同样适用', '双层眼部卸妆水,豆蔻素洁肤水,温和护理日霜', '双层眼部卸妆水,豆蔻素洁肤水,温和护理日霜', '1', '1441964458', '6', '1', '缓解快节奏生活带给您的身心压力');
INSERT INTO `sk_service` VALUES ('6', '1', '1', './Uploads/image/20150911/55f2a18083384.png', './Uploads/image/20150911/55f2a1868219d.png', '面部spa4', '2,3', '服务概要很好1', '30', '400.00', '390.00', '关于肌肤问题，有个著名的“苹果理论”，肌肤问题像一只苹果的腐烂当第一块变质发生，总是以加速度迅速发展、蔓延，当腐烂到一定程度时，苹果的腐烂速度会减缓，但这时候的苹果已经发酸、发臭了。如果在苹果刚开始出问题时，就将变质部分清理掉，苹果的变质会大大延缓这就是女人肌肤保养中的“苹果理论”。', '双层眼部卸妆水,脂质囊修复眼霜，天然净白收缩水', '双层眼部卸妆水,脂质囊修复眼霜，天然净白收缩水', '双层眼部卸妆水,脂质囊修复眼霜，天然净白收缩水', '0', '1441964425', '9', '1', '缓解快节奏生活带给您的身心压力');
INSERT INTO `sk_service` VALUES ('7', '1', '2', './Uploads/image/20150912/55f3a25a6583b.jpg', './Uploads/image/20150912/55f3a25e9409a.jpg', '手部spa1', '2', '服务很好1', '34', '123.00', '111.00', '关于肌肤问题，有个著名的“苹果理论”，肌肤问题像一只苹果的腐烂当第一块变质发生，总是以加速度迅速发展、蔓延，当腐烂到一定程度时，苹果的腐烂速度会减缓，但这时候的苹果已经发酸、发臭了。如果在苹果刚开始出问题时，就将变质部分清理掉，苹果的变质会大大延缓这就是女人肌肤保养中的“苹果理论”。', '强润补水，敏感肌肤同样适用', '双层眼部卸妆水,脂质囊修复眼霜，天然净白收缩水', '双层眼部卸妆水,脂质囊修复眼霜，天然净白收缩水', '1', '1441867849', '4', '1', '缓解快节奏生活带给您的身心压力');
INSERT INTO `sk_service` VALUES ('8', '1', '1', './Uploads/image/20150912/55f39a84ce8f9.jpg', './Uploads/image/20150912/55f39a8a9e287.png', '身体spa', '2', '服务很好1', '12', '111.00', '111.00', '关于肌肤问题，有个著名的“苹果理论”，肌肤问题像一只苹果的腐烂当第一块变质发生，总是以加速度迅速发展、蔓延，当腐烂到一定程度时，苹果的腐烂速度会减缓，但这时候的苹果已经发酸、发臭了。如果在苹果刚开始出问题时，就将变质部分清理掉，苹果的变质会大大延缓这就是女人肌肤保养中的“苹果理论”。', '老人，女人', '双层眼部卸妆水,脂质囊修复眼霜，天然净白收缩水', '双层眼部卸妆水,脂质囊修复眼霜，天然净白收缩水', '0', '1441868925', '4', '1', '缓解快节奏生活带给您的身心压力');
INSERT INTO `sk_service` VALUES ('9', '1', '3', './Uploads/image/20150911/55f29ff86c6ee.jpg', './Uploads/image/20150911/55f2a00039fc6.png', '面部清理', '2,3', '服务很好，值得看看1', '56', '111.00', '111.00', '关于肌肤问题，有个著名的“苹果理论”，肌肤问题像一只苹果的腐烂当第一块变质发生，总是以加速度迅速发展、蔓延，当腐烂到一定程度时，苹果的腐烂速度会减缓，但这时候的苹果已经发酸、发臭了。如果在苹果刚开始出问题时，就将变质部分清理掉，苹果的变质会大大延缓这就是女人肌肤保养中的“苹果理论”。', '强润补水，敏感肌肤同样适用', '双层眼部卸妆水,脂质囊修复眼霜,豆蔻素洁肤水', '双层眼部卸妆水,脂质囊修复眼霜,豆蔻素洁肤水', '1', '1441964034', '4', '1', '缓解快节奏生活带给您的身心压力');
INSERT INTO `sk_service` VALUES ('10', '1', '3', './Uploads/image/20150911/55f29fdc9b7a8.png', './Uploads/image/20150911/55f29fe3aec1c.png', '身体spa', '2,3', '服务概要22221', '97', '50.00', '49.00', '关于肌肤问题，有个著名的“苹果理论”，肌肤问题像一只苹果的腐烂当第一块变质发生，总是以加速度迅速发展、蔓延，当腐烂到一定程度时，苹果的腐烂速度会减缓，但这时候的苹果已经发酸、发臭了。如果在苹果刚开始出问题时，就将变质部分清理掉，苹果的变质会大大延缓这就是女人肌肤保养中的“苹果理论”。', '强润补水，敏感肌肤同样适用', '双层眼部卸妆水,豆蔻素洁肤水,温和护理日霜', '双层眼部卸妆水,豆蔻素洁肤水,温和护理日霜', '1', '1441964006', '9', '1', '缓解快节奏生活带给您的身心压力');
INSERT INTO `sk_service` VALUES ('11', '1', '3', './Uploads/image/20150912/55f3a1ec9beaf.jpg', './Uploads/image/20150912/55f3a1f1553d3.jpg', '全身舒缓芳香SPA', '3', '服务很好1', '40', '120.00', '110.00', '关于肌肤问题，有个著名的“苹果理论”，肌肤问题像一只苹果的腐烂当第一块变质发生，总是以加速度迅速发展、蔓延，当腐烂到一定程度时，苹果的腐烂速度会减缓，但这时候的苹果已经发酸、发臭了。如果在苹果刚开始出问题时，就将变质部分清理掉，苹果的变质会大大延缓这就是女人肌肤保养中的“苹果理论”。', '老人，女人', '双层眼部卸妆水,脂质囊修复眼霜，天然净白收缩水', '双层眼部卸妆水,脂质囊修复眼霜，天然净白收缩水', '1', '1441956205', '0', '1', '缓解快节奏生活带给您的身心压力');
INSERT INTO `sk_service` VALUES ('12', '1', '4', '/beautya/Uploads/image/20150922/5600d64933e39.jpg', '/beautya/Uploads/image/20150922/5600d65274665.jpg', 'spa', '2,3', '服务很好1', '30', '123.00', '111.00', '关于肌肤问题，有个著名的“苹果理论”，肌肤问题像一只苹果的腐烂当第一块变质发生，总是以加速度迅速发展、蔓延，当腐烂到一定程度时，苹果的腐烂速度会减缓，但这时候的苹果已经发酸、发臭了。如果在苹果刚开始出问题时，就将变质部分清理掉，苹果的变质会大大延缓这就是女人肌肤保养中的“苹果理论”。', '情侣,亲人,老人，强润补水，敏感肌肤同样适用', 'a,b,c', 'dddd,dddd,bbbb', '1', '1442026826', '21', '1', '缓解快节奏生活带给您的身心压力');
INSERT INTO `sk_service` VALUES ('13', '1', '5', '/beautya/Uploads/image/20150924/560382c9ea6dd.png', '/beautya/Uploads/image/20150924/560382d4ec648.jpg', '全身按摩spa', '3,4', '缓解快节奏生活带压力', '40', '109.00', '100.00', '肌肤问题像一只苹果的腐烂当第一块变质发生，总是以加速度迅速发展、蔓延', '老人,女人,达人', '双层眼部卸妆水产品,脂质囊修复眼霜,豆蔻素洁肤水产品', '双层眼部卸妆水,脂质囊修复眼霜,豆蔻素洁肤水', '0', '1443071274', '3', '1', null);

-- ----------------------------
-- Table structure for `sk_servicelab`
-- ----------------------------
DROP TABLE IF EXISTS `sk_servicelab`;
CREATE TABLE `sk_servicelab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `labname` varchar(30) DEFAULT NULL COMMENT '标签名称',
  `pic` varchar(100) DEFAULT NULL COMMENT '图标',
  `sort` int(4) DEFAULT NULL COMMENT '排序号',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '1启用  0禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='服务标签表';

-- ----------------------------
-- Records of sk_servicelab
-- ----------------------------
INSERT INTO `sk_servicelab` VALUES ('2', '无隐形消费', './Uploads/image/20150912/55f3b925e268f.png', '0', '1');
INSERT INTO `sk_servicelab` VALUES ('3', '标准服务流程', './Uploads/image/20150912/55f3b91577dd0.png', '1', '1');
INSERT INTO `sk_servicelab` VALUES ('4', '专业美容师', './Uploads/image/20150912/55f3b95caf242.png', '0', '1');

-- ----------------------------
-- Table structure for `sk_servicestep`
-- ----------------------------
DROP TABLE IF EXISTS `sk_servicestep`;
CREATE TABLE `sk_servicestep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sname` varchar(50) DEFAULT NULL COMMENT '步骤名称',
  `summary` varchar(500) DEFAULT NULL COMMENT '步骤说明',
  `sort` int(4) DEFAULT NULL,
  `serviceid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='美容步骤表';

-- ----------------------------
-- Records of sk_servicestep
-- ----------------------------
INSERT INTO `sk_servicestep` VALUES ('1', '面部舒缓', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '1', '7');
INSERT INTO `sk_servicestep` VALUES ('2', '脸部调节3', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果33', '2', '7');
INSERT INTO `sk_servicestep` VALUES ('3', '背部舒缓', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '0', '7');
INSERT INTO `sk_servicestep` VALUES ('4', '腰部舒缓', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '3', '7');
INSERT INTO `sk_servicestep` VALUES ('5', '脸部调节', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果111', '3', '7');
INSERT INTO `sk_servicestep` VALUES ('6', '脸部调节9', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '6', '7');
INSERT INTO `sk_servicestep` VALUES ('7', '脸部调节10', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '6', '8');
INSERT INTO `sk_servicestep` VALUES ('8', '脸部调节6', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '5', '8');
INSERT INTO `sk_servicestep` VALUES ('9', '调节8888', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '5', '8');
INSERT INTO `sk_servicestep` VALUES ('10', '脸部调节822', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '7', '8');
INSERT INTO `sk_servicestep` VALUES ('11', '脸部调节3333', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '9', '8');
INSERT INTO `sk_servicestep` VALUES ('12', '脸部调节444', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '3', '8');
INSERT INTO `sk_servicestep` VALUES ('13', '脸部调节5', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '4', '8');
INSERT INTO `sk_servicestep` VALUES ('14', '面部步骤1', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '1', '2');
INSERT INTO `sk_servicestep` VALUES ('15', '面部步骤2', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '2', '2');
INSERT INTO `sk_servicestep` VALUES ('16', '面部步骤3', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '3', '2');
INSERT INTO `sk_servicestep` VALUES ('17', '面部步骤4', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '4', '2');
INSERT INTO `sk_servicestep` VALUES ('18', '面部5', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '5', '2');
INSERT INTO `sk_servicestep` VALUES ('19', '面部1', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果111', '1', '4');
INSERT INTO `sk_servicestep` VALUES ('20', '面部2', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '2', '4');
INSERT INTO `sk_servicestep` VALUES ('21', '面部3', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '3', '4');
INSERT INTO `sk_servicestep` VALUES ('22', '面部4', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '4', '4');
INSERT INTO `sk_servicestep` VALUES ('23', '腿部1', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '1', '16');
INSERT INTO `sk_servicestep` VALUES ('24', '腿部2', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '2', '16');
INSERT INTO `sk_servicestep` VALUES ('25', '腿部3', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果433333333333333', '3', '16');
INSERT INTO `sk_servicestep` VALUES ('26', '面部舒缓', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '1', '1');
INSERT INTO `sk_servicestep` VALUES ('27', '脸部调节3', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果33', '2', '1');
INSERT INTO `sk_servicestep` VALUES ('28', '背部舒缓', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '0', '1');
INSERT INTO `sk_servicestep` VALUES ('29', '腰部舒缓', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '3', '1');
INSERT INTO `sk_servicestep` VALUES ('30', '脸部调节', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果111', '3', '1');
INSERT INTO `sk_servicestep` VALUES ('31', '脸部调节9', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '6', '2');
INSERT INTO `sk_servicestep` VALUES ('32', '脸部调节10', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '6', '2');
INSERT INTO `sk_servicestep` VALUES ('33', '脸部调节6', '采用甜杏仁按摩油，舒缓放松，帮助后续面部护理大道最佳效果', '5', '2');

-- ----------------------------
-- Table structure for `sk_servicetype`
-- ----------------------------
DROP TABLE IF EXISTS `sk_servicetype`;
CREATE TABLE `sk_servicetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classname` varchar(30) DEFAULT NULL COMMENT '分类名称',
  `pic` varchar(255) DEFAULT NULL COMMENT '图标',
  `sort` int(4) NOT NULL DEFAULT '0' COMMENT '排序号',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1启用 0禁用',
  `selpic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='服务分类表';

-- ----------------------------
-- Records of sk_servicetype
-- ----------------------------
INSERT INTO `sk_servicetype` VALUES ('1', '面部', './Uploads/image/20150911/55f29e1f4a74a.png', '1', '1', './Uploads/image/20150911/55f29e28257f6.png');
INSERT INTO `sk_servicetype` VALUES ('2', '手部', './Uploads/image/20150911/55f29db3ef8d2.png', '1', '1', './Uploads/image/20150911/55f29dc11d363.png');
INSERT INTO `sk_servicetype` VALUES ('3', '身体', './Uploads/image/20150911/55f29c68c8838.png', '2', '1', './Uploads/image/20150911/55f29d8edf6df.png');
INSERT INTO `sk_servicetype` VALUES ('4', '腿部', './Uploads/image/20150911/55f29c4f47c8f.png', '3', '1', './Uploads/image/20150911/55f29d447d67e.png');
INSERT INTO `sk_servicetype` VALUES ('5', '全身', './Uploads/image/20150911/55f29c14d42fe.png', '1', '1', './Uploads/image/20150911/55f29d34e4700.png');

-- ----------------------------
-- Table structure for `sk_setting`
-- ----------------------------
DROP TABLE IF EXISTS `sk_setting`;
CREATE TABLE `sk_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linkphone` varchar(15) DEFAULT NULL COMMENT '客服电话',
  `signinpoint` int(8) DEFAULT NULL COMMENT '签到获得积分',
  `conpoint` decimal(2,2) DEFAULT NULL COMMENT '消费积分比例',
  `returnpoint` decimal(2,2) DEFAULT NULL COMMENT '消费返回积分比例',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='综合设置表';

-- ----------------------------
-- Records of sk_setting
-- ----------------------------
INSERT INTO `sk_setting` VALUES ('1', '1380013801', '1', '0.03', '0.02');

-- ----------------------------
-- Table structure for `sk_signrecord`
-- ----------------------------
DROP TABLE IF EXISTS `sk_signrecord`;
CREATE TABLE `sk_signrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(8) DEFAULT NULL COMMENT '会员ID',
  `createtime` int(11) DEFAULT NULL COMMENT '签到时间',
  `point` int(8) DEFAULT NULL COMMENT '获得积分',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='签到记录表';

-- ----------------------------
-- Records of sk_signrecord
-- ----------------------------
INSERT INTO `sk_signrecord` VALUES ('1', '1', '1442670875', '1');
INSERT INTO `sk_signrecord` VALUES ('2', '1', '1442755045', '1');
INSERT INTO `sk_signrecord` VALUES ('3', '1', '1442797344', '1');
INSERT INTO `sk_signrecord` VALUES ('4', '1', '1441072664', '1');
INSERT INTO `sk_signrecord` VALUES ('5', '1', '1441245584', '1');
INSERT INTO `sk_signrecord` VALUES ('6', '1', '1441418440', '1');
INSERT INTO `sk_signrecord` VALUES ('7', '1', '1442924637', '1');
INSERT INTO `sk_signrecord` VALUES ('8', '1', '1443319383', '1');

-- ----------------------------
-- Table structure for `sk_user`
-- ----------------------------
DROP TABLE IF EXISTS `sk_user`;
CREATE TABLE `sk_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL COMMENT '登录名',
  `password` varchar(50) DEFAULT NULL COMMENT '密码',
  `truename` varchar(30) DEFAULT NULL COMMENT '真实姓名',
  `roleid` int(2) DEFAULT NULL COMMENT '所属角色ID',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注说明',
  `status` int(2) DEFAULT NULL COMMENT '状态：1 启用 0 禁用',
  `last_login_time` int(11) DEFAULT NULL COMMENT '最后一次登录时间',
  `last_login_ip` int(11) DEFAULT NULL COMMENT '最后一次登录IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of sk_user
-- ----------------------------
INSERT INTO `sk_user` VALUES ('1', 'admin', 'c3284d0f94606de1fd2af172aba15bf3', '系统管理员', '1', '', '1', '1444918020', '0');
INSERT INTO `sk_user` VALUES ('2', 'test1', '418d89a45edadb8ce4da17e07f72536c', '测试1', '1', '', '1', null, null);
