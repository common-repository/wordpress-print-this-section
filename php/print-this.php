<?php
/* 
 * Print This Section Template File - Used to display section for print.
 */

/* FUNCTION: extracts the div to be printed that was inserted by plugin. */
function extract_content() {
    global $pages, $multipage, $numpages, $post;

    if(!empty($post->post_password) && stripslashes($_COOKIE['wp-postpass_'.COOKIEHASH]) != $post->post_password) {
	$content = get_the_password_form();
    } else {
	if($multipage) {
            for($page = 0; $page < $numpages; $page++) {
                $content .= $pages[$page];
            }
	} else {
            $content = $pages[0];
	}
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);

        // extract Print This Section from content.
        $print_this_sect_number = intval( get_query_var( 'printsect' ) );
        $print_this_starting_marker = "<!-- Print This Section $print_this_sect_number Start -->";
        $print_this_ending_marker = "<!-- Print This Section $print_this_sect_number End -->";
        $content_chunks = explode( $print_this_starting_marker, $content, 2 );
        $content = $content_chunks[1];
        $content_chunks = explode( $print_this_ending_marker, $content, 2 );
        $content = $content_chunks[0];
        if ( !$content ) {
            $content = __( 'Print This was unable to locate the section you requested. Please contact the site administrator', 'print-this-section' );
        }
    }

    echo $content;
}

/* FUNCTION: retrieves the specified print this option. */
function get_print_this_option( $option ) {
    global $print_this_plugin;
    return $print_this_plugin->admin_options[$option];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="Robots" content="noindex, nofollow" />
	<link rel="stylesheet" href="<?php echo plugins_url('wordpress-print-this-section/css/printthis.css'); ?>" type="text/css" media="screen, print" />
</head>
<body class="print-this-body">
<!-- <p style="text-align: center;"><strong>From: <?php bloginfo('name'); ?> - <span dir="ltr"><?php bloginfo('url')?></span> -</strong></p> -->
    <div class="Center">
	<div id="Outline">
		<?php if (have_posts()): ?>
			<?php while (have_posts()): the_post(); ?>
					<?php if ( get_print_this_option( 'print_title' ) ): ?><p id="BlogTitle"><?php the_title(); ?></p><?php endif; ?>
					<?php if ( get_print_this_option( 'print_by_line' ) ): ?><p id="BlogDate"><?php _e('Posted By', 'print-this-section'); ?> <u><?php the_author(); ?></u> <?php _e('On', 'print-this-section'); ?> <?php the_time(sprintf(__('%s @ %s', 'print-this-section'), get_option('date_format'), get_option('time_format'))); ?> </p><?php endif; ?>
					<div id="BlogContent"><?php extract_content(); ?></div>
			<?php endwhile; ?>
			<hr class="Divider" style="text-align: center;" />
			<?php if ( get_print_this_option( 'print_article' ) ) : ?><p><?php _e('Article printed from', 'print-this-section'); ?> <?php bloginfo('name'); ?>: <strong dir="ltr"><?php bloginfo('url'); ?></strong></p><?php endif; ?>
			<?php if ( get_print_this_option( 'print_url' ) ) : ?><p><?php _e('URL to article', 'print-this-section'); ?>: <strong dir="ltr"><?php the_permalink(); ?></strong></p><?php endif; ?>
			<p id="print-link"><?php _e('Click', 'print-this-section'); ?> <a href="#Print" onclick="window.print(); return false;" title="<?php _e('Click here to print.', 'print-this-section'); ?>"><?php _e('here', 'print-this-section'); ?></a> <?php _e('to print.', 'print-this-section'); ?></p>
		<?php else: ?>
				<p><?php _e('No posts matched your criteria.', 'print-this-section'); ?></p>
		<?php endif; ?>
	</div>
    </div>
    <?php if ( get_print_this_option( 'print_disclaimer' ) ) : ?><p id="print-disclaimer"><?php echo get_print_this_option( 'disclaimer' ); ?></p><?php endif; ?>
</body>
</html>