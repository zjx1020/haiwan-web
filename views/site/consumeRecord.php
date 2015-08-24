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
    <p style="color:red">对于提前交钱充次数的已注册用户，请选择”网站注册用户“，这样添加完后就会自动加上可使用次数，对于活动当天临时交场地费的不管是不是注册用户都请选择非网站用户，即使是注册用户，交了场地费不是为了充值次数从而通过网站报名的也请选择非网站用户，对于跟活动场地费无关的其它费用也请选择非网站用户，”不能与网站会员重名“是指账号而非网站上显示的名字，所以请随便填写，重复的话会有提示！</p>
    <form class="form-horizontal" method="post">
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>">
    <div class="form-group">
        <label class="col-lg-2 control-label" for="payer-kind"></label>
        <div class="col-lg-8" id="payer-kind">
            <label class="radio-inline">
              <input type="radio" name="payer-kind" checked="checked" value="1" onclick="changePayerKind(this)"> 网站注册用户
            </label>
            <label class="radio-inline">
                <input type="radio" name="payer-kind" value="0" onclick="changePayerKind(this)"> 非网站注册用户
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
            <select id="money" class="form-control">
                <option value="1">35</option>
                <option value="10">300</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label" placeholder="请输入本次交易描述" for="description">描述</label>
        <div class="col-lg-8">
            <input type="text" id="description" class="form-control">
        </div>
    </div>
    <div style="text-align:center;color:red">
        <p class="error"></p>
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
        <label class="col-lg-2 control-label" for="owner">收款方</label>
        <div class="col-lg-8">
            <input type="text" placeholder="请输入收款方，不能与网站会员重名" id="owner" class="form-control" maxlength="32"> 
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label" for="pay-money">金额</label>
        <div class="col-lg-8">
            <input type="text" placeholder="请输入大于0的金额" id="pay-money" class="form-control" maxlength="8"> 
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label" for="pay-description">描述</label>
        <div class="col-lg-8">
            <input type="text" placeholder="请输入本次交易描述" id="pay-description" class="form-control">
        </div>
    </div>
    <div style="text-align:center;color:red">
        <p class="pay-error"></p>
    </div>
    </form>
    ';
    \yii\bootstrap\Modal::end();
    ?>
</div>
