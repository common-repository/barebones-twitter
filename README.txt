=== Plugin Name ===
Contributors: aaronfisher
Donate link: https://www.paypal.me/aaronfisher
Tags: twitter, shortcode
Requires at least: 3.0
Tested up to: 4.4.2
Stable tag: 4.4.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple plugin for adding Twitter to your Wordpress install via a shortcode by @AaronPFisher

== Description ==

A simple plugin that allows you to include a Twitter feed on any page or post within your Wordpress website. All you need to do is configure the plugin with your Twitter handle and your Twitter access tokens and you are good to go, from there you can include `[display_twitter]` and the feed will appear.

You can choose how many Tweets will appear, whether to include ReTweets in the list, whether to include replies in the list and whether you want to the Tweets to scroll. Selecting the scroll option will set the Tweets to show in a 'ticker' style one after the other automatically.

The plugin is designed to be easily styled, we do not include any default CSS so as not to interfere with the current styling of your site. Each Tweet is a simple `<li>` element that can be easily styled.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/barebones-twitter` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Barebones Twitter screen to configure the plugin and add your Twitter credentials
4. You will need to create an app on [http://dev.twitter.com](http://dev.twitter.com/), this will give you 4 keys that you will need to enter into the configuration window.
5. Once configured, include `[display_twitter]` or `<?php echo do_shortcode('[display_twitter]'); ?>` on any page to display the Twitter stream.

== Frequently Asked Questions ==

= What is the access section in the settings? =

In order for the plugin to communicate with the Twitter API you will first need to configure an app on [http://dev.twitter.com/](http://dev.twitter.com/) and then copy the credentials into the settings.

== Screenshots ==

1. This is the settings menu
2. Tweets being displayed on the front end (non scroll)

== Changelog ==

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.0 =
* Initial release
