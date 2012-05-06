<?php
/*
Plugin Name: WP-tsina
Plugin URI: http://observerlife.com/wp-tsina/
Description: WP-tsina是一个为新浪微博开发的插件，目前提供自动将新发布的文章发布到微博的功能。后续将添加如下功能：发布、管理微博信息。 
Version: 0.3.4
Author: kedyyan
Author URI: http://observerlife.com/
*/

define('TSINA_VERSION', '0.3.4');
session_start();
require_once('wp-tsina.config.php');
require_once('wp-tsina.curl.cls.php');
// 避免有其他插件已包含此文件
if( !class_exists( 'WeiboOAuth' ) ){
	require_once('wp-tsina.weibooauth.php');
}

// If you hardcode a WP.com API key here, all key config screens will be hidden
if ( defined('WPCOM_API_KEY') )
	$wpcom_api_key = constant('WPCOM_API_KEY');
else
	$wpcom_api_key = '';


function tsina_init( $postID ) {
  
  add_action('admin_menu', 'tsina_config_page');
  
  add_action('publish_post', 'tsina_post');
  
  add_action('right_now_table_end', 'tsina_addto_right_now');
  
  tsina_admin_warnings();
}

function tsina_post( $postID ){
	
	//检查是否post过
	if( true == tsina_is_posted( $postID ) ) return '';
	
	$postinfo = tsina_get_postinfo( $postID );
	$info_to_post = tsina_assemble_msg( $postinfo );
  $response = tsina_post_tosina( $info_to_post );
  
  tsina_last_pubinfo( $postID );
}
add_action('init', 'tsina_init');


/**
 * get the post info by postID
 */
function tsina_get_postinfo( $postID ){
	global $wpdb;
	
	$sql = sprintf( 'SELECT * FROM %s WHERE ID = %d', $wpdb->posts, $postID );
	$row = $wpdb->get_row( $sql );
	$string = var_export( $row, true );
	
	$postinfo = array();
	$postinfo['title'] = $row->post_title;
	$postinfo['url'] = $row->guid;
	$postinfo['id'] = $row->ID;
	$postinfo['excerpt'] = strip_tags( $row->post_excerpt );
	$postinfo['content'] = $row->post_content;
	
	return $postinfo;
}

function tsina_get_tags( $postID ){
	global $wpdb;
	
	$sql = sprintf( 'SELECT term_id FROM %s r LEFT JOIN %s t ON r.term_taxonomy_id = t.term_taxonomy_id WHERE t.taxonomy = "post_tag" and r.object_id = %d', $wpdb->term_relationships, $wpdb->term_taxonomy, $postID );
	$rows = $wpdb->get_results( $sql );
  
  if( empty( $rows ) ) return array();
  
  $ids = array();
	foreach( $rows as $obj ){
		$ids[] = $obj->term_id;
	}
	$ids_str = implode( ',', $ids );
	
	$sql = sprintf( 'SELECT name FROM %s WHERE term_id IN (%s)', $wpdb->terms, $ids_str );
	$res = $wpdb->get_results( $sql );
	if( empty( $res ) ) return array();
	
	$tags = array();
	foreach( $res as $obj ){
		$tags[] = sprintf( '#%s#', $obj->name );
	}
	
	return $tags;
}

function tsina_assemble_msg( $postinfo ){
	$charset = get_option( 'blog_charset' );
	$pubtype = (int)get_option( 'tsina_pubtype' );
	$pubpic = (int)get_option( 'tsina_pubpic' );
	
	$len_max = 140;
	
	// 计算标题和URL地址的长度
	$len_title = mb_strlen( $postinfo['title'], $charset );
	$len_url   = mb_strlen( $postinfo['url'], $charset );
	
	$len_now = $len_title + $len_url;
	$len_leave = $len_max - $len_now - 2;	//多减掉2个，以供空格与:使用
	
	$info_to_post = array();
	
	if( 1 == $pubpic ){
		$img_url = tsina_getfirst_imgurl( $postinfo['content'] );
		if( false != $img_url ){
			$info_to_post['img_url'] = $img_url;
		}
	}
	$postinfo['content'] = strip_tags( $postinfo['content'] );
	
	$content = '';
	
	if( 1 == $pubtype ){
		if( 0 < $len_leave ){ //长度不足140，可以增加内容
			$content_source = ( '' == trim( $postinfo['excerpt'] ) ) ? $postinfo['content'] : $postinfo['content'];
			$content = mb_substr( $content_source, 0, $len_leave, $charset );
			$content = ':' . $content;
		}
  }elseif( 2 == $pubtype ){
  	$tags = tsina_get_tags( $postinfo['id'] );
  	if( !empty( $tags ) ){
  		$content = implode( ',', $tags);
  	}
  }elseif( 3 == $pubtype ){
  	$content = '';
  	$postinfo['url'] = '';
  }
	
	$info_to_post['content'] = urlencode( $postinfo['title'] . $content . ' ' . $postinfo['url']);
	
	return $info_to_post;
}

