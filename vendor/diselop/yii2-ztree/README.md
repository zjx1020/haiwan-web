ztree
=====
zTree is a multi-functional 'tree plug-ins.'

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist diselop/yii2-ztree "*"
```

or add

```
"diselop/yii2-ztree": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \diselop\ztree\Ztree::widget(['nodes'=>[
    'name'=>'cities','children'=>[
        ['name'=>'USA','children'=>[
            ['name'=>'New York'],
            ['name'=>'Los Angeles'],
            ['name'=>'Chicago'],
            ['name'=>'San Diego'],
        ]],
        ['name'=>'China','children'=>[
            ['name'=>'Beijing'],
            ['name'=>'Shanghai'],
            ['name'=>'Shenzhen'],
            ['name'=>'Gaozhou'],
        ]],
        ['name'=>'Russia','children'=>[
            ['name'=>'Moscow'],
            ['name'=>'Orenburg'],
            ['name'=>'Omsk'],
            ['name'=>'Samara'],
        ]],
    ]
]]);
?>
