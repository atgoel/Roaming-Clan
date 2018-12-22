=== WooCommerce Expand Tabs ===
Contributors: diana_burduja
Tags: woocommerce, tabs, product page tabs, expand tabs, woocommerce SEO
Requires at least: 3.0.1
Tested up to: 4.9
Stable tag: 1.8 
License: GPLv2 or later 
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires PHP: 5.2.4

Expand the tabs in the single-product page.

== Description ==

This plugin simply expands the tabs in the single-product page. It will remove the tabs (Description, Reviews or other custom tabs) and show only the content of the tabs one after another. 

You can enable the tabs expansion only for desktop or only for mobile devices. Check the settings on the Woocommerce->Settings->Products->Display page, as shown in the [screenshot](https://ps.w.org/woocommerce-extend-tabs/assets/screenshot-2.png).

Recently there were many discussions on Google Webmaster Central regarding the hidden content within tabs. Google regards the content under tabs as hidden and discards it when building their ranking of the page. Check out [More From Google On Hidden Content Within Tabs & Expand All](https://www.seroundtable.com/google-hidden-content-tabs-19534.html) about the issue. Therefore this plugin will simply expand the content of tabs and show all the content you have about products.

Some might argue that the tabs add a bit of esthetics to the single-product page. On the other hand ebay and Amazon show all their content on one page, one section after another, and there seems to be no consideration about hidding parts of it under tabs.

The plugin supports 3rd party tabs. The content of all of your tabs will be shown one section after another.

If you liked this plugin, then I'll also recommend the [WooCommerce Multi-Step Checkout](https://wordpress.org/plugins/wp-multi-step-checkout/) free plugin.


== Installation ==

= Automatic installation =
1. Press **Install** to install this plugin to your WordPress.
2. Enable the plugin in WP admin.

= Manual installation =
1. Download `woocommerce-extend-tabs.zip` from any available source.
2. Connect to your FTP server and upload and extract the zip-archive to your `/wp-content/plugins/` folder.
3. Enable the plugin in WP admin.

== Frequently Asked Questions ==

= With which WooCommerce versions is the plugin compatible? =
The plugin works with WooCommerce from 2.1 to up the latest 3.4 version.

= Why aren't the titles of the tabs shown on my site? =
Some themes suppress the `<h2>` title of the section with CSS or by overwritting the template file. We tested the plugin on 22 free themes that support WooCommerce and on two of them the `<h2>` title was hidden. This plugin should work for most of the themes, but we take no responsability for the themes that don't show the `<h2>` title of the section.

= Does it support tabs created by other plugins? =
Yes

= Does it support multi-site WordPress installations? =
Yes

= I want to add/modify/delete a tab =
If you're comfortable with adding code to your website, then see the [WooCommerce documentation](https://docs.woocommerce.com/document/editing-product-data-tabs/). If not, you can check out a plugin similar to [WooCommerce Tab Manager](https://docs.woocommerce.com/document/tab-manager/).

= Why doesn't it work on my website? =
Drop me a line in the support and maybe we can try to figure it out.

== Screenshots ==

1. Example of tabs expanded on the twentyfifteen theme 
2. Settings for enabling/disabling the tabs expansion 


== Changelog ==

= 1.8 =
* Use a different single-product.js file for every WooCommerce minor release 
* Remove the donation link

= 1.7 =
* Update: make the code compatible with WC 3.2
* Declare compatibility with WooCommerce 3.2 (https://woocommerce.wordpress.com/2017/08/28/new-version-check-in-woocommerce-3-2/)

= 1.6 =
* Fix: again https://wordpress.org/support/topic/bug-with-enfold-theme/

= 1.5 =
* Fix: https://wordpress.org/support/topic/bug-with-enfold-theme/

= 1.4 =
* Update: make the code compatible with WooCommerce 3.0.+ 

= 1.3 =
* Fix: PHP warning for Additional Tabs without weight, dimensions or attributes as explained in https://docs.woocommerce.com/document/editing-product-data-tabs/#section-6

= 1.2 =
* Feature: compatibility with the Enfold theme
* Feature: compatibility with the Flatsome theme

= 1.1.1 =
* Fix: adjusted the single-product.js file to the WooCommerce 2.5.2 version

= 1.1.0 =
* Fix: Error "Call to undefined function wp_is_mobile" on multi-site installations

= 1.0.4 =
* Added the 'Enable for desktop devices' and 'Enable for mobile devices' options

= 1.0.3 =
* Bug: https://wordpress.org/support/topic/warning-missing-argument-1-for-woocommerce_output_product_data_tabs-see-mor

= 1.0.2 =
* Tweak: support up to WordPress 4.2.1

= 1.0.1 =
* Change readme.txt file to show the screenshots on wordpress.org

= 1.0.0 =
* Initial release of WooCommerce Expand Tabs 

== Upgrade Notice ==
= 1.0.0 =
Initial release.
