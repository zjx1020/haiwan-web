<?php

namespace app\controllers;

//use Yii;
use yii\web\Controller;
use app\models\Dance;
use app\models\User;

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
        if (count($danceLeaders) == 0) {
            $dance["leaders"] = "海湾竟然没人会跳这首舞。。。";
        } else {
            $leaders = array();
            foreach ($danceLeaders as $danceLeader) {
                $leaders[] = $danceLeader->name;
            }
            $dance["leaders"] = implode(",", $leaders);
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
    
    private static $DANCE_LEVEL = array(
        1 => '简单',
        2 => '入门',
        3 => '熟练',
        4 => '进阶',
        5 => '高阶',
    );
}
