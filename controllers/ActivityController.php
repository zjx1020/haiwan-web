<?php

namespace app\controllers;

//use Yii;
use yii\web\Controller;
use app\models\Activity;
use app\models\User;
use app\models\Dance;
use app\models\DanceRecord;
use yii\log\Logger;

class ActivityController extends Controller
{
    public function actionGenerateActivityTree()
    {
        $activities = Activity::find()->select(['id', 'time', 'name'])->where("kind=1")->orderBy(['time' => SORT_DESC])->all();
        $activitiesArr = array();
        foreach ($activities as $activity) {
            $year = substr($activity->time, 0, 4);
            $name = substr($activity->time, 5) . " " . $activity->name;
            if (!array_key_exists($year, $activitiesArr)) {
                $activitiesArr[$year] = array();
            }
            $activitiesArr[$year][$activity->id] = $name;
        }

        $yearName = '年';
        $childNodes = array();
        foreach ($activitiesArr as $year => $names) {
            $childs = array();
            foreach ($names as $id => $name) {
                $childs[] = array('name' => $name, 'id' => $id);
            }
            $childNodes[] = array('name' => $year . $yearName, 'children' => $childs);
        }
        $childNodes[0]['open'] = true;
        $nodes = array('name' => '活动', 'open' => true, 'children' => $childNodes);

        return json_encode($nodes);
    }

    public function actionDisplayActivity() {
        $result = array();
        $params = $_REQUEST;
        $id = (integer)$params["id"];
        $activity = Activity::find()->select(['address', 'description'])->where("id=$id")->asArray()->One();
        $users = User::findBySql("select name from user where account in (select account from activity_record where activity_id=$id)")->all();
        $names = array();
        foreach ($users as $user) {
            $names[] = $user->name;
        }
        $activity['users'] = implode(" ", $names);

        $dinnerUsers = User::findBySql("select name from user where account in (select account from activity_record where activity_id=$id and is_dinner=1)")->all();
        $dinnerNames = array();
        foreach ($dinnerUsers as $dinnerUser) {
            $dinnerNames[] = $dinnerUser->name;
        }
        $activity['dinnerUsers'] = implode(" ", $dinnerNames);
        $result['info'] = $activity;

        $dances = DanceRecord::find()->select(['dance_name', 'teacher'])->where("activity_id=$id and kind=2")->all();
        $teachDances = array();
        foreach ($dances as $dance) {
            $kind = Dance::find()->select(['kind'])->where("name=\"" . $dance->dance_name . "\"")->One()->kind;
            $teachDance = array();
            $teachDance['name'] = $dance->dance_name . ($kind == 1 ? "*" : "");
            $teachDance['teacher'] = "教舞者：" . $dance->teacher;
            $teachDances[] = $teachDance;
        }
        $result['teachDances'] = $teachDances;

        $reviewDances = array();
        $dances = Dance::findBySql("select name,kind from dance where name in (select dance_name from dance_record where activity_id=$id and kind=1)")->all();
        foreach ($dances as $dance) {
            $reviewDances[] = $dance->name . ($dance->kind == 1 ? "*" : "");
        }
        $result['reviewDances'] = $reviewDances;

        $activityDances = array();
        $dances = Dance::findBySql("select name,kind from dance where name in (select dance_name from dance_record where activity_id=$id and kind=0)")->all();
        foreach ($dances as $dance) {
            $activityDances[] = $dance->name . ($dance->kind == 1 ? "*" : "");
        }
        $result['activityDances'] = $activityDances;

        return json_encode($result);
    }

    public function actionDisplayAllActivity() {
        $minTime = Activity::find()->where("kind=1")->min('time');
        $totalCount = Activity::find()->where("kind=1")->count();
        $days = floor((time() - strtotime($minTime)) / 86400);
        $result = "海湾从" . $minTime . "开始已举办" . $totalCount . "次活动，横跨" . $days . "天。" . "<br>";
        $yearCount = array();
        $currentYear = date("Y", time());
        $minYear = substr($minTime, 0, 4);
        for ($i = $minYear; $i <= $currentYear; ++$i) {
            $yearCount[$i] = Activity::find()->where("kind=1 and time like \"$i%\"")->count();
        }
        $result .= "其中：" . "<br>";
        foreach ($yearCount as $year => $count) {
            $result .= $year . "年" . $count . "次活动。" . "<br>";
        }
        return json_encode(array('content' => $result));
    }

    public function actionDisplayYearActivity() {
        $params = $_REQUEST;
        $year = $params["year"];
        $count = Activity::find()->where("kind=1 and time like \"$year%\"")->count();
        $result = "本年度海湾活动" . $count . "次。";
        return json_encode(array('content' => $result));
    }

    public function checkAuth() {
        $id = (integer) $_REQUEST['id'];
        $result = array();
        $result['canJoin'] = canJoin();
        $result['hasAuth'] = hasAuth($id);
        return json_encode($result);
    }

    private function canJoin() {
        if (Yii::$app->user->isGuest || ActivityRecord::find()->where("account=\"" . Yii::$app->user->identity->account . "\"")->one() != null) {
            return false;
        }
        return true;
    }

    private function hasAuth($id) {
        $activity = Activity::findOne($id);
        if (Yii::$app->user->identity->name == $activity->creator || Yii::$app->user->identity->account == 'haiwan') {
            return true;
        }
        return false;
    }

    public function actionJoin() {
        $id = (integer) $_REQUEST['id'];
        if (canJoin() === false) {
            return json_encode(array('succ' => false, 'msg' => '无法报名'));
        }
        $activityRecord = new ActivityRecord();
        $activityRecord->account = Yii::$app->user->identity->account;
        $activityRecord->activity_id = $id;
        $activityRecord->pay = 30;
        try {
            $result = $activityRecord->insert();
            if ($result === false) {
                Yii::error("insert to db activityRecord failed");
                return json_encode(array('succ' => false, 'msg' => '网站异常，报名失败，请联系管理员'));
            }
            return $this->redirect(['/site/new-activity']);
        } catch (Exception $e) {
            Yii::error("insert to db activityRecord exception:" . $e->getMessage());
            return json_encode(array('succ' => false, 'msg' => '网站异常，报名失败，请联系管理员'));
        }
    }

    public function actionCancel() {
        $id = (integer) $_REQUEST['id'];
    }

    public function actionFinish() {
        $id = (integer) $_REQUEST['id'];
    }
}
