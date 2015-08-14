<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = Yii::$app->params['webTitle'] . '-活动';
$subtitle = '创建活动';
$this->params['breadcrumbs'][] = $subtitle;
$baseUrl = Url::base() . "/index.php?r=";
$this->registerJsFile(Url::base() . '/js/create_activity.js', ['depends' => ['yii\web\JqueryAsset']]);
?>
<div class="createActivity" id="createActivity">
    <form class="form-horizontal" method="post">
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>">
    <div class="form-group">
        <label class="col-lg-1 control-label" for="activityform-time">活动时间</label>
        <div class="col-lg-3">
            <?php echo \yii\jui\DatePicker::widget([
                'options' => [
                    'class' => 'form-control',
                ],
                'id' => 'activityform-time',
                'clientOptions' => [
                    'changeYear' => true,
                    'changeMonth' => true,
                    'minDate' => '+1',
                ],
                'value' => $model->time,
                'language' => 'zh-CN',
                'dateFormat' => 'yyyy-MM-dd',
            ])?>
        </div>
        <label class="col-lg-1 control-label" for="activityform-name">活动主题</label>
        <div class="col-lg-3">
            <input type="text" placeholder="请输入活动主题" id="activityform-name" class="form-control" name="[name]" maxlength="32" value=<?= $model->name?>>
        </div>
        <label class="col-lg-1 control-label" for="activityform-cost">活动花费</label>
        <div class="col-lg-3">
            <input type="text" placeholder="请输入活动花费" id="activityform-cost" class="form-control" name="[cost]" value=<?= $model->cost?>>
        </div>
    </div>

    <div class="form-group field-activityform-address required">
        <label class="col-lg-1 control-label" for="activityform-address">活动地址</label>
        <div class="col-lg-11">
            <input type="text" placeholder="请输入活动地址" id="activityform-address" class="form-control" name="[address]" maxlength="256" value=<?= $model->address?>>
        </div>
    </div>

    <div class="form-group field-activityform-description">
        <label class="col-lg-1 control-label" for="activityform-description">活动简介</label>
        <div class="col-lg-11">
            <input type="text" id="activityform-description" class="form-control" name="[description]" value=<?= $model->description?>>
        </div>
    </div>
    </form>
    <div class="form-group">
        <button class="btn btn-primary col-lg-offset-6 create">创建</button>
    </div>
<?php
\yii\bootstrap\Modal::begin([
    'header' => '<h2>提示</h2>',
    'options' => ["class" => "confirmModal"],
    'footer' => '<button class="confirm btn btn-primary">确认</button><button type="button" class="btn btn-default" data-dismiss="modal">取消</button>',
    ]);
echo '<p class="content">本次活动花费为0，确认是免费活动？</p>';
\yii\bootstrap\Modal::end();
?>
</div>
