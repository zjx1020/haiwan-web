<?php

namespace app\controllers;

//use Yii;
use yii\web\Controller;
use app\models\Dance;

class DanceController extends Controller
{
    public function actionGenerateDanceTree()
    {
        $dances = Dance::find()->select(['country', 'name'])->orderBy('country')->all();
        $dancesArr = array();
        foreach ($dances as $dance) {
            $country = $dance->country;
            if (!array_key_exists($country, $dancesArr)) {
                $dancesArr[$country] = array();
            }
            $dancesArr[$country][] = $dance->name;
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
    /*
        $params = $_REQUEST;
        $id = (integer)$params["id"];
        $dance = Dance::find()->select(['time', 'name', 'address', 'description'])->where("id=$id")->asArray()->One();
        return json_encode($dance);
        */
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
}
