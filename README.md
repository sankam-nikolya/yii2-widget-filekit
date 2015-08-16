vetoni/yii2-widget-filekit
============================
Simple file upload widget based on BlueImp jQuery Plugin

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist vetoni/yii2-widget-filekit "*"
```

or add

```
"vetoni/yii2-widget-filekit": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \vetoni\widgets\FileUpload::widget(); ?>
```