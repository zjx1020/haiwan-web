<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property string $account
 * @property string $role
 *
 * @property User $account0
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account', 'role'], 'required'],
            [['account', 'role'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'account' => 'Account',
            'role' => 'Role',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount0()
    {
        return $this->hasOne(User::className(), ['account' => 'account']);
    }
}
