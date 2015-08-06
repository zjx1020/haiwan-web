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
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use yii\db\Query;
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
        return $this->render('consumeRecord');
    }

    public function actionGetConsumeRecord() {
        $offset = (integer) $_REQUEST['offset'];
        $limit = (integer) $_REQUEST['limit'];

        $query = new Query;
        $account = Yii::$app->user->identity->account;
        $activityRecord = null;
        $activityRecordCnt = 0;
        if ($account != 'haiwan') {
            $activityRecordCnt = ActivityRecord::find()->where("account=\"$account\"")->count();
            $activityRecord = $query->select(['activity_record.time AS time', 'CONCAT(activity.time, " ", activity.name) AS title'])->from(['activity_record', 'activity'])->where("activity_record.account=\"$account\" and activity_record.activity_id=activity.id")->orderBy('activity_record.time DESC')->limit($limit)->offset($offset)->all();
        }
        $query = new Query;
        $consumeRecord = $query->select(['time', 'owner', 'money', 'description'])->from('pay_record')->where("account=\"$account\"")->limit($limit)->offset($offset)->all();
        $consumeRecordCnt = PayRecord::find()->where("account=\"$account\"")->count();

        return json_encode(array('account' => $account, 'consumeRecordCnt' => $consumeRecordCnt, 'consumeRecord' => $consumeRecord, 'activityRecordCnt' => $activityRecordCnt, 'activityRecord' => $activityRecord));
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
            return $this->render('noActivity');
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

        /*
        if ($model->load(Yii::$app->request->post())) {
            if ($model->createActivity()) {
                return $this->redirect(['site/new-activity']);
            }
        }
        */

        return $this->render('createActivity', [
            'model' => $model,
            ]);
    } 

    public function actionDances() {
        return $this->render('dance');
    }

/*
    public function actionTest() {
    $model = new UploadForm();

    $val = "value";
    if (Yii::$app->request->isPost) {
        $model->file = UploadedFile::getInstance($model, 'file');

        if ($model->file && $model->validate()) {                
            $model->file->saveAs('uploads/' . $model->file->baseName . '.' . $model->file->extension);
        } else {
            if ($model->file == null) {
                $val = "file is null";
            } else {
                $val = "validate not pass";
            }
        }
    }

    return $this->render('test', ['model' => $model, 'val' => $val]);
    }
    */
}
