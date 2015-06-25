<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserForm */
/* @var $form ActiveForm */

$this->title = '上海海湾土风舞社-修改密码';
$this->params['breadcrumbs'][] = '修改密码';
?>
<div class="modifyPassword">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => 20]) ?>
        <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => 20]) ?>
        <?= $form->field($model, 'passwordVerify')->passwordInput(['maxlength' => 20]) ?>
    
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('确认', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- modifyPassword -->
