<?php
$args = array(
    'post_type'      => 'cricket_bat',
    'posts_per_page' => 10,
);

$loop = new WP_Query($args);

if ($loop->have_posts()) :
    while ($loop->have_posts()) : $loop->the_post();
        ?>
        <div class="cricket-bat-item">
            <h2><?php the_title(); ?></h2>
            <?php if (has_post_thumbnail()) : ?>
                <div class="bat-thumbnail">
                    <?php the_post_thumbnail('medium'); ?>
                </div>
            <?php endif; ?>
            <p><?php the_excerpt(); ?></p>
            <a href="<?php the_permalink(); ?>">View Details</a>
        </div>
        <?php
    endwhile;
else :
    echo '<p>No cricket bats found.</p>';
endif;

wp_reset_postdata();
?>
