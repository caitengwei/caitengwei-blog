<?php
/*
WP-tsina (configure file)
Plugin URI: http://observerlife.com/wp-sina.html
Description: WP-tsina ia a wordpress plugin for http://t.sina.com.cn(Sina.com's twitter like web app in China.)
Version: 0.3.0
Author: KedyYan
Author URI: http://observerlife.com/wp-sina.html
*/

/**
 * DO NOT edit this file.
 */

define('TSINA_APP_NAME', 'WP-tsina');

define('TSINA_APP_KEY', '2011183415');	// 请将2011183415替换为你自己的APP Key
define('TSINA_APP_SECRET', '16c0d2da8862562e8d29a598f22168a2');	//请将 16c0d2da8862562e8d29a598f22168a2 替换为你自己的APP key secret
define('TSINA_API_DOMAIN', 'api.t.sina.com.cn');
define('TSINA_API_POST', TSINA_API_DOMAIN . '/statuses/update.json?source=' . TSINA_APP_KEY);
define('TSINA_API_VERIFY', TSINA_API_DOMAIN . '/account/verify_credentials.json?source=' . TSINA_APP_KEY);
define('TSINA_API_LIST', TSINA_API_DOMAIN . '/statuses/user_timeline.json?user_id=%s&since_id=%d&count=%d&source=' . TSINA_APP_KEY);
define('TSINA_DEFAULT_TITLE', 'MySinaWeibo');

define('TSINA_CONFIG_PAGE', 'tsina-key-config');
define('TSINA_AUTOPOST', 'tsina-autopost');

define( "WB_AKEY" , TSINA_APP_KEY );
define( "WB_SKEY" , TSINA_APP_SECRET );
