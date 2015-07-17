<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use app\models\Dance;
use app\models\DanceRecord;
use app\models\DanceLeader;
use app\models\User;
use yii\web\UploadedFile;

require_once dirname(__FILE__) . '/../vendor/PHPExcel-1.8/Classes/PHPExcel.php'; 

class DanceController extends Controller
{
    public function actionGenerateDanceTree()
    {
        $dances = Dance::find()->select(['country', 'name', 'kind'])->orderBy('country')->all();
        $dancesArr = array();
        foreach ($dances as $dance) {
            $country = $dance->country;
            if (!array_key_exists($country, $dancesArr)) {
                $dancesArr[$country] = array();
            }
            $dancesArr[$country][] = $dance->name . ($dance->kind == 1 ? "*" : "");
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
        $PHPExcel = new PHPExcel(); 

        //默认用excel2007读取excel，若格式不对，则用之前的版本进行读取
        $PHPReader = new PHPExcel_Reader_Excel2007(); 
        if(!$PHPReader->canRead($filePath)){ 
            $PHPReader = new PHPExcel_Reader_Excel5(); 
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
        $dance = new Dance();
        $msg = "";
        for($currentRow = 2;$currentRow <= $allRow;$currentRow++){ 
            $arr = array();
            for($currentColumn= 'A';$currentColumn<= $allColumn; $currentColumn++){ 
                $val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getValue();//ord()将字符转为十进制数
                $arr[$currentColumn] = $val;
                //如果输出汉字有乱码，则需将输出内容用iconv函数进行编码转换，如下将gb2312编码转为utf-8编码输出 
                //echo iconv('utf-8','gb2312', $val)."\t"; 
            }
            $dance->name = $arr['A'];
            $dance->country = $arr['B'];
            $dance->kind = $arr['C'];
            $dance->dance_level = $arr['D'];
            $dance->description = $arr['E'];
            $dance->dance_count = 0;
            if (!$dance->insert()) {
                $msg .= $arr['A'] . ",";
            }
        }
        return json_encode(array('msg' => $msg));
    }


    private static $DANCE_LEVEL = array(
        1 => '简单',
        2 => '入门',
        3 => '熟练',
        4 => '进阶',
        5 => '高阶',
    );
}
