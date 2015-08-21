<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $account
 * @property string $name
 * @property string $password
 * @property integer $sex
 * @property string $phone
 * @property string $email
 * @property string $birth
 * @property string $join_date
 * @property integer $left_count
 * @property string $weixin
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['account', 'name', 'password', 'sex', 'phone', 'email', 'birth', 'join_date', 'left_count', 'weixin'], 'required'],
            [['sex', 'left_count'], 'integer'],
            [['birth', 'join_date'], 'safe'],
            [['account', 'name'], 'string', 'max' => 30],
            [['password', 'phone'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 128],
            [['weixin'], 'string', 'max' => 60],
        ];
    }

    public function attributeLabels()
    {
        return [
            'account' => 'Account',
            'name' => 'Name',
            'password' => 'Password',
            'sex' => 'Sex',
            'phone' => 'Phone',
            'email' => 'Email',
            'birth' => 'Birth',
            'join_date' => 'Join Date',
            'left_count' => 'Left Count',
            'weixin' => 'Weixin',
        ];
    } 

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        //return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->account;
    }

    public function getAuthKey()
    {
        //return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        //return $this->authKey === $authKey;
    }
}
