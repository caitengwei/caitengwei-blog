<?php
$myWpMathPublisher =& new WpMathPublisher;

// check if updates have to be saved
if(isset($_POST['submit']['defaults'])) {
	$myWpMathPublisher->toDefaults();
	?>
	<div class="updated">
		<h4><?php _e('Options resetted to default values', WPMP_TEXTDOMAIN); ?></h4>
	</div>
	<?php
} else if(isset($_POST['submit']['clearCache'])) {
	$myWpMathPublisher->clearCache();
	?>
	<div class="updated">
		<h4><?php _e('Cache cleared', WPMP_TEXTDOMAIN); ?></h4>
	</div>
	<?php
} else if(isset($_POST['submit']['save'])) {
	$fontColor = $_POST['fontColor'];
	$backColor = $_POST['backColor'];
	
	# check and convert colors from hex to rgb
	$messageFont = $myWpMathPublisher->checkColor($fontColor, $_POST['fontColorAlpha']);
	$messageBack = $myWpMathPublisher->checkColor($backColor, $_POST['backColorAlpha']);
	$messageSize = (!is_numeric($_POST['fontSize']) || $_POST['fontSize'] > WPMP_FONT_MAX || $_POST['fontSize'] < WPMP_FONT_MIN) ? '<li>'.sprintf(__('Font size must be between %1$d and %2$d', WPMP_TEXTDOMAIN), WPMP_FONT_MIN, WPMP_FONT_MAX).'</li>' : '';
	
	$message = (empty($messageFont)) ? '' : '<li class="head">'.__('Font:', WPMP_TEXTDOMAIN).'</li>'.$messageFont;
	$message .= (empty($messageBack)) ? '' : '<li class="head">'.__('Back:', WPMP_TEXTDOMAIN).'</li>'.$messageBack;
	$message .= (empty($messageSize)) ? '' : '<li class="head">'.__('Options:', WPMP_TEXTDOMAIN).'</li>'.$messageSize;
	?>
	<div class="updated">
		<?php 
		if(!empty($message)) {
			echo '<h4>'.__('Update not successfull:', WPMP_TEXTDOMAIN).'</h4>';
			echo '<ul>'; echo $message; echo '</ul>'; 
		} else {
			echo '<h4>'.__('Options saved', WPMP_TEXTDOMAIN).'</h4>';
			
			update_option('wpmathpublisher_font', array('color' => $fontColor, 'alpha' => $_POST['fontColorAlpha']));
			update_option('wpmathpublisher_back', array('color' => $backColor, 'alpha' => $_POST['backColorAlpha']));
			update_option('wpmathpublisher_size', $_POST['fontSize']);
			
			$myWpMathPublisher->readOptions();
		}
		?>
	</div>
	<?php
}

