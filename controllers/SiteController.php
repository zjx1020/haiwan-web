<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ContactForm;
use app\models\UserForm;
use app\models\User;
use app\models\UploadForm;
use yii\web\UploadedFile;
use app\models\Activity;
use app\models\ActivityForm;
use app\models\Role;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use yii\db\Query;
use yii\db\Connection;
use app\models\ActivityRecord;
use app\models\PayRecord;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new UserForm(['scenario' => 'login']);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->login()) {
                    return $this->redirect(['site/index']);
                }
            }
        }

        return $this->render('login', [
            'model' => $model,
            ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionRegister()
    {
        $model = new UserForm(['scenario' => 'register']);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->register()) {
                    return $this->redirect(['site/login']);
                }
            }
        }

        return $this->render('register', [
            'model' => $model,
            ]);
    }

    public function actionModifyPassword() {
        $model = new UserForm(['scenario' => 'modifyPassword']);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->modifyPassword()) {
                    return $this->goHome();
                }
            }
        }
        return $this->render('modifyPassword', ['model' => $model]);
    }

    public function actionProfile() {
        $model = new UserForm(['scenario' => 'profile']);
        $model->profile();
        return $this->render('profile', ['model' => $model]);
    }

    public function actionModifyProfile() {
        $model = new UserForm(['scenario' => 'modifyProfile']);
        $model->getOldProfile();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->modifyProfile()) {
                    return $this->redirect(['site/profile']);
                }
            }
        }
        return $this->render('modifyProfile', ['model' => $model]);
    }

    public function actionConsumeRecord() {
        $account = Yii::$app->user->identity->account;
        if ($account == 'haiwan') {
            $name = Yii::$app->user->identity->name;
            $income = PayRecord::find()->where("owner=\"$name\"")->sum('money');
            $pay = PayRecord::find()->where("payer=\"$name\"")->sum('money');
            $leftCount = $income - $pay;
        } else {
            $user = User::find()->select('left_count')->where("account=\"$account\"")->one();
            $leftCount = $user->left_count;
        }
        return $this->render('consumeRecord', ['leftCount' => $leftCount]);
    }

    public function actionGetConsumeRecord() {
        $offset = (integer) $_REQUEST['offset'];
        $limit = (integer) $_REQUEST['limit'];

        $query = new Query;
        $account = Yii::$app->user->identity->account;
        $name = Yii::$app->user->identity->name;
        $record = null;
        $recordCnt = 0;
        if ($account != 'haiwan') {
            $recordCnt = ActivityRecord::find()->where("account=\"$account\"")->count();
            $sql = "select activity_record.time AS time,CONCAT(activity.time, ' ', activity.name) AS title,if(activity.cost>0,-1,0) as count from activity_record,activity where activity_record.account=\"$account\" and activity_record.activity_id=activity.id";
            $sql .= " union all select time,\"充值活动次数\" as title,if(money>50,10,1) as count from pay_record where payer=\"$name\" and owner=\"海湾\" order by time desc limit $limit offset $offset";
            $connection = Yii::$app->db;
            $record = $connection->createCommand($sql)->queryAll();
        } else {
            $query = new Query;
            $record = $query->select(['time', 'payer', 'owner', 'money', 'description'])->from('pay_record')->where("payer=\"$name\" or owner=\"$name\"")->limit($limit)->offset($offset)->all();
            for ($i = 0; $i < count($record); $i++) {
                if ($record[$i]['payer'] == $name) {
                    $record[$i]['money'] *= -1;
                } else {
                    $record[$i]['owner'] = $record[$i]['payer'];
                }
            }
            $recordCnt = PayRecord::find()->where("payer=\"$name\" or owner=\"$name\"")->count();
        }

        return json_encode(array('account' => $account, 'recordCnt' => $recordCnt, 'record' => $record));
    }

    public function actionActivity()
    {
        return $this->render('activity');
    }

    public function actionNewActivity()
    {
        $activity = Activity::find()->where("kind=0")->one();
        $model = array();
        if ($activity != null) {
            $model['id'] = $activity->id;
            $model['title'] = substr($activity->time, 5) . " " . $activity->name;
            $model['address'] = $activity->address;
            $model['description'] = $activity->description;
            $model['cost'] = $activity->cost;
            $users = User::findBySql("select name from user where account in (select account from activity_record where activity_id=$activity->id)")->all();
            $userArr = array();
            foreach ($users as $user) {
                $userArr[] = $user->name;
            }
            $model['users'] = implode(",", $userArr);
            return $this->render('newActivity', ['model' => $model]);
        } else {
            $hasAuth = false;
            if (!Yii::$app->user->isGuest) {
                $role = Role::findOne(Yii::$app->user->identity->account);
                if ($role != null && $role->role == 'admin') {
                    $hasAuth = true;
                }
            }
            return $this->render('noActivity', ['hasAuth' => $hasAuth]);
        }
    }

    public function actionCreateActivity()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new ActivityForm();
        $model->time = date("Y-m-d", strtotime("+0 week Saturday"));
        $model->name = '例会';
        $activity = Activity::find()->select(['address', 'cost'])->where("kind=1")->orderBy(['time' => SORT_DESC])->limit(1)->one();
        if ($activity != null) {
            $model->address = $activity->address;
            $model->cost = $activity->cost;
        }

        return $this->render('createActivity', [
            'model' => $model,
            ]);
    } 

    public function actionDances() {
        return $this->render('dance');
    }

    public function actionRookie() {
        return $this->render('rookie');
    }
}
