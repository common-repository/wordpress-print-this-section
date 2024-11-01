<?php
/**
 * Description: This is the main object for the Print This Section Plugin.
 * It contains all the functions used by action hooks and filters.
 * @author Scott Hair
 */

class WP_Print_This_Plugin{
    var $admin_options_name = "Print_This_Admin_Options";
    var $admin_options;
    var $option_keys = array( 'button_text', 'button_image', 'print_title', 'print_by_line', 'print_article', 'print_url', 'print_disclaimer', 'disclaimer' );

    /* CLASS CONSTRUCTOR: called when the class is instantiated. Loads admin options. */
    function __construct() {
        // Create default options array
        $disclaimer = sprintf(__('Copyright &copy; %s %s. All rights reserved.', 'wp-print'), date('Y'), get_option('blogname'));
        $this->admin_options = array(   'button_text' => 'Print This!',
                                        'button_image' => 'none',
                                        'print_title' => 1,
                                        'print_by_line' => 1,
                                        'print_article' => 1,
                                        'print_url' => 1,
                                        'print_disclaimer' => 1,
                                        'disclaimer' => $disclaimer,
                                        'plugin_version' => '2.0.3',
                                        'rewrite_rules_flag' => 1);
        $dev_options = get_option( $this->admin_options_name);
        if ( !empty( $dev_options ) ) {
            foreach ( $dev_options as $key => $option ) $this->admin_options[$key] = $option;
        }

        // Check Version of plugin. If not same, then flag rewrite rules.
        if ( WPPTS_PLUGIN_VER != $this->admin_options['plugin_version'] ) {
            $this->admin_options['rewrite_rules_flag'] = 1;
        }

        // Update the options in case new options have been added.
        update_option( $this->admin_options_name, $this->admin_options );
    }
    

    /* FUNCTION: Temporary Logging Function! */
    function log_me($message) {
        if (WP_DEBUG === true) {
            if (is_array($message) || is_object($message)) {
                error_log(print_r($message, true));
            } else {
	        error_log($message);
	    }
	}
    }


    /* FUNCTION: loads text domain for translations */
    function load_textdomain() {
	load_plugin_textdomain( 'print-this-section', false, WPPTS_PLUGIN_DIR . '/languages/' );
    }


    /* FUNCTION: causes TinyMCE to refresh cache instead of using it from cache */
    function my_refresh_mce( $ver ) {
        $ver += 3;
        return $ver;
    }


    /* FUNCTION adds the print this shortcode to the array of buttons. */
    function register_print_this_button($buttons) {
        array_push( $buttons, "separator", 'printthis');
        return $buttons;
    }


    /* FUNCTION registers our TinyMCE Plugin letting wordpress and TinyMCE know how to handle button. */
    function add_print_this_tinymce_plugin($plugin_array) {
        $url = trim(get_bloginfo('url'), "/" );
        $url .= "/wp-content/plugins/wordpress-print-this-section/js/customcodes.js";
        $plugin_array['printthis'] = $url;
        return $plugin_array;
    }

    
    /* FUNCTION: loads the admin options management page. */
    function print_admin_page() {

        // Update options if admin page was updated.
        if (isset($_POST['update_print_this_settings'])) {
           
            if ( isset( $_POST['button_text'] ) ) {
		$this->admin_options['button_text'] = apply_filters('content_save_pre',$_POST['button_text']);
            }
            if ( isset( $_POST['button_image'] ) ) {
                $this->admin_options['button_image'] = trim($_POST['button_image']);
            }
            $this->admin_options['print_title'] = intval($_POST['print_title']);
            $this->admin_options['print_by_line'] = intval($_POST['print_by_line']);
            $this->admin_options['print_article'] = intval($_POST['print_article']);
            $this->admin_options['print_url'] = intval($_POST['print_url']);
            $this->admin_options['print_disclaimer'] = intval($_POST['print_disclaimer']);
            if ( isset( $_POST['disclaimer'] ) ) {
                $this->admin_options['disclaimer'] = trim($_POST['disclaimer']);
            }

            update_option( $this->admin_options_name, $this->admin_options );
            echo '<div class="updated"><p><strong>'.__('Settings Updated.', "print-this-section").'</strong></p></div>';
            
	}

	include( WPPTS_PLUGIN_DIR.'/php/print-this-admin.php');

    }