function tsina_last_pubinfo( $id = 0 ){
	if( 0 == $id ){	//获取信息
		$last_pub = get_option( 'tsina_lastpub' );
		return $last_pub;
	}else{		//更新
		update_option( 'tsina_lastpub', $id );
	}
}

/**
 * 检查当前信息是否已经发布过，发布过则不会重新发布
 */
function tsina_is_posted( $postID ){
	$last_postinfo = tsina_last_pubinfo();
	
	if( $last_postinfo >= $postID ) return true;
	else return false;
}

function tsina_post_tosina( $info_to_post ){
	
	$client = tsina_get_oauthclient();

	if( isset( $info_to_post['img_url'] ) ){
		$res = $client->upload($info_to_post['content'], $info_to_post['img_url']);
	}else{
		$res = $client->update($info_to_post['content']);
	}
	
	return ;
}

function tsina_admin_warnings() {
	if( false == tsina_check_curl() ) {
		function tsina_warning() {
			echo "
			<div id='akismet-warning' class='updated fade'><p><strong>".__('WP-tsina已经安装完成.')." ".sprintf(__('但您的服务器PHP当前配置不支持curl，请联系服务器管理员重新配置。'))."</strong></p></div>
			";
		}
		add_action('admin_notices', 'tsina_warning');
		return;
	}
	if ( !tsina_verify_info( 'saved' ) && empty($_POST) && is_admin() ) {
			function tsina_warning() {
				echo "
				<div id='akismet-warning' class='updated fade'><p><strong>".__('WP-tsina has detected a problem.')."</strong> ".sprintf(__('A server or network problem is preventing Akismet from working correctly.  <a href="%1$s">Click here for more information</a> about how to fix the problem.'), "options-general.php?page=tsina-key-config")."</p></div>
				";
			}
		add_action('admin_notices', 'tsina_warning');
		return;
	}
}

function tsina_config_page() {
	if ( function_exists('add_submenu_page') ){
		add_submenu_page('options-general.php', __('新浪微博配置'), __('新浪微博配置'), 'manage_options', 'tsina-key-config', 'tsina_conf');
		add_submenu_page('options-general.php', __('新浪微博备份'), __('新浪微博备份'), 'manage_options', 'tsina-autopost', 'tsina_autopost');
	}
}


