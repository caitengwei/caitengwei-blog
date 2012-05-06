<?php
/*
Plugin Name: Chicklet Creator
Version: 0.5.1
Plugin URI: http://www.twistermc.com/shake/RSS-index.php
Description: Add feed subscription buttons to your blog. <a href="options-general.php?page=Chicklet-Creator/chicklet-creator.php">Config Instructions</a>
Author: Thomas McMahon
Author URI: http://www.twistermc.com/
*/

function chicklet_creator() {

// Create an array.
$array = get_option('chicklet_creator');
$array = explode(";", $array);
$displayoptions = explode(",", $array[1]);
$array = explode(",", $array[0]);

if ($displayoptions[5] != "") {
$thefeed = $displayoptions[5];
} else {
$thefeed = get_bloginfo_rss('rss2_url');

}

$thetitle = get_bloginfo_rss('name');
// blog title. probably no need to change.

$theurl = get_bloginfo_rss('url');
// blog url.  probably no need to change.

$imageURL = $theurl."/wp-content/plugins/Chicklet-Creator/RSS-images";
// path to the button images.

// Stop editing here and read the read me. //

$button0 = "<a href=\"$thefeed\" title=\"Subscribe to my feed\"><img src=\"$imageURL/feed-icon.gif\" style=\"border:0\"/></a>";
$button1 = "<a title='Subscribe to my feed' href=\"$thefeed\" style='text-decoration:none;'><img src=\"$imageURL/xml.gif\" style=\"border:0\"/></a>";
$button2 = "<a href=\"http://fusion.google.com/add?feedurl=$thefeed\"><img src=\"$imageURL/google-plus.gif\" alt=\"Google Reader or Homepage\" border=\"0\"></a>";
$button3 = "<a href=\"http://www.ifeedreaders.com/subscribe.php?thefeed=$thefeed&\"><img src=\"$imageURL/ifeedreaders.gif\" alt=\"Subscribe\" border=\"0\" title=\"More Subscription Options\"/></a>"; 
$button4 = "<a href=\"http://add.my.yahoo.com/rss?url=$thefeed\"><img src=\"$imageURL/yahoo.gif\" border=\"0\" alt=\"Add to My Yahoo!\"></a>";
$button5 = "<a href=\"http://www.bloglines.com/sub/$thefeed\"><img src=\"$imageURL/bloglines.gif\" alt=\"Subscribe with Bloglines\" border=\"0\" /></a>";
$button6 = "<a href=\"http://www.newsgator.com/ngs/subscriber/subext.aspx?url=$thefeed\"><img src=\"$imageURL/newsgator.gif\" alt=\"Subscribe in NewsGator Online\" border=\"0\"></a> ";
$button7 = "<a href=\"http://my.msn.com/addtomymsn.armx?id=rss&ut=$thefeed&ru=$theurl\"><img src=\"$imageURL/mymsn.gif\" border=\"0\"></a>";
$button8 = "<a href=\"http://www.bitty.com/manual/?contenttype=rssfeed&contentvalue=$thefeed\"><img src=\"$imageURL/bittybrowser.gif\" alt=\"BittyBrowser\" border=\"0\" /></a>";
$button9 = "<a href=\"http://feeds.my.aol.com/add.jsp?url=$thefeed\"><img src=\"$imageURL/myaol.gif\" alt=\"Add to My AOL\" border=\"0\"/></a>";
$button10 = "<a href=\"http://www.furl.net/storeIt.jsp?u=$theurl\" target=\"_blank\"><IMG alt=\"Furl $thetitle\" src=\"http://www.twistermc.com/RSS-images/furl.gif\" border=0></a>";
$button11 = "<a href=\"http://rss2pdf.com?url=$thefeed\"> <img src=\"$imageURL/rss2pdf.png\" alt=\"Convert RSS to PDF\" border=\"0\"/></a>";
$button12 = "<a href=\"http://www.rojo.com/add-subscription?resource=$thefeed\"> <img src=\"$imageURL/rojo.gif\" alt=\"Subscribe in Rojo\" style=\"border:0\"></a>";
$button13 = "<a href=\"http://my.feedlounge.com/external/subscribe?url=$thefeed\"><img src=\"$imageURL/feedlounge.gif\" style=\"border:0\" alt=\"Subscribe in FeedLounge\" /></a>";
$button14 = "<a href=\"http://client.pluck.com/pluckit/prompt.aspx?GCID=C12286x053&a=$thefeed&t=$thetitle\"><img src=\"$imageURL/pluck.png\" alt=\"Subscribe with Pluck RSS reader\" border=\"0\" /></a>";
$button15 = "<a href=\"http://www.feedfeeds.com/add?feed=$thefeed\"><img src=\"$imageURL/addff.gif\" alt=\"Feed Your Feeds\" border=\"0\" /></a>";
$button16 = "<a href=\"http://www.kinja.com/checksiteform.knj?pop=y&add=$thefeed\"><img src=\"$imageURL/addkinja.gif\" alt=\"Kinja Digest\" border=\"0\" /></a>";
$button17 = "<a href=\"http://solosub.com/sub/$thefeed\"><img src=\"$imageURL/solosub.gif\" alt=\"Solosub\" border=\"0\" /></a>";
$button18 = "<a href=\"http://www.multirss.com/rss/$thefeed\"><img src=\"$imageURL/multirss.gif\" alt=\"MultiRSS\" border=\"0\"  /></a>";

$button19 = "<a href=\"http://www.r-mail.org/bm.aspx?rss=$thefeed\"><img src=\"$imageURL/rmail.jpg\" border=\"0\"></a>";

$button20 = "<a href=\"http://www.rssfwd.com/rssfwd/preview?url=$thefeed\"><img src=\"$imageURL/rssfwd.png\" alt=\"Rss fwd\" border=\"0\"  /></a>";
$button21 = "<a href=\"http://www.blogarithm.com/subrequest.php?BlogURL=$thefeed\"> <img src=\"$imageURL/blogarithm.gif\" alt=\"Blogarithm\" border=\"0\" /></a>";
$button22 = "<a href=\"http://www.eskobo.com/?AddToMyPage=$thefeed\"><img src=\"$imageURL/eskobo.gif\" alt=\"Eskobo\" border=\"0\" /></a>";
$button23 = "<a href=\"http://my.gritwire.com/feeds/addExternalFeed.aspx?FeedUrl=$thefeed\"><img src=\"$imageURL/addToMyGritwire.gif\" alt=\"gritwire\" border=\"0\" /></a>";
$button24 = "<a href=\"http://www.botablog.com/botthisblog.php?blog=$thefeed&name=$thetitle\"><img src=\"$imageURL/botablog.gif\" alt=\"BotABlog\" border=\"0\" /></a>";
$button25 = "<a href=\"javascript:location.href='http://immedi.at/accounts/discover?feed_url='+encodeURIComponent(location.href)\" ><img alt=\"Monitor_this\" border=\"0\" src=\"$imageURL/monitor_this.png\" /></a>";
$button26 = "<a href=\"http://www.simpy.com/simpy/LinkAdd.do?href=$thefeed&title=$thetitle\"><img src=\"$imageURL/simpy-orange.png\" alt=\"Simpify!\" style=\"border-width: 0px;\"/></a>";

$button27 = "<a href=\"http://technorati.com/faves?add=$theurl\"><img src=\"$imageURL/technorati.gif\" alt=\"Add to Technorati Favorites!\" border=\"0\"/></a>";

$button28 = "<a href=\"http://www.netvibes.com/subscribe.php?url=$thefeed\"><img alt=\"Add to netvibes\" src=\"$imageURL/netvibes.gif\" border=\"0\"></a>";

$button29 = "<a href=\"http://www.pageflakes.com/subscribe.aspx?url=$thefeed\"><img src=\"$imageURL/pageflakes.gif\" border=\"0\"></a>";

$button30 = "<a href=\"http://www.protopage.com/add-button-site?url=$thefeed&label=$thetitle&type=feed\"><img alt=\"Add this site to your Protopage\" src=\"$imageURL/protopage.gif\" border=\"0\"></a>";

$button31 = "<a href=\"http://www.newsburst.com/Source/?add=$thefeed\"><img src=\"$imageURL/newsburst3.gif\" border=\"0\"></a>";

$button32 = "<a href=\"http://www.newsalloy.com/?rss=$thefeed\"><img src=\"$imageURL/newsalloy.gif\" border=\"0\" alt=\"Subscribe in NewsAlloy\" title=\"Subscribe in NewsAlloy\" /></a>";

$button33 = "<a href=\"http://reader.earthlink.net/feed/add?url=$thefeed\"><img src=\"$imageURL/myearthlink.gif\"  border=\"0\" alt=\"Subscribe in myEarthlink\" title=\"Subscribe in myEarthlink !You must already be logged into your Earthlink account.\" /></a>";

$button34="<script type=\"text/javascript\">var button = '10';var partner_name = '$thetitle';var feed_url = '$thefeed';var feed_service = '';</script><script type=\"text/javascript\" src=\"http://winksite.com/site/iframe_quick_add.js\"></script>";

$button35="<a href=\"http://plusmo.com/add?url=$thefeed\"><img src=\"$imageURL/plusmo.gif\" border=\"0\" alt=\"Add to your phone\" title=\"Add to your phone\" /></a>";

$button36="<a href=\"http://www.live.com/?add=$thefeed\"><img src=\"$imageURL/windowslive.gif\" border=\"0\"></a>";

$button37 = "<script language=\"javascript\" src=\"http://sm.feeds.yahoo.com/Buttons/V2.0/yactions.js\"></script><a class=\"yaction-link-alert\" id=\"BUTTONID\"></a><script type=\"text/javascript\">yAction.config.BUTTONID = {buttonActionUrl : \"$thefeed\"}</script>"; 

$button38 = "<a href=\"http://www.inclue.com/client/7?feed=$thefeed\"><img src=\"$imageURL/include.gif\" alt=\"Include\" border=\"0\"></a>"; 

$button39 = "<a href=\"http://www.feedshow.com/add_subscriptions.php?url=$thefeed\" title=\"Feedshow\"><img src=\"$imageURL/feedshow.gif\" border=\"0\" alt=\"Add to FeedShow\" /></a>"; 

$button40 = "<a href=\"http://www.fwicki.com/users/default.aspx?addfeed=$thefeed\" title=\"Fwicki\"><img src=\"$imageURL/fwicki_clicklet.png\" border=\"0\" alt=\"Add to FeedShow\" /></a>"; 

$button41 = "<a href=\"javascript:location.href='http://newshutch.com/external/add_feed?url='+encodeURIComponent('$thefeed')\"> <img src=\"$imageURL/newshutch.png\" alt=\"Add to Newshutch\" border=\"0\"/> </a>";

$button42 = "<a target=\"new\" href=\"http://www.newgie.com/account/subscribe.asp?feedurl=$thefeed\"><img src=\"$imageURL/newgiechicklet.gif\" border=\"0\" alt=\"Add to MyNewgie\"/></a>"; 

$button43 = "<a target=\"new\" href=\"http://www.zhuaxia.com/add_channel.php?url=$thefeed\"><img src=\"$imageURL/zhuaxia.gif\" border=\"0\" alt=\"Add to 抓虾\"/></a>"; 

$button44 = "<a target=\"new\" href=\"http://www.emailrss.cn/?rss=$thefeed\"><img src=\"$imageURL/youtianxia.gif\" border=\"0\" alt=\"Add to 邮天下\"/></a>"; 

$button45 = "<a target=\"new\" href=\"http://www.xianguo.com/subscribe.php?url=$thefeed\"><img src=\"$imageURL/xianguo.gif\" border=\"0\" alt=\"Add to 鲜果\"/></a>"; 


$counter = 0;
$button = '$button';

echo ($displayoptions[1]);
while ($counter < count($array)) {
	//if (${'array' . $counter}) {
	if ($array[$counter] == 1) {
	// prints rss button
	$printbutton = ${'button' . $counter};
	echo ($displayoptions[2]);
	echo($printbutton."\n");
	echo ($displayoptions[3]);
	}
	$counter = $counter+1;
}
echo ($displayoptions[4]);
}

