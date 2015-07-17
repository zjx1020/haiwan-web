<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\log\Logger;

class ActivityForm extends Model
{
    public $time;
    public $name;
    public $address;
    public $cost;
    public $description;

    public function attributeLabels()
    {
        return [
            'time' => '活动时间',
            'name' => '活动主题',
            'address' => '活动地址',
            'cost' => '活动花费',
            'description' => '活动简介',
        ];
    }

    public function rules()
    {
        return [
            [['time', 'name', 'address', 'cost'], 'required'],
            [['time', 'name'], 'checkExist'],
        ];
    }

    public function checkExist($attribute, $params) {
        if (!$this->hasErrors()) {
            $activity = Activity::find()->where("name=\"" . $this->name . "\" and time=\"" . $this->time . "\"")->one();
            if ($activity != null) {
                $this->addError($attribute, '活动已存在');
            }
        }
    }

    public function createActivity()
    {
        $activity = new Activity();
        $activity->time = $this->time;
        $activity->name = $this->name;
        $activity->address = $this->address;
        $activity->cost = $this->cost;
        $activity->description = $this->description == null ? "" : $this->description;
        $activity->income = 0;
        $activity->kind = 0;
        $activity->creator = Yii::$app->user->identity->name;
        try {
            $result = $activity->insert();
            if ($result === false) {
                Yii::error("insert to db activity failed");
            }
            return $result;
        } catch (Exception $e) {
            Yii::error("insert to db activity exception:" . $e->getMessage());
            return false;
        }
    }
}
