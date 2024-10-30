=== LC Header Footer Widgets ===
Contributors: jamesdlow
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=K6VKWB3HZB2T2&item_name=Donation%20to%20jameslow%2ecom&currency_code=USD&bn=PP%2dDonationsBF&charset=UTF%2d8
Tags: live composer, live, composer, lc, header, footer, widget, theme, template
Requires at least: 3.0
Tested up to: 6.0.1
Stable tag: 1.1.5
License: MIT License
License URI: https://opensource.org/licenses/MIT

Add support for Live Composer Headers and Footers to themes that only have Widget support

== Description ==
Many themes work with Live Composer out of the box, but do not support using Live Composer for headers, footers or sidebars.

This plugin lets you use a Live Composer header or footer template in any Wordpress widget area, be it in the header, footer or even on the sidebar of the theme.

== Installation ==

This section describes how to install the plugin and get it working.

1. Install the Live Composer Page Builder plugin
2. Upload entire `lc-header-footer-widgets` folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Go to Appearance -> Headers/Footers (LC) and create new header or footer template and edit in Live Composer
5. Select whether it is the default or not and save it
6. Go to Appearance -> Widgets
7. Drag the LC Header/Footer Widget to a widgetized area, a header or footer or even a sidebar!
8. Select either the default header or footer or the specific one created in step 5.

== Frequently Asked Questions ==


== Screenshots ==


== Changelog ==

= 1.1.5 =
* Update for PHP 8.0+

= 1.1.4 =
* Bug Fixes

= 1.1.3 =
* Fix for assumed constant warning

= 1.1.2 =
* Fix bug where footer content appeared in post when edited due to live composer update
* Fix bug where footer couldn't be edited

= 1.1.1 =
* Fix for allowing a specific header or footer to be chosen for each widget

= 1.1.0 =
* Don't show header/footer on Live Composer Editor for single page

= 1.0.0 =
* Initital version