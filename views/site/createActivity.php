<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = '上海海湾土风舞社-活动';
$subtitle = '创建活动';
$this->params['breadcrumbs'][] = $subtitle;
$baseUrl = yii\helpers\Url::base() . "/index.php?r="
?>
<div class="createActivity">
    <form class="form-horizontal" action="<?=$baseUrl?>activity/create-activity" method="post">
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>">
    <div class="form-group">
        <label class="col-lg-1 control-label" for="activityform-time">活动时间</label>
        <div class="col-lg-3">
            <input type="text" id="activityform-time" class="form-control hasDatepicker" name="[time]" value=<?= $model->time?>>
        </div>
        <label class="col-lg-1 control-label" for="activityform-name">活动主题</label>
        <div class="col-lg-3">
            <input type="text" id="activityform-name" class="form-control" name="[name]" maxlength="32" value=<?= $model->name?>>
        </div>
        <label class="col-lg-1 control-label" for="activityform-cost">活动花费</label>
        <div class="col-lg-3">
            <input type="text" id="activityform-cost" class="form-control" name="[cost]" value=<?= $model->cost?>>
        </div>
    </div>

    <div class="form-group field-activityform-address required">
        <label class="col-lg-1 control-label" for="activityform-address">活动地址</label>
        <div class="col-lg-11">
            <input type="text" id="activityform-address" class="form-control" name="[address]" maxlength="256" value=<?= $model->address?>>
        </div>
    </div>

    <div class="form-group field-activityform-description">
        <label class="col-lg-1 control-label" for="activityform-description">活动简介</label>
        <div class="col-lg-11">
            <input type="text" id="activityform-description" class="form-control" name="[description]" value=<?= $model->description?>>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary col-lg-offset-6">创建</button>
    </div>
    </form>
</div>
