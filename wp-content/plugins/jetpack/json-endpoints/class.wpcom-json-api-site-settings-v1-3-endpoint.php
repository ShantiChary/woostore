<?php
/**
 * WARNING: This file is distributed verbatim in Jetpack.
 * There should be nothing WordPress.com specific in this file.
 *
 * @hide-in-jetpack
 * @autounit api-v1 site-settings
 */

new WPCOM_JSON_API_Site_Settings_V1_3_Endpoint( array(
	'description' => 'Get detailed settings information about a site.',
	'group'       => '__do_not_document',
	'stat'        => 'sites:X',
	'min_version' => '1.3',
	'method'      => 'GET',
	'path'        => '/sites/%s/settings',
	'path_labels' => array(
		'$site' => '(int|string) Site ID or domain',
	),

	'query_parameters' => array(
		'context' => false,
	),

	'response_format' => WPCOM_JSON_API_Site_Settings_Endpoint::$site_format,

	'example_request' => 'https://public-api.wordpress.com/rest/v1.3/sites/en.blog.wordpress.com/settings?pretty=1',
) );

new WPCOM_JSON_API_Site_Settings_V1_3_Endpoint( array(
	'description' => 'Update settings for a site.',
	'group'       => '__do_not_document',
	'stat'        => 'sites:X',
	'min_version' => '1.3',
	'method'      => 'POST',
	'path'        => '/sites/%s/settings',
	'path_labels' => array(
		'$site' => '(int|string) Site ID or domain',
	),

	'request_format'  => array(
		'blogname'                             => '(string) Blog name',
		'blogdescription'                      => '(string) Blog description',
		'default_pingback_flag'                => '(bool) Notify blogs linked from article?',
		'default_ping_status'                  => '(bool) Allow link notifications from other blogs?',
		'default_comment_status'               => '(bool) Allow comments on new articles?',
		'blog_public'                          => '(string) Site visibility; -1: private, 0: discourage search engines, 1: allow search engines',
		'jetpack_sync_non_public_post_stati'   => '(bool) allow sync of post and pages with non-public posts stati',
		'jetpack_relatedposts_enabled'         => '(bool) Enable related posts?',
		'jetpack_relatedposts_show_headline'   => '(bool) Show headline in related posts?',
		'jetpack_relatedposts_show_thumbnails' => '(bool) Show thumbnails in related posts?',
		'jetpack_protect_whitelist'            => '(array) List of IP addresses to whitelist',
		'infinite_scroll'                      => '(bool) Support infinite scroll of posts?',
		'default_category'                     => '(int) Default post category',
		'default_post_format'                  => '(string) Default post format',
		'require_name_email'                   => '(bool) Require comment authors to fill out name and email?',
		'comment_registration'                 => '(bool) Require users to be registered and logged in to comment?',
		'close_comments_for_old_posts'         => '(bool) Automatically close comments on old posts?',
		'close_comments_days_old'              => '(int) Age at which to close comments',
		'thread_comments'                      => '(bool) Enable threaded comments?',
		'thread_comments_depth'                => '(int) Depth to thread comments',
		'page_comments'                        => '(bool) Break comments into pages?',
		'comments_per_page'                    => '(int) Number of comments to display per page',
		'default_comments_page'                => '(string) newest|oldest Which page of comments to display first',
		'comment_order'                        => '(string) asc|desc Order to display comments within page',
		'comments_notify'                      => '(bool) Email me when someone comments?',
		'moderation_notify'                    => '(bool) Email me when a comment is helf for moderation?',
		'social_notifications_like'            => '(bool) Email me when someone likes my post?',
		'social_notifications_reblog'          => '(bool) Email me when someone reblogs my post?',
		'social_notifications_subscribe'       => '(bool) Email me when someone follows my blog?',
		'comment_moderation'                   => '(bool) Moderate comments for manual approval?',
		'comment_whitelist'                    => '(bool) Moderate comments unless author has a previously-approved comment?',
		'comment_max_links'                    => '(int) Moderate comments that contain X or more links',
		'moderation_keys'                      => '(string) Words or phrases that trigger comment moderation, one per line',
		'blacklist_keys'                       => '(string) Words or phrases that mark comment spam, one per line',
		'lang_id'                              => '(int) ID for language blog is written in',
		'locale'                               => '(string) locale code for language blog is written in',
		'wga'                                  => '(array) Google Analytics Settings',
		'disabled_likes'                       => '(bool) Are likes globally disabled (they can still be turned on per post)?',
		'disabled_reblogs'                     => '(bool) Are reblogs disabled on posts?',
		'jetpack_comment_likes_enabled'        => '(bool) Are comment likes enabled for all comments?',
		'sharing_button_style'                 => '(string) Style to use for sharing buttons (icon-text, icon, text, or official)',
		'sharing_label'                        => '(string) Label to use for sharing buttons, e.g. "Share this:"',
		'sharing_show'                         => '(string|array:string) Post type or array of types where sharing buttons are to be displayed',
		'sharing_open_links'                   => '(string) Link target for sharing buttons (same or new)',
		'twitter_via'                          => '(string) Twitter username to include in tweets when people share using the Twitter button',
		'jetpack-twitter-cards-site-tag'       => '(string) The Twitter username of the owner of the site\'s domain.',
		'eventbrite_api_token'                 => '(int) The Keyring token ID for an Eventbrite token to associate with the site',
		'timezone_string'                      => '(string) PHP-compatible timezone string like \'UTC-5\'',
		'gmt_offset'                           => '(int) Site offset from UTC in hours',
		'date_format'                          => '(string) PHP Date-compatible date format',
		'time_format'                          => '(string) PHP Date-compatible time format',
		'start_of_week'                        => '(int) Starting day of week (0 = Sunday, 6 = Saturday)',
		'jetpack_testimonial'                  => '(bool) Whether testimonial custom post type is enabled for the site',
		'jetpack_testimonial_posts_per_page'   => '(int) Number of testimonials to show per page',
		'jetpack_portfolio'                    => '(bool) Whether portfolio custom post type is enabled for the site',
		'jetpack_portfolio_posts_per_page'     => '(int) Number of portfolio projects to show per page',
		Jetpack_SEO_Utils::FRONT_PAGE_META_OPTION => '(string) The SEO meta description for the site.',
		Jetpack_SEO_Titles::TITLE_FORMATS_OPTION => '(array) SEO meta title formats. Allowed keys: front_page, posts, pages, groups, archives',
		'verification_services_codes'          => '(array) Website verification codes. Allowed keys: google, pinterest, bing, yandex',
		'amp_is_enabled'                       => '(bool) Whether AMP is enabled for this site',
		'podcasting_archive'                   => '(string) The post category, if any, used for publishing podcasts',
		'site_icon'                            => '(int) Media attachment ID to use as site icon. Set to zero or an otherwise empty value to clear',
		'api_cache'                            => '(bool) Turn on/off the Jetpack JSON API cache',
		'posts_per_page'                       => '(int) Number of posts to show on blog pages',
		'posts_per_rss'                        => '(int) Number of posts to show in the RSS feed',
		'rss_use_excerpt'                      => '(bool) Whether the RSS feed will use post excerpts',
	),

	'response_format' => array(
		'updated' => '(array)'
	),

	'example_request' => 'https://public-api.wordpress.com/rest/v1/sites/en.blog.wordpress.com/settings?pretty=1',
) );

