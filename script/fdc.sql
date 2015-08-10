-- MySQL dump 10.13  Distrib 5.1.66, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: fdc
-- ------------------------------------------------------
-- Server version	5.1.66

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity`
--

DROP TABLE IF EXISTS `activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` date NOT NULL,
  `name` varchar(128) NOT NULL,
  `address` varchar(1024) NOT NULL,
  `cost` int(11) NOT NULL,
  `income` int(11) NOT NULL,
  `description` text NOT NULL,
  `kind` tinyint(4) DEFAULT NULL,
  `creator` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity`
--

LOCK TABLES `activity` WRITE;
/*!40000 ALTER TABLE `activity` DISABLE KEYS */;
INSERT INTO `activity` VALUES (7,'2013-11-28','例会','曹溪公园',0,0,'例会',1,'海湾'),(8,'2013-12-18','例会','曹溪公园',0,0,'例会',1,'海湾'),(9,'2014-10-28','例会','宜山路',0,0,'例会',1,'海湾'),(10,'2014-12-28','例会','宜山路',0,0,'例会',1,'海湾'),(11,'2015-02-20','例会','joy',0,0,'例会',1,'海湾'),(12,'2015-02-27','例会','joy',0,0,'例会',1,'海湾'),(14,'2015-07-25','例会','joy',0,0,'',1,'云中'),(17,'2015-08-01','例会','joy',0,0,'',1,'云中'),(18,'2015-08-08','例会','joy',0,0,'',1,'云中'),(19,'2015-08-09','例会','joy',0,0,'',1,'云中');
/*!40000 ALTER TABLE `activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_record`
--

DROP TABLE IF EXISTS `activity_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_record` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account` varchar(30) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_record`
--

LOCK TABLES `activity_record` WRITE;
/*!40000 ALTER TABLE `activity_record` DISABLE KEYS */;
INSERT INTO `activity_record` VALUES (1,'1',12,'0000-00-00 00:00:00'),(2,'2',12,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `activity_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `name` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES ('不丹'),('东帝汶'),('中国'),('中立区'),('中非共和国'),('丹麦'),('乌克兰'),('乌兹别克斯坦'),('乌干达'),('乌拉圭'),('乍得'),('也门'),('亚美尼亚'),('以色列'),('伊拉克'),('伊朗'),('伯利兹'),('佛得角'),('俄罗斯联邦'),('保加利亚'),('克罗地亚'),('关岛'),('冈比亚'),('冰岛'),('几内亚'),('几内亚比绍'),('列支敦士登'),('刚果'),('利比亚'),('利比里亚'),('前苏联'),('加拿大'),('加纳'),('加蓬'),('匈牙利'),('北马里亚那群岛'),('南斯拉夫'),('南极洲'),('南非'),('博茨瓦纳'),('卡塔尔'),('卢旺达'),('卢森堡'),('印度'),('印度尼西亚'),('危地马拉'),('厄瓜多尔'),('叙利亚'),('古巴'),('可可岛'),('吉尔吉斯斯坦'),('吉布提'),('哈萨克斯坦'),('哥伦比亚'),('哥斯达黎加'),('喀麦隆'),('图瓦卢'),('土尔其'),('土库曼斯坦'),('圣卢西亚'),('圣多美与普林西比'),('圣诞岛'),('圣赫勒那'),('圣马力诺'),('圭亚那'),('坦桑尼亚'),('埃及'),('埃塞俄比亚'),('基里巴斯'),('塔吉克斯坦'),('塞内加尔'),('塞拉利昂'),('塞浦路斯'),('塞舌尔'),('墨西哥'),('多哥'),('多明哥'),('多米尼加'),('奥地利'),('委内瑞拉'),('孟加拉'),('安哥拉'),('安圭拉'),('安提瓜和巴布达'),('安道尔'),('密克罗尼西亚'),('尼加拉瓜'),('尼日利亚'),('尼日尔'),('尼泊尔'),('巴哈马'),('巴基斯坦'),('巴巴多斯'),('巴布亚新几内亚'),('巴拉圭'),('巴拿马'),('巴林'),('巴西'),('布其纳法索'),('布维岛'),('布隆迪'),('希腊'),('帕劳'),('库克群岛'),('开曼群岛'),('德国'),('意大利'),('所罗门群岛'),('扎伊尔'),('托克劳'),('拉托维亚'),('挪威'),('捷克共和国'),('摩尔多瓦'),('摩洛哥'),('摩纳哥'),('文莱'),('斐济'),('斯威士兰'),('斯洛伐克'),('斯洛文尼亚'),('斯里兰卡'),('新加坡'),('新喀里多尼亚'),('新西兰'),('日本'),('智利'),('朝鲜'),('柬埔寨'),('格林纳达'),('格陵兰'),('格鲁吉亚'),('梵蒂冈'),('比利时'),('毛里塔尼亚'),('毛里求斯'),('汤加'),('沙特阿拉伯'),('法国'),('法属南方领土'),('法属圭亚那'),('法属玻里尼西亚'),('波兰'),('波多黎各（美）'),('波黑'),('泰国'),('津巴布韦'),('洪都拉斯'),('海地'),('澳大利亚'),('爱尔兰'),('爱沙尼亚'),('牙买加'),('特克斯和凯科斯群岛'),('特立尼达和多巴哥'),('玻利维亚'),('瑙鲁'),('瑞典'),('瑞士'),('瓜德罗普'),('白俄罗斯'),('百慕大'),('皮特开恩群岛'),('直布罗陀'),('福克兰群岛'),('科威特'),('科摩罗'),('秘鲁'),('突尼斯'),('立陶宛'),('索马里'),('约旦'),('纳米比亚'),('纽埃'),('维尔京（美）'),('维尔京（英）'),('缅甸'),('罗马尼亚'),('美国'),('美国边远小岛'),('老挝'),('肯尼亚'),('芬兰'),('苏丹'),('苏里南'),('英国'),('英联邦的印度洋领域'),('荷兰'),('莫桑比克'),('莱索托'),('菲律宾'),('萨尔瓦多'),('葡萄牙'),('蒙古'),('蒙特塞拉特'),('西撒哈拉'),('西班牙'),('西萨摩亚'),('诺福克岛'),('象牙海岸'),('贝宁'),('赞比亚'),('赤道几内亚'),('越南'),('阿塞拜疆'),('阿富汗'),('阿尔及利亚'),('阿尔巴尼亚'),('阿拉伯联合酋长国'),('阿曼'),('阿根廷'),('阿鲁巴'),('韩国'),('马尔代夫'),('马拉维'),('马来西亚'),('马绍尔群岛'),('马耳他'),('马达加斯加'),('马里'),('黎巴嫩');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dance`
--

DROP TABLE IF EXISTS `dance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dance` (
  `name` varchar(128) NOT NULL,
  `country` varchar(128) NOT NULL,
  `kind` tinyint(4) NOT NULL,
  `dance_level` tinyint(4) NOT NULL,
  `description` text NOT NULL,
  `dance_count` int(11) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dance`
--

LOCK TABLES `dance` WRITE;
/*!40000 ALTER TABLE `dance` DISABLE KEYS */;
INSERT INTO `dance` VALUES ('26号公寓','以色列',2,3,'',2),('Sax Man','未知',1,5,'出自：自编。',2),('Suddently','未知',1,2,'出自：以。',2),('Sunny Day','未知',1,1,'出自：。',0),('TicoTico','以色列',2,2,'',2),('一千夜','未知',1,1,'出自：。',0),('一把情种','未知',1,3,'出自：台湾山地。',0),('一舞定情','美国',2,3,'',0),('万物之始','以色列',1,3,'',0),('三世情缘','未知',1,1,'出自：。',0),('三月桃花','未知',2,1,'出自：台.自编。',0),('上路','以色列',2,2,'',2),('不老林','以色列',1,1,'',0),('与我同唱','以色列',1,2,'',0),('世外桃源','未知',1,1,'出自：台湾山地。',0),('丝路之旅','中国',1,3,'',0),('两情相悦','以色列',1,4,'',0),('中国探戈','未知',2,1,'出自：。',2),('中欧少女','匈牙利',1,3,'',0),('丰年海洋之歌','未知',1,1,'出自：台湾山地。',0),('为你欢唱','以色列',1,3,'',0),('为我欢唱','未知',1,1,'出自：。',2),('为爱情干杯','未知',1,2,'出自：新自编。',0),('乌克兰小品','未知',1,3,'出自：俄国。',1),('也爵克','未知',2,2,'出自：自编。',1),('也许是爱','未知',2,3,'出自：台湾。',0),('乡愁','未知',1,1,'出自：。',0),('五彩缤纷','未知',2,4,'出自：探戈。',1),('亚罗曼之音','罗马尼亚',1,2,'',0),('亚营呼拉','以色列',1,2,'',0),('亚隆狄不开','以色列',1,4,'',0),('仗鼓舞','韩国',1,1,'',2),('以我全心','以色列',1,3,'',0),('以色列歌手','以色列',1,1,'',0),('以色列茉莉','以色列',1,2,'',2),('以色列马则卡','以色列',2,2,'',1),('伊娜伊娜','未知',1,1,'出自：。',1),('伊斯潘诺扇子舞','未知',1,5,'出自：现代芭蕾。',1),('伊甸园','以色列',2,2,'',0),('伊莎拉','未知',1,1,'出自：。',0),('优雅的女士','未知',1,1,'出自：亚。',0),('伴你同行','以色列',2,4,'',0),('低调探戈','未知',2,3,'出自：自编。',1),('佐巴','以色列',1,1,'',0),('何日君再来','未知',1,1,'出自：。',0),('你很美丽','以色列',2,2,'',0),('俄罗斯之茶','未知',1,5,'出自：俄罗斯。',0),('俪影探戈','未知',2,3,'出自：探戈。',0),('假日圆舞曲','未知',2,3,'出自：华尔兹。',1),('停不了','以色列',1,3,'',0),('光明在望','以色列',1,3,'',0),('八音盒舞者','未知',2,3,'出自：自编。',0),('关岛颂','关岛',1,2,'',0),('再续情缘','以色列',2,2,'',0),('再见','未知',1,1,'海湾传统结束舞',1),('农家子弟','罗马尼亚',1,3,'',1),('冬季到台北看雨','未知',1,2,'出自：现代。',0),('凝眸','以色列',1,3,'',0),('凡格里探戈','未知',2,1,'出自：探戈。',0),('凯瑟琳华士','未知',2,2,'出自：华尔兹。',1),('击鞋兰德勒','奥地利',2,4,'',0),('刀剑如梦','中国',1,3,'',1),('初恋情人','未知',1,1,'出自：。',1),('别让我心碎','未知',1,1,'出自：。',0),('北爱琴海之音','未知',1,1,'出自：希。',1),('千里之外','未知',1,3,'出自：扇子。',1),('午夜狂欢','以色列',1,2,'',0),('华尔兹宫廷舞','未知',2,3,'出自：华尔兹。',0),('南美午夜探戈','未知',2,3,'出自：探戈。',0),('南都夜曲','未知',1,1,'出自：。',0),('卡布里岛','未知',1,3,'出自：探戈。',0),('卡罗索','未知',1,3,'出自：华尔兹。',1),('卡马伦斯卡','未知',2,5,'出自：俄国。',0),('只在以色列','以色列',1,2,'',0),('只想与你共舞','未知',2,1,'出自：。',0),('可爱的森巴','以色列',2,3,'',0),('台湾好','未知',1,3,'出自：台湾山地。',0),('吉普赛姑娘','以色列',2,4,'',0),('吉普赛披巾舞','未知',1,1,'出自：。',0),('吉普赛狂欢','罗马尼亚',1,4,'',0),('吉普赛玫瑰','美国',1,3,'',0),('名家帕索','西班牙',2,4,'',0),('听吧!以色列','以色列',1,2,'',0),('听泉','未知',1,3,'出自：。',0),('告别华尔滋','未知',2,1,'出自：欧。',1),('周末晚上','美国',1,2,'',0),('呼唤','未知',1,1,'出自：。',0),('哈萨匹克莫扎特','希腊',1,2,'',0),('哥伦比亚假期','未知',1,1,'出自：。',0),('哥萨克雪球树','未知',1,2,'出自：俄国。',0),('唐山子民','未知',1,4,'出自：现代国舞。',0),('啼鸟','以色列',2,3,'',0),('困惑','以色列',2,2,'',0),('国王之歌','未知',1,1,'出自：。',0),('圆桌武士','匈牙利',1,3,'',0),('土耳其之吻','以色列',1,3,'',0),('土耳其呼啦','未知',1,2,'出自：土耳其。',1),('土耳其婚礼舞','未知',1,1,'出自：土。',0),('圣临','未知',1,1,'出自：。',1),('圣诞铃声','未知',1,1,'出自：自编。',0),('在游逛场上','以色列',1,2,'',1),('坚信不移','以色列',1,3,'',0),('夏夜','未知',1,1,'出自：。',0),('夏威夷情歌','未知',1,3,'出自：夏威夷。',1),('夏日之末','以色列',2,2,'',0),('多美丽','以色列',1,1,'',0),('多阿狄不开','未知',1,3,'出自：。',0),('夜半歌声','以色列',1,2,'',0),('夜玫瑰','以色列',2,2,'',2),('大东京音头','日本',1,1,'',1),('大众之歌','以色列',2,3,'',0),('大巡行','以色列',1,3,'',0),('大法师','以色列',1,3,'',1),('大灰狼与小红帽','未知',1,1,'出自：。',0),('大花轿','中国',2,2,'',0),('天与地','以色列',1,4,'',0),('天堂','以色列',1,3,'',1),('天天年轻','未知',1,3,'出自：自编。',1),('奥地利风光','奥地利',2,2,'',0),('奥贝雷克','波兰',2,3,'',1),('女鼓手','以色列',1,2,'',0),('威尼华士','未知',2,5,'出自：华尔兹。',1),('婆锡尼沙Poseniica','保加利亚',1,2,'',0),('学生王子','德国',2,1,'',0),('宁静海','未知',2,2,'出自：。',0),('宝岛曼波','未知',2,1,'出自：自编。',0),('客栈风情画','以色列',1,2,'',1),('寇西卡','未知',2,4,'出自：华尔兹。',0),('寻梦舞No.1','波兰',2,2,'',0),('寻梦舞No3','波兰',2,3,'',0),('小村婚礼','未知',1,1,'出自：。',0),('小淘气','未知',1,2,'出自：爵士。',0),('小茶店','未知',2,3,'出自：。',0),('小马车','以色列',1,2,'',1),('少女约葳','保加利亚',1,5,'',0),('就是爱跳舞','未知',1,1,'出自：。',1),('就是现在','以色列',1,3,'',0),('就要挥别','中国',2,2,'',0),('山地情歌','未知',1,1,'出自：台湾山地。',0),('巴康之歌','未知',2,1,'出自：自编。',0),('巴斯克山谷','西班牙',1,4,'',0),('巴比伦塔','未知',1,2,'出自：。',1),('帆船','以色列',1,3,'',0),('希望之树','未知',1,1,'出自：。',1),('希腊情歌','希腊',2,2,'',0),('希腊水手','希腊',1,4,'',1),('帕索帕索','西班牙',2,4,'',0),('帛拉','未知',1,1,'出自：。',0),('年轻不要留白','未知',1,4,'出自：台湾自编。',0),('幸福人生','以色列',1,3,'',0),('康乃馨','保加利亚',1,1,'',0),('张开你的眼','以色列',1,3,'',0),('弦歌探戈','未知',2,1,'出自：探戈。',0),('弯曲的圆环','未知',1,4,'出自：保。',0),('归乡','以色列',1,3,'',0),('归来之歌','未知',1,1,'出自：日。',0),('归来的游子','以色列',1,2,'',0),('当那枫叶红','未知',2,2,'出自：台湾。',0),('彩云之南','未知',1,5,'出自：傣族。',0),('征兵','未知',1,4,'出自：匈。',0),('微不足道','以色列',2,3,'',1),('微醺的午后','以色列',2,2,'',1),('心中梦中','未知',2,2,'出自：。',1),('心想事成','以色列',1,3,'',0),('快乐恰恰','保加利亚',1,4,'',0),('快乐水手','美国',2,2,'',1),('怀念老歌','以色列',2,3,'',0),('恰恰恰','未知',2,3,'出自：自编。',1),('悦耳的音符','未知',1,2,'出自：以。',0),('悲伤嫉妒','未知',1,2,'出自：自编。',0),('情歌恰恰','未知',2,2,'出自：恰恰。',0),('情毒','以色列',1,3,'',0),('愉快的舞者','罗马尼亚',1,1,'',1),('意大利顽童','意大利',1,1,'',1),('感动','以色列',2,3,'',0),('慕情','美国',2,4,'',0),('慕罗薛伯','未知',1,3,'出自：罗.吉。',1),('戈兰高地','未知',1,1,'出自：。',0),('戴维王','以色列',1,1,'',1),('所罗门王的光辉','以色列',1,1,'',0),('扇子手巾舞','菲律宾',2,2,'',0),('手足情深','以色列',1,1,'',0),('手足欢聚','以色列',1,2,'',0),('托罗潘卡','未知',1,2,'出自：保。',0),('拉丁旋律','未知',2,3,'出自：恰恰。',0),('拉丁美洲之夜','未知',2,1,'出自：。',0),('拉荷儿','未知',2,2,'出自：。',0),('拿坡里手鼓舞','意大利',2,3,'',0),('捍卫祖国','以色列',1,3,'',0),('探戈伊斯康地诺','未知',2,2,'出自：探戈。',0),('探戈回想曲','以色列',2,1,'',0),('探戈探戈','未知',2,4,'出自：探戈。',1),('探戈舞会','未知',2,4,'出自：探戈。',0),('摇摆舞会','巴西',1,2,'',1),('放手','未知',1,3,'出自：。',1),('故乡的女孩','未知',1,2,'出自：中.自编。',0),('散步舞','美国',1,1,'',0),('斯卡狄布开','以色列',1,2,'',1),('方形探戈','未知',2,2,'出自：探戈。',1),('旅程','印度',1,5,'',1),('日出日落','美国',2,4,'',0),('日本人的拖鞋','美国',2,2,'',0),('星与花','以色列',2,3,'',0),('春之维也纳','未知',2,4,'出自：华尔兹。',0),('春之花','以色列',2,3,'',1),('春日时光','亚美尼亚',1,2,'',0),('春雾之恋','未知',1,1,'出自：。',1),('暗夜','以色列',2,4,'',0),('最后一夜','未知',2,4,'出自：华尔兹。',1),('最后华士','未知',2,2,'出自：华尔兹。',1),('月光小语','未知',1,1,'出自：。',1),('月光曲','未知',1,1,'出自：。',0),('月桃花','未知',1,3,'出自：自编。',0),('月琴','未知',1,2,'出自：现代.自编。',0),('木船','以色列',1,1,'',0),('未停','以色列',2,3,'',0),('杜鹃圆舞曲','未知',2,4,'出自：华尔兹。',0),('来吧.苏珊娜','未知',1,3,'出自：以。',0),('枫叶飘飘','美国',2,3,'',0),('柔情','以色列',2,3,'',1),('格拉夫斯卡.力沙','未知',1,3,'出自：保。',0),('格拉欧斯克NO.1','南斯拉夫',1,4,'',1),('桑塔雷塔','墨西哥',2,3,'',1),('梦中的妈妈','未知',1,2,'出自：新自编。',0),('梦幻巴黎','未知',2,4,'出自：探戈。',0),('梭罗河畔','印度尼西亚',2,3,'',0),('欢迎光临','以色列',1,3,'',0),('欧耶莎莎','未知',2,1,'出自：莎莎。',0),('歌','以色列',1,2,'',2),('歌与甜酒','未知',2,3,'出自：华尔兹。',0),('每年','以色列',1,3,'',0),('水汪汪','中国',2,1,'',1),('水舞','以色列',1,1,'',0),('水色华士','未知',2,3,'出自：华尔兹。',0),('池畔舞影','未知',2,4,'出自：华尔兹。',0),('沙漠儿女','未知',2,2,'出自：中.自编。',0),('沙漠幻影','未知',1,2,'出自：。',0),('法兰西华士','未知',2,2,'出自：华尔兹。',0),('法国香水','以色列',2,3,'',0),('法拉弗','以色列',2,2,'',0),('波斯地毯','以色列',1,1,'',0),('泰国欢乐舞','未知',1,4,'出自：自编。',1),('泰山','希腊',1,3,'',1),('洛哈地','以色列',2,1,'',1),('活力四射','以色列',1,2,'',0),('浓情蜜意','以色列',2,2,'',0),('浪迹天涯','未知',2,4,'出自：台湾自编。',0),('海亚','未知',1,1,'出自：。',1),('海兰快舞','未知',1,3,'出自：苏格兰。',1),('海滩慕情','菲律宾',2,3,'',1),('海韵','未知',2,3,'出自：华尔兹。',1),('海龙之歌','未知',2,3,'出自：。',0),('深情相拥','未知',1,4,'出自：自编。',0),('深情难忘','未知',2,3,'出自：探戈。',0),('温泉山庄','未知',1,2,'出自：。',0),('激情莎莎','以色列',2,4,'',0),('火星攻击','美国',1,2,'',0),('烈火青春','未知',1,4,'出自：爵士。',1),('烛光与香水','以色列',2,2,'',1),('热舞啦啦啦','未知',1,4,'出自：爵士。',0),('爱人琴娜蕊','以色列',2,3,'',1),('爱在风中蔓延时','以色列',2,3,'',1),('爱尔兰探戈','未知',2,3,'出自：探戈。',1),('爱情万岁','以色列',1,3,'',2),('爱情斥侯兵','以色列',2,2,'',0),('爱无止尽','未知',2,2,'出自：。',2),('爱的光芒','以色列',2,4,'',2),('爱的期盼','以色列',2,1,'',0),('爱的渴望','美国',2,3,'',0),('爵士','未知',1,3,'出自：爵士。',0),('牛奶蜜糖','以色列',1,3,'',0),('牡丹花冠','未知',1,1,'出自：。',1),('牧场游戏','未知',1,3,'出自：。',1),('牧羊人之歌','以色列',1,2,'',0),('狂欢节扑克','未知',2,4,'出自：自编。',1),('玫瑰玫瑰我爱你','未知',1,2,'出自：自编。',0),('玫瑰花丛','未知',2,3,'出自：华尔兹。',1),('珍惜','以色列',1,2,'',0),('珠曼阿铁克','以色列',1,1,'',0),('甘美拉','以色列',1,1,'',1),('生命之扉','未知',1,1,'出自：。',1),('田纳西假发舞','美国',2,1,'',0),('田纳西华士','未知',2,1,'出自：华尔兹。',0),('白色的秋天','以色列',2,3,'',0),('白鸽','未知',2,1,'出自：。',1),('皇后来了','以色列',1,2,'',0),('相思比梦长','中国',1,2,'',0),('真善美','奥地利',2,3,'',0),('短暂相聚','以色列',2,4,'',0),('祈祷','以色列',1,2,'',1),('童年','中国',2,1,'',0),('笑咪咪','未知',1,1,'出自：。',0),('米歇尔','以色列',1,3,'',0),('红睡莲','未知',2,1,'出自：台湾自编。',0),('细说从头','以色列',1,1,'',0),('维洲之音','美国',2,2,'',0),('罗拉探戈','未知',2,3,'出自：探戈。',1),('美丽的夜','以色列',2,2,'',1),('美丽的大地','以色列',1,2,'',0),('美丽的神话','未知',2,3,'出自：现代。',0),('美就是心中有爱','以色列',1,3,'',2),('美忆','未知',2,2,'出自：自编。',0),('美拉美拉','未知',1,4,'出自：自编。',0),('翠堤春晓','中国',2,5,'',0),('翠提菩提','未知',1,1,'出自：。',0),('考验','以色列',1,3,'',0),('脚踏车华士','未知',2,3,'出自：华尔兹。',0),('舞会','以色列',1,3,'',0),('舞在桌上','未知',1,3,'出自：以。',2),('舞影翩翩','未知',2,2,'出自：华尔兹。',0),('艺术家生涯','未知',2,4,'出自：华尔兹。',2),('花之旋律','未知',1,1,'出自：。',0),('花之语','未知',2,2,'出自：华尔兹。',0),('苏珊娜','以色列',2,3,'',0),('苏穆基女郎','匈牙利',1,3,'',0),('苦恋','以色列',2,3,'',0),('苹果','希腊',1,1,'',1),('苹果树下','未知',2,1,'出自：俄罗斯。',1),('苹果西打','美国',2,1,'',1),('草原倾诉','未知',1,4,'出自：保。',0),('荷塘月色','未知',1,3,'出自：。',0),('莉亚','以色列',1,3,'',1),('莎拉恰恰','未知',2,4,'出自：恰恰。',0),('莫希雅','以色列',1,3,'',0),('菊花台','未知',1,1,'出自：。',0),('落魄的游民','以色列',2,3,'',0),('蓝色别墅','未知',2,2,'出自：台湾。',0),('蓝色多恼河A','未知',2,5,'出自：华尔兹。',1),('蓝色探戈','未知',2,4,'出自：探戈。',0),('蕾丝裙','中国',2,2,'',0),('血染的风釆','未知',1,3,'出自：台湾。',0),('行云流水','未知',1,1,'出自：保。',0),('裸足天使','以色列',1,3,'',0),('西班牙之心','以色列',2,3,'',2),('西班牙进行曲','西班牙',2,3,'',0),('西维拉娜斯A','西班牙',2,4,'',1),('诗情画意','未知',2,2,'出自：自编。',0),('诗般的梦幻','未知',2,3,'出自：华尔兹。',0),('谁是幸运儿','未知',1,2,'出自：罗.吉。',1),('谜','以色列',1,3,'',0),('豪华华士','未知',2,3,'出自：华尔兹。',1),('贝壳小语','未知',1,1,'出自：。',0),('贝西斯男子舞','未知',1,1,'出自：。',0),('跳舞街','未知',1,3,'出自：港.自编。',0),('辣妹子','未知',1,1,'出自：。',1),('达布卡鼓','未知',1,1,'出自：。',0),('迷途的小鸟','意大利',1,2,'',0),('追忆','未知',1,2,'出自：排湾族。',0),('那乐','未知',1,1,'出自：亚。',0),('那玛小姐','以色列',2,3,'',1),('邵族迎宾舞','未知',1,1,'出自：台湾山地。',0),('金山恋','未知',1,1,'出自：。',1),('金巴拉','罗马尼亚',1,4,'',1),('金玉盟','以色列',1,1,'',1),('金粉梦河','未知',2,2,'出自：。',0),('金色华士','未知',1,2,'出自：华尔兹。',0),('银线','未知',1,1,'出自：。',0),('锁上记忆','以色列',2,4,'',0),('锦衣还乡','未知',1,4,'出自：自编。',0),('问天','未知',1,1,'出自：。',1),('阿拉伯英雄','以色列',1,1,'',0),('阿拉木汗','未知',2,1,'出自：中.自编。',1),('阿根廷探戈','未知',2,4,'出自：探戈。',2),('阿路娜','罗马尼亚',1,1,'',0),('阿达娜','未知',1,1,'出自：亚。',1),('阿里郎','韩国',1,1,'',2),('难忘的今天','未知',2,2,'出自：华尔兹。',0),('难舍难分','未知',2,2,'出自：。',0),('雅各布的袜丝','以色列',1,1,'',0),('雅歌','以色列',1,2,'',0),('雅蒂娜','以色列',2,3,'',0),('雨中旋律','美国',2,2,'',1),('雨中行','未知',2,2,'出自：。',0),('雨夜花','未知',1,1,'出自：中.自编。',0),('雷安耶男子舞No1','匈牙利',1,5,'',0),('韵律人生','未知',2,4,'出自：。',0),('预兆','以色列',2,3,'',0),('风之采','未知',2,4,'出自：现代芭蕾。',0),('风吹风吹','未知',1,1,'出自：台湾自编。',0),('风声','以色列',1,3,'',0),('风流寡妇','未知',2,2,'出自：自编。',1),('飞吧.梦想','未知',1,1,'出自：自编。',0),('马尼夏莉','未知',1,1,'出自：。',0),('马来情歌','马来西亚',2,3,'',0),('驼峰','以色列',1,4,'',0),('高傲的少女','以色列',1,4,'',0),('高潮','以色列',2,3,'',1),('鲁卡','保加利亚',1,5,'',2),('黄丝带','美国',1,1,'',1),('黄昏','以色列',1,3,'',0),('黑池探戈','未知',2,3,'出自：探戈。',1),('黑猫探戈','未知',2,3,'出自：探戈。',0),('黑眼睛','未知',2,1,'出自：亚。',0),('黑眼睛的女孩','亚美尼亚',1,2,'',1),('黛绿年华','未知',2,2,'出自：。',1),('齐罗鲁兰德勒','德国',2,4,'',1),('龙之家族','以色列',2,3,'',0),('龙飞凤舞','未知',2,3,'出自：吉鲁巴。',1);
/*!40000 ALTER TABLE `dance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dance_leader`
--

DROP TABLE IF EXISTS `dance_leader`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dance_leader` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dance_name` varchar(128) NOT NULL,
  `account` varchar(30) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dance_leader`
--

LOCK TABLES `dance_leader` WRITE;
/*!40000 ALTER TABLE `dance_leader` DISABLE KEYS */;
INSERT INTO `dance_leader` VALUES (1,'tico','1','2015-06-29 16:25:46'),(2,'天空','1','2015-06-29 16:28:00'),(3,'女鼓手','1','2015-06-29 16:28:42'),(4,'女鼓手','1','2015-06-29 16:29:58'),(5,'女鼓手','1','2015-06-29 16:55:31'),(6,'女鼓手','1','2015-06-29 17:08:09'),(7,'伊斯潘诺','1','2015-06-29 17:08:13'),(8,'午夜狂欢','1','2015-06-29 17:16:53'),(9,'午夜狂欢','1','2015-06-29 17:21:30'),(10,'午夜狂欢','1','2015-06-29 17:21:31'),(11,'午夜狂欢','1','2015-06-29 17:21:31'),(12,'午夜狂欢','1','2015-06-29 17:21:31'),(13,'午夜狂欢','1','2015-06-29 17:21:31'),(14,'午夜狂欢','1','2015-06-29 17:21:31'),(15,'午夜狂欢','1','2015-06-29 17:21:34'),(16,'午夜狂欢','1','2015-06-29 17:21:34'),(17,'午夜狂欢','1','2015-06-29 17:21:35'),(18,'午夜狂欢','1','2015-06-29 17:21:35'),(19,'午夜狂欢','1','2015-06-29 17:21:36'),(20,'午夜狂欢','1','2015-06-29 17:21:36'),(21,'烈火青春','1','2015-06-29 17:47:40'),(22,'美拉美拉','1','2015-06-29 17:55:40'),(23,'吉普赛玫瑰','1','2015-06-29 18:09:08'),(24,'吉普赛玫瑰','1','2015-06-29 18:10:22'),(25,'水舞','1','2015-06-29 18:12:13'),(26,'水舞','1','2015-06-29 18:12:28'),(27,'木船','1','2015-06-29 18:14:02'),(28,'圆桌武士','1','2015-06-29 18:15:20'),(29,'只想与你共舞','1','2015-06-29 18:54:02'),(30,'探戈','1','2015-06-29 18:57:57'),(31,'tico','2','2015-06-29 19:02:20');
/*!40000 ALTER TABLE `dance_leader` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dance_record`
--

DROP TABLE IF EXISTS `dance_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dance_record` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dance_name` varchar(128) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `kind` tinyint(4) NOT NULL COMMENT '0=>联欢舞码，1=>复习舞码，2=>教学舞码',
  `teacher` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dance_record`
--

LOCK TABLES `dance_record` WRITE;
/*!40000 ALTER TABLE `dance_record` DISABLE KEYS */;
INSERT INTO `dance_record` VALUES (1,'西班牙之心',12,2,'云中'),(2,'好汉',12,2,'米姐，小洁'),(3,'舞在桌上',12,2,'鸡哥'),(4,'以色列茉莉',12,2,'taro'),(5,'圆桌武士',12,1,''),(6,'木船',12,1,''),(7,'水舞',12,1,''),(8,'勇气',12,1,''),(9,'脚踏车华氏',12,1,''),(10,'裸足天使',12,1,''),(11,'爱',12,1,''),(12,'难舍难分',12,1,''),(13,'美丽的夜',12,1,''),(14,'再见',12,1,''),(15,'归来的游子',12,0,''),(16,'杜那托里跳跃舞',12,0,''),(17,'在路上',12,0,''),(18,'征兵',12,0,''),(19,'伊斯潘诺',12,0,''),(20,'美拉美拉',12,0,''),(21,'烈火青春',12,0,''),(22,'女鼓手',12,0,''),(23,'tico',12,0,''),(24,'午夜狂欢',12,0,''),(25,'吉普赛玫瑰',12,0,''),(26,'表演会俄国舞',12,0,''),(27,'只想与你共舞',12,0,''),(28,'天空',12,0,''),(29,'苏珊娜',12,0,''),(30,'雅蒂娜',12,0,''),(31,'牧场游戏',12,0,''),(32,'苦恋',12,0,''),(33,'山地舞',12,0,''),(34,'天地人',12,0,''),(35,'探戈',12,0,''),(36,'黑猫探戈',12,0,''),(37,'爵士',12,0,''),(38,'天天年轻',12,0,''),(39,'凡格里探戈',12,0,''),(40,'探戈舞会',12,0,''),(41,'流浪者',12,0,''),(42,'风流寡妇',12,0,''),(43,'哈萨皮克莫扎特',12,0,''),(44,'土耳其呼啦',12,0,''),(45,'以色列茉莉',17,1,''),(46,'舞在桌上',17,1,''),(47,'西班牙之心*',17,1,''),(48,'贝西斯男子舞',17,0,''),(49,'为爱情干杯',17,0,''),(50,'脚踏车华士*',17,0,''),(51,'南都夜曲',17,0,''),(52,'珠曼阿铁克',17,0,''),(53,'呼唤',17,0,''),(54,'中欧少女',17,0,''),(55,'苏穆基女郎',17,0,''),(56,'小村婚礼',17,0,''),(57,'贝壳小语',17,0,''),(58,'希腊水手',17,0,''),(59,'月光小语',17,0,''),(60,'微醺的午后*',17,0,''),(61,'土耳其之吻',17,0,''),(62,'莉亚',17,0,''),(63,'泰国欢乐舞',17,0,''),(64,'欧耶莎莎*',17,0,''),(65,'激情莎莎*',17,0,''),(66,'美丽的大地',17,0,''),(67,'拉丁旋律*',17,0,''),(68,'假日圆舞曲*',17,0,''),(69,'烛光与香水*',17,0,''),(70,'雷安耶男子舞No1',17,0,''),(71,'飞吧.梦想',17,0,''),(72,'火星攻击',17,0,''),(73,'停不了',17,0,''),(74,'就是爱跳舞',17,0,''),(75,'西班牙进行曲*',17,0,''),(76,'那玛小姐*',17,0,''),(77,'别让我心碎',17,0,''),(78,'法拉弗*',17,0,''),(79,'未停*',17,0,''),(80,'月光曲',17,0,''),(81,'多阿狄不开',17,0,''),(82,'雅歌',17,0,''),(83,'TicoTico*',17,0,''),(84,'坚信不移',17,0,''),(85,'卡马伦斯卡*',17,0,''),(86,'低调探戈*',17,0,''),(87,'难忘的今天*',17,0,''),(88,'以色列茉莉',17,1,''),(89,'舞在桌上',17,1,''),(90,'西班牙之心*',17,1,''),(91,'弯曲的圆环',17,0,''),(92,'齐罗鲁兰德勒*',17,0,''),(93,'春之维也纳*',17,0,''),(94,'艺术家生涯*',17,0,''),(95,'谜',17,0,''),(96,'血染的风釆',17,0,''),(97,'乡愁',17,0,''),(98,'心想事成',17,0,''),(99,'笑咪咪',17,0,''),(100,'小淘气',17,0,''),(101,'诗情画意*',17,0,''),(102,'爱的渴望*',17,0,''),(103,'卡布里岛',17,0,''),(104,'生命之扉',17,0,''),(105,'梦幻巴黎*',17,0,''),(106,'美拉美拉',17,0,''),(107,'落魄的游民*',17,0,''),(108,'梭罗河畔*',17,0,''),(109,'慕罗薛伯',17,0,''),(110,'牡丹花冠',17,0,''),(111,'康乃馨',17,0,''),(112,'西班牙之心*',17,0,''),(113,'苏珊娜*',17,0,''),(114,'活力四射',17,0,''),(115,'星与花*',17,0,''),(116,'哥伦比亚假期',17,0,''),(117,'万物之始',17,0,''),(118,'法国香水*',17,0,''),(119,'金色华士',17,0,''),(120,'草原倾诉',17,0,''),(121,'春日时光',17,0,''),(122,'方形探戈*',17,0,''),(123,'帛拉',17,0,''),(124,'田纳西假发舞*',17,0,''),(125,'吉普赛狂欢',17,0,''),(126,'天与地',17,0,''),(127,'也许是爱*',17,0,''),(128,'周末晚上',17,0,''),(129,'浓情蜜意*',17,0,''),(130,'日出日落*',17,0,''),(131,'26号公寓',18,2,'33,44'),(132,'Sax Man',18,2,'ian'),(133,'Suddently',18,2,'taro'),(134,'以色列茉莉',18,1,''),(135,'舞在桌上',18,1,''),(136,'西班牙之心',18,1,''),(137,'爱无止尽',18,1,''),(138,'阿里郎',18,1,''),(139,'TicoTico',18,1,''),(140,'爱尔兰探戈',18,1,''),(141,'爱的光芒',18,1,''),(142,'爱情万岁',18,1,''),(143,'爱人琴娜蕊',18,1,''),(144,'中国探戈',18,0,''),(145,'美丽的夜',18,0,''),(146,'卡罗索',18,0,''),(147,'希望之树',18,0,''),(148,'金玉盟',18,0,''),(149,'黑池探戈',18,0,''),(150,'最后一夜',18,0,''),(151,'风流寡妇',18,0,''),(152,'心中梦中',18,0,''),(153,'黑眼睛的女孩',18,0,''),(154,'愉快的舞者',18,0,''),(155,'海兰快舞',18,0,''),(156,'柔情',18,0,''),(157,'以色列马则卡',18,0,''),(158,'威尼华士',18,0,''),(159,'大法师',18,0,''),(160,'谁是幸运儿',18,0,''),(161,'巴比伦塔',18,0,''),(162,'鲁卡',18,0,''),(163,'夜玫瑰',18,0,''),(164,'客栈风情画',18,0,''),(165,'金山恋',18,0,''),(166,'罗拉探戈',18,0,''),(167,'方形探戈',18,0,''),(168,'北爱琴海之音',18,0,''),(169,'探戈探戈',18,0,''),(170,'龙飞凤舞',18,0,''),(171,'放手',18,0,''),(172,'狂欢节扑克',18,0,''),(173,'也爵克',18,0,''),(174,'上路',18,0,''),(175,'初恋情人',18,0,''),(176,'春之花',18,0,''),(177,'阿根廷探戈',18,0,''),(178,'最后华士',18,0,''),(179,'美就是心中有爱',18,0,''),(180,'恰恰恰',18,0,''),(181,'白鸽',18,0,''),(182,'歌',18,0,''),(183,'阿达娜',18,0,''),(184,'海滩慕情',19,2,'33,44'),(185,'齐罗鲁兰德勒',19,2,'taro,鸡哥'),(186,'苹果西打',19,2,'米姐,海湾'),(187,'26号公寓',19,1,''),(188,'Sax Man',19,1,''),(189,'Suddently',19,1,''),(190,'以色列茉莉',19,1,''),(191,'舞在桌上',19,1,''),(192,'西班牙之心',19,1,''),(193,'阿里郎',19,1,''),(194,'爱的光芒',19,1,''),(195,'爱无止尽',19,1,''),(196,'爱情万岁',19,1,''),(197,'仗鼓舞',19,0,''),(198,'五彩缤纷',19,0,''),(199,'为我欢唱',19,0,''),(200,'希腊水手',19,0,''),(201,'牡丹花冠',19,0,''),(202,'伊娜伊娜',19,0,''),(203,'辣妹子',19,0,''),(204,'艺术家生涯',19,0,''),(205,'慕罗薛伯',19,0,''),(206,'玫瑰花丛',19,0,''),(207,'在游逛场上',19,0,''),(208,'水汪汪',19,0,''),(209,'低调探戈',19,0,''),(210,'高潮',19,0,''),(211,'天堂',19,0,''),(212,'小马车',19,0,''),(213,'生命之扉',19,0,''),(214,'莉亚',19,0,''),(215,'海韵',19,0,''),(216,'问天',19,0,''),(217,'就是爱跳舞',19,0,''),(218,'海亚',19,0,''),(219,'泰国欢乐舞',19,0,''),(220,'月光小语',19,0,''),(221,'大东京音头',19,0,''),(222,'旅程',19,0,''),(223,'奥贝雷克',19,0,''),(224,'春雾之恋',19,0,''),(225,'牧场游戏',19,0,''),(226,'微醺的午后',19,0,''),(227,'格拉欧斯克NO.1',19,0,''),(228,'烛光与香水',19,0,''),(229,'农家子弟',19,0,''),(230,'微不足道',19,0,''),(231,'苹果树下',19,0,''),(232,'伊斯潘诺扇子舞',19,0,''),(233,'天天年轻',19,0,''),(234,'洛哈地',19,0,''),(235,'土耳其呼啦',19,0,''),(236,'再见',19,0,'');
/*!40000 ALTER TABLE `dance_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pay_record`
--

DROP TABLE IF EXISTS `pay_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pay_record` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `account` varchar(30) NOT NULL,
  `time` datetime NOT NULL,
  `money` int(11) NOT NULL,
  `owner` varchar(30) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pay_record`
--

LOCK TABLES `pay_record` WRITE;
/*!40000 ALTER TABLE `pay_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `pay_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `account` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  `sex` tinyint(4) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(128) NOT NULL,
  `birth` date NOT NULL,
  `join_date` date NOT NULL,
  `left_count` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('1','云中','1',0,'*','*','2008-03-08','2008-03-08',20),('10','王磊','10',1,'*','*','2008-03-08','2008-03-08',0),('2','米姐','2',1,'*','*','2008-03-08','2008-03-08',1),('3','小洁','3',0,'*','*','2008-03-08','2008-03-08',1),('4','taro','4',1,'*','*','2008-03-08','2008-03-08',1),('5','鸡哥','5',0,'*','*','2008-03-08','2008-03-08',1),('6','33','6',1,'*','*','2008-03-08','2008-03-08',1),('7','44','7',0,'*','*','2008-03-08','2008-03-08',1),('8','花姐','8',1,'*','*','2008-03-08','2008-03-08',1),('9','ian','9',0,'*','*','2008-03-08','2008-03-08',0),('haiwan','海湾','haiwan',0,'*','*','2008-03-08','2008-03-08',1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-08-10 14:12:15
