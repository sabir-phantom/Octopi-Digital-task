<?php

get_header();

?>


< class="container">

    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
    <?php the_thumbnail(); ?>
    
    <form>
        <button type="submit">Add to cart</button>
    </form>

</div>

<?php 

get_footer();

?>