function tsina_conf() {
	
	if( 'appkey' == $_GET['act'] ){
		tsina_appkey_set_form();
		exit;
	}
	if( 'yes' == $_GET['reset'] ){
		tsina_clear_oauth();
	}
	// get the last key, and goto oauth page if false.
	if ( false == ( $last_key = tsina_get_oauthinfo() ) ) {
		tsina_oauth();
		exit;
	}
	
	$ms = array();
	if ( isset($_POST['submit']) ) {
		if ( function_exists('current_user_can') && !current_user_can('manage_options') )
			die(__('Cheatin&#8217; uh?'));

    $ms = array();
    $username = $_POST['t_username'];
    $password = $_POST['t_password'];
    $pubtype  = $_POST['t_pubtype'];
    $pubpic  = $_POST['t_pubpic'];
    $backup_draft = (int)$_POST['t_backup_draft'];
    $backup_postout = (int)$_POST['t_backup_postout'];
    $backup_title = $_POST['t_title_prefix'];
    $backup_category = (int)$_POST['t_backup_category'];
    
			update_option('tsina_username', $username);
			update_option('tsina_password', $password);
			update_option('tsina_pubtype', $pubtype);
			update_option('tsina_pubpic', $pubpic);
			update_option('tsina_backup_draft', $backup_draft);
			update_option('tsina_backup_postout', $backup_postout);
			update_option('tsina_title_prefix', $backup_title);
			update_option('tsina_backup_category', $backup_category);
			
			$key_status = tsina_verify_info();
			if( false == $key_status ){
				$ms[] = 'verify_failed';
			}else{
				$ms[] = 'verify_ok';
			}
	}

	$messages = array(
		'verify_ok' => array('color' => 'aa0', 'text' => __('保存完成')),
		'save_failed' => array('color' => 'd22', 'text' => __('保存失败'))
		);
		
	$categories = tsina_get_all_categories();
	$backupinfo = tsina_get_backupinfo();
?>
<?php if ( !empty($_POST['submit'] ) ) : ?>
<!--div id="message" class="updated fade"><p><strong><?php _e('已保存.') ?></strong></p></div-->
<?php endif; 
$tsina_pubtype = (int)get_option( 'tsina_pubtype' );
$tsina_pubpic = (int)get_option( 'tsina_pubpic' );
?>
<div class="wrap">
<h2><?php _e('WP-tsina配置'); ?></h2>
<div class="narrow">
<form action="" method="post" id="tsina-conf" style="margin: auto; width: 700px; ">
<?php if ( !$wpcom_api_key ) { ?>
	<p><?php printf(__('在您发布新的文章时，WP-tsina插件将自动向新浪微博发送一条新的信息。<br /><a href="http://observerlife.com/wp-tsina" target="_blank">点击这里访问插件开发者页面</a> 或者关注<a href="http://t.sina.com.cn/kedy">我的新浪微博</a>')); ?></p>

<h3><label for="key"><?php _e('自动发微博选项'); ?></label></h3>
<?php foreach ( $ms as $m ) : ?>
	<p style="padding: .5em; background-color: #<?php echo $messages[$m]['color']; ?>; color: #fff; font-weight: bold;"><?php echo $messages[$m]['text']; ?></p>
<?php endforeach; ?>
<?php } ?>
<p><label>内容格式：</label>
	<label><input type="radio" name="t_pubtype" value="0" <?php if($tsina_pubtype == 0){?>checked<?php }?> />标题+URL</label>
	<label><input type="radio" name="t_pubtype" value="1" <?php if($tsina_pubtype == 1){?>checked<?php }?> />标题+内容+URL</label>
	<label><input type="radio" name="t_pubtype" value="2" <?php if($tsina_pubtype == 2){?>checked<?php }?> />标题+标签(tag)+URL</label>
	<label><input type="radio" name="t_pubtype" value="3" <?php if($tsina_pubtype == 3){?>checked<?php }?> />标题Only</label>
	</p>
<p><label>是否发布文章中的图片：</label>
	<label><input type="radio" name="t_pubpic" value="1" <?php if($tsina_pubpic == 1){?>checked<?php }?> />是</label>
	<label><input type="radio" name="t_pubpic" value="0" <?php if($tsina_pubpic == 0){?>checked<?php }?> />否</label>
	(注:若选择"是"，且文章中有多张图片，只会自动上传第一张图片。)
	</p>
<h3><label for="key"><?php _e('自动备份设置'); ?></label></h3>
<p>
	<?php printf(__('自动备份，是根据您的设置，将您近期的微博自动下载并发布到您的WordPress博客中。一来可实现备份的功能，二来可视为微博关自动整理发布。')); ?>
</p>
<p>
	<label>发布设置：</label>
	<label><input type="radio" name="t_backup_draft" value="0" <?php if($backupinfo['backup_draft'] == 0){?>checked<?php }?> />存为草稿</label>
	<label><input type="radio" name="t_backup_draft" value="1" <?php if($backupinfo['backup_draft'] == 1){?>checked<?php }?> />自动发布</label>
</p>
<p>
	<label>标题前缀：<input type="text" size="40" name="t_title_prefix" value="<?php echo $backupinfo['title_prefix']; ?>" /></label>
</p>
<p>
	<label>是否将备份发布到微博：</label>
	<label><input type="radio" name="t_backup_postout" value="0" <?php if($backupinfo['backup_postout'] == 0){?>checked<?php }?> />否</label>
	<label><input type="radio" name="t_backup_postout" value="1" <?php if($backupinfo['backup_postout'] == 1){?>checked<?php }?> />是</label>
</p>
<p>
	<label>备份所属分类：</label>
	<label>
		<?php if(count( $categories) > 0 ){ ?>
		<select name="t_backup_category">
		<?php
		foreach ( $categories as $cate ){
			if( $backupinfo['backup_category'] == $cate['cat_ID'] ){
				echo '<option value="' . $cate['cat_ID'] . '" selected>'.$cate['cat_name'].'</option>';
			}else{
				echo '<option value="' . $cate['cat_ID'] . '">'.$cate['cat_name'].'</option>';
			}
		}
		 ?>
		</select>
	<?php } ?>
	</label>
</p>
	<p class="submit"><input type="submit" name="submit" value="<?php _e('保存 &raquo;'); ?>" /></p>
</form>
<!--p>如果需要设置自己的APP Key，请<a href="options-general.php?page=tsina-key-config&act=appkey">点击这里</a></p-->
<p>&nbsp;</p>
<p style="margin: auto; width: 700px; ">如果<b>确实需要</b>重新完成Oauth认证，请<a href="options-general.php?page=tsina-key-config&reset=yes">点击这里</a>。</p>
</div>
</div>
<?php
}

function tsina_clear_oauth(){
	update_option( 'tsina_oauth_token', '' );
	update_option( 'tsina_oauth_token_secret', '' );
}

/**
 * verify the username and password
 */
function tsina_verify_info( $option = null ) {
	return true;
}

function tsina_plugin_actions( $links, $file ) {
	if( $file == 'wp-tsina/wp-tsina.php' && function_exists( "admin_url" ) ) {
		$settings_link = '<a href="' . admin_url( 'options-general.php?page=tsina-key-config' ) . '">' . __('微博配置') .
			'</a>';
		array_unshift( $links, $settings_link ); // before other links
	}
	return $links;
}
add_filter( 'plugin_action_links', 'tsina_plugin_actions', 10, 2 );

function tsina_check_curl(){
	return function_exists( 'curl_init' ) ? true : false;
}

function tsina_get_timeline(){
	$weibo_uid = tsina_get_user_id();
	$backupinfo = tsina_get_backupinfo();
	$lastbackid = $backupinfo['lastbackid'];
	
	$url = sprintf( TSINA_API_LIST, 'wptsina', $lastbackid, $count );
	$client = tsina_get_oauthclient();
	$list = $client->user_timeline(1, 200);
	
	$count = count( $list );
	$i_start = $count - 1;
	for( $i = $i_start; $i > -1; $i -- ){
		$id = $list[$i]['id'];
		if( $lastbackid >= $id ){
			unset( $list[$i] );
		}else{
			break;
		}
	}
  
  if( !isset( $list[0] ) ){
  	return false;
  }
  
  return tsina_backup_post( $list, $backupinfo );
}

function tsina_backup_post( $list, $backupinfo ){
	$max_id = 0;
	$post_content = array();
	$title = $backupinfo['title_prefix'];
	
	foreach( $list as $item ){
		$max_id = $max_id < $item['id'] ? $item['id'] : $max_id;
		$text = $item['text'];
		if( isset( $item['retweeted_status'] ) ){
			$text .= sprintf( '//@<a href="http://t.sina.com.cn/%s">%s</a>: %s', $item['retweeted_status']['user']['id'], $item['retweeted_status']['user']['screen_name'], $item['retweeted_status']['text'] );
		}

		date_default_timezone_set('Asia/Shanghai');
		$time = date( ' [m/d/Y H:i:s]', strtotime( $item['created_at']) );

		if( '' != trim( $item['thumbnail_pic'] ) ){
			$text .= sprintf( '<br /><a href="%s" target="_blank"><img src="%s" /></a>', $item['original_pic'], $item['thumbnail_pic'] );
		}
		if( '' != trim( $item['retweeted_status']['thumbnail_pic'] ) ){
			$text .= sprintf( '<br /><a href="%s" target="_blank"><img src="%s" /></a>', $item['retweeted_status']['original_pic'], $item['retweeted_status']['thumbnail_pic'] );
		}

		$text .= $time;

		$post_content[] = '<li>' . $text . '</li>';
	}
	
	$contents = implode('', $post_content);
	$contents = '<ol>' . $contents . '</ol>';
	
	$my_post = array();
  $my_post['post_title'] = $title . '  -  ' . date("Y-m-d");
  $my_post['post_content'] = $contents;
  $my_post['post_status'] = $backupinfo['backup_draft'] ? 'publish' : 'draft'; // or 'publish or draft'
  $userinfo = get_currentuserinfo();
  $my_post['post_author'] = $userinfo->ID;
  $my_post['post_category'] = array( $backupinfo['backup_category'] );
  
  $post_id = wp_insert_post( $my_post );
  if( 0 == $backupinfo['backup_postout'] ){
  	remove_action('publish_post', 'tsina_post');
	}
	update_option('tsina_lastbackid', $max_id);
  return $post_id;
}

