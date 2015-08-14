<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserForm */
/* @var $form ActiveForm */

$this->title = Yii::$app->params['webTitle'] . "-修改个人资料";
$this->params['breadcrumbs'][] = ['label' => '个人资料', 'url' => ['site/profile']];
$this->params['breadcrumbs'][] = '修改个人资料';
?>
<div class="modifyProfile">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-7\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => 10]) ?>
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
        ]) ?>
        <?= $form->field($model, 'join_date')->widget(\yii\jui\DatePicker::className(), [
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
        ]) ?>
    
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <?= Html::submitButton('保存', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- modifyProfile -->
