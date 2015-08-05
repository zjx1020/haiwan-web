<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use app\models\Activity;
use app\models\Dance;
use app\models\DanceRecord;
use app\models\DanceLeader;
use app\models\User;
use app\models\Country;
use yii\web\UploadedFile;
use yii\log\Logger;

require_once (dirname(__FILE__) . '/../vendor/phpoffice/phpexcel/Classes/PHPExcel.php'); 

class DanceController extends Controller
{
    public function actionGenerateDanceTree()
    {
        $dances = Dance::find()->select(['country', 'name', 'kind'])->orderBy("convert(country using gbk)")->all();
        $dancesArr = array();
        foreach ($dances as $dance) {
            $country = $dance->country;
            if (!array_key_exists($country, $dancesArr)) {
                $dancesArr[$country] = array();
            }
            $dancesArr[$country][] = $dance->name . ($dance->kind == 2 ? "*" : "");
        }

        $childNodes = array();
        foreach ($dancesArr as $country => $names) {
            $childs = array();
            foreach ($names as $name) {
                $childs[] = array('name' => $name, 'isDance' => true);
            }
            $childNodes[] = array('name' => $country, 'children' => $childs);
        }
        $nodes = array('name' => '舞码大全', 'open' => true, 'children' => $childNodes);

        return json_encode($nodes);
    }

    public function actionDisplayDance() {
        $params = $_REQUEST;
        $name = $params["name"];
        $dance = Dance::find()->select(['dance_level', 'description', 'dance_count'])->where("name=\"$name\"")->asArray()->One();
        $dance['dance_level'] = self::$DANCE_LEVEL[$dance['dance_level']];
        $danceLeaders = User::findBySql("select name from user where account in (select account from dance_leader where dance_name=\"$name\")")->all();
        $leaderCnt = count($danceLeaders);
        if ($leaderCnt == 0) {
            $dance["leaders"] = "海湾竟然没人会跳这首舞。。。";
        } else {
            $leaders = array();
            foreach ($danceLeaders as $danceLeader) {
                $leaders[] = $danceLeader->name;
            }
            $dance["leaders"] = implode("，", $leaders);
        }
        $dance['isGuest'] = Yii::$app->user->isGuest ? true : false;
        if (!$dance['isGuest']) {
            if ($leaderCnt != 0 && strpos($dance["leaders"], Yii::$app->user->identity->name) !== false) {
                $dance['isLeader'] = true;
            } else {
                $dance['isLeader'] = false;
            }
        }
        return json_encode($dance);
    }

    public function actionDisplayAllDance() {
        $totalCount = Dance::find()->count();
        $totalCountryCount = Dance::find()->groupBy(['country'])->count();
        $result = "海湾共收录" . $totalCountryCount . "个国家" . $totalCount . "首舞蹈。" . "<br>";
        
        return json_encode(array('content' => $result));
    }

    public function actionDisplayCountryDance() {
        $params = $_REQUEST;
        $country = $params["country"];
        $count = Dance::find()->where("country=\"$country\"")->count();
        $result = $country . "土风舞有" . $count . "首。";
        return json_encode(array('content' => $result));
    }

    public function actionAddDanceLeader() {
        $params = $_REQUEST;
        $danceLeader = new DanceLeader;
        $danceLeader->dance_name = $params["name"];
        $danceLeader->account = Yii::$app->user->identity->account;
        $danceLeader->time = date("Y-m-d H:i:s", time());
        $result = array();
        if ($danceLeader->insert()) {
            $result['msg'] = "恭喜成为\"" . $params["name"] . "\"领舞者，请每次活动前认真复习并积极领舞，领舞不合格者将被取消领舞资格！";
        } else {
            $result['msg'] = "系统异常，请联系管理员！";
        }
        return json_encode($result);
    }

    public function actionDisplayTeachRecord() {
        $params = $_REQUEST;
        $name = $params['name'];
        $query = new Query;
        $rows = $query->select(['activity.time', 'dance_record.teacher'])->from(['dance_record', 'activity'])->where("dance_record.activity_id=activity.id and dance_record.kind=2 and dance_name=\"$name\"")->orderBy('activity.time')->all();

        return json_encode($rows);
    }

