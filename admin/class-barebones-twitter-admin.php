<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Barebones_Twitter
 * @subpackage Barebones_Twitter/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Barebones_Twitter
 * @subpackage Barebones_Twitter/admin
 * @author     Your Name <email@example.com>
 */
class Barebones_Twitter_Admin {
	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'barebones_twitter';

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/barebones-twitter-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/barebones-twitter-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Barebones Twitter Settings', 'barebones-twitter' ),
			__( 'Barebones Twitter', 'barebones-twitter' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);
	}
	/**
	* Render the options page for plugin
	*
	* @since  1.0.0
	*/
	public function display_options_page() {
		include_once 'partials/barebones-twitter-admin-display.php';
	}

	/**
	 * Register all related settings of this plugin
	 *
	 * @since  1.0.0
	 */
	public function register_setting() {
		//General settings
		add_settings_section(
			$this->option_name . '_general',
			__( 'General', 'barebones-twitter' ),
			array( $this, $this->option_name . '_general_cb' ),
			$this->plugin_name
		);

		//Twitter handle
		add_settings_field(
			$this->option_name . '_twtrhandle',
			__( 'Twitter Handle', 'barebones-twitter' ),
			array( $this, $this->option_name . '_twtrhandle_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_twtrhandle' )
		);
		register_setting( $this->plugin_name, $this->option_name . '_twtrhandle');

		//How many Tweets the retrieve (count)
		add_settings_field(
			$this->option_name . '_twtrcount',
			__( 'Tweets to show (e.g. 5)', 'barebones-twitter' ),
			array( $this, $this->option_name . '_twtrcount_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_twtrcount' )
		);
		register_setting( $this->plugin_name, $this->option_name . '_twtrcount');

		//Scroll Tweets
		add_settings_field(
			$this->option_name . '_scrolltweets',
			__( 'Scroll Tweets?', 'barebones-twitter' ),
			array( $this, $this->option_name . '_scrolltweets_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_scrolltweets' )
		);
		register_setting( $this->plugin_name, $this->option_name . '_scrolltweets');

		//Include ReTweets?
		add_settings_field(
			$this->option_name . '_includerts',
			__( 'Include ReTweets?', 'barebones-twitter' ),
			array( $this, $this->option_name . '_includerts_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_includerts' )
		);
		register_setting( $this->plugin_name, $this->option_name . '_includerts');

		//Include replies?
		add_settings_field(
			$this->option_name . '_includereplies',
			__( 'Include Replies?', 'barebones-twitter' ),
			array( $this, $this->option_name . '_includereplies_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_includereplies' )
		);
		register_setting( $this->plugin_name, $this->option_name . '_includereplies');

		//Twitter access section
		add_settings_section(
			$this->option_name . '_access',
			__( 'Twitter API Access', 'barebones-twitter' ),
			array( $this, $this->option_name . '_access_cb' ),
			$this->plugin_name
		);

		//oauth_access_token
		add_settings_field(
			$this->option_name . '_oauth_access_token',
			__( 'OAUTH Access Token', 'barebones-twitter' ),
			array( $this, $this->option_name . '_oauth_access_token_cb' ),
			$this->plugin_name,
			$this->option_name . '_access',
			array( 'label_for' => $this->option_name . '_oauth_access_token' )
		);
		register_setting( $this->plugin_name, $this->option_name . '_oauth_access_token');

		//oauth_access_token_secret
		add_settings_field(
			$this->option_name . '_oauth_access_token_secret',
			__( 'OAUTH Access Token Secret', 'barebones-twitter' ),
			array( $this, $this->option_name . '_oauth_access_token_secret_cb' ),
			$this->plugin_name,
			$this->option_name . '_access',
			array( 'label_for' => $this->option_name . '_oauth_access_token_secret' )
		);
		register_setting( $this->plugin_name, $this->option_name . '_oauth_access_token_secret');

		//consumer_key
		add_settings_field(
			$this->option_name . '_consumer_key',
			__( 'Consumer Key', 'barebones-twitter' ),
			array( $this, $this->option_name . '_consumer_key_cb' ),
			$this->plugin_name,
			$this->option_name . '_access',
			array( 'label_for' => $this->option_name . '_consumer_key' )
		);
		register_setting( $this->plugin_name, $this->option_name . '_consumer_key');

		//consumer_secret
		add_settings_field(
			$this->option_name . '_consumer_secret',
			__( 'Consumer Secret', 'barebones-twitter' ),
			array( $this, $this->option_name . '_consumer_secret_cb' ),
			$this->plugin_name,
			$this->option_name . '_access',
			array( 'label_for' => $this->option_name . '_consumer_secret' )
		);
		register_setting( $this->plugin_name, $this->option_name . '_consumer_secret');
	}

	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function barebones_twitter_general_cb() {
		echo '<p>' . __( 'Please change the settings accordingly.', 'outdated-notice' ) . '</p>';
	}

	/**
	 * Render the radio input field for users Twitter handle
	 *
	 * @since  1.0.0
	 */
	public function barebones_twitter_twtrhandle_cb() {
		$twtrhandle = get_option( $this->option_name . '_twtrhandle' );
		?>
		<input type="text" name="<?php echo $this->option_name . '_twtrhandle' ?>" value="<?php echo $twtrhandle; ?>">
		<?php
	}

	/**
	 * Render the radio input field for the number of Tweets to show
	 *
	 * @since  1.0.0
	 */
	public function barebones_twitter_twtrcount_cb() {
		$twtrcount = get_option( $this->option_name . '_twtrcount' );
		?>
		<input type="text" name="<?php echo $this->option_name . '_twtrcount' ?>" value="<?php echo $twtrcount; ?>">
		<?php
	}

	/**
	 * Render the radio input field for scrolling Tweets
	 *
	 * @since  1.0.0
	 */
	public function barebones_twitter_scrolltweets_cb() {
		$scrolltweets = get_option( $this->option_name . '_scrolltweets' );
		?>
			<fieldset>
				<label>
					<input type="checkbox" name="<?php echo $this->option_name . '_scrolltweets' ?>" id="<?php echo $this->option_name . '_scrolltweets' ?>" value="1" <?php checked( $scrolltweets, '1' ); ?>>
					<?php _e( 'Scroll Tweets', 'barebones-twitter' ); ?>
				</label>
			</fieldset>
		<?php
	}

	/**
	 * Render the radio input field for including retweets
	 *
	 * @since  1.0.0
	 */
	public function barebones_twitter_includerts_cb() {
		$includerts = get_option( $this->option_name . '_includerts' );
		?>
			<fieldset>
				<label>
					<input type="checkbox" name="<?php echo $this->option_name . '_includerts' ?>" id="<?php echo $this->option_name . '_includerts' ?>" value="1" <?php checked( $includerts, '1' ); ?>>
					<?php _e( 'Include ReTweets?', 'barebones-twitter' ); ?>
				</label>
			</fieldset>
		<?php
	}

	/**
	 * Render the radio input field for including replies
	 *
	 * @since  1.0.0
	 */
	public function barebones_twitter_includereplies_cb() {
		$includereplies = get_option( $this->option_name . '_includereplies' );
		?>
			<fieldset>
				<label>
					<input type="checkbox" name="<?php echo $this->option_name . '_includereplies' ?>" id="<?php echo $this->option_name . '_includereplies' ?>" value="1" <?php checked( $includereplies, '1' ); ?>>
					<?php _e( 'Include Replies?', 'barebones-twitter' ); ?>
				</label>
			</fieldset>
		<?php
	}

	/**
	 * Render the radio input field for oauth_access_token
	 *
	 * @since  1.0.0
	 */
	public function barebones_twitter_oauth_access_token_cb() {
		$oauth_access_token = get_option( $this->option_name . '_oauth_access_token' );
		?>
		<input type="text" name="<?php echo $this->option_name . '_oauth_access_token' ?>" value="<?php echo $oauth_access_token; ?>">
		<?php
	}

	/**
	 * Render the radio input field for oauth_access_token_secret
	 *
	 * @since  1.0.0
	 */
	public function barebones_twitter_oauth_access_token_secret_cb() {
		$oauth_access_token_secret = get_option( $this->option_name . '_oauth_access_token_secret' );
		?>
		<input type="text" name="<?php echo $this->option_name . '_oauth_access_token_secret' ?>" value="<?php echo $oauth_access_token_secret; ?>">
		<?php
	}

	/**
	 * Render the radio input field for consumer_key
	 *
	 * @since  1.0.0
	 */
	public function barebones_twitter_consumer_key_cb() {
		$consumer_key = get_option( $this->option_name . '_consumer_key' );
		?>
		<input type="text" name="<?php echo $this->option_name . '_consumer_key' ?>" value="<?php echo $consumer_key; ?>">
		<?php
	}

	/**
	 * Render the radio input field for consumer_secret
	 *
	 * @since  1.0.0
	 */
	public function barebones_twitter_consumer_secret_cb() {
		$consumer_secret = get_option( $this->option_name . '_consumer_secret' );
		?>
		<input type="text" name="<?php echo $this->option_name . '_consumer_secret' ?>" value="<?php echo $consumer_secret; ?>">
		<?php
	}

}
