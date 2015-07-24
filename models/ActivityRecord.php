<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_record".
 *
 * @property integer $id
 * @property string $account
 * @property integer $activity_id
 * @property string $time
 */
class ActivityRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account', 'activity_id', 'time'], 'required'],
            [['activity_id'], 'integer'],
            [['time'], 'safe'],
            [['account'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account' => 'Account',
            'activity_id' => 'Activity ID',
            'time' => 'Time',
        ];
    }
}
