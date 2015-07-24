<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Activity;
use app\models\ActivityRecord;
use app\models\User;
use app\models\Dance;
use app\models\DanceRecord;
use yii\log\Logger;

class ActivityController extends Controller
{
    private $sysErr = "操作失败，系统异常，请联系管理员！";

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

        $result['info'] = $activity;

        $dances = DanceRecord::find()->select(['dance_name', 'teacher'])->where("activity_id=$id and kind=2")->all();
        $teachDances = array();
        foreach ($dances as $dance) {
            $kind = Dance::find()->select(['kind'])->where("name=\"" . $dance->dance_name . "\"")->One()['kind'];
            $teachDance = array();
            $teachDance['name'] = $dance->dance_name . ($kind == 2 ? "*" : "");
            $teachDance['teacher'] = "教舞者：" . $dance->teacher;
            $teachDances[] = $teachDance;
        }
        $result['teachDances'] = $teachDances;

        $reviewDances = array();
        $dances = Dance::findBySql("select name,kind from dance where name in (select dance_name from dance_record where activity_id=$id and kind=1)")->all();
        foreach ($dances as $dance) {
            $reviewDances[] = $dance->name . ($dance->kind == 2 ? "*" : "");
        }
        $result['reviewDances'] = $reviewDances;

        $activityDances = array();
        $dances = Dance::findBySql("select name,kind from dance where name in (select dance_name from dance_record where activity_id=$id and kind=0)")->all();
        foreach ($dances as $dance) {
            $activityDances[] = $dance->name . ($dance->kind == 2 ? "*" : "");
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

    public function actionCheckAuth() {
        $id = (integer) $_REQUEST['id'];
        $result = array();
        $result['canJoin'] = $this->canJoin();
        $result['hasAuth'] = $this->hasAuth($id);
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
        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->name == $activity->creator || Yii::$app->user->identity->account == 'haiwan') {
                return true;
            }
        }
        return false;
    }

    public function actionJoin() {
        $id = (integer) $_REQUEST['id'];
        if (canJoin() === false) {
            return json_encode(array('succ' => false, 'msg' => '无权限报名'));
        }
        $user = User::findOne(Yii::$app->user->identity->account);
        if ($user->left_count < 1) {
            return json_encode(array('succ' => false, 'msg' => '无报名次数，请缴费'));
        }
        $activityRecord = new ActivityRecord();
        $activityRecord->account = Yii::$app->user->identity->account;
        $activityRecord->activity_id = $id;
        $activityRecord->time = date("Y-m-d H:i:s", time());
        $user->left_count -= 1;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($user->update() === false || $activityRecord->insert() === false) {
                $transaction->rollBack();
                Yii::error("update db failed");
                return json_encode(array('succ' => false, 'msg' => $this->sysErr));
            }
            return $this->redirect(['/site/new-activity']);
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::error("update db exception:" . $e->getMessage());
            return json_encode(array('succ' => false, 'msg' => $this->sysErr));
        }
        $transaction->commit();
        return json_encode(array('succ' => true, 'msg' => '报名成功'));
    }

    public function actionCancel() {
        $id = (integer) $_REQUEST['id'];
        if ($this->hasAuth($id) === false) {
            return json_encode(array('succ' => false, 'msg' => '无权限取消'));
        }
        $activity = Activity::findOne($id);
        $user = User::findOne(Yii::$app->user->identity->account);
        $user->left_count += 1;
        $danceRecords = DanceRecord::find()->where("activity_id=$id")->all();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($activity->delete() === false || $user->update() === false) {
                $transaction->rollBack();
                Yii::error("update db failed");
                return json_encode(array('succ' => false, 'msg' => $this->sysErr));
            }
            foreach ($danceRecords as $danceRecord) {
                if ($danceRecord->delete() === false) {
                    $transaction->rollBack();
                    Yii::error("update db failed");
                    return json_encode(array('succ' => false, 'msg' => $this->sysErr));
                }
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::error("db exception: " . $e->getMessage());
            return json_encode(array('succ' => false, 'msg' => $this->sysErr));
        }
        $transaction->commit();
        return json_encode(array('succ' => true, 'msg' => '取消成功'));
    }

    public function actionFinish() {
        $id = (integer) $_REQUEST['id'];
        if ($this->hasAuth($id) === false) {
            return json_encode(array('succ' => false, 'msg' => '无权限操作'));
        }
        $activity = Activity::findOne($id);
        $activity->kind = 1;
        $danceRecords = DanceRecord::find()->where("activity_id=$id")->all();
        $dances = array();
        foreach ($danceRecords as $danceRecord) {
            $dances[] = Dance::findOne($danceRecord->dance_name);
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($activity->update() === false) {
                $transaction->rollBack();
                Yii::error("update db failed");
                return json_encode(array('succ' => false, 'msg' => $this->sysErr));
            }
            foreach ($dances as $dance) {
                $dance->dance_count += 1;
                if ($dance->update() === false) {
                    $transaction->rollBack();
                    Yii::error("update db failed");
                    return json_encode(array('succ' => false, 'msg' => $this->sysErr));
                }
            }
        } catch (Exception $e) {
            Yii::error("db exception: " . $e->getMessage());
            return json_encode(array('succ' => false, 'msg' => $this->sysErr));
        }
        $transaction->commit();
        return json_encode(array('succ' => true, 'msg' => '确认成功'));
    }

    public function actionCreateActivity() {
        //$time = $_POST['[time]'];
        //return json_encode(array('time' => $time));
        var_dump(Yii::$app->request->post());
    }
}
