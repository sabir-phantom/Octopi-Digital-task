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
function cricket_shop_registration_form() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_user'])) {
        $username = sanitize_text_field($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);

        $user_id = wp_create_user($username, $password, $email);

        if (!is_wp_error($user_id)) {
            echo '<p>Registration successful. Please <a href="/login">log in</a>.</p>';
        } else {
            echo '<p>Error: ' . $user_id->get_error_message() . '</p>';
        }
    }

    ob_start();
    ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="register_user">Register</button>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('cricket_shop_registration', 'cricket_shop_registration_form');

// Login form

function cricket_shop_login_form() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_user'])) {
        $credentials = array(
            'user_login' => $_POST['username'],
            'user_password' => $_POST['password'],
            'remember' => true,
        );

        $user = wp_signon($credentials, false);

        if (!is_wp_error($user)) {
            wp_redirect(home_url()); // Redirect to the home page after successful login
            exit;
        } else {
            echo '<p>Error: ' . $user->get_error_message() . '</p>';
        }
    }

    ob_start();
    ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login_user">Login</button>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('cricket_shop_login', 'cricket_shop_login_form');


// Creating custom db
function create_cart_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'cart';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_setup_theme', 'create_cart_table');

// DB for purchase history
function create_orders_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'orders';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        product_id INT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_setup_theme', 'create_orders_table');

// order history for logged-in users

global $wpdb;
$user_id = get_current_user_id();
$orders = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}orders WHERE user_id = $user_id");

foreach ($orders as $order) {
    $product = get_post($order->product_id);
    echo '<p>Order ID: ' . $order->id . ' - ' . $product->post_title . ' - ' . $order->created_at . '</p>';
}


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