<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */

$this->title = Yii::$app->params['webTitle'] . "-消费记录";
$this->params['breadcrumbs'][] = '消费记录';
$this->registerJsFile(Url::base() . '/js/consume_record.js', ['depends' => ['yii\web\JqueryAsset']]);
?>
<div id="consumeRecord">

    <?php if ($account == 'haiwan') {?>
    <table class="table table-bordered col-lg-12" id="consumeRecordTable">
        <caption style="text-align:center">消费记录（当前结余：<?= $leftCount ?>￥）</caption>
        <tr>
            <th class="col-lg-3">时间</th>
            <th class="col-lg-3">对方</th>
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
    <div style="text-align:center">
        <button class="btn btn-primary addConsumeRecord">新增收款记录</button>
        <button class="btn btn-primary addPayConsumeRecord">新增付款记录</button>
    </div>
    <?php } else {?>

    <table class="table table-bordered col-lg-12" id="activityRecordTable">
        <caption style="text-align:center">活动记录（当前结余：<?= $leftCount ?>次）</caption>
        <tr>
            <th class="col-lg-3">时间</th>
            <th class="col-lg-6">事项</th>
            <th class="col-lg-3">次数</th>
        </tr>
        <tr><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td></tr>
        <tr><td></td><td></td><td></td></tr>
    </table>
    <?php } ?>

    <?php
    \yii\bootstrap\Modal::begin([
        'header' => '<h2>新增收款记录</h2>',
        'options' => ["class" => "consumeRecordModal"],
        'footer' => '<button class="confirm btn btn-primary">确认</button><button type="button" class="btn btn-default" data-dismiss="modal">取消</button>',
    ]);
    echo '
    <form class="form-horizontal" method="post">
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>">
    <div class="form-group">
        <label class="col-lg-2 control-label" for="payer-kind"></label>
        <div class="col-lg-8" id="payer-kind">
            <label class="radio-inline">
              <input type="radio" name="payer-kind" checked="checked" value="1"> 网站注册用户
            </label>
            <label class="radio-inline">
                <input type="radio" name="payer-kind" value="2"> 非网站注册用户
            </label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label" for="payer">付款人</label>
        <div class="col-lg-8">
            <select id="payer" class="form-control"></select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label" for="money">金额</label>
        <div class="col-lg-8">
            <input type="text" placeholder="请输入大于0的金额" id="money" class="form-control" maxlength="8"> 
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label" placeholder="请输入本次交易描述" for="description">描述</label>
        <div class="col-lg-8">
            <input type="text" id="description" class="form-control">
        </div>
    </div>
    </form>
    ';
    \yii\bootstrap\Modal::end();

    \yii\bootstrap\Modal::begin([
        'header' => '<h2>新增付款记录</h2>',
        'options' => ["class" => "payConsumeRecordModal"],
        'footer' => '<button class="confirm btn btn-primary">确认</button><button type="button" class="btn btn-default" data-dismiss="modal">取消</button>',
    ]);
    echo '
    <form class="form-horizontal" method="post">
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>">
    <div class="form-group">
        <label class="col-lg-2 control-label" for="dance-name">舞名</label>
        <div class="col-lg-8">
            <input type="text" placeholder="请输入舞名" id="dance-name" class="form-control" maxlength="32"> 
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label" for="dance-country">国家</label>
        <div class="col-lg-8">
            <select id="dance-country" class="form-control"></select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label" for="dance-kind">类型</label>
        <div class="col-lg-8" id="dance-kind">
            <label class="radio-inline">
              <input type="radio" name="dance-kind" checked="checked" value="1"> 单人
            </label>
            <label class="radio-inline">
                <input type="radio" name="dance-kind" value="2"> 双人
            </label>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label" for="dance-level">难度</label>
        <div class="col-lg-8" id="dance-level">
            <label class="radio-inline">
              <input type="radio" name="dance-level" checked="checked" value="1"> 简单
            </label>
            <label class="radio-inline">
                <input type="radio" name="dance-level" value="2"> 入门
            </label>
            <label class="radio-inline">
              <input type="radio" name="dance-level" value="3"> 熟练
            </label>
            <label class="radio-inline">
                <input type="radio" name="dance-level" value="4"> 进阶
            </label>
            <label class="radio-inline">
                <input type="radio" name="dance-level" value="5"> 高阶
            </label>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label" for="dance-description">简介</label>
        <div class="col-lg-8">
            <input type="text" id="dance-description" class="form-control">
        </div>
    </div>
    <div style="text-align:center;color:red">
        <p class="error"></p>
    </div>
    </form>
    ';
    \yii\bootstrap\Modal::end();
    ?>
</div>
