<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use app\models\DanceAction;
use app\models\DancePose;
use yii\log\Logger;

class RookieController extends Controller {
    private $sysErr = "操作失败，系统异常，请联系管理员！";

    public function actionBasicAction() {
        $actions = DanceAction::find()->orderBy("convert(name using gbk)")->asArray()->all();
        return json_encode($actions);
    }

    public function actionBasicPose() {
        $poses = DancePose::find()->orderBy("convert(name using gbk)")->asArray()->all();
        return json_encode($poses);
    }

    public function actionAddAction() {
        $action = new DanceAction;
        $action->name = $_REQUEST['name'];
        $action->description = $_REQUEST['description'];
        $action->url = '';
        try {
            if ($action->insert() === false) {
                Yii::error("insert into db failed");
                return json_encode(array('succ' => false));
            }
        } catch (yii\db\IntegrityException $e) {
            return json_encode(array('succ' => false, 'exist' => true));
        } catch (Exception $e) {
            Yii::error("db exception: " . $e->getMessage());
            return json_encode(array('succ' => false));
        }
        return json_encode(array('succ' => true));
    }

    public function actionAddPose() {
        $pose = new DancePose;
        $pose->name = $_REQUEST['name'];
        $pose->description = $_REQUEST['description'];
        $pose->url = '';
        try {
            if ($pose->insert() === false) {
                Yii::error("insert into db failed");
                return json_encode(array('succ' => false));
            }
        } catch (yii\db\IntegrityException $e) {
            return json_encode(array('succ' => false, 'exist' => true));
        } catch (Exception $e) {
            Yii::error("db exception: " . $e->getMessage());
            return json_encode(array('succ' => false));
        }
        return json_encode(array('succ' => true));
    }

    public function actionUpdateAction() {
        $names = explode(',', $_REQUEST['names']);
        $values = explode("delim", $_REQUEST['values']);
        $targets = DanceAction::find()->where(['in', 'name', $names])->all();
        $inputMap = array();
        for ($i = 0; $i < count($names); ++$i) {
            $inputMap[$names[$i]] = $values[$i];
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($targets as $target) {
                $target->description = $inputMap[$target->name];
                if ($target->update() === false) {
                    $transaction->rollBack();
                    return json_encode(array('succ' => false, 'msg' => $this->sysErr));
                }
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::error("update db exception:" . $e->getMessage());
            return json_encode(array('succ' => false, 'msg' => $this->sysErr));
        }
        $transaction->commit();
        return json_encode(array('succ' => true));
    }

    public function actionUpdatePose() {
        $names = explode(',', $_REQUEST['names']);
        $values = explode("delim", $_REQUEST['values']);
        $targets = DancePose::find()->where(['in', 'name', $names])->all();
        $inputMap = array();
        for ($i = 0; $i < count($names); ++$i) {
            $inputMap[$names[$i]] = $values[$i];
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($targets as $target) {
                $target->description = $inputMap[$target->name];
                if ($target->update() === false) {
                    $transaction->rollBack();
                    return json_encode(array('succ' => false, 'msg' => $this->sysErr));
                }
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::error("update db exception:" . $e->getMessage());
            return json_encode(array('succ' => false, 'msg' => $this->sysErr));
        }
        $transaction->commit();
        return json_encode(array('succ' => true));
    }
}
