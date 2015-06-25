<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity_record".
 *
 * @property integer $id
 * @property string $account
 * @property integer $activity_id
 * @property integer $is_dinner
 * @property integer $pay
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
            [['account', 'activity_id', 'is_dinner', 'pay'], 'required'],
            [['activity_id', 'is_dinner', 'pay'], 'integer'],
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
            'is_dinner' => 'Is Dinner',
            'pay' => 'Pay',
        ];
    }
}
