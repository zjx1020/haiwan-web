<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dance".
 *
 * @property string $name
 * @property string $country
 * @property integer $kind
 * @property integer $dance_level
 * @property string $description
 * @property integer $dance_count
 */
class Dance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'kind', 'dance_level', 'dance_count'], 'required'],
            [['kind', 'dance_level', 'dance_count'], 'integer'],
            [['description'], 'string'],
            [['name', 'country'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'country' => 'Country',
            'kind' => 'Kind',
            'dance_level' => 'Dance Level',
            'description' => 'Description',
            'dance_count' => 'Dance Count',
        ];
    }
}