////////database//////

if ($_POST['totalbuttons']) {
$newchicklets="";

$counter=0;
while ($counter<$_POST['totalbuttons']) {
	$element_type='$_POST[a';
	$elemnt_type_end = ']';
	$check_var=$element_type.$counter.$elemnt_type_end;
	eval("\$check_var = \"$check_var\";");
	if ($check_var != "") {
		$newchicklets = $newchicklets.$check_var.",";
	} else {
		$newchicklets = $newchicklets."0,";
	}
	$counter++;
}

$newchicklets = $newchicklets.";".$_POST['menutype'].",";

$newchicklets = $newchicklets.$_POST['beforeall'].",";
$newchicklets = $newchicklets.$_POST['beforeeach'].",";
$newchicklets = $newchicklets.$_POST['aftereach'].",";
$newchicklets = $newchicklets.$_POST['afterall'].",";
$newchicklets = $newchicklets.$_POST['blogfeed'].",";

update_option('chicklet_creator', $newchicklets);
get_option('chicklet_creator');
} else {
get_option('chicklet_creator');
add_option('chicklet_creator', '1,0,1,1,1,1,1,0,0,1,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,1,0,0,0,0,0,0,1,0,0,', $description, $autoload);
}
///////admin///////

add_action('admin_menu', 'chicklet_add_pages');