    public function actionAddDances() {
        $filePath = $_REQUEST['filePath'];
        if (!isset($filePath)) {
            return;
        }
        $filePath = dirname(__FILE__) . "/../" . $filePath;
        $PHPExcel = new \PHPExcel(); 

        //默认用excel2007读取excel，若格式不对，则用之前的版本进行读取
        $PHPReader = new \PHPExcel_Reader_Excel2007(); 
        if(!$PHPReader->canRead($filePath)){ 
            $PHPReader = new \PHPExcel_Reader_Excel5(); 
            if(!$PHPReader->canRead($filePath)){ 
                echo 'no Excel'; 
                return ; 
            }
        }

        $PHPExcel = $PHPReader->load($filePath); 
        //读取excel文件中的第一个工作表
        $currentSheet = $PHPExcel->getSheet(0); 
        /**取得最大的列号*/ 
        $allColumn = $currentSheet->getHighestColumn(); 
        if ($allColumn != 'E') {
            return;
        }
        //取得一共有多少行
        $allRow = $currentSheet->getHighestRow(); 
        /*
        for($currentColumn= 'A';$currentColumn <= $allColumn; $currentColumn++){ 
            $val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,1)->getValue();
            echo $val . "\n";
        }
        */
        //从第二行开始输出，因为excel表中第一行为列名
        $msg = "";
        $countryArr = Country::find()->all();
        $countries = array();
        foreach ($countryArr as $country) {
            $countries[] = $country->name;
        }
        for($currentRow = 2;$currentRow <= $allRow;$currentRow++){ 
            $dance = new Dance();
            $arr = array();
            for($currentColumn= 'A';$currentColumn<= $allColumn; $currentColumn++){ 
                $val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getValue();//ord()将字符转为十进制数
                $val = $val == null ? "" : $val;
                if ($currentColumn == 'C' || $currentColumn == 'D') {
                    $val = $val == "" ? 1 : (integer) $val;
                }
                $arr[$currentColumn] = $val;
                //如果输出汉字有乱码，则需将输出内容用iconv函数进行编码转换，如下将gb2312编码转为utf-8编码输出 
                //echo iconv('utf-8','gb2312', $val)."\t"; 
            }
            $dance->name = $arr['A'];
            $dance->country = in_array($arr['B'], $countries) ? $arr['B'] : '未知';
            $dance->kind = $arr['C'];
            $dance->dance_level = $arr['D'];
            if (!in_array($arr['B'], $countries)) {
                $dance->description = "出自：" . $arr['B'] . "。" . $arr['E'];
            } else {
                $dance->description = $arr['E'];
            }
            $dance->dance_count = 0;
            try {
                if (!$dance->insert()) {
                    $msg .= $arr['A'] . ",";
                }
            } catch (yii\db\IntegrityException $e) {
                $msg .= $arr['A'] . ":" . $e->getMessage() . ",";
            }
        }
        return json_encode(array('msg' => $msg));
    }

    public function actionGenerateReviewDances() {
        $num = (integer) $_REQUEST['num'];
    }

    /**
     * 自动生成舞码逻辑：
     * 1、单、双人舞各选一半
     * 2、从舞码库里选出上一次没跳过且不在这次教舞、复习舞里的所有舞码
     */
     /*
    public function actionGenerateActivityDances() {
        $num = (integer) $_REQUEST['num'];
        $id = (integer) $_REQUEST['id'];
        $coupleDanceNum = $num / 2;
        $singleDanceNum = $num - $coupleDanceNum;
        $lastActivity = Activity::find()->select(['id'])->where("kind=1")->orderBy('time DESC')->One();
        if ($lastActivity === false) {
            $filter = " and name not in (select dance_name from dance_record where activity_id=$id)";
        } else {
            $lastId = $lastActivity['id'];
            $filter = " and name not in (select dance_name from dance_record where activity_id=$id or activity_id=$lastId)";
        }

        $sql = "select name from dance where kind=1";
        $dances = Dance::findBySql($sql . $filter)->all();
        if (count($dances) < $singleDanceNum) {
            return json_encode(array('succ' => false, 'msg' => "舞码库舞码太少，无法排舞"));
        }
        $singleDances = array();
        $i = 0;
        foreach ($dances as $dance) {
            $singleDances[$i++] = $dance->name;
        }
        
        $sql = "select name from dance where kind=2";
        $dances = Dance::findBySql($sql . $filter)->all();
        if (count($dances) < $coupleDanceNum) {
            return json_encode(array('succ' => false, 'msg' => "舞码库舞码太少，无法排舞"));
        }
        $coupleDances = array();
        $i = 0;
        foreach ($dances as $dance) {
            $coupleDances[$i++] = $dance->name;
        }

        $file = fopen(dirname(__FILE__) . "/../web/uploads/result", "w");
        $leftSingle = count($singleDances);
        $leftCouple = count($coupleDances);
        for ($i = 0; $i < $num; ++$i) {
            if ($singleDanceNum == 0) {
                $type = 2;
            } elseif ($coupleDanceNum == 0) {
                $type = 1;
            } else {
                $type = rand(1, 2);
            }
            if ($type == 1) {
                $pos = rand(0, $leftSingle - 1);
                $name = $singleDances[$pos];
                $leftSingle -= 1;
                $singleDances[$pos] = $singleDances[$leftSingle];
            } else {
                $pos = rand(0, $leftCouple - 1);
                $name = $coupleDances[$pos] . "*";
                $leftCouple -= 1;
                $coupleDances[$pos] = $coupleDances[$leftCouple];
            }
            
            fwrite($file, $name . "\n");
        }
    }
    */

