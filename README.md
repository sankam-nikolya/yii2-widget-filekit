vetoni/yii2-widget-filekit
============================
Simple upload file kit based on BlueImp jQuery plugin.
Basically it's a simplified version of trntv/yii2-file-kit plugin.
Main idea of this plugin is using it in typical model update scenarios, such as saving linked images, like user photo, product thumbnail etc. 
Plugin does not support multiple file uploads at this moment. 
Also it requires a separate 'file' table in your database and web accessible file storage for uploaded images (inside web root dir).

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

It has not been registered at http://packagelist.org yet.

So add

```
"repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:vetoni/yii2-widget-filekit.git"
        }
    ],
```

to the root section of your `composer.json` file

and 

```
"vetoni/yii2-widget-filekit": "dev-master"    
```

to the require section of your `composer.json` file.

Configuration
------------

Once the extension is installed, you should configure path for uploaded files and add one extra table in your database.

First add some configuration to your params.php

```php
<?php 
return [
    'fileStorage.basePath' => '/files/uploaded'
];
```

In next step you should create 'file' table with such scheme:

```sql
CREATE TABLE `file` (
  `fid` varchar(16) NOT NULL,
  `name` varchar(255) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

So your model table is supposed to have a foreign key associated with this table.

And the last step is configure controller to handle file upload and delete actions.
The only thing you need is to add some suff in actions() method.

```php
public function actions()
{
    return [
        'upload' => [
            'class' => 'vetoni\filekit\actions\UploadAction'
        ],
        'delete' => [
            'class' => 'vetoni\filekit\actions\DeleteAction'
        ],
    ];
}
```
It will save your uploaded file into 'fileStorage.basePath' dir and also will made changes in database (updates the related 'file' table).


Usage
-----

Simply use it in your code by  :

```php
<?= $form->field($model, 'fid')->widget(\vetoni\filekit\FileUpload::className(),
    [
        'uploadUrl' => Url::to('/file/upload'),
        'deleteUrl' => Url::to('/file/delete'),
        'clientOptions' => [
            'acceptFileTypes' => '^image\/(gif|jpe?g|png)$'
        ]
    ])
?>
```