<?php
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\UploadForm;

/* @var $this yii\web\View */

$this->title = '上海海湾土风舞社-舞码大全';
$subtitle = '舞码大全';
$this->params['breadcrumbs'][] = $subtitle;
$this->registerJsFile(Url::base() . '/js/dance_ztree.js', ['depends'=>['diselop\ztree\ZTreeAsset']]);
?>
<div class="dance">
    <div class="col-lg-3">
        <ul id="danceTree" class="ztree" style="overflow:auto;height:500px"></ul>
        <div class="btn-group btn-group-xs">
        <button type="button" class="btn btn-primary addDance">新增一条舞码</button>
        <!--button type="button" class="btn btn-primary addDances">新增多条舞码</button-->
        </div>
    </div>
    <div class="col-lg-9" id="danceDetail">
        <h1 class="danceTitle" style="text-align:center">舞码大全</h1>
        <p class="danceDescription" style="display:none"></p>
        <table class="danceTable" style="display:none">
            <tr>
                <td class="col-lg-1"></td>
                <th class="col-lg-2">难度等级：</th>
                <td class="col-lg-3 dance_level"></td>
                <th class="col-lg-2">联欢次数：</th>
                <td class="col-lg-4 dance_count"></td>
            </tr>
            <tr>
                <td class="col-lg-1"></td>
                <th class="col-lg-2">舞蹈简介：</th>
                <td class="description" colspan=3></td>
            </tr>
            <!--tr>
                <td class="col-lg-1"></td>
                <th class="col-lg-2">领舞者：</th>
                <td class="leaders" colspan=3></td>
            </tr>
            <tr class="leadDanceTr" style="display:none">
                <td class="col-lg-1"></td>
                <td class="col-lg-2"></td>
                <td class="btn btn-primary leadDanceBtn">我能领舞</td>
            <tr-->
            <tr>
                <td class="col-lg-1"></td>
                <th class="col-lg-2">教学记录：</th>
                <td class="teachRecordsContent" colspan=3></td>
            </tr>
        </table>
        <table id="teachRecords" style="display:none" class="table table-bordered col-lg-offset-1 col-lg-11">
            <tr>
                <th class="col-lg-2">教学时间</th>
                <th class="col-lg-10">教舞者</th>
            <tr>
        </table>
    </div>
    <?php
    \yii\bootstrap\Modal::begin([
        //'header' => '<h2></h2>',
        'id' => "leadDanceConfirmModal",
        'footer' => '<button class="confirm btn btn-primary">OK</button>',
    ]);
    echo '<p class="leadDanceConfirmModalContent"></p>';
    \yii\bootstrap\Modal::end();

    \yii\bootstrap\Modal::begin([
        'header' => '<h2>新增舞码</h2>',
        'options' => ["class" => "addDanceModal"],
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

    \yii\bootstrap\Modal::begin([
        'header' => '<h2>新增舞码</h2>',
        'options' => ["class" => "addDancesModal"],
        'footer' => '<button class="confirm btn btn-primary">确认</button><button type="button" class="btn btn-default" data-dismiss="modal">取消</button>',
    ]);
    //$model = new UploadForm();
    //$form = $this->render("test", ['model'=>$model]);
    echo '
    <div style="color:red">
    <h2 style="text-align:center">注意</h2>
    <p>1、只接受excel。</p>
    <p>2、提交的excel头部必须是A-E共5列，且每列名字顺序固定为舞名、国家、类型、难度、简介。</p>
    <p>3、不能有空行。<p>
    <p>4、请全部使用简体字。</p>
    <p>5、除简介栏可留空外其余栏不可为空。</p>
    <p>6、类型分1 => 单人、2 => 双人，填数字或对应文字。</p>
    <p>7、难度分1 => 简单、2 => 入门、3 => 熟练、4 => 进阶、5 => 高阶，填数字或对应文字。</p>
    <p>示例图：</p>
    <div  class="thumbnail">
        <img src="images/addDances.png">
    </div>
    </div>
    <form id="addDancesForm" methos="post" enctype="multipart/form-data">
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>">
        <input id="newDanceFile" type="file" accept=".xls,.xlsx" />
        <input type="submit" class="addNewDanceBtn" style="display:none">
    </form>
    ';
    \yii\bootstrap\Modal::end();

    \yii\bootstrap\Modal::begin([
        'header' => '<h2>结果</h2>',
        'options' => ["class" => "addDancesResultModal"],
        'footer' => '<button class="btn btn-primary" data-dismiss="modal">确认</button>',
    ]);
    echo '<p class="content"></p>';
    \yii\bootstrap\Modal::end();
    ?>

</div>
