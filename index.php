<?php

use source\core\front\FrontApplication;
use source\LuLu;
use source\libs\Common;

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// 这个是第三方的autoloader
require (__DIR__ . '/vendor/autoload.php');
// 这个是Yii的Autoloader，放在最后面，确保其插入的autoloader会放在最前面
require (__DIR__ . '/vendor/yiisoft/yii2/Yii.php');
// 后面不应再有autoloader了

require (__DIR__ . '/source/override.php');

require (__DIR__ . '/data/config/bootstrap.php');
require (__DIR__ . '/frontend/config/bootstrap.php');



$config = yii\helpers\ArrayHelper::merge(
		require(__DIR__ . '/data/config/main.php'),
		require(__DIR__ . '/data/config/main-local.php'),
		require(__DIR__ . '/frontend/config/main.php'),
		require(__DIR__ . '/frontend/config/main-local.php')
);

Common::checkInstall($config);

$app = new FrontApplication($config);
$siteStatus = Common::getConfigValue('sys_status');
if($siteStatus === '0')
{
    $app->catchAll = ['site/close', 'message' => 'test'];
}
$app->run();