class WPCOM_JSON_API_Site_Settings_V1_3_Endpoint extends WPCOM_JSON_API_Site_Settings_V1_2_Endpoint {
	public static $wga_defaults = array(
		'code'                 => '',
		'anonymize_ip'         => false,
		'ec_track_purchases'   => false,
		'ec_track_add_to_cart' => false
	);

	function callback( $path = '', $blog_id = 0 ) {
		add_filter( 'site_settings_endpoint_get', array( $this, 'filter_site_settings_endpoint_get' ) );
		add_filter( 'site_settings_update_wga', array( $this, 'filter_update_google_analytics' ), 10, 2 );
		return parent::callback( $path, $blog_id );
	}

	/**
	 * Filter the parent's response to include the fields
	 * added to 1.3 (and their defaults)
	 */
	public function filter_site_settings_endpoint_get( $settings ) {
		$option_name = defined( 'IS_WPCOM' ) && IS_WPCOM ? 'wga' : 'jetpack_wga';
		$option = get_option( $option_name, array() );
		$settings[ 'wga' ] = wp_parse_args( $option, $this->get_defaults() );
		return $settings;
	}

	/**
	 * Filter the parent's response to consume our new fields
	 */
	public function filter_update_google_analytics( $wga, $new_values ) {
		$wga_keys = array_keys( $this->get_defaults() );
		foreach ( $wga_keys as $wga_key ) {
			// Skip code since the parent class has handled it
			if ( 'code' === $wga_key ) {
				continue;
			}
			// All our new keys are booleans, so let's coerce each key's value
			// before updating the value in settings
			if ( array_key_exists( $wga_key, $new_values ) ) {
				$wga[ $wga_key ] = WPCOM_JSON_API::is_truthy( $new_values[ $wga_key ] );
			}
		}
		return $wga;
	}
}
