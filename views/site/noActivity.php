<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::$app->params['webTitle'] . '-活动';
$subtitle = '最新活动';
$this->params['breadcrumbs'][] = $subtitle;
?>
<div class="noActivity">
    <h1 style="text-align:center">暂无最新活动</h1>
    <?php if ($hasAuth) {?>
    <div style="text-align:center">
        <?= Html::a('创建活动', ['/site/create-activity'], ['class' => "btn btn-primary"]) ?>
    </div>
    <?php }?>
</div>
