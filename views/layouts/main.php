<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <meta name="author" content="zengjingxiang"/> 
    <meta name="Copyright" content="zengjingxiang"/> 
    <meta name="description" content="海湾之家"/>
    <meta name="keywords" content="上海，土风舞，海湾"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script type="text/javascript">var BASEURL='<?= yii\helpers\Url::base()?>/index.php?r=';</script>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->params['webTitle'],
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => '首页', 'url' => ['/site/index']],
                    ['label' => '活动', 'items' => [
                            ['label' => '最新活动', 'url' => ['/site/new-activity']],
                            ['label' => '历史活动', 'url' => ['/site/activity']],
                            //['label' => '创建活动', 'url' => ['/site/create-activity']],
                        ]
                    ],
                    ['label' => '舞码大全', 'url' => ['/site/dances']],
                    ['label' => '新人专区', 'url' => ['/site/rookie']],
                    Yii::$app->user->isGuest ?
                        ['label' => '登录', 'url' => ['/site/login']] :
                        [
                            'label' => Yii::$app->user->identity->name,
                            'items' => [
                                ['label' => '个人资料', 'url' => ['/site/profile']],
                                ['label' => '消费记录', 'url' => ['/site/consume-record']],
                                ['label' => '修改密码', 'url' => ['/site/modify-password']],
                                ['label' => '退出', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
                            ],
                        ],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <!--p class="pull-left">&copy; 海湾之家 <?= date('Y') ?></p-->
            <p style="text-align:center">&copy; 海湾之家 <?= date('Y') ?> <a href="http://www.miitbeian.gov.cn">沪ICP备15037398</a></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
