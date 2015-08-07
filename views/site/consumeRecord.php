<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */

$this->title = "上海海湾土风舞社-消费记录";
$this->params['breadcrumbs'][] = '消费记录';
$this->registerJsFile(Url::base() . '/js/consume_record.js', ['depends' => ['yii\web\JqueryAsset']]);
?>
<div id="consumeRecord">

    <table class="table table-bordered col-lg-12" id="consumeRecordTable">
        <caption style="text-align:center">消费记录</caption>
        <tr>
            <th class="col-lg-3">时间</th>
            <th class="col-lg-3">收款人</th>
            <th class="col-lg-3">金额</th>
            <th class="col-lg-3">描述</th>
        </tr>
        <tr><td></td><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td><td></td></tr>
    </table>

    <table class="table table-bordered col-lg-12" id="activityRecordTable">
        <caption style="text-align:center">活动记录</caption>
        <tr>
            <th class="col-lg-6">时间</th>
            <th class="col-lg-6">活动</th>
        </tr>
        <tr><td></td><td></td></tr>
        <tr><td></td><td></td></tr>
        <tr><td></td><td></td></tr>
        <tr><td></td><td></td></tr>
        <tr><td></td><td></td></tr>
        <tr><td></td><td></td></tr>
        <tr><td></td><td></td></tr>
        <tr><td></td><td></td></tr>
        <tr><td></td><td></td></tr>
        <tr><td></td><td></td></tr>
    </table>
</div>
