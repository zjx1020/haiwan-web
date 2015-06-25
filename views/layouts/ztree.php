<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>
    <div class="col-lg-3">
        <?= \diselop\ztree\Ztree::widget($this->params['ztree']); ?>
    </div>
    <div class="col-lg-9">
        <?= $content ?>
    </div>
<?php $this->endContent(); ?>
