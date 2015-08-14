<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserForm */

$this->title = Yii::$app->params['webTitle'] . "-个人资料";
$this->params['breadcrumbs'][] = '个人资料';
?>
<div class="profile">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'sex',
            'phone',
            'email:email',
            'birth',
            'join_date',
            //'leader_dance_list:ntext',
            'left_count',
        ],
        'template' => "<tr><th class=\"col-lg-3\">{label}</th><td class=\"col-lg-9\">{value}</td></tr>",
    ]) ?>

    <div style="text-align:center">
        <?= Html::a('修改', ['/site/modify-profile'], ['class' => 'btn btn-primary']) ?>
    </div>

</div><!-- profile -->
