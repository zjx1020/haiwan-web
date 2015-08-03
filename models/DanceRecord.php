<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dance_record".
 *
 * @property integer $id
 * @property string $dance_name
 * @property integer $activity_id
 * @property integer $kind
 * @property string $teacher
 */
class DanceRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dance_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dance_name', 'activity_id', 'kind'], 'required'],
            [['activity_id', 'kind'], 'integer'],
            [['dance_name', 'teacher'], 'string', 'max' => 128]
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
            'activity_id' => 'Activity ID',
            'kind' => 'Kind',
            'teacher' => 'Teacher',
        ];
    }
}
