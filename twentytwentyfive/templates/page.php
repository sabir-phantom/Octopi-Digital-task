<?php
$args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
);

$products = new WP_Query($args);

if ($products->have_posts()) {
    while ($products->have_posts()) {
        $products->the_post();
        echo '<h2>' . get_the_title() . '</h2>';
        echo '<p>' . get_the_content() . '</p>';
        echo '<a href="' . get_permalink() . '">View Product</a>';
    }
} else {
    echo '<p>No products found.</p>';
}

wp_reset_postdata();
?>