function tsina_get_backupinfo(){
	$backupinfo = array();
	$backupinfo['title_prefix'] = get_option('tsina_title_prefix');
	
	if( '' == trim( $backupinfo['title_prefix'] ) ){
		$backupinfo['title_prefix'] = TSINA_DEFAULT_TITLE;
	}
	$backupinfo['lastbackid'] = (int)get_option('tsina_lastbackid');
	$backupinfo['backup_category'] = (int)get_option('tsina_backup_category');
	$backupinfo['backup_postout'] = (int)get_option('tsina_backup_postout');
	$backupinfo['backup_draft'] = (int)get_option('tsina_backup_draft');
	
	return $backupinfo;
}

function tsina_get_user_id(){
	$weibo_uid = get_option('tsina_userid');
	
	if( !$weibo_uid ){
		$userinfo = tsina_verify_info( 'userinfo' );
		
		update_option('tsina_userid', $userinfo['id']);
		update_option('screen_name', $userinfo['screen_name']);
		
		$weibo_uid = $userinfo['id'];
	}
	
	return $weibo_uid;
	
}

function tsina_autopost(){
	$action = $_GET['act'];
	if( '' == $action ){
		echo '<p><a href="options-general.php?page=tsina-autopost&act=backup">点击这里备份并发布</a></p>';
	}elseif( 'backup' == $action ){
		$post_id = tsina_get_timeline();
		if( $post_id ){
			$url = 'post.php?action=edit&post=' . $post_id;
			echo '<p>发布完成，<a href="'. $url . '">点击这里查看</a></p>';
		}else{
			echo '<p>没有需要备份的微博。</p>';
		}
	}
}

function tsina_addto_right_now() {
				echo '<tr>';
        echo '<td class="t_tags" colspan="2" style="">新浪微博</td>';
        echo '<td><a href="options-general.php?page=tsina-autopost">自动备份</a></td>';
				echo '<td><a href="options-general.php?page=tsina-key-config">配置</a></td>';
        echo '</tr>';
}

function tsina_get_all_categories(){
	$category_ids = get_all_category_ids();
	if( count( $category_ids ) == 0 ) return array();
	
	$categories = array();
	foreach($category_ids as $cat_id) {
  	$cat_name = get_cat_name($cat_id);
  	$categories[] = array( 'cat_ID' => $cat_id, 'cat_name' => $cat_name );
	}
	
	return $categories;
}

function tsina_get_oauthinfo(){
	//oauth_token, last_key
	$last_key = array();
	if( $token = get_option('tsina_oauth_token') ){
		$last_key['oauth_token'] = get_option('tsina_oauth_token');
		$last_key['oauth_token_secret'] = get_option('tsina_oauth_token_secret');
		$_SESSION['last_key'] = $last_key;
		return $last_key;
	}else{
		return false;
	}
}

function tsina_update_oauthinfo(){
	$o = new WeiboOAuth( WB_AKEY , WB_SKEY , $_SESSION['keys']['oauth_token'] , $_SESSION['keys']['oauth_token_secret']  );

	$last_key = $o->getAccessToken(  $_REQUEST['oauth_verifier'] );
	$oauth_token = $last_key['oauth_token'];
	$oauth_token_secret = $last_key['oauth_token_secret'];
	update_option('tsina_oauth_token', $oauth_token);
	update_option('tsina_oauth_token_secret', $oauth_token_secret);
	$_SESSION['last_key'] = $last_key;
	return $last_key;
}

