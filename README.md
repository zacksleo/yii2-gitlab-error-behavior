# yii2-gitlab-error-behavior
send error to gitlab for yii


[![Latest Stable Version](https://poser.pugx.org/zacksleo/yii2-gitlab-error-behavior/version)](https://packagist.org/packages/zacksleo/yii2-gitlab-error-behavior)
[![Total Downloads](https://poser.pugx.org/zacksleo/yii2-gitlab-error-behavior/downloads)](https://packagist.org/packages/zacksleo/yii2-gitlab-error-behavior)
[![StyleCI](https://styleci.io/repos/85786180/shield)]()
[![Travis](https://img.shields.io/travis/rust-lang/rust.svg)]()
[![Scrutinizer](https://img.shields.io/scrutinizer/g/zacksleo/yii2-gitlab-error-behavior.svg)]()
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/zacksleo/yii2-gitlab-error-behavior.svg)]()
[![Code Climate](https://img.shields.io/codeclimate/github/zacksleo/yii2-gitlab-error-behavior.svg)]()
[![License](https://poser.pugx.org/zacksleo/yii2-gitlab-error-behavior/license)](https://packagist.org/packages/zacksleo/yii2-gitlab-error-behavior)


## Usage


### Install By Composer

```
  composer require zacksleo/yii2-gitlab-error-behavior --prefer-dist 
  
```

### set component

```
    'errorHandler' => [
        'errorAction' => 'site/error',
    ],

```
### set behavior in SiteController

set apiRoot, privateToken and projectName

```
    public function behaviors()
    {
        return [
            'behaviors' => [
                'class' => ErrorBehavior::className(),
                'apiRoot' => 'http://gitlab.com/api/v3/',
                'privateToken' => 'privateToken',
                'projectName' => 'demo/project'
            ]
        ];
    }
    
```

## Screenshot

![](http://ww1.sinaimg.cn/large/675eb504gy1fe0mhspoo6j212706vabc.jpg)
