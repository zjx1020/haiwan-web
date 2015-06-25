<?php
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->params['ztree'] = $ztree;
?>
<div class="display-activity">
    <?php Pjax::begin(); ?>
    <?= $this->render('test', ['selectName' => $selectName]); ?>
    <?php Pjax::end(); ?>
</div>
