<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
<input type="hidden" name="cat" value="6" />
<input type="submit" id="searchsubmit" value="Search" />
</form>