function chicklet_add_pages() {
    global $wpdb;
    if (function_exists('add_submenu_page'))
        add_submenu_page('options-general.php', __('Chicklet Creator'), __('Chicklet Creator'), 1, __FILE__, 'chicklet_options_subpanel');
}

function chicklet_options_subpanel() {

$array = get_option('chicklet_creator');
$array = explode(";", $array);
$displayoptions = explode(",", $array[1]);
$array = explode(",", $array[0]);
	?>
<div class="wrap">
        <h2 id="write-post">Chicklet Creator Options</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=Chicklet-Creator/chicklet-creator.php">
           
				<legend>Select Buttons</legend>
		  <div style="float:left;">
				<input name="a0" type="checkbox" id="a0" value="1" <? if ($array[0]==1) {echo("checked");}; ?>>
                <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/feed-icon.gif" style="border:0"/><br>
      <input name="a1" type="checkbox" id="a1" value="1" <? if ($array[1]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/xml.gif" style="border:0"/> <br>

      <input name="a2" type="checkbox" id="a2" value="1" <? if ($array[2]==1) {echo("checked");}; ?>>
      <IMG src="../wp-content/plugins/Chicklet-Creator/RSS-images/google-plus.gif" alt="Google Reader or Homepage" border="0"> <br>
      <input name="a3" type="checkbox" id="a3" value="1" <? if ($array[3]==1) {echo("checked");}; ?>>
      <img src='../wp-content/plugins/Chicklet-Creator/RSS-images/ifeedreaders.gif' alt='Subscribe' border="0" /> <br>
      <input name="a4" type="checkbox" id="a4" value="1" <? if ($array[4]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/yahoo.gif" border="0" alt="Add to My Yahoo!"> <br>
      <input name="a5" type="checkbox" id="a5" value="1" <? if ($array[5]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/bloglines.gif" alt="Subscribe with Bloglines" border="0" /> <br>
      <input name="a6" type="checkbox" id="a6" value="1" <? if ($array[6]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/newsgator.gif" alt="Subscribe in NewsGator Online" border="0"> <br>
      <input name="a7" type="checkbox" id="a7" value="1" <? if ($array[7]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/msn.gif" border="0"> <br>
      <input name="a8" type="checkbox" id="a8" value="1" <? if ($array[8]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/bittybrowser.gif" alt="BittyBrowser" border="0" /> <br>

      <input name="a9" type="checkbox" id="a9" value="1" <? if ($array[9]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/myaol.gif" alt="Add to My AOL" border="0"/> <br>
      <input name="a11" type="checkbox" id="a11" value="1" <? if ($array[11]==1) {echo("checked");}; ?>>
       <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/rss2pdf.png" alt="Convert RSS to PDF" border="0"/> <br>
      <input name="a12" type="checkbox" id="a12" value="1"  <? if ($array[12]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/rojo.gif" alt="Subscribe in Rojo" style="border:0">	  </div>

	  <div style="float:left;">
<input name="a13" type="checkbox" id="a13" value="1" <? if ($array[13]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/feedlounge.gif" style="border:0" alt="Subscribe in FeedLounge" /> <br>
      <input name="a14" type="checkbox" id="a14" value="1" <? if ($array[14]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/pluck.png" alt="Subscribe with Pluck RSS reader" border="0" /> <br>
     
      <input name="a16" type="checkbox" id="a16" value="1" <? if ($array[16]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/addkinja.gif" alt="Kinja Digest" border="0" /><br>

      <input name="a17" type="checkbox" id="a17" value="1" <? if ($array[17]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/solosub.gif" alt="Solosub" border="0" /><br>
      <input name="a18" type="checkbox" id="a18" value="1" <? if ($array[18]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/multirss.gif" alt="MultiRSS" border="0"  /><br>
      <input name="a19" type="checkbox" id="a19" value="1" <? if ($array[19]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/rmail.jpg" alt="RMail" border="0"><br>
      <input name="a20" type="checkbox" id="a20" value="1" <? if ($array[20]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/rssfwd.png" alt="Rss fwd" border="0"  /><br>

      <input name="a21" type="checkbox" id="a21" value="1" <? if ($array[21]==1) {echo("checked");}; ?>>
       <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/blogarithm.gif" alt="Blogarithm" border="0" /> <br>
      <input name="a22" type="checkbox" id="a22" value="1" <? if ($array[22]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/eskobo.gif" alt="Eskobo" border="0" /> <br>
      <input name="a23" type="checkbox" id="a23" value="1" <? if ($array[23]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/addToMyGritwire.gif" alt="gritwire" border="0" /> <br>
      <input name="a24" type="checkbox" id="a24" value="1" <? if ($array[24]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/botablog.gif" alt="BotABlog" border="0" /> </div>
    <div style="float:left;">
    <!--<input name="a25" type="checkbox" id="a25" value="1">
      <a href="javascript:location.href='http://immedi.at/accounts/discover?feed_url='+encodeURIComponent(location.href)" ><img alt="Monitor_this" border="0" src="http://immedi.at/images/monitor_this.png" /></a> <br>-->
      <input name="a26" type="checkbox" id="a26" value="1" <? if ($array[26]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/simpy-orange.png" alt="Simpify!" style="border-width: 0px;"/> <br>
      <input name="a27" type="checkbox" id="a27" value="1" <? if ($array[27]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/technorati.gif" alt="Add to Technorati Favorites!" border="0" /><br>
      <input name="a28" type="checkbox" id="a28" value="1" <? if ($array[28]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/netvibes.gif" alt="Add to netvibes" border="0"><br>
      <input name="a29" type="checkbox" id="a29" value="1" <? if ($array[29]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/pageflakes.gif" border="0"><br>
      <input name="a30" type="checkbox" id="a30" value="1" <? if ($array[30]==1) {echo("checked");}; ?>>
      <img alt="Add this site to your Protopage" src="../wp-content/plugins/Chicklet-Creator/RSS-images/protopage.gif" border="0"><br />
     <input name="a31" type="checkbox" id="a31" value="1" <? if ($array[31]==1) {echo("checked");}; ?>>
     <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/newsburst.gif" border="0"><br />

<input name="a32" type="checkbox" id="a32" value="1" <? if ($array[32]==1) {echo("checked");}; ?>>
<img src="../wp-content/plugins/Chicklet-Creator/RSS-images/newsalloy.gif" border="0" alt="Subscribe in NewsAlloy" title="Subscribe in NewsAlloy" /><br />

<input name="a33" type="checkbox" id="a33" value="1" <? if ($array[33]==1) {echo("checked");}; ?>>
<img src="../wp-content/plugins/Chicklet-Creator/RSS-images/myearthlink.gif" width="91" height="20" border="0" alt="Subscribe in myEarthlink" title="Subscribe in myEarthlink !You must already be logged into your Earthlink account." /><br />

<input name="a34" type="checkbox" id="a34" value="1" <? if ($array[34]==1) {echo("checked");}; ?>><script type="text/javascript">
var button = '10';
var partner_name = '';
var feed_url = '';
var feed_service = '';
</script>
<script type="text/javascript" src="http://winksite.com/site/iframe_quick_add.js"></script><br />

<input name="a35" type="checkbox" id="a35" value="1" <? if ($array[35]==1) {echo("checked");}; ?>>
<img src="../wp-content/plugins/Chicklet-Creator/RSS-images/plusmo.gif" border="0" alt="Add to your phone" title="Add to your phone" /><br />

<input name="a36" type="checkbox" id="a36" value="1" <? if ($array[36]==1) {echo("checked");}; ?>>
<img style="visibility: visible; width: 92px; height: 17px;" src="../wp-content/plugins/Chicklet-Creator/RSS-images/windowslive.gif" border="0"><br />

<!--input name="a37" type="checkbox" id="a37" value="1" < ? if ($array[37]==1) {echo("checked");}; ? >><img src="http://us.i1.yimg.com/us.yimg.com/i/us/my/yt/bn/alert.gif" /> Yahoo! Email Alerts<br /> -->
</div>
<div style="float:left;">

<input name="a38" type="checkbox" id="a38" value="1" <? if ($array[38]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/include.gif" alt="Include" border="0"><br>
      <input name="a39" type="checkbox" id="a39" value="1" <? if ($array[39]==1) {echo("checked");}; ?>>
      <img src="../wp-content/plugins/Chicklet-Creator/RSS-images/feedshow.gif" border="0"><br>
      <input name="a40" type="checkbox" id="a40" value="1" <? if ($array[40]==1) {echo("checked");}; ?>>
      <img alt="Add this site to Fwicki" src="../wp-content/plugins/Chicklet-Creator/RSS-images/fwicki_clicklet.png" border="0"><br />
      <input name="a41" type="checkbox" id="a41" value="1" <? if ($array[41]==1) {echo("checked");}; ?>>
      <img alt="Add this site to Newshutch" src="../wp-content/plugins/Chicklet-Creator/RSS-images/newshutch.png" border="0"><br />

      <input name="a42" type="checkbox" id="a42" value="1" <? if ($array[42]==1) {echo("checked");}; ?>>
      <img alt="Add this site to Newshutch" src="../wp-content/plugins/Chicklet-Creator/RSS-images/newgiechicklet.gif" border="0"><br />
	  
	        <input name="a43" type="checkbox" id="a43" value="1" <? if ($array[43]==1) {echo("checked");}; ?>>
      <img alt="Add this site to 抓虾" src="../wp-content/plugins/Chicklet-Creator/RSS-images/zhuaxia.gif" border="0"><br />

	        <input name="a44" type="checkbox" id="a44" value="1" <? if ($array[44]==1) {echo("checked");}; ?>>
      <img alt="Add this site to 邮天下" src="../wp-content/plugins/Chicklet-Creator/RSS-images/youtianxia.gif" border="0"><br />
	  
	  	        <input name="a45" type="checkbox" id="a45" value="1" <? if ($array[45]==1) {echo("checked");}; ?>>
      <img alt="Add this site to 鲜果" src="../wp-content/plugins/Chicklet-Creator/RSS-images/xianguo.gif" border="0"><br />


<input type="hidden" name="totalbuttons" value="46" />
      </div>
	  <br style="clear:both"; /><br />
	 
                <!--<legend>Link List Type</legend>
                <select name="menutype">
                	<option value="0">Drop Down</option>
                	<option value="1">Button List</option>
                </select>
				<br /><br />-->
				<legend>Separators (Please do not include semi-colons or commas)</legend>
	  
                <div>
	 <input name="beforeall" size="15" type="text" value="<? echo ($displayoptions[1]); ?>">
	 : Before all buttons<br>
	 <input name="beforeeach" size="15" type="text" value="<? echo ($displayoptions[2]); ?>">
	: Before each button<br>
	<input name="aftereach" size="15" type="text" value="<? echo ($displayoptions[3]); ?>">
	: After each button<br>
	<input name="afterall" size="15" type="text" value="<? echo ($displayoptions[4]); ?>">
	: After all buttons<br>
<br />
<input name="blogfeed" size="15" type="text" value="<? echo ($displayoptions[5]); ?>"> : Blog Feed
(leave blank if you are using the default feed URL)
</div>
                <p class="submit"><input type="submit" value="Update Feed Buttons &raquo;" name="Submit" /></p>
        </form>
    </div>
<?
}


?>