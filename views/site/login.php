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
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'account')->textInput(['maxlength' => 20, 'placeholder' => '账号']) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 20, 'placeholder' => '请输入密码']) ?>

    <!--?= $form->field($model, 'rememberMe', [
        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ])->checkbox() ?-->

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
        <div class="col-lg-offset-1">
            <div class="col-lg-2">
                <?= Html::a('忘记密码？', null, ['class' => 'forgetPassword']) ?>
            </div>
            <div class="col-lg-1">
                <?= Html::a('注册', ['/site/register']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
