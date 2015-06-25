<?php

/**
 * @package yii2-ztree
 */

namespace diselop\ztree;
use Yii;
use yii\web\AssetBundle;

/**
 * Asset bundle for ZTree Widget
 *
 * @author Tony Krutins <diselop@gmail.com>
 * @since 0.1.0
 */
class ZTreeAsset extends AssetBundle
{
    public $sourcePath = '@diselop/ztree/assets';
    public $js = [
        'ztree.min.js'
    ];
    public $css = [
        'ztree.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
