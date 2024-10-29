<?php
require_once('includes/TwitterAPIExchange.php');
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Barebones_Twitter
 * @subpackage Plugin_Name/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Barebones_Twitter
 * @subpackage Plugin_Name/public
 * @author     Your Name <email@example.com>
 */
class Barebones_Twitter_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/barebones-twitter-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/barebones-twitter-public.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Register the shortcodes used
	 */
	public function register_shortcodes(){
		add_shortcode('display_twitter', array($this, 'display_twitter_function'));
	}

	/**
	 * display_twitter shortcode
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function display_twitter_function(){
		$twtrhandle = get_option( 'barebones_twitter_twtrhandle' );
		$twtrcount = get_option( 'barebones_twitter_twtrcount' );
		$oauth_access_token = get_option( 'barebones_twitter_oauth_access_token' );
		$oauth_access_token_secret = get_option( 'barebones_twitter_oauth_access_token_secret' );
		$consumer_key = get_option( 'barebones_twitter_consumer_key' );
		$consumer_secret = get_option( 'barebones_twitter_consumer_secret' );

		//TODO: error check all of the options
		//TODO: include RTs option?

		if(!$twtrcount){
			$twtrcount = 5;
		}

		if(!$oauth_access_token || !$oauth_access_token_secret || !$consumer_key || !$consumer_secret || !$twtrhandle){
			echo "Please enter your Twitter credentials.";
		} else {
			//Twitter access
			$settings = array(
				'oauth_access_token' => $oauth_access_token,
				'oauth_access_token_secret' => $oauth_access_token_secret,
				'consumer_key' => $consumer_key,
				'consumer_secret' => $consumer_secret
			);

			$excludereplies = "0";
			$includerts = "1";
			if(get_option( 'barebones_twitter_includereplies' ) != 1){
				$excludereplies = "1";
			}
			if(get_option( 'barebones_twitter_includerts' ) != 1){
				$includerts = "0";
			}

			//Retrieve the set users timeline
			$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
			$getfield = '?screen_name='.$twtrhandle.'&count='.$twtrcount."&exclude_replies=".$excludereplies."&include_rts=".$includerts;
			$requestMethod = 'GET';
			$twitter = new TwitterAPIExchange($settings);
			$user_timeline= $twitter->setGetfield($getfield)
			             ->buildOauth($url, $requestMethod)
			             ->performRequest();

			//Output the timeline
			$user_timeline = json_decode($user_timeline);
			if(get_option('barebones_twitter_scrolltweets')){
				echo "<div class='bb-tweet-list bb-scroll-tweet-list'><ul>";
			} else {
				echo "<div class='bb-tweet-list'><ul>";
			}
				foreach ($user_timeline as $tweet) {
					//TODO: ReTweets
					//TODO: "Tweeted by"
					$text = $this->link_it($tweet->text);
					$date = strtotime($tweet->created_at);
					echo "<li class='tweet'><div class='tweet_text'>".$text."</div><div class='tweet_dt'>at ".date("h:m d/m/Y", $date)."</div> <div class='tweet_by'>by @<a href='http://twitter.com/".$tweet->user->screen_name."'>".$tweet->user->screen_name."</a></div></li>";
				}
			echo "</ul></div>";
			//print_r($user_timeline);
		}
	}

	/**
	 * Parse links and Twitter items in text
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function link_it($text){
		$text = preg_replace('/https?:\/\/[^\s"<>]+/', '<a href="$0" target="_blank">$0</a>', $text);//URLs
		$text= preg_replace("/@(\w+)/", '<a href="http://www.twitter.com/$1" target="_blank">@$1</a>', $text);//Twitter users
	    $text= preg_replace("/\#(\w+)/", '<a href="http://search.twitter.com/search?q=$1" target="_blank">#$1</a>',$text);//Hashtags etc
		return $text;
	}
}
