<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */

$this->title = '上海海湾土风舞社-活动';
$subtitle = '最新活动';
$this->params['breadcrumbs'][] = $subtitle;
$this->registerJsFile(Url::base() . '/js/activity.js', ['depends' => ['yii\web\JqueryAsset']]);
?>
<div class="newActivity">
    <p style="display:none" class="activityId"><?php echo $model['id']?></p>
    <h1 style="text-align:center"><?php echo $model['title'] ?></h1>
    <table class="col-lg-12">
        <tr>
            <td class="col-lg-3"></td>
            <th class="col-lg-2">活动地址：</th>
            <td><?php echo $model['address'] ?></td>
        </tr>
        <tr>
            <td class="col-lg-3"></td>
            <th class="col-lg-2">活动简介：</th>
            <td><?php echo $model['description'] ?></td>
        </tr>
        <tr>
            <td class="col-lg-3"></td>
            <th class="col-lg-2">活动开销：</th>
            <td><?php echo $model['cost'] ?></td>
        </tr>
        <tr>
            <td class="col-lg-3"></td>
            <th class="col-lg-2">活动人员：</th>
            <td><?php echo $model['users'] ?></td>
        </tr>
    </table>

    <div style="text-align:center">
        <button class="btn btn-primary join">报名</button>
        <button class="btn btn-primary finish">活动结束</button>
        <button class="btn btn-primary cancel">取消活动</button>
    </div>
</div>
