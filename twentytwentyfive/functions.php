<?php
/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'twentytwentyfive_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'twentytwentyfive_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_editor_style() {
		add_editor_style( get_parent_theme_file_uri( 'assets/css/editor-style.css' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 'twentytwentyfive_enqueue_styles' ) ) :
	/**
	 * Enqueues style.css on the front.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_enqueue_styles() {
		wp_enqueue_style(
			'twentytwentyfive-style',
			get_parent_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'twentytwentyfive_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'twentytwentyfive_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfive' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'twentytwentyfive_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfive_page',
			array(
				'label'       => __( 'Pages', 'twentytwentyfive' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfive' ),
			)
		);

		register_block_pattern_category(
			'twentytwentyfive_post-format',
			array(
				'label'       => __( 'Post formats', 'twentytwentyfive' ),
				'description' => __( 'A collection of post format patterns.', 'twentytwentyfive' ),
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'twentytwentyfive_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_register_block_bindings() {
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive' ),
				'get_value_callback' => 'twentytwentyfive_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'twentytwentyfive_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function twentytwentyfive_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;

?>

<?php
// **Cricket Bat Shop (ecommerce)** //

// Registration form 
function user_registration_form(){
	ob_start();
	echo "Registration form function is called...";
	if( is_user_logged_in() ) {
		ob_end_flush();
		return;
	}
	?>

	<form method="post" action="">
		<input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="register" value="Register">
	</form>
	
	<?php
	if( isset( $_POST['register']) ) {
		$username = sanitize_user( $_POST['username'] );
        $password = sanitize_text_field( $_POST['password'] );

		$user_id = wp_create_user( $username, $password);

		if ( !is_wp_error($user_id) ) {
			// wp_set_auth_cookie($user_id);
			wp_redirect( home_url() );
			exit;
		} else {
			echo 'Registration failed';
			}
	}
	ob_end_flush();
}
add_shortcode( 'registration_form', 'user_registration_form');

// Login form

function user_login_form(){
	if( is_user_logged_in() ) {
		return;
	}
	?>
	
	<form method="post" action="">
        <input type="text" name="log" placeholder="Username" required>
        <input type="password" name="pwd" placeholder="Password" required>
        <input type="submit" name="wp-submit" value="Login">
    </form>
	<?php
}

add_shortcode( 'login_form', 'user_login_form');



// Product management

function create_bat_post_type() {
	$labels = array (
		'name' => _x( 'Cricket Bats', 'Post Type General Name', 'Text' ),
		'singular_name' => _x( 'Cricket Bat', 'Post Type Singular Name', 'Text' ),
	);
	$args = array(
		'label' => __( 'Cricket Bats', 'Text' ),
		'description' => __( 'Cricket Bats', 'Text' ),
		'labels' => $labels,
		'taxomonies' =>	array( 'category' ),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
	);
	register_post_type( 'cricket_bat', $args );

}

add_action( 'init', 'create_bat_post_type' );


function add_bat_id_meta_box() {
	add_meta_box(
		'bat_id', //id
		__( 'Bat ID', 'text' ), //title
		'display_product_id_meta_box', //callback
		'cricket_bat', //screen
		'normal', //context
		'default', //priority
	);	
}
add_action( 'add_meta_boxes', 'add_bat_id_meta_box' );

function display_product_id_meta_box( $post ) {
	?>
	<div>
		<label for="bat_id">Bat ID:</label>
		<input type="text" name="bat_id" id="bat_id" value="">
	</div>
	<?php
}

// add to cart

function add_to_cart($product_id){
	if ( isset($_SESSION['cart']) ) {
		if(in_array($product_id, $_SESSION['cart'])){
			return;
		} 
		else {
			$_SESSION['cart'][] = $product_id; 
		}
	}
	else {
		$_SESSION['cart'] = array($product_id);
		}
}


// Purchase history

function get_purchase_history(){
	global $wpdb;

	$current_user_id = get_current_user_id();

	$query = $wpdb->prepare(
		"SELECT * FROM $wpdb->prefix . 'cricket_bat_purchase_history' WHERE 
		user_id = %d
		ORDER BY purchase_date DESC",
		$current_user_id
	);
	$results = $wpdb->get_results($query);
	
	return $results;
}