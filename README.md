# yii2-gitlab-error-behavior
send error to gitlab for yii


[![Latest Stable Version](https://poser.pugx.org/zacksleo/yii2-gitlab-error-behavior/version)](https://packagist.org/packages/zacksleo/yii2-gitlab-error-behavior)
[![Total Downloads](https://poser.pugx.org/zacksleo/yii2-gitlab-error-behavior/downloads)](https://packagist.org/packages/zacksleo/yii2-gitlab-error-behavior)
[![StyleCI](https://styleci.io/repos/85786180/shield)]()
[![Build Status](https://travis-ci.org/Graychen/yii2-gitlab-error-behavior.svg?branch=master)](https://travis-ci.org/Graychen/yii2-gitlab-error-behavior)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Graychen/yii2-gitlab-error-behavior/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Graychen/yii2-gitlab-error-behavior/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Graychen/yii2-gitlab-error-behavior/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Graychen/yii2-gitlab-error-behavior/?branch=master)
[![Code Climate](https://img.shields.io/codeclimate/github/zacksleo/yii2-gitlab-error-behavior.svg)]()
[![Build Status](https://scrutinizer-ci.com/g/Graychen/yii2-gitlab-error-behavior/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Graychen/yii2-gitlab-error-behavior/build-status/master)


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
