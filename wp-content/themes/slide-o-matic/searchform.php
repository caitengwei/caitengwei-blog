<form id="searchform" method="get" action="<?php bloginfo('url'); ?>/">
	<fieldset>
		<label for="livesearch" class="screenreader">Search: </label>
		<input id="livesearch" name="s" value="<?php the_search_query(); ?>" onblur="if (this.value == '') {this.value = '<?php the_search_query(); ?>';}" onfocus="if (this.value == '<?php the_search_query(); ?>') {this.value = '';}"  />
		<input type="submit" id="livesearchsubmit" value=">" />
	</fieldset>
</form>
