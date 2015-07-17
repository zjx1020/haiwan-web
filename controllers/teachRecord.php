<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="teachRecord">
    <h2><?= Html::encode($model->title) ?></h2>
    <?= HtmlPurifier::process($model->text) ?>    
</div>
