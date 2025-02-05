=== Print This Section ===
Contributors: twodeuces
Donate Link: http://twodeuces.com/wordpress-plugins/wordpress-print-this-section
Tags: print, section, page printing, print button, pages, posts, printing
Requires at least: 3.0
Tested up to: 3.1
Stable tag: 2.0.4

Print This Section allows WordPress authors to easily select sections of their posts for printing by their readers in a clean easy to read format. 

== Description ==
Have you ever wanted the possibility of letting your users print out just a section of a post or page? Deliver only the necessary parts in hard form without wasting all the extra paper and ink! This plugin will allow users of your wordpress install print out a designated section of a page or post. Great for printing out things like directions, instructions or recipes, although the uses are unlimited.

This plugin seems to work best when you have a custom permalink structure instead of the default link structure. I highly recommend you change your permalink structure to something that is a little more SEO friendly than the '/?p=xxx' format. 

Print This Section allows wordpress contributors to create a section of a post with a print button to allow for easy printing of that section. Good examples of this would be a recipe or driving instructions with a map. It will create a secondary window, print out the selected section and then close the window automatically. It will also add a "Print This" button to your post and page editors. You can add multiple Print This sections on a single page or post, but they must not overlap each other. WordPress will have a bad day if they are nested in each other.

This revised edition has been entirely reworked. Inspiration and some sections of code were adapted from WP-Print by Lester Chan. Unlike WP-Print, Print This Section is designed to print just a subset of the post and not an entire post or page. 

**Features:**
*   Easy to implement printing function.
*   Customized Print Button Text and selectable image.
*   Custom TinyMCE button added to Visual Editor.
*   Allows for setting each button text individually if desired.
*   Can optionally add Footer and Copyright information.
*   Is setup for language translation files for easy globalization.
*   Multi-section capability readded.

**Requirements:**
*   Wordpress 3.1+
*   Javascript

**Usage:** Simply highlight the section of your post that you wish to select for printing. Then press the "Print This" icon to add the shortcode to the post, or can add the [print_this] ... [/print_this] shortcodes manually around the section you would like printed.

You may set Print This Section Settings on the Settings->Print This page. These settings include customizing the Print Button and Disclaimer / Footer information, as well as turning on or off various bits of information like Title, By Line, and URL information. 

If you would like to customize each print section button then add the text attribute to the shortcode as follows: [print_this button_text='Print!']Your text and images that you wanted printed.[/print_this]

\* button_text='Print!' is optional and may be omitted.


== Installation ==

1. Upload wp-print-this-section directory into you wp-content/plugins/ directory.
2. Login to your WordPress Admin menu, go to Plugins, and activate it.
3. Adjust plugin settings found under Settings -> Print This in the administrators dashboard.
4. You may edit the css files found in the wp-print-this-section/css folder to adjust how the print this box appears on your page.


== Frequently Asked Questions ==

= Can I have Multiple Print This on a single page or post? =
As of revision 2.0.2 we have added the ability to print multiple sections on a post capabilities. Use multiple [print_this]…[/print_this] shortcode pairs to create more print sections. Make sure they are not nested within each other.
= Where can I submit feedback, ask questions or get answers about this plugin? =
You can go to the support page located [here](http://twodeuces.com/264-wordpress-print-this-section-comments-and-feedback.html) and enter your information.
= Can I customize the print page? =
You can certainly adjust the CSS for both the print preview page as well as the actual printed page. To do this, simply edit /css/printthis.css file found in the plugin's directory.
= Can I use a different print icon or image? =
Yes you can. Just add your image you wish to use to the /images folder in the plugin. It will automatically add the icon to the list of available icons. Keep in mind that smaller images work better for buttons.
= After installation of the plugin I am getting "404 - Page Not Found Errors". What's the deal? =
As of version 2.0.4 we are not using permalink redirection, notify me if you are still getting these issues. If you are using an older version, you need to update your permalinks settings. Go to Dashboard -> Settings -> Permalinks and click on "Save Changes". This will update the structure for the plugin and the /printthis redirection. 

== Screenshots ==

1. This screen shot is the Dashboard -> Settings -> Print This settings control. Used to set the options and defaults for the Print This Section plugin.
2. Screenshot of the visual editor with a Print_This section already installed. Note the printor icon in upper right of tool bar is for Print_This.
3. Screenshot of a post with a Print This Section being used.
4. Screenshot of a Print This Section preview page. Users just hit the back button to get back to the post.

== Changelog ==
= 2.0.4 =
* Corrected issues when using default permalink structures.
= 2.0.3 =
* Re-added Multi-Section print capability. Now you can have more than one Print This Section on a post or page.
* Added Alerts about updating your permalink structure.

= 2.0.1 =
* Major Revision of the plugin with nearly everything being redone.
* Updated to be compatible with nearly all browsers.
* Uses a print-preview page approach, so users can use browser print functions if needed.
* Uses page redirection so print page is bookmark capable.
* Added On/Off settings for various post attributes and a customizable footer section.

= 1.0.1 =
* Corrected CSS to include "Clear" class.
* Added more settings configurable in Dashboard -> Settings -> Print This.
* Added optional additional information on print page including Header, Footer and Copyright.

= 0.1.1 = 
* Corrected admininistrative and documentation notes.
* No functional changes were made.

= 0.1 =
* Initial release.
* Working using [print_this] for posts and pages, with button text changing option.


== Upgrade Notice ==
= 2.0.4 =
Fixes conflict when using default permalink structures. Please update.