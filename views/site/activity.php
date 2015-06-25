<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = '上海海湾土风舞社-活动';
$subtitle = '活动';
$this->params['breadcrumbs'][] = $subtitle;
$this->registerJsFile(Url::base() . '/js/activity_ztree.js', ['depends'=>['diselop\ztree\ZTreeAsset']]);
?>
<div class="activity">
    <div class="col-lg-3">
    <!--?= \diselop\ztree\Ztree::widget($ztree); ?-->
    <ul id="activityTree" class="ztree"></ul>
    </div>
    <div class="col-lg-9">
        <h1 class="activityTitle">海湾活动大全</h1>
        <p class="activityDescription" style="display:none"></p>
        <table class="activityTable" style="display:none">
            <tr>
                <th class="col-lg-2">活动时间：</th>
                <td class="time"></td>
            </tr>
            <tr>
                <th class="col-lg-2">活动主题：</th>
                <td class="name"></td>
            </tr>
            <tr>
                <th class="col-lg-2">活动地址：</th>
                <td class="address"></td>
            </tr>
            <tr>
                <th class="col-lg-2">活动简介：</th>
                <td class="description"></td>
            </tr>
            <tr>
                <th class="col-lg-2">活动人员：</th>
                <td class="users"></td>
            </tr>
            <tr>
                <th class="col-lg-2">聚餐人员：</th>
                <td class="dinnerUsers"></td>
            </tr>
            <tr>
                <th class="col-lg-2">活动舞码：</th>
                <td class="dances"></td>
            </tr>
        </table>
        <table id="teachDanceTable" style="display:none;color:red" class="col-lg-12">
            <caption style="text-align:center;color:red">教学舞码</caption>
        </table>
        <table id="reviewDanceTable" style="display:none;color:green" class="col-lg-12">
            <caption style="text-align:center;color:green">复习舞码</caption>
        </table>
        <table id="activityDanceTable" style="display:none;color:blue" class="col-lg-12">
            <caption style="text-align:center;color:blue">联欢舞码</caption>
        </table>
    </div>

</div>
