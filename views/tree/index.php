<?php
use kartik\tree\TreeView;
use app\models\Tree;

$this->title = '上海海湾土风舞社-活动';
$this->params['breadcrumbs'][] = "活动";
?>
<div class="activities">
    <?php echo TreeView::widget([
        'query' => Tree::find()->addOrderBy('root, lft'),
        'headingOptions' => ['label' => '海湾活动'],
        'isAdmin' => true,
        'displayValue' => 1,
        'softDelete' => false,
        'cacheSettings' => [        
            'enableCache' => true
        ],
        //'nodeView' => '@kvtree/views/_form',
    ]);
    ?>
</div>
