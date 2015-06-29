<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dance_leader".
 *
 * @property integer $id
 * @property string $dance_name
 * @property string $account
 * @property string $time
 */
class DanceLeader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dance_leader';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dance_name', 'account', 'time'], 'required'],
            [['time'], 'safe'],
            [['dance_name'], 'string', 'max' => 128],
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
            'dance_name' => 'Dance Name',
            'account' => 'Account',
            'time' => 'Time',
        ];
    }
}
