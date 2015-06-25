<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property integer $id
 * @property string $time
 * @property string $name
 * @property string $address
 * @property integer $cost
 * @property integer $income
 * @property string $description
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time', 'name', 'address', 'cost', 'income', 'description'], 'required'],
            [['time'], 'safe'],
            [['cost', 'income'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 128],
            [['address'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time' => 'Time',
            'name' => 'Name',
            'address' => 'Address',
            'cost' => 'Cost',
            'income' => 'Income',
            'description' => 'Description',
        ];
    }
}
