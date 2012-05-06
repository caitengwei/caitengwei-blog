=== WP-tsina ===
Contributors: kedyyan
Tags: wp-tsina, sina, 微博
Requires at least: 2.6
Tested up to: 3.0.4

WP-tsina can send a message to t.sina.com.cn when you publish a new post.

== Description ==

WP-tsina是一个专为新浪微博用户开发的，可以将新发布的文章主动同步到新浪微博。
后续功能将实现可在WordPress中对微博的管理。

安装后，完成Oauth认证，可以实现自动同步。
可以在新浪微博关注我：http://t.sina.com.cn/kedy ,或者订阅我的Blog: http://observerlife.com


== Installation ==

上传WP-tsina到你的WordPress，激活，然后完成OAuth认证。(需要WordPress主机PHP配置支持curl)

== Changelog ==

= 0.3.4 =
(2010-12-05)
分拆OAuth文件，避免和sina-connnect等插件冲突

= 0.3.3 =
(2010-12-05)
1、增加如何修改为自定义APP的说明
2、添加对是否已经定义WeiBoOAuth的判断

= 0.3.2 =
(2010-09-25)
1、增加重设Oauth认证功能

= 0.3.1 =
(2010-09-24)
1、菜单调整到Settings中
2、备份增加确认功能

= 0.3.0 =
(2010-09-22)
1、修改为OAuth认证方式。
2、配置项增加：可只发布标题，可将图片一并上传发布到微博(只上传第一张图片)

= 0.2.0 =
(2010-07-18)
1、增加后台一键自动备份微博到Wordpress功能(也可当作每周定期汇总微博用)；
2、版本升级为0.2.0

= 0.1.7 =
(2010-06-20)修正后台设置发布形式时，配置界面显示错误的bug

= 0.1.6 =
(2010-06-19)修正发布时未去掉HTML代码的问题

= 0.1.5 =
(2010-06-19) 
1、配置增加，可选择不同的形式发布微博:"标题+URL", "标题+摘要+URL", "标题+标签+URL"
2、自动检查，避免修改时重复发布

= 0.1.4 =
(2010-06-19) 配置增加，可选择不同的形式发布微博:"标题+URL", "标题+摘要+URL"

= 0.1.3 =
(2010-02-27)修正用户名使用邮箱名时无法验证通过的bug

= 0.1.2 =
1、后台插件页增加配置链接，方便直接进入配置

2、增加对curl支持的检测并提醒用户

= 0.1.1 =
增大输入框大小(thanks to Sishitou)

= 0.1.0 =
可以将发布的文章自动同步到新浪微博。(需要WordPress主机PHP配置支持curl)