    /* FUNCTION: loads the admin page CSS file into the header. */
    function add_admin_header_code() {
        echo '<link type="text/css" rel="stylesheet" href="' . WPPTS_PLUGIN_URL . '/css/admin.css" />' . "\n";
	echo "<!-- Print This Plugin Was Here! -->\n";
    }


    /* FUNCTION: loads printthis CSS file into the header. */
    function add_print_this_header_code() {
        echo '<link type="text/css" rel="stylesheet" href="' . WPPTS_PLUGIN_URL . '/css/printthis.css" />' . "\n";
        echo "<!-- Print This Plugin Was Here! -->\n";
    }


    /* FUNCTION: adds custom query vars so they are retained by wordpress */
    function add_print_this_query_vars( $qvars ) {
        $qvars[] = 'printthis';
        $qvars[] = 'printsect';
        return $qvars;
    }


    /* FUNCTION: determines and redirects to print_this template if appropriate */
    /* This functionality piece was adapted from WP-Print By Lester "GaMerZ' Chan */
    function print_this() {
	if( intval( get_query_var( 'printthis' ) ) == 1 ) {
		include( WPPTS_PLUGIN_DIR.'/php/print-this.php' );
		exit();
	}
    }


    /* FUNCTION: shortcode adds button and div container */
    function print_this_shortcode( $atts, $content = null ) {
        global $print_this_counter;
        global $wp_rewrite;
        global $post;

        extract( shortcode_atts( array( 'button_text' => 'Default' ), $atts ) );

        if ( 'Default' == $button_text ) $button_text = $this->admin_options['button_text'];
        if ( 'none' == $this->admin_options['button_image'] && empty( $button_text ) ) { $button_text = __( 'Print', 'print-this-section' ); }

        $button_image_src = FALSE;
        if ( 'none' != $this->admin_options['button_image'] ) {
            $button_image_src = WPPTS_PLUGIN_URL . "/images/" . $this->admin_options['button_image'];
        }

        /* Instead of using redirection and $wp-rewrite rules, I decided to go with simpler template redirection.
         * Although it is not as pretty or sexy, the functionality and realability is greatly increased. This section
         * takes the permalink and appends the propper query vars. The link is still bookmarkable, but not as SEO
         * friendly. But we really don't want our print page SEO friendly. This also works better with the default
         * permalink structures which were causing the page to just reload instead of redirecting. This change also
         * eliminated 3 functions making the plugin smaller and more efficient. -Version 2.0.4-
         */
        if ( 1 == substr_count( get_permalink($post->ID), '?' ) ) {
            $print_this_link = get_permalink( $post->ID ) . '&printthis=1&printsect=' . $print_this_counter;
        } else {
            $print_this_link = get_permalink( $post->ID ) . '?printthis=1&printsect=' . $print_this_counter;
        }

        $output = '<div class="print-this-button-shell">' . "\n";
        $output .= '<button type="button" class="print-this-button" onClick="parent.location=\'' . $print_this_link . '\'">&nbsp;&nbsp;&nbsp;&nbsp;';

        if ( $button_image_src ) {
            $output .= '<img src="' . $button_image_src . '" /> &nbsp; ';
        }

        $output .= $button_text . '&nbsp;&nbsp;&nbsp;&nbsp;</button>' . "\n";
        $output .= "</div>\n";
        $output .= "<!-- Print This Section $print_this_counter Start -->\n";
        $output .= '<div class="print-this-content">';
        $output .= do_shortcode( $content );
        $output .= '<div class="clear"></div>' . "</div>\n";
        $output .= "<!-- Print This Section $print_this_counter End -->\n";

        $print_this_counter++;

        return $output;
    }

}
?>