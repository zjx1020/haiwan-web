<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */

$this->title = Yii::$app->params['webTitle'] . '-活动';
$subtitle = '最新活动';
$this->params['breadcrumbs'][] = $subtitle;
$this->registerJsFile(Url::base() . '/js/activity.js', ['depends' => ['yii\web\JqueryAsset']]);
?>
<div class="newActivity" id="newActivity">
    <p style="display:none" class="activityId"><?php echo $model['id']?></p>
    <h1 style="text-align:center"><?php echo $model['title'] ?></h1>
    <table class="col-lg-12">
        <tr>
            <td class="col-lg-2"></td>
            <th class="col-lg-2">活动地址：</th>
            <td><?php echo $model['address'] ?></td>
        </tr>
        <tr>
            <td class="col-lg-2"></td>
            <th class="col-lg-2">活动简介：</th>
            <td><?php echo $model['description'] ?></td>
        </tr>
        <tr>
            <td class="col-lg-2"></td>
            <th class="col-lg-2">活动开销：</th>
            <td><?php echo $model['cost'] ?></td>
        </tr>
        <tr>
            <td class="col-lg-2"></td>
            <th class="col-lg-2">活动人员：</th>
            <td><?php echo $model['users'] ?></td>
        </tr>
    </table>

    <div style="text-align:center" id="activityBtns">
        <?php if ($canJoin) { ?>
        <button class="btn btn-primary join">报名</button>
        <?php } elseif ($hasJoined) { ?>
        <button class="btn btn-primary cancelJoin">取消报名</button>
        <?php }
        if ($hasAuth) {
        ?>
        <button class="btn btn-primary finish">报名结束开始排舞</button>
        <button class="btn btn-primary cancel">取消活动</button>
        <?php } ?>
    </div>
    <?php
    \yii\bootstrap\Modal::begin([
        'header' => '<h2>取消活动</h2>',
        'options' => ["class" => "confirmModal"],
        'footer' => '<button class="confirm btn btn-primary">确认</button><button type="button" class="btn btn-default" data-dismiss="modal">取消</button>',
    ]);
    echo '<p class="content">确定要取消活动？</p>';
    \yii\bootstrap\Modal::end();
    ?>
</div>
