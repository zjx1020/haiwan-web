<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = Yii::$app->params['webTitle'] . '-登录';
$subtitle = '登录';
$this->params['breadcrumbs'][] = $subtitle;
$this->registerJsFile(Url::base() . '/js/login.js', ['depends' => ['yii\web\JqueryAsset']]);
?>
<div class="site-login">
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3 col-xs-6\">{input}</div>\n<div class=\"col-lg-8 col-xs-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 col-xs-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'account')->textInput(['maxlength' => 20, 'placeholder' => '账号']) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 20, 'placeholder' => '请输入密码']) ?>

    <!--?= $form->field($model, 'rememberMe', [
        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ])->checkbox() ?-->

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11 col-xs-offset-2 col-xs-10">
            <?= Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
        <div class="col-lg-offset-1 col-xs-offset-2">
            <div class="col-lg-2 col-xs-5">
                <?= Html::a('忘记账号密码？', null, ['class' => 'forgetPassword']) ?>
            </div>
            <div class="col-lg-1 col-xs-5">
                <?= Html::a('注册', ['/site/register']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    \yii\bootstrap\Modal::begin([
        'header' => '<h2>忘记账号密码</h2>',
        'options' => ["class" => "forgetPasswordModal"],
        'footer' => '<button class="confirm btn btn-primary">确认</button><button type="button" class="btn btn-default" data-dismiss="modal">取消</button>',
    ]);
    echo '
    <form class="form-horizontal" method="post">
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>">
    <div class="form-group">
        <label class="col-lg-3 control-label" for="email">注册账号邮箱</label>
        <div class="col-lg-8">
            <input type="text" placeholder="请输入邮箱" id="email" class="form-control" maxlength="64"> 
        </div>
    </div>
    <div style="text-align:center;color:red">
        <p class="error"></p>
    </div>
    </form>
    ';
    \yii\bootstrap\Modal::end();
    ?>

</div>
