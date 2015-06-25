<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = '上海海湾土风舞社-舞码大全';
$subtitle = '舞码大全';
$this->params['breadcrumbs'][] = $subtitle;
$this->registerJsFile(Url::base() . '/js/dance_ztree.js', ['depends'=>['diselop\ztree\ZTreeAsset']]);
?>
<div class="dance">
    <div class="col-lg-3">
    <ul id="danceTree" class="ztree"></ul>
    </div>
    <div class="col-lg-9">
        <h1 class="danceTitle">舞码大全</h1>
        <p class="danceDescription" style="display:none"></p>
        <table class="danceTable table table-striped table-bordered detail-view" style="display:none">
            <tr>
                <th class="col-lg-3">活动时间</th>
                <td class="time col-lg-6"></td>
            </tr>
            <tr>
                <th class="col-lg-3">活动主题</th>
                <td class="name col-lg-6"></td>
            </tr>
            <tr>
                <th class="col-lg-3">活动地址</th>
                <td class="address col-lg-6"></td>
            </tr>
            <tr>
                <th class="col-lg-3">活动简介</th>
                <td class="description col-lg-6"></td>
            </tr>
            <tr>
                <th class="col-lg-3">活动人员</th>
                <td class="user col-lg-6"></td>
            </tr>
            <tr>
                <th class="col-lg-3">活动舞码</th>
                <td class="dance col-lg-6"></td>
            </tr>
        </table>
    </div>

</div>
