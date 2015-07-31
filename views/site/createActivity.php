<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = '上海海湾土风舞社-活动';
$subtitle = '创建活动';
$this->params['breadcrumbs'][] = $subtitle;
?>
<div class="createActivity">
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <?= $form->field($model, 'time')->widget(\yii\jui\DatePicker::className(), [
        'options' => [
        'class' => 'form-control',
        ],
        'clientOptions' => [
        'changeYear' => true,
        'changeMonth' => true,
        'minDate' => '+1',
        ],
        'language' => 'zh-CN',
        'dateFormat' => 'yyyy-MM-dd',
        ])?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => 32]) ?>
    <?= $form->field($model, 'address')->textInput(['maxlength' => 256]) ?>
    <?= $form->field($model, 'cost') ?>
    <?= $form->field($model, 'description') ?> 

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('创建', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
