<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\log\Logger;

class UserForm extends Model
{
    public $account;
    public $name;
    public $password;
    public $newPassword;
    public $passwordVerify;
    public $sex;
    public $phone;
    public $email;
    public $birth;
    public $join_date;
    public $leader_dance_list;
    public $left_count;
    public $rememberMe = true;


    public function attributeLabels()
    {
        return [
            'account' => '账号',
            'name' => '昵称',
            'password' => '密码',
            'newPassword' => '新密码',
            'passwordVerify' => '确认密码',
            'sex' => '性别',
            'phone' => '电话',
            'email' => '邮箱',
            'birth' => '生日',
            'join_date' => '首次加入海湾的时间',
            'leader_dance_list' => '可领跳舞码',
            'left_count' => '剩余活动次数',
            'rememberMe' => '记住我',
        ];
    }

    public function rules()
    {
        return [
            // rules for scenario login
            [['account', 'password'], 'required', 'on' => 'login'],
            ['rememberMe', 'boolean', 'on' => 'login'],
            ['password', 'validateAccountPassword', 'on' => 'login'],
            // rules for scenario register
            [['account', 'name', 'password', 'passwordVerify', 'sex', 'phone', 'email', 'birth'], 'required', 'on' => 'register'],
            ['account', 'validateAccountExist', 'on' => 'register'],
            ['name', 'validateNameExist', 'on' => 'register'],
            ['password', 'compare', 'compareAttribute' => 'passwordVerify', 'on' => 'register'],
            ['email', 'email', 'on' => 'register'],
            // rules for scenario modifyProfile
            [['name', 'sex', 'phone', 'email', 'birth'], 'required', 'on' => 'profile'],
            ['name', 'validateNewNameExist', 'on' => 'modifyProfile'],
            // rules for scenario modifyPassword
            [['password', 'newPassword', 'passwordVerify'], 'required', 'on' => 'modifyPassword'],
            ['password', 'validatePassword', 'on' => 'modifyPassword'],
            ['passwordVerify', 'compare', 'compareAttribute' => 'newPassword', 'on' => 'modifyPassword'],
        ];
    }

    public function scenarios() {
        return [
            'login' => ['account', 'password', 'rememberMe'],
            'register' => ['account', 'name', 'password', 'passwordVerify', 'sex', 'phone', 'email', 'birth'],
            'profile' => ['name', 'sex', 'phone', 'email', 'birth', 'join_date', 'leader_dance_list', 'left_count'],
            'modifyProfile' => ['name', 'sex', 'phone', 'email', 'birth', 'join_date'],
            'modifyPassword' => ['password', 'newPassword', 'passwordVerify'],
        ];
    }

    /**
     *  functions for scenario login
     */
    public function validateAccountPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findOne($this->account);

            if ($user == null || $user->account != $this->account || $user->password != $this->password) {
                $this->addError($attribute, '账号或密码错误.');
            }
        }
    }

    public function login()
    {
        //return Yii::$app->user->login(User::findIdentity($this->account), $this->rememberMe ? 3600*24*30 : 0);
        return Yii::$app->user->login(User::findIdentity($this->account));
    }

    /**
     *  functions for scenarios register
     */
    public function validateAccountExist($attribute, $params) {
        if (!$this->hasErrors()) {
            if (User::findOne($this->account) != null) {
                $this->addError($attribute, '账号已存在');
            }
        }
    }

    public function validateNameExist($attribute, $params) {
        if (!$this->hasErrors()) {
            if (User::findOne($this->name) != null) {
                $this->addError($attribute, '昵称已存在');
            }
        }
    }

    public function register()
    {
        $user = new User();
        $user->account = $this->account;
        $user->name = $this->name;
        $user->password = $this->password;
        $user->sex = $this->sex;
        $user->phone = $this->phone;
        $user->email = $this->email;
        $user->birth = $this->birth;
        $user->join_date = "0000-00-00";
        $user->left_count = 0;
        try {
            $result = $user->insert();
            if ($result === false) {
                Yii::error("insert to db user failed");
            }
            return $result;
        } catch (Exception $e) {
            Yii::error("insert to db user exception:" . $e->getMessage());
            return false;
        }
    }

    public function profile() {
        $account = Yii::$app->user->identity->account;
        $user = User::findOne($account);
        if ($user) {
            $this->name = $user->name;
            $this->sex = $user->sex == 0 ? '男' : '女';
            $this->phone = $user->phone;
            $this->email = $user->email;
            $this->birth = $user->birth;
            $this->join_date = $user->join_date == "0000-00-00" ? "未知" : $user->join_date;
            $this->leader_dance_list = '还没有可以领跳的舞哦';
            $this->left_count = $user->left_count;
            return true;
        } else {
            Yii::error("get db user by account=$account failed");
            return false;
        }
    }
    /**
     *  functions for scenarios modifyProfile
     */
    public function validateNewNameExist() {
        if (!$this->hasErrors()) {
            $user = User::findOne(['name' => $this->name]);
            if ($user != null && $user->account != Yii::$app->user->identity->account) {
                $this->addError($attribute, '昵称已存在');
            }
        }
    }

    public function getOldProfile() {
        $account = Yii::$app->user->identity->account;
        $user = User::findOne($account);
        if ($user) {
            $this->name = $user->name;
            $this->sex = $user->sex;
            $this->phone = $user->phone;
            $this->email = $user->email;
            $this->birth = $user->birth;
            $this->join_date = $user->join_date == "0000-00-00" ? "" : $user->join_date;
        } else {
            Yii::error("get db user by account=$account failed");
        }
    }

    public function modifyProfile() {
        $account = Yii::$app->user->identity->account;
        $user = User::findOne($account);
        if ($user) {
            $user->name = $this->name;
            $user->sex = $this->sex;
            $user->phone = $this->phone;
            $user->email = $this->email;
            $user->birth = $this->birth;
            $user->join_date = $this->join_date == "" ? "0000-00-00" : $this->join_date;
            try {
                if ($user->update() !== false) {
                    return true;
                } else {
                    Yii::error("update db user by account=$account failed");
                    return false;
                }
            } catch (Exception $e) {
                Yii:error("update db user by account=$account failed with exception:" . $e->getMessage());
                return false;
            }
        } else {
            Yii::error("get db user by account=$account failed");
            return false;
        }
    }

    /**
     *  functions for scenarios modifyPassword
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $account = Yii::$app->user->identity->account;
            $user = User::findOne($account);

            if ($user->password != $this->password) {
                $this->addError($attribute, '密码错误.');
            }
        }
    }

    public function modifyPassword() {
        $account = Yii::$app->user->identity->account;
        $user = User::findOne($account);
        if ($user) {
            $user->password = $this->newPassword;
            try {
                if ($user->update() !== false) {
                    return true;
                } else {
                    Yii::error("update db user by account=$account failed");
                    return false;
                }
            } catch (Exception $e) {
                Yii:error("update db user by account=$account failed with exception:" . $e->getMessage());
                return false;
            }
        } else {
            Yii::error("get db user by account=$account failed");
            return false;
        }
    }
}