    /**
     * 自动生成舞码逻辑：
     * 1、单、双人舞各选一半
     * 2、从舞码库里选出上一次没跳过且不在这次教舞、复习舞里的所有舞码
     * 3、最后一首固定为"再见"
     */
    public function generateActivityDances($num, $reviewDances) {
        $coupleDanceNum = $num / 2;
        $singleDanceNum = $num - $coupleDanceNum;
        $lastActivity = Activity::find()->select(['id'])->where("kind=1")->orderBy('time DESC')->One();
        
        for ($i = 0; $i < count($reviewDances); ++$i) {
            $reviewDances[$i].rtrim('*');
        }
        if ($lastActivity != null) {
            $lastId = $lastActivity['id'];
            $filter = "name not in (select dance_name from dance_record where activity_id=$lastId)";
            $dances = Dance::find()->select(['name'])->where("kind=1")->andWhere(['not in', 'name', $reviewDances])->andWhere($filter)->all();
        } else {
            $dances = Dance::find()->select(['name'])->where("kind=1")->andWhere(['not in', 'name', $reviewDances])->all();
        }
        if (count($dances) < $singleDanceNum) {
            return null;
        }
        $singleDances = array();
        $i = 0;
        foreach ($dances as $dance) {
            $singleDances[$i++] = $dance->name;
        }
        
        if ($lastActivity != null) {
            $lastId = $lastActivity['id'];
            $filter = "name not in (select dance_name from dance_record where activity_id=$lastId)";
            $dances = Dance::find()->select(['name'])->where("kind=2")->andWhere(['not in', 'name', $reviewDances])->andWhere($filter)->all();
        } else {
            $dances = Dance::find()->select(['name'])->where("kind=2")->andWhere(['not in', 'name', $reviewDances])->all();
        }
        if (count($dances) < $coupleDanceNum) {
            return null;
        }
        $coupleDances = array();
        $i = 0;
        foreach ($dances as $dance) {
            $coupleDances[$i++] = $dance->name;
        }

        $leftSingle = count($singleDances);
        $leftCouple = count($coupleDances);
        $result = array();
        for ($i = 0; $i < $num; ++$i) {
            if ($singleDanceNum == 0) {
                $type = 2;
            } elseif ($coupleDanceNum == 0) {
                $type = 1;
            } else {
                $type = rand(1, 2);
            }
            if ($type == 1) {
                $pos = rand(0, $leftSingle - 1);
                $name = $singleDances[$pos];
                $leftSingle -= 1;
                $singleDances[$pos] = $singleDances[$leftSingle];
            } else {
                $pos = rand(0, $leftCouple - 1);
                $name = $coupleDances[$pos] . "*";
                $leftCouple -= 1;
                $coupleDances[$pos] = $coupleDances[$leftCouple];
            }
            $result[] = $name;
        }
        $result[] = '再见';
        return $result;
    }

    public function actionGetActivityDanceInfo() {
        $reviewCnt = (integer) $_REQUEST['reviewCnt'];
        $activityCnt = (integer) $_REQUEST['activityCnt'];

        $dances = Dance::find()->select(['name', 'kind'])->orderBy("convert(name using gbk)")->all();
        $allDances = array();
        foreach ($dances as $dance) {
            $allDances[] = $dance->kind == 2 ? $dance->name . "*" : $dance->name;
        }

        $users = User::find()->select('name')->orderBy("convert(name using gbk)")->all();
        $allUsers = array();
        foreach ($users as $user) {
            $allUsers[] = $user->name;
        }

        $sql = "select name,kind from dance where name in (select dance_name from dance_record where kind=2 and activity_id in (select id from activity where kind=1 order by time desc)) limit $reviewCnt";
        $dances = Dance::findBySql($sql)->all();
        $reviewDances = array();
        foreach ($dances as $dance) {
            $reviewDances[] = $dance->name;
        }
        $activityDances = $this->generateActivityDances($activityCnt - 1, $reviewDances);
        unset($reviewDances);
        foreach ($dances as $dance) {
            $reviewDances[] = $dance->kind == 2 ? $dance->name . "*" : $dance->name;
        }

        return json_encode(array('allDances' => $allDances, 'allUsers' => $allUsers, 'reviewDances' => $reviewDances, 'activityDances' => $activityDances));
    }

    private static $DANCE_LEVEL = array(
        1 => '简单',
        2 => '入门',
        3 => '熟练',
        4 => '进阶',
        5 => '高阶',
    );
}
