<?php

get_header();
?>

<div class="container">

    <h1>Cricket Bats</h1>

    <?php 
    $args = array(
        'post_type' => 'cricket_bat',
        'posts_per_page' => -1
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) : while( $query -> $have_posts() ) : $query -> $the_post();
    ?>

    <div class="product">
        <h2><?php the_title(); ?></h2>
        <?php the_post_thumbnail(); ?>
        <p><?php the_content(); ?></p>

    </div>

    <?php endwhile; endif; ?>

</div>

<?php get_footer(); ?>