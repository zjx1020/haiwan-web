<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = Yii::$app->params['webTitle'] . '-基本舞姿';
$subtitle = '基本舞姿';
$this->params['breadcrumbs'][] = $subtitle;
$this->registerJsFile(Url::base() . '/js/table.js', ['depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Url::base() . '/js/basic_pose.js', ['depends' => ['yii\web\JqueryAsset']]);
?>
<div class="basicPose">
    <table id="basicPoseTable" class="col-lg-12">
        <tr>
            <th class="col-lg-2">基本舞姿</th>
            <th class="col-lg-10">描述</th>
        </tr>
    </table>
    <div style="text-align:center" id="basicPoseBtns">
        <?php if ($hasAuth) { ?>
        <button class="btn btn-primary addPose">新增</button>
        <button id="modify" class="btn btn-primary">修改</button>
        <button id="cancel" class="btn btn-primary" disabled=true>取消</button>
        <button id="save" class="btn btn-primary" disabled=true>保存</button>
        <?php } ?>
    </div>
    <?php
    \yii\bootstrap\Modal::begin([
        'header' => '<h2>新增舞姿</h2>',
        'options' => ["class" => "addPoseModal"],
        'footer' => '<button class="confirm btn btn-primary">确认</button><button type="button" class="btn btn-default" data-dismiss="modal">取消</button>',
    ]);
    echo '
    <form class="form-horizontal" method="post">
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>">
    <div class="form-group">
        <label class="col-lg-2 control-label" for="name">舞姿名</label>
        <div class="col-lg-8">
            <input type="text" placeholder="请输入名字" id="name" class="form-control" maxlength="32"> 
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label" for="description">描述</label>
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
    
    ?>
</div>
