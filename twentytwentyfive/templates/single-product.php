<?php
if (is_user_logged_in()) {
    $product_id = get_the_ID();
    echo '<form method="post">
        <input type="hidden" name="product_id" value="' . $product_id . '">
        <button type="submit" name="add_to_cart">Add to Cart</button>
    </form>';

    if (isset($_POST['add_to_cart'])) {
        global $wpdb;
        $user_id = get_current_user_id();

        $wpdb->insert(
            $wpdb->prefix . 'cart',
            array(
                'user_id' => $user_id,
                'product_id' => $product_id,
            )
        );

        echo '<p>Product added to cart!</p>';
    }
} else {
    echo '<p><a href="/login">Log in</a> to add to cart.</p>';
}
?>