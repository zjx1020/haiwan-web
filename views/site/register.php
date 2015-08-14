<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RegisterForm */
/* @var $form ActiveForm */

$this->title = Yii::$app->params['webTitle'] . '-注册';
$subtitle = '注册';
$this->params['breadcrumbs'][] = $subtitle;
?>
<div class="register">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'account')->textInput(['maxlength' => 10]) ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 10]) ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => 20]) ?>
        <?= $form->field($model, 'passwordVerify')->passwordInput(['maxlength' => 20]) ?>
        <?= $form->field($model, 'sex')->radioList([0 => '男', 1 => '女']) ?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'birth')->widget(\yii\jui\DatePicker::className(), [
            'options' => [
                'class' => 'form-control',
            ],
            'clientOptions' => [
                'changeYear' => true,
                'changeMonth' => true,
                'maxDate' => '+0',
            ],
            'language' => 'zh-CN',
            'dateFormat' => 'yyyy-MM-dd',
        ])?>
    
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('注册', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- register -->
