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
use app\models\Dance;
use app\models\DanceAction;
use app\models\DancePose;
use yii\log\Logger;

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
            $income = PayRecord::find()->where("owner=\"$account\"")->sum('money');
            $pay = PayRecord::find()->where("payer=\"$account\"")->sum('money');
            $leftCount = $income - $pay;
        } else {
            $user = User::find()->select('left_count')->where("account=\"$account\"")->one();
            $leftCount = $user->left_count;
        }
        return $this->render('consumeRecord', ['leftCount' => $leftCount, 'account' => $account]);
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
            $sql .= " union all select time,\"充值活动次数\" as title,if(money=35,1,ceil(money/30)) as count from pay_record where payer=\"$account\" and owner=\"haiwan\" order by time desc limit $limit offset $offset";
            $connection = Yii::$app->db;
            $record = $connection->createCommand($sql)->queryAll();
        } else {
            $query = new Query;
            $record = $query->select(['time', 'payer', 'owner', 'money', 'description'])->from('pay_record')->where("payer=\"$account\" or owner=\"$account\"")->orderBy('time DESC')->limit($limit)->offset($offset)->all();
            for ($i = 0; $i < count($record); $i++) { 
                if ($record[$i]['payer'] == $account) {
                    $relation = $record[$i]['owner'];
                    $user = User::findOne($relation);
                    if ($user != null) {
                        $relation = $user->name;
                    }
                    $record[$i]['money'] *= -1;
                    $record[$i]['owner'] = $relation;
                } else {
                    $relation = $record[$i]['payer'];
                    $user = User::findOne($relation);
                    if ($user != null) {
                        $relation = $user->name;
                    }
                    $record[$i]['owner'] = $relation;
                }
            }
            $recordCnt = PayRecord::find()->where("payer=\"$account\" or owner=\"$account\"")->count();
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
        $hasAuth = $this->hasAuth();
        if ($activity != null) {
            $model['id'] = $activity->id;
            $model['title'] = substr($activity->time, 5) . " " . $activity->name;
            $model['address'] = $activity->address;
            $model['description'] = $activity->description;
            $model['cost'] = $activity->cost;
            $users = User::findBySql("select name from user join activity_record on user.account=activity_record.account where activity_id=$activity->id order by activity_record.time")->all();
            $userArr = array();
            foreach ($users as $user) {
                $userArr[] = $user->name;
            }
            $model['users'] = implode("，", $userArr);
            $canJoin = true;
            $hasJoined = false;
            if (Yii::$app->user->isGuest) {
                $canJoin = false;
            } elseif (ActivityRecord::find()->where("account=\"" . Yii::$app->user->identity->account . "\" and activity_id=$activity->id")->one() != null) {
                $canJoin = false;
                $hasJoined = true;
            }
            return $this->render('newActivity', ['model' => $model, 'hasAuth' => $hasAuth, 'canJoin' => $canJoin, 'hasJoined' => $hasJoined]);
        } else {
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
        $dances = Dance::find()->select(['name', 'kind'])->orderBy("convert(name using gbk)")->all();
        $danceNames = array();
        foreach ($dances as $dance) {
            $danceNames[] = $dance->name . ($dance->kind == 2 ? "*" : "");
        }
        return $this->render('dance', ['dances' => $danceNames]);
    }

    public function actionRookie() {
        return $this->render('rookie');
    }

    public function actionBasicAction() {
        return $this->render('basicAction', ['hasAuth' => $this->hasAuth()]);
    }

    public function actionBasicPose() {
        return $this->render('basicPose', ['hasAuth' => $this->hasAuth()]);
    }

    public function actionBasicTerm() {
        return $this->render('basicTerm');
    }

    public function actionIntroduction() {
        return $this->render('introduction');
    }

    public function actionBasicInformation() {
        return $this->render('basicInformation');
    }

    public function actionAddConsumeRecord() {
        $isVip = $_REQUEST['isVip'];
        $payRecord = new PayRecord;
        if ($isVip == 1) {
            $user = User::find()->select('account')->where("name=\"" . $_REQUEST['payer'] . "\"")->one();
            $payRecord->payer = $user['account'];
        } else {
            $payRecord->payer = $_REQUEST['payer'];
        }
        $payRecord->money = (integer) $_REQUEST['money'];
        $payRecord->description = $_REQUEST['description'];
        $payRecord->time = date("Y-m-d H:i:s", time());
        $payRecord->owner = Yii::$app->user->identity->account;
        if ($isVip != 1) {
            $user = User::findOne($payRecord->payer);
            if ($user != null) {
                return json_encode(array('succ' => false, 'nameExist' => true));
            }
        }
        $succ = true;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($payRecord->insert() === false) {
                $transaction->rollBack();
                Yii::error("insert db failed");
                return json_encode(array('succ' => false));
            } else {
                if ($isVip == 1) {
                    $user = User::findOne($payRecord->payer);
                    $user->left_count = $payRecord->money == 35 ? $user->left_count + 1 : $user->left_count + 10;
                    if ($user->update() === false) {
                        $transaction->rollBack();
                        Yii::error("update db failed");
                        return json_encode(array('succ' => false));
                    }
                }
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::error("insert db failed: " . $e->getMessage());
            return json_encode(array('succ' => false));
        }
        $transaction->commit();
        return json_encode(array('succ' => $succ));
    }

    public function actionAddPayConsumeRecord() {
        $payRecord = new PayRecord;
        $payRecord->owner = $_REQUEST['owner'];
        $payRecord->money = (integer) $_REQUEST['money'];
        $payRecord->description = $_REQUEST['description'];
        $payRecord->time = date("Y-m-d H:i:s", time());
        $payRecord->payer = Yii::$app->user->identity->account;

        $user = User::findOne($payRecord->owner);
        if ($user != null) {
            return json_encode(array('succ' => false, 'nameExist' => true));
        }

        $succ = true;
        try {
            if ($payRecord->insert() === false) {
                Yii::error("insert db failed");
                $succ = false;
            }
        } catch (Exception $e) {
            Yii::error("insert db failed: " . $e->getMessage());
            $succ = false;
        }
        return json_encode(array('succ' => $succ));
    }

    public function actionGetUserInfo() {
        $users = User::find()->select('name')->orderBy("convert(name using gbk)")->all();
        $allUsers = array();
        foreach ($users as $user) {
            $allUsers[] = $user->name;
        }
        return json_encode($allUsers);
    }

    public function hasAuth() {
        $hasAuth = false;
        if (!Yii::$app->user->isGuest) {
            $role = Role::findOne(Yii::$app->user->identity->account);
            if ($role != null && $role->role == 'admin') {
                $hasAuth = true;
            }
        }

        return $hasAuth;
    }
}
