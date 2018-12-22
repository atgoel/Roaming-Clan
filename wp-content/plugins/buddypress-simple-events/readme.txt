=== BuddyPress Simple Events ===
Contributors: shanebp
Donate link: http://www.philopress.com/donate/
Tags: buddypress, events
Author URI: http://philopress.com/contact/
Plugin URI: http://philopress.com/products/
Requires at least: 4.0 
Tested up to: 4.9
Stable tag: 2.2.5
License: GPLv2 or later

A simple Events plugin for BuddyPress

== Description ==

This BuddyPress plugin allows members to create, edit and delete Events from their profile.

It:

* provides a tab on each members' profile for front-end creation, editing and deletion
* uses the Google Places API for creating locations
* uses Google Maps to show Event location 
* creates a custom post type called 'event'
* uses WP and BP templates that can be overloaded
* includes a widget


It does NOT have:

* ticketing
* calendars - BUT should work with any WP Calendar that supports custom post types
* recurring events

If you would like support for...

* search
* a map showing all Events
* a Settings screen for Map options
* an end Date
* Images
* an Attending button
* an option for assignment to a Group

... then you may be interested in [BuddyPress Simple Events Pro](https://www.philopress.com/products/buddypress-simple-events-pro/ "BuddyPress Simple Events Pro")

For more BuddyPress plugins, please visit [PhiloPress](https://www.philopress.com/ "PhiloPress")

== Installation ==

1. Upload the zip on the Plugins > Add screen in wp-admin

2. Activate the plugin through the 'Plugins' menu in WordPress

3. Go to Settings -> BP Simple Events and enter your Google Maps API Key. If you don't have a Key - See the FAQ


== Frequently Asked Questions ==

= Do I need a Google Maps API Key?
Yes. If you need help, read this tutorial [Google Maps API Key](https://www.philopress.com/google-maps-api-key/ "Google Maps API Key")

= MultiSite support? =

Yes. Tested in the following configuration:

* WP.4.1.1 - Multisite
* BuddyPress 2.2 + - Network Activated
* BuddyPress Simple Events - Network Activated

Roles can be assigned via the Network Admin > Settings > BP Simple Events screen.

But a member _must_ be a member of the main site in order to create Events.
If they are not a member of the main site, they will not see the Events tab.

= Calendar support? =

Yes - if the Calendar supports custom post types


== Screenshots ==
1. Shows the front-end Create an Event screen on a member profile
2. Shows the Dashboard > Settings screen


== Changelog ==

= 1.0 =
* Initial release.

= 1.1 =
* Refactored as a component.

= 1.2 =
* Add file missing from last release.

= 1.3 =
* Add multisite support, improved cleanup on trash

= 1.3.2 =
* Use trash hook instead of delete hook for cleanup on Event deletion 

= 1.3.4 =
* Check if BP is activated 

= 1.4 =
* Tested in WP 4.2 & BP 2.2.3.1, tweak subnav creation, replace template_redirect with template_include

= 1.4.1 =
* typo in single template filter

= 1.4.2 =
* fix bug in WP templates filter

= 1.4.3 =
* close the recent XSS vulnerability found in add_query_arg

= 1.4.4 =
* tested in WP 4.3

= 2.0 =
* Added requirement for Google Maps API Key

= 2.1 =
* fixed bug re timestamp

= 2.2 =
* Save post_date as the Event Start date so that Calendar plugins can be used

= 2.2.3 =
* Fix PHP Warning re incorrect function name in filter hook

= 2.2.5 =
* Fix status when Event is restored from Trash, set to 'publish'


== Upgrade Notice ==

= 2.2.5 =
* Fix status when Event is restored from Trash, set to 'publish'

= 2.2.3 =
* Fix PHP Warning re incorrect function name in filter hook

= 2.2 =
* Save post_date as the Event Start date so that Calendar plugins can be used
 
= 2.1 =
* fixed bug re timestamp

= 2.0 =
* Added requirement for Google Maps API Key. If you are already using this plugin, you don't need this update.

= 1.4.4 =
* tested in WP 4.3

= 1.4.3 =
* close the recent XSS vulnerability found in add_query_arg

= 1.4.2 =
* fix bug in WP templates filter

= 1.4.1 =
* typo in single template filter

= 1.4 =
* Tested in WP 4.2 & BP 2.2.3.1, tweak subnav creation, replace template_redirect with template_include

= 1.3.4 =
* Check if BP is activated 

= 1.3.2 =
* Use trash hook instead of delete hook for cleanup on Event deletion

= 1.3 =
* Add multisite support, improved cleanup on trash

= 1.2 =
* Add file missing from last release.

= 1.1 =
* Refactored as a component. Pagination fixed.

