<?php
/**
 * Plugin Name: Remove Comments
 * Description: Plugin for removing comments features from front and backend of WP
 * Version: 1.0
 * Author: Mike Estrada
 *
 * Since we don't have comments on this site, we get rid of all instances of them throughout the admin area.
 * Also remove from front end so it doesn't make any queries to any of the WP comment features.
 *
 * Credit for these functions goes to the following:
 *    https://www.dfactory.eu/turn-off-disable-comments/
 *    https://github.com/solarissmoke/disable-comments
 *
 * Notes:
 * - Class is called at the bottom of this file.
 * - In WPVIP environments, this file should be in the folder `client-mu-plugins` instead of `mu-plugins`.
 */

if ( ! defined( 'WPINC' ) ) {
	die( 'YOU SHALL NOT PASS!' );
}

/**
 * Class for Removing Comments
 */
class Remove_Comments {
	/**
	 * Instance of this class
	 *
	 * @var boolean
	 */
	public static $instance = false;

	/**
	 * Using construct method to add any actions and filters
	 */
	public function __construct() {
		/**
		 * UNUSED ACTIONS/FILTERS FROM https://www.dfactory.eu/turn-off-disable-comments/
		 */
		// add_filter( 'comments_open', [ $this, 'disable_comments_status' ], 20, 2);
		// add_filter( 'pings_open', [ $this, 'disable_comments_status' ], 20, 2);
		// add_filter( 'comments_array', [ $this, 'disable_comments_hide_existing_comments' ], 10, 2);
		// add_action( 'init', [ $this, 'disable_comments_admin_bar' ] );

		add_action( 'admin_init', [ $this, 'disable_comments_admin_menu_redirect' ] );
		add_action( 'admin_init', [ $this, 'disable_comments_dashboard' ] );
		add_action( 'admin_menu', [ $this, 'disable_comments_admin_menu' ] );

		add_action( 'widgets_init', [ $this, 'disable_rc_widget' ] );

		add_filter( 'wp_headers', [ $this, 'filter_wp_headers' ] );

		// add_action( 'template_redirect', [ $this, 'filter_query' ], 9 );

		add_action( 'template_redirect', [ $this, 'filter_admin_bar' ] );

		// Remove the comments feeds.
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		add_filter( 'feed_links_show_comments_feed', '__return_false' );

		add_action( 'wp_loaded', [ $this, 'init_wploaded_filters' ] );

		add_action( 'wp_before_admin_bar_render', [ $this, 'my_admin_bar_render' ] );
	}

	/**
	 * Singleton
	 *
	 * Returns a single instance of the current class.
	 */
	public static function singleton() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Remove the comments widget.
	 *
	 * @return void
	 */
	public function disable_rc_widget() {
		unregister_widget( 'WP_Widget_Recent_Comments' );
	}

	/**
	 * Remove the X-Pingback HTTP header
	 */
	/**
	 * Undocumented function
	 *
	 * @param string $headers Associative array of headers to be sent.
	 * @return string
	 */
	public function filter_wp_headers( $headers ) {
		unset( $headers['X-Pingback'] );
		return $headers;
	}

	/**
	 * Issue a 403 for all comments feed requests.
	 * Bad thing, big nono for Google'S crawler. Commented out in _setup_hooks
	 */
	public function filter_query() {
		if ( is_comment_feed() ) {
			wp_die( 'Comments are closed.', '', [ 'response' => 403 ] );
		}
	}

	/**
	 * Remove comment links from the admin bar.
	 */
	public function filter_admin_bar() {
		if ( is_admin_bar_showing() ) {
			remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 ); // WP 3.3.
		}
	}

	/**
	 * Disable support for comments and trackbacks in post types.
	 */
	public function init_wploaded_filters() {
		$post_types = get_post_types();

		foreach ( $post_types as $post_type ) {
			if ( post_type_supports( $post_type, 'comments' ) ) {
				remove_post_type_support( $post_type, 'comments' );
				remove_post_type_support( $post_type, 'trackbacks' );
			}
		}

		// add_filter( 'comments_array', [ $this, 'filter_existing_comments' ], 20, 2 );
		add_filter( 'comments_open', '__return_false', 20, 2 );
		add_filter( 'pings_open', '__return_false', 20, 2 );
	}

	/**
	 * Close comments on the front-end
	 *
	 * @return boolean
	 */
	public function disable_comments_status() {
		return false;
	}

	/**
	 * Hide existing comments
	 *
	 * @param array $comments Array of comments supplied to the comments template.
	 *
	 * @return array
	 */
	public function disable_comments_hide_existing_comments( $comments ) {
		return [];
	}

	/**
	 * Remove comments page in menu
	 *
	 * @return void
	 */
	public function disable_comments_admin_menu() {
		remove_menu_page( 'edit-comments.php' );
		remove_submenu_page( 'options-general.php', 'options-discussion.php' );
	}

	/**
	 * Redirect any user trying to access comments page
	 *
	 * @return void
	 */
	public function disable_comments_admin_menu_redirect() {
		global $pagenow;
		if ( in_array( $pagenow, [ 'edit-comments.php', 'comment.php', 'options-discussion.php' ], true ) ) {
			wp_safe_redirect( admin_url() );
			exit;
		}
	}

	/**
	 * Remove comments metabox from dashboard
	 *
	 * @return void
	 */
	public function disable_comments_dashboard() {
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	}

	/**
	 * Remove comments links from admin bar
	 *
	 * @return void
	 */
	public function disable_comments_admin_bar() {
		if ( is_admin_bar_showing() ) {
			remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
		}
	}

	/**
	 * Remove the comments option from the admin bar.
	 *
	 * @return void
	 */
	public function my_admin_bar_render() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'comments' );
	}
}

Remove_Comments::singleton();
