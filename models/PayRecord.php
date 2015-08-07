<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_record".
 *
 * @property integer $id
 * @property string $account
 * @property string $time
 * @property integer $money
 * @property string $owner
 * @property string $description
 */
class PayRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account', 'time', 'money', 'owner', 'description'], 'required'],
            [['time'], 'safe'],
            [['money'], 'integer'],
            [['description'], 'string'],
            [['account', 'owner'], 'string', 'max' => 30]
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
            'time' => 'Time',
            'money' => 'Money',
            'owner' => 'Owner',
            'description' => 'Description',
        ];
    }
}
