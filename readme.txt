=== PuSHPress ===
Contributors: josephscott, automattic, westi, kraftbj
Plugin Name: PushPress
Tags: websub, pubsubhubbub, push, WordPress.com
Requires at least: 2.9
Tested up to: 5.9
License: GPLv2
Stable tag: 0.1.10

Add WebSub (formerly known as PubSubHubbub) support to your WordPress site, with a built in hub.

== Description ==

This plugin adds WebSub/PubSubHubbub ( PuSH ) support to your WordPress powered site.  The main difference between this plugin and others is that it includes the hub features of PuSH, built right in.  This means the updates will be sent directly from WordPress to your PuSH subscribers.

== Installation ==

1. Upload `pushpress.zip` to your plugins directory ( usally `/wp-content/plugins/` )
2. Unzip the `pushpress.zip` file
3. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Question ==

= How is this plugin different from other PubSubHubbub plugins? =

Other plugins use 3rd party hubs to relay updates out to subscribers.  This plugin has a built in hub, allowing WordPress to send out the updates directly.

= Is there anything to configure? =

No, once the plugin is activated it takes care of the rest.

== Changelog ==

= 0.1.10 =
* Resolves notice in PHP 7.4/fatal in PHP 8.0 due to deprecation of curly-brace array notation.

= 0.1.9 =
* Update plugin header to avoid deprecated argument warnings
* Update class constructor to modern PHP
* Update readme to reflect new name for the standard (WebSub)
* Correct duplicate filter name
* Add disable_pushpress_send_ping filter to disable pings when needed
* Add X-Hub-Self headers
* Bump stable to 4.9

= 0.1.8 =
* Use wp_safe_remote_*() instead of wp_remote_*()

= 0.1.7.2 =
* Make sure to only output the hub information in feeds
* Bump tested value up to 3.6

= 0.1.7.1 =
* Use get_error_message() from the WP HTTP API ( Andrew Nacin )
* Bump tested value up to 3.2

= 0.1.7 =
* Fix typo during error handling (reported by John Godley)
* Improve HTTP error detection ( Andrew Nacin )
* Make sure the channel title in pings matches the channel title in the regular feed ( reported by Hugo Hallqvist )
* Normalize feed URLs ( Mike Adams )
* Make sure the WP environment has no one logged in when querying post data for pings ( Mike Adams )

= 0.1.6 =
* Force enclosure processing to happen before sending out a ping
* Make the plugin site wide for WPMU/multi-site installs

= 0.1.5 =
* When sending out pings we need to make sure that the PuSHPress
  options have been initialized
* Apply the hub array filter later in the process, as part of
  the feed head filter
* Verify unsubscribe requests (noticed by James Holderness)

= 0.1.4 =
* Be more flexible dealing with trailing slash vs. no trailing slash

= 0.1.3 =
* Suspend should really be unsubscribe

= 0.1.2 =
* Look for WP_Error being returned when sending a ping

= 0.1.1 =
* Initial release

== Upgrade Notice ==

= 0.1.2 =
Improved error checking

= 0.1.1 =
New PubSubHubbub plugin