?>
<div class="wrap">
	<div id="icon-themes" class="icon32"><br /></div>
	<h2><?php _e('WpMathPublisher Design', WPMP_TEXTDOMAIN); ?></h2>
	<form name="wpmathpublisherColors" method="post" action="">
		<fieldset class="options">
			<!-- default submit button -->
			<input type="submit" name="submit[save]" value="<?php _e('Save', WPMP_TEXTDOMAIN); ?>" style="display: none;" />
			<div id="wpmp_preview">
				<strong><?php _e('Information:', WPMP_TEXTDOMAIN); ?></strong>
				<br />
				<?php _e('Default image will look like this:', WPMP_TEXTDOMAIN); ?><br /><br />
				<div><?php echo $myWpMathPublisher->parseMath(array(), '1 = e^{i pi}'); ?></div>
				<br />
				<input class="button" type="submit" tabindex="2" name="submit[defaults]" value="<?php _e('Reset to defaults', WPMP_TEXTDOMAIN); ?>" />
			</div>
			<h3><?php _e('Font color', WPMP_TEXTDOMAIN); ?></h3>
			<table class="editform">
				<tr>
					<td class="description"><?php _e('RGB-Value:', WPMP_TEXTDOMAIN); ?></td>
					<td><input name="fontColor" type="text" id="fontColor" class="color {pickerMode:'HVS',pickerPosition:'right',pickerFaceColor:'transparent',pickerFace:3,pickerBorder:0,pickerInsetColor:'black',caps:false}" value="<?php echo $myWpMathPublisher->font['color']; ?>" /></td>
				</tr><tr>
					<td class="description"><?php _e('Transparency:', WPMP_TEXTDOMAIN); ?></td>
					<td style="width: 196px;">
						<span class="comment" style="float: left;" ><?php _e('opaque', WPMP_TEXTDOMAIN); ?>&nbsp;</span>
						<span class="comment" style="float: right; margin-right: 40px;">&nbsp;<?php _e('transparent', WPMP_TEXTDOMAIN); ?></span>
						<br />
						<div class="carpe_horizontal_slider_track">
						    <div class="carpe_slider_slit">&nbsp;</div>
						    <div class="carpe_slider" id="fontAlphaSlider" orientation="horizontal" distance="128" display="fontAlphaDisplay" style="left: <?php echo $myWpMathPublisher->font['alpha']; ?>px;">&nbsp;</div>
						</div>
						<div class="carpe_slider_display_holder" >
						    <input class="carpe_slider_display" id="fontAlphaDisplay" name="fontColorAlpha" type="text" from="0" to="127" valuecount="128" value="<?php echo $myWpMathPublisher->font['alpha']; ?>" typelock="off" />
						</div>
						
						<!--  <input name="fontColorAlpha" type="text" id="fontColorAlpha" value="<?php echo $myWpMathPublisher->font['alpha']; ?>" /> -->
					</td>
				</tr>
			</table>
			<h3><?php _e('Background color', WPMP_TEXTDOMAIN); ?></h3>
			<table class="editform">
				<tr>
					<td class="description"><?php _e('RGB-Value:', WPMP_TEXTDOMAIN); ?></td>
					<td><input name="backColor" type="text" id="backColor" class="color {pickerMode:'HSV',pickerPosition:'right',pickerFaceColor:'transparent',pickerFace:3,pickerBorder:0,pickerInsetColor:'black',caps:false}" value="<?php echo $myWpMathPublisher->back['color']; ?>" /></td>
				</tr><tr>
					<td class="description"><?php _e('Transparency:', WPMP_TEXTDOMAIN); ?></td>
					<td style="width: 196px;">
						<span class="comment" style="float: left;" ><?php _e('opaque', WPMP_TEXTDOMAIN); ?>&nbsp;</span>
						<span class="comment" style="float: right; margin-right: 40px;">&nbsp;<?php _e('transparent', WPMP_TEXTDOMAIN); ?></span>
						<br />
						<div class="carpe_horizontal_slider_track">
						    <div class="carpe_slider_slit">&nbsp;</div>
						    <div class="carpe_slider" id="backAlphaSlider" orientation="horizontal" distance="128" display="backAlphaDisplay" style="left: <?php echo $myWpMathPublisher->back['alpha']; ?>px;">&nbsp;</div>
						</div>
						<div class="carpe_slider_display_holder" >
						    <input class="carpe_slider_display" id="backAlphaDisplay" name="backColorAlpha" type="text" from="0" to="127" valuecount="128" value="<?php echo $myWpMathPublisher->back['alpha']; ?>" typelock="off" />
						</div>
						
				</tr>
			</table>
			<h3><?php _e('Font Options', WPMP_TEXTDOMAIN); ?></h3>
			<table class="editform">
				<tr>
					<td class="description"><?php _e('Font size:', WPMP_TEXTDOMAIN); ?><br /><span class="comment"><?php printf(__('Allowed range: %1$d to %2$d', WPMP_TEXTDOMAIN), WPMP_FONT_MIN, WPMP_FONT_MAX); ?></span></td>
					<td><input type="text" name="fontSize" id="fontSize" value="<?php echo $myWpMathPublisher->size; ?>" /></td>
				</tr>
			</table>
			<p></p>
			<div id="wpmp_send">
				<input class="button-primary" type="submit" tabindex="1" name="submit[save]" value="<?php _e('Save Changes', WPMP_TEXTDOMAIN); ?>" />
				&nbsp;&nbsp;&nbsp;
				<input class="button" type="reset" value="<?php _e('Reset', WPMP_TEXTDOMAIN); ?>" />
			</div>
		</fieldset>
	</form>
	<br /><br />
	<form name="wpmathpublisherFiles" method="post" action="">
		<fieldset class="options">
			<h3><?php _e('Empty Cache', WPMP_TEXTDOMAIN); ?></h3>
			<p><?php _e('Click this button to empty the image cache. This can be necessary if you changed colors and want your old images to be rendered again:', WPMP_TEXTDOMAIN); ?></p>
			<input class="button" type="submit" tabindex="2" name="submit[clearCache]" value="<?php _e('Clear cache', WPMP_TEXTDOMAIN); ?>" />
		</fieldset>
	</form>
	<br /><hr /><br />
	<h3><?php _e('User Guide', WPMP_TEXTDOMAIN); ?></h3>
	<div id="wpmp_guide">
		<?php _e('To use this plugin is quite easy. The most simple use is just to to convert formulas into readable images', WPMP_TEXTDOMAIN); ?>
		<br />
		<div>
			[math]1 = e^{i pi}[/math]&nbsp;&nbsp;&nbsp;
			<em><?php _e('will be converted to', WPMP_TEXTDOMAIN); ?></em>&nbsp;&nbsp;&nbsp;
			<?php echo $myWpMathPublisher->parseMath(array(), '1 = e^{i pi}'); ?>
		</div>
		<?php _e('If you don\'t like the size of the text in the images you can adjust it just by passing an additional attribute "size"', WPMP_TEXTDOMAIN); ?>
		<div>
			[math size="20"]1 = e^{i pi}[/math]&nbsp;&nbsp;&nbsp;
			<em><?php _e('will be converted to', WPMP_TEXTDOMAIN); ?></em>&nbsp;&nbsp;&nbsp;
			<?php echo $myWpMathPublisher->parseMath(array('size' => '20'), '1 = e^{i pi}'); ?>
			<br />
			[math size="10"]1 = e^{i pi}[/math]&nbsp;&nbsp;&nbsp;
			<em><?php _e('will be converted to', WPMP_TEXTDOMAIN); ?></em>&nbsp;&nbsp;&nbsp;
			<?php echo $myWpMathPublisher->parseMath(array('size' => '10'), '1 = e^{i pi}'); ?>
		</div>
		<?php _e('In any case there even is an option if you do NOT want you\'re code to be parsed to an image. Just add the attribute noparse="true"', WPMP_TEXTDOMAIN); ?>
		<div>
			[math]1 = e^{i pi}[/math]&nbsp;&nbsp;&nbsp;
			<em><?php _e('will be converted to', WPMP_TEXTDOMAIN); ?></em>&nbsp;&nbsp;&nbsp;
			<?php echo $myWpMathPublisher->parseMath(array(), '1 = e^{i pi}'); ?>
			<br />
			[math noparse="false"]1 = e^{i pi}[/math]&nbsp;&nbsp;&nbsp;
			<em><?php _e('will be converted to', WPMP_TEXTDOMAIN); ?></em>&nbsp;&nbsp;&nbsp;
			<?php echo $myWpMathPublisher->parseMath(array('noparse' => 'false'), '1 = e^{i pi}'); ?>
			<br />
			[math noparse="true"]1 = e^{i pi}[/math]&nbsp;&nbsp;&nbsp;
			<em><?php _e('will be converted to', WPMP_TEXTDOMAIN); ?></em>&nbsp;&nbsp;&nbsp;
			<?php echo $myWpMathPublisher->parseMath(array('noparse' => 'true'), '1 = e^{i pi}'); ?>
		</div>
		<?php _e('Of course you can combine all attributes:', WPMP_TEXTDOMAIN); ?>
		<div>
			[math size=13]1 = e^{i pi}[/math]&nbsp;&nbsp;&nbsp;
			<em><?php _e('will be converted to', WPMP_TEXTDOMAIN); ?></em>&nbsp;&nbsp;&nbsp;
			<?php echo $myWpMathPublisher->parseMath(array('size' => 13), '1 = e^{i pi}'); ?>
			<br />
			[math size=13 noparse="true"]1 = e^{i pi}[/math]&nbsp;&nbsp;&nbsp;
			<em><?php _e('will be converted to', WPMP_TEXTDOMAIN); ?></em>&nbsp;&nbsp;&nbsp;
			<?php echo $myWpMathPublisher->parseMath(array('noparse' => 'true', 'size' => '13'), '1 = e^{i pi}'); ?>
		</div>
	</div>
	<hr />
	<h3>Credits:</h3>
	<ul>
		<li><?php _e('PhpMathPublisher by', WPMP_TEXTDOMAIN); ?> <a href="http://www.xm1math.net/phpmathpublisher/" title="PhpMathPublisher Homepage">Pascal Brachet</a></li>
		<li><?php _e('Colorpicker by', WPMP_TEXTDOMAIN); ?> <a href="http://jscolor.com" title="Jscolor Homepage">Honza Odvarko</a></li>
		<li><?php _e('Slider by', WPMP_TEXTDOMAIN); ?> <a href="http://carpe.ambiprospect.com/slider/" title="Homepage slider">Carpe</a></li>
	</ul>
</div>