function tsina_oauth(){
	$action = $_GET['act'];
	if( 'callback' == trim( $action ) ){
		tsina_update_oauthinfo();
		?>
		<div class="wrap">
<h2><?php _e('WP-tsina配置'); ?></h2>
<div class="narrow">
	<?php
	echo "<div id='akismet-warning' class='updated fade'><p><strong>".__('Oauth认证完成，请<a href="/wp-admin/options-general.php?page=tsina-key-config">点击这里进入WP-Tsina配置页</a>.')." </strong></p></div>";
	?>
</div>
</div>
		<?php
	}else {
		$site_url = get_option('siteurl');
		$callback_url = $site_url . '/wp-admin/options-general.php?page=tsina-key-config&act=callback';
		
		$o = new WeiboOAuth( WB_AKEY , WB_SKEY  );
	
		$keys = $o->getRequestToken();
	
		$aurl = $o->getAuthorizeURL( $keys['oauth_token'] ,false , $callback_url );
	
		$_SESSION['keys'] = $keys;
		?>
		<div class="wrap">
<h2><?php _e('WP-tsina配置'); ?></h2>
<div class="narrow">
	<p><?php printf(__('请按下面提示，完成新浪微博的OAuth权限认证。完成之后就可以进入设置界面，正式开始使用WP-Tsina微博插件了。<br /><a href="http://observerlife.com/wp-tsina" target="_blank">点击这里访问插件开发者页面</a> 或者关注<a href="http://t.sina.com.cn/kedy">我的新浪微博</a>')); ?></p>
	<p><a href="<?php echo $aurl; ?>" style="font-size:16px">点击这里完成新浪微博的Oauth认证</a></p>
	<!--p>如果需要设置自己的APP Key，请<a href="options-general.php?page=tsina-key-config&act=appkey">点击这里</a></p-->
</div>
</div>
		<?php
	}
}

function tsina_appkey_set_form(){
	$appkey = tsina_get_appkey();
	?>
		<div class="wrap">
<h2><?php _e('WP-tsina配置'); ?></h2>
<div class="narrow">
	
	<form action="" method="post" id="tsina-conf" style="margin: auto; width: 700px; ">
	<p><?php printf(__('设置新浪微博APP Key信息。如果不清楚APP Key指什么，请一定不要修改，以免出现无法同步的问题。')); ?></p>
	<h3><label for="key"><?php _e('设置新浪微博APP Key信息'); ?></label></h3>
	<p>
		<label>APP Key：<input type="text" name="t_appkey" value="<?php echo $appkey['key']; ?>" size="16" />(默认值:<?php echo TSINA_APP_KEY;?>)</label>
	</p>
		<p>
		<label>APP Secret：<input type="text" name="t_appsecret" value="<?php echo $appkey['secret']; ?>" size="40" />(默认值:<?php echo TSINA_APP_SECRET;?>)</label>
	</p>
	<p class="submit"><input type="submit" name="submit" value="<?php _e('保存 &raquo;'); ?>" /></p>
</form>
</div>
</div>
		<?php
}

function tsina_get_oauthclient(){
	tsina_get_oauthinfo();
	$client = new WeiboClient( WB_AKEY , WB_SKEY , $_SESSION['last_key']['oauth_token'] , $_SESSION['last_key']['oauth_token_secret']  );
	return $client;
}

function tsina_getfirst_imgurl( $content ){
	$pos_img_start = strpos( $content, '<img' );
	if ( false === $pos_img_start ){
		return false;
	}
	$pos_img_quote_1 = strpos( $content, 'src="', $pos_img_start );
	$pos_img_quote_2 = strpos( $content, '"', $pos_img_quote_1 + 5 );
	
	$img_url = substr( $content, $pos_img_quote_1 + 5, $pos_img_quote_2 - $pos_img_quote_1 - 5 );
	return $img_url;
}

function tsina_get_appkey(){
	$appkey = array();
	$appkey['key'] = get_option( 'tsina_app_key' );
	if( '' == trim( $appkey['key'] ) ){
		$appkey['key'] = TSINA_APP_KEY;
		$appkey['secret'] = TSINA_APP_SECRET;
		return $appkey;
	}
	$appkey['secret'] = get_option( 'tsina_app_secret' );
	return $appkey;
}

function tsina_set_appkey( $key, $secret ){
	update_option( 'tsina_app_key', $key );
	update_option( 'tsina_app_secret', $secret );
}
?>
