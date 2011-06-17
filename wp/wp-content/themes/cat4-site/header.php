<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php if ( is_single() || is_page() || is_paged() ) {
      bloginfo('name');
      wp_title(' | ');
 
} else if ( is_author() ) {
      bloginfo('name');
      wp_title(' | Archive for ');	  
	  
} else if ( is_archive() ) {
      bloginfo('name');
      echo (' | Archive for ');
      wp_title('');
 
} else if ( is_search() ) {
      bloginfo('name');
      echo (' | Search Results');
 
} else if ( is_404() ) {
      bloginfo('name');
      echo (' | 404 Error (Page Not Found)');
	  
} else if ( is_home() ) {
      bloginfo('name');
      echo (' | ');
      bloginfo('description');
 
} else {
      bloginfo('name');
      echo (' | ');
      echo (''.$blog_longd.'');
}
 ?></title>
	
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> 
<?php if ( is_single() ) { ?>
<meta name="description" content="<?php wp_title(''); ?>" />
<meta name="keywords" content="<?php wp_title(''); ?>" />
<?php }
else { ?>
<meta name="description" content="<?php bloginfo('description'); ?>" />
<meta name="keywords" content="<?php bloginfo('description'); ?>" />
<?php } ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel='stylesheet' type='text/css' media='all' href='/scripts/thickbox.css' />

<script language="javascript" type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-1.3.2.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-ui-1.7.3.custom.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.cookie.js"></script>
<script language="javascript" type="text/javascript" src="/scripts/thickbox-compressed.js"></script>
<script language="javascript" type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/popup.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    var cookieName = 'stickyAccordion';

	$("#poem_sorting").accordion({ 
		active: ( $.cookies.get( cookieName ) || 0 ),
		header: 'h4',
		autoHeight: false,
		alwaysOpen: false,
		change: function( e, ui ) {
			$.cookies.set( cookieName, $( this ).find( 'h4' ).index ( ui.newHeader[0] ) );
		}
	} );

    $('#searchform').submit(function() {
		$('#results').html('<img src="/images/ajax-loader.gif" alt="Loading" style="border:none" />');
		var s_term;
		if($('#s').val() == ""){
			s_term = "/materials/category/glossary/";
		} else {
			s_term = '/?s='+$('#s').val()+'&amp;cat=6';
		}
				$('#results').load(s_term+' #results');
		return false;
	});
  });
</script>

<?php if(!is_page()) { ?>
<script type="text/javascript">
  $(document).ready(function(){
	$('#poem-tabs').tabs({
		load: function(event, ui) {
			$('a', ui.panel).click(function() {
				$(ui.panel).load(this.href);
				return false;
			});
		}
	});
	$('#subnav-wrapper').tabs({
		load: function(event, ui) {
			$('a', ui.panel).click(function() {
				$(ui.panel).load(this.href);
				return false;
			});
		}
	});
	
  });
</script>
<?php } ?>

<?php if (is_front_page() ) { ?>
<script type="text/javascript" src="/scripts/jquery.cycle.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#logo').cycle({
			timeout:  100,
			speed:    300,
			speedIn:     100,
    		speedOut:    null,
			delay:    -100,
			nowrap:  1
		});
		$('#poem-tabs').tabs();
     });
</script>
<?php } ?>

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<link rel="shortcut icon" href="/favicon.ico" />

<?php wp_head(); ?>

</head>

<body <?php if (is_home()) { ?>id="home"<?php } else { ?>class="page-<?php echo $post->post_name; ?>" id="interior"<?php } ?>>
<div id="contactInfo" style="display:none"><p>Questions or suggestions?  Please write to <a href="mailto:prosody@collab.itc.virginia.edu">prosody@collab.itc.virginia.edu</a>.</p></div>
<div id="masthead" class="wrapper">
	<?php if (is_home()) { ?>
	<div id="logo"> 
		<img src="/images/logo01.gif" alt="" /> 
		<img src="/images/logo02.gif" alt="" /> 
		<img src="/images/logo03.gif" alt="" /> 
		<img src="/images/logo04.gif" alt="" />
		<img src="/images/logo05.gif" alt="" />
		<img src="/images/logo06.gif" alt="" />
		<img src="/images/logo.gif" alt="<?php bloginfo('name'); ?>" />
	</div>
	<?php } else { ?>
	<h1 id="logo"><a href="/"><?php bloginfo('name'); ?></a></h1>
	<?php } ?>
	<div id="intro">
	<p><strong><?php bloginfo('name'); ?>:</strong> <?php bloginfo('description'); ?></p>
	
	<h2 id="tagline"><a href="http://www.engl.virginia.edu/">a project of the University of Virginia English Department</a></h2>
	
	</div>
</div>

<?php if(!is_single() && !is_home() && !is_page()) : ?>
<div id="main" class="clearfloat">
<div class="wrapper">
<?php endif; ?>
<div id="poem-tabs">
