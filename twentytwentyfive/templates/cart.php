<?php
global $wpdb;
$user_id = get_current_user_id();
$cart_items = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}cart WHERE user_id = $user_id");

foreach ($cart_items as $item) {
    $product = get_post($item->product_id);
    echo '<p>' . $product->post_title . ' - Quantity: ' . $item->quantity . '</p>';
}

// Add a form for payment or order confirmation
?>