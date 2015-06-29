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
        <h1 class="danceTitle" style="text-align:center">舞码大全</h1>
        <p class="danceDescription" style="display:none"></p>
        <table class="danceTable" style="display:none">
            <tr>
                <td class="col-lg-1"></td>
                <th class="col-lg-2">难度等级：</th>
                <td class="dance_level"></td>
            </tr>
            <tr>
                <td class="col-lg-1"></td>
                <th class="col-lg-2">舞蹈简介：</th>
                <td class="description"></td>
            </tr>
            <tr>
                <td class="col-lg-1"></td>
                <th class="col-lg-2">联欢次数：</th>
                <td class="dance_count"></td>
            </tr>
            <tr>
                <td class="col-lg-1"></td>
                <th class="col-lg-2">领舞者：</th>
                <td class="leaders"></td>
            </tr>
            <tr class="leadDanceTr" style="display:none">
                <td class="col-lg-1"></td>
                <td class="col-lg-2"></td>
                <td class="btn btn-primary leadDanceBtn">我能领舞</td>
            <tr>
            <tr>
                <td class="col-lg-1"></td>
                <th class="col-lg-2">教学记录：</th>
                <td class="teachRecords"></td>
            </tr>
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
    ?>

</div>
