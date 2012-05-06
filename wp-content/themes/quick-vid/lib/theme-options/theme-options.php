<?php
/*
Copyright 2008 iThemes (email: support@ithemes.com)

Written by Nathan Rice & Chris Jean

Version History
	1.0.0 - 2009-08-17
		Initial Release
*/

$GLOBALS['wp_theme_name']	= "My Theme";
$GLOBALS['wp_theme_shortname']	= "it";
$GLOBALS['wp_theme_page_name']	= 'theme-options';
$GLOBALS['wp_tutorial_var'] = 'ch';

require_once( 'theme-options-framework.php' );

if ( ! class_exists( 'iThemesThemeOptions' ) && class_exists( 'iThemesThemeOptionsFramework' ) ) {
	class iThemesThemeOptions extends iThemesThemeOptionsFramework {
		function setDefaults() {
			$this->force_defaults['include_pages'] = array( 'home' );
			$this->force_defaults['tracking_pos'] = 'footer';
		}
		
		function renderForm() {
			
?>
	<tr><th scope="row">Menu Builder</th>
		<td><div>Please select the pages you would like to <strong>INCLUDE</strong> in the Header Menus.</div>
			<table>
				<tr><th style="border:none; padding:0px;"><strong>Pages:</strong></th></tr>
				<tr><td style="border-bottom:none; vertical-align:top; padding:0px;"><?php $this->createMenuBuilderCheckboxes( 'include_pages', 'pages' ); ?></td>
				</tr>
			</table>
		</td>
	</tr>
	
	<tr><th scope="row">Tracking Code</th>
		<td>If you use a tracking service like <a href="http://google.com/analytics">Google Analytics</a>, paste the tracking code in the box below:<br />
			(leave blank for none)<br />
			<?php $this->_addTextArea( 'tracking', array( 'rows' => '3', 'cols' => '50' ) ); ?><br />
			Does your tracking service go in the header or footer of the code?<br />
			<?php $this->_addDropDown( 'tracking_pos', array( 'footer' => 'Footer (default)', 'header' => 'Header' ) ); ?>
		</td>
	</tr>

<?php
			
		}
		
		function createMenuBuilderCheckboxes( $var, $type ) {
			if ( empty( $this->_options[$var] ) )
				$this->_options[$var] = array();
			
			$options = array();
			
			if ( 'pages' == $type ) {
				$options['home'] = array( 'title' => "Home", 'depth' => 0 );
				$source_options = get_pages();
			}
			elseif ( 'categories' == $type )
				$source_options = get_categories('hide_empty=0&hierarchical=1');
			
			
			foreach ( (array) $source_options as $option ) {
				if ( 'pages' == $type ) {
					$parent = $option->post_parent;
					$title = $option->post_title;
					$id = $option->ID;
				}
				elseif ( 'categories' == $type ) {
					$parent = $option->category_parent;
					$title = $option->name;
					$id = $option->cat_ID;
				}
				
				if ( 0 == $parent )
					$options[$id] = array( 'title' => $title, 'depth' => 0 );
				else
					$options[$id] = array( 'title' => $title, 'depth' => ( $options[$parent]['depth'] + 1 ) );
			}
			
			foreach ( (array) $options as $id => $data ) {
				$attributes = array();
				$attributes['value'] = $id;
				
				if ( in_array( $id, $this->_options[$var] ) )
					$attributes['checked'] = 'checked';
				?>
					<div style="position:relative; left:<?php echo ( $data['depth'] * 15 ); ?>px;"><?php $this->_addMultiCheckBox( $var, $attributes ); ?> <?php echo $data['title']; ?></div>
				<?php
			}
		}
	}
}


if ( empty( $ithemes_theme_options ) )
	$GLOBALS['ithemes_theme_options'] =& new iThemesThemeOptions();

?>
