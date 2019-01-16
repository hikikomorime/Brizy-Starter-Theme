<?php
/**
 * Template part for displaying posts
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="page-header">
        <h1 class="page-title"><?php the_title(); ?></h1>
    </header>

    <div class="page-content">
        <div class="site-featured-image">
            <?php brizy_starter_theme_post_thumbnail(); ?>
        </div>

        <?php the_content(); ?>


    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php brizy_starter_theme_entry_footer(); ?>
    </footer><!-- .entry-footer -->

</article><!-- #post-${ID} -->
