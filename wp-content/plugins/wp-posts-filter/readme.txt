=== WP Posts Filter ===
Contributors: olezhek.net
Donate link:https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=EVNMXA3EZSRVN&lc=US&item_name=WP%20Posts%20Filter&item_number=wp%2dposts%2dfilter%2ddonate&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted
Tags: post, filter, tag, category, sort
Requires at least: 3.3.0
Tested up to: 3.8
Stable tag: 0.3.2

With WP Posts Filter you can display posts of certain categories and tags in a page.

== Description ==

**ATTENTION! Please backup your custom templates if you're updating the plugin!**

This plugin filters posts by tags and/or categories. It could be set up to filter posts for the main page and/or any other static page of a blog. To set up the filter for a page, one needs to adjust the settings and put a shortcode, a piece of text playing the role of a placeholder for post lists, in the page. Since version 0.3 templates introduced.

= Filters by: =
1. Category
2. Tag
3. both Category and Tag

= Plugin behavior =
1. the plugin outputs a post if and only if the post has at least one category that is marked in plugin's settings page,
2. the plugin outputs a post if and only if the post contains at least one tag that is marked in plugin's settings page,
3. the plugin outputs a post "by category and tag" if and only if the post has the category **and** the tag that are marked in plugin's settings page.

You can set the number of posts per page and other preferences either in the plug-in settings page or by placing a customized shortcode tag in a page.

= Shortcode =

A shortcode needs to be put in a page to make the plugin showing posts in it. You can also setup some additional options using the shortcode. Settings set using the shortcode have higher priority compared to what is set up in the plugin settings page.
Here is how shortcode looks by default:

`[wppf]`

This way, the plugin filters posts using default settings or settings defined in the plugin settings page. Here is the complete writing for the shortcode:

`[wppf heading_tag="h2" heading_class="entry-title" content_tag="div" content_class="entry-content" per_page="10"  date_format=”F j, Y” post_template=”default”]`

Attributes are:

* `heading_tag` - html tag for the post title. `h2` by default,
* `heading_class` - css style for the post title. `entry-title` by default,
* `content_tag` - html tag for the post excerpt. `div` by default,
* `content_class` - css style for the post excerpt. `entry-content` by default,
* `per_page` - number of items per page. Settings -> Reading "Posts per page" or 10 by default,
* `date_format` - Date format in case if you’re using `#post_date#` tag in your template.
* `post_template` - Post template. Should contain the part of a filename, e.g. `default` for `wppf-item-default.php` file.

The attributes are not required, as you can always set up them in the plugin settings page, though you can always set up them this way either.

= Templates =
Since version 0.3 templates are available. Templating system is applied only to the part of a page containing the plugin output. There are two templates available by default - first one with the default layout (just like it was in the older versions), and the second one with thumbnails display. You can set up what template to use for a page (or for all pages) in the plugin settings page. Please refer to Screenshots section here to find mocks reproducing the way how default templates place post contents in a page.

= Creating custom templates =
Templates are php files located in `<plugin-dir>/templates` and having filenames like `wppf-item-<some-text-without-dot>.php`. To create your own template, name it following the rule described before, put it in `<plugin-dir>/templates` folder, and assign a string containing HTML-code to $item_template variable in that file. You can use placeholders to put parts of a post in the places you need. Following placeholders are presented in this version:

* `#heading_tag#` - tag for a post title. `<h2>` by default,
* `#heading_class#` - style for a post title heading tag. `entry-title` by default,
* `#content_tag#` - tag for a post excerpt. `<div>` by default,
* `#content_class#` - style for a post excerpt content tag. `entry-content` by default
* `#date_format#` - date format, has the same format as WP Date Format setting and PHP date() function. Refer to PHP date() function for details on how to setup date format. Set it up in the plugin settings page

First four in the list above exist for compatibility reasons. 

Following placeholders represent data fetched by the plugin from WP database:

* `#post_title#` - contains post title,
* `#post_excerpt#` - contains post excerpt,
* `#post_thumbnail#` - contains post thumbnail. Contains nothing if a post doesn’t contain a thumbnail,
* `#permalink#` - contains permalink to the post

You can take both templates included as examples for your own template.
WARNING! Please consider setting correct file permissions when create a new template file!

== Installation ==

1. Download and unpack the archive containing the plugin to the `/wp-content/plugins/` directory
2. Activate the plugin in the 'Plugins' menu of your WordPress install
3. Setup a filter for the desired page
3. Place the shortcode in that page. Skip this if you set up the filter for the main page

== Frequently Asked Questions ==

= This plugin doesn't work! =

I've used techniques that are recommended by WordPress development team for this plugin. Still, there could be some compatibility issues with other plugins used. If you've faced with the plugin malfunction:
1. Turn off (do not uninstall) all plugins but WP Posts Filter and check if it works.
2. (regardless of what you've got in the pt.1) Start a new issue [here](https://bitbucket.org/olezhek/wp-posts-filter/issues/new "New issue for WP Posts Filter at bitbucket.org") or [here](http://wordpress.org/tags/wp-posts-filter?forum_id=10#postform "New discussion topic at wordpress.org") and provide a list of all plugins you have, WordPress version, WP Posts Filter version, results of the pt.1 with the detailed description of a problem.
... and I'll help you.
 

== Screenshots ==

1. Plugin settings page
2. Showing filtered posts at the main page
3. Showing filtered posts at the particular page with the pagination
4. A default template mock-up
5. A template with thumbnail display enabled

== Other notes ==

You have to have JavaScript enabled in your browser so the plugin settings page could work properly.

Plugin home page: http://olezhek.net/codez/wp-posts-filter/

Plugin mirror repo: https://bitbucket.org/olezhek/wp-posts-filter/

Any comments/suggestions/ideas on this plugin would be appreciated.

If you want to create a translation for this plugin, you can use wp-posts-filter.pot file as the starting point (located in the root directory of the plugin). More info about plugin internationalization could be found [here](http://codex.wordpress.org/I18n_for_WordPress_Developers "I18n for WordPress Developers").
Contact me if you want to add a translation for your language to this plugin.

== Changelog ==

= 0.3.2 =
* Fixed display of dates under #post_date# placeholder
* Fixed the problem causing Add post admin section to be displayed improperly
* Added Dutch translation for the plugin. Special thanks go to [bakkelhan](http://wordpress.org/support/profile/bakkelhan) for translating the plugin settings page 

= 0.3.1 =
* Fixed incompatibility with Nextgen Gallery plugin for WordPress

= 0.3 =
* Added templates, with two templates included 
* Save settings button is now hovering to improve usability
* Fixed wrong order of tags/categories lists in plugin Settings page
* Fixed Submit button for plugin settings page in WP 3.0

= 0.2 =
* Added a feature to put selected posts in a custom place of a page.
* Added a possibility to set up styles and tags of selected posts in the settings page.
* Fixed display of the page navigation links. They're now wrapped inside `div` tags with classes `nav-previous` and `nav-next` for "previous page" and "next page" links respectively.
* Fixed display of tags and categories lists in the settings page.

= 0.1 =
* Initial version

== Upgrade Notice ==

= 0.3.2 =
* Please backup your custom templates before updating the plugin

= 0.3.1 =
* It is strongly recommended to update to this version in case if you use Nextgen Gallery plugin for WordPress

= 0.2 =

* Since version 0.2 has a feature to place selected posts in a custom place of the page, you'll probably find that the page display changed. This way, you need to place the shortcode in the place you need.

== Special thanks ==

* [bakkelhan](http://wordpress.org/support/profile/bakkelhan) - for translating the plugin settings page to Dutch

