<?php
/**
 * Brizy Starter Theme functions and definitions
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! isset( $content_width ) ) {
	$content_width = 800; // pixels
}

/**
 * Set up theme support
 */
if ( ! function_exists( 'brizy_starter_theme_setup' ) ) {
	function brizy_starter_theme_setup() {
        /**
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Brizy Starter Theme, use a find and replace
         * to change 'brizy-starter-theme' to the name of your theme in all the template files.
         */
        load_theme_textdomain( 'brizy-starter-theme', get_template_directory() . '/languages' );

        /**
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /**
         * Enable support for Post Thumbnails on posts and pages.
         */
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 1568, 9999 );

        register_nav_menus(
            array(
                'menu-1' => __( 'Primary', 'brizy_starter_theme' ),
                'footer' => __( 'Footer Menu', 'brizy_starter_theme' ),
            )
        );

        /**
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            )
        );

        /**
         * Add support for core custom logo.
         */
        add_theme_support(
            'custom-logo',
            array(
                'height'      => 190,
                'width'       => 190,
                'flex-width'  => true,
                'flex-height' => true,
            )
        );
	}
}
add_action( 'after_setup_theme', 'brizy_starter_theme_setup' );

/**
 * Theme Scripts & Styles
 */
if ( ! function_exists( 'brizy_starter_theme_scripts_styles' ) ) {
	function brizy_starter_theme_scripts_styles() {
        wp_enqueue_style( 'brizy-starter-theme-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
	}
}
add_action( 'wp_enqueue_scripts', 'brizy_starter_theme_scripts_styles' );

if ( ! function_exists( 'brizy_starter_theme_post_thumbnail' ) ) :
    /**
     * Displays post thumbnail.
     */
    function brizy_starter_theme_post_thumbnail() {

        if ( is_singular() ) :
            ?>

            <figure class="post-thumbnail">
                <?php the_post_thumbnail(); ?>
            </figure><!-- .post-thumbnail -->

        <?php
        else :
            ?>

            <figure class="post-thumbnail">
                <a class="post-thumbnail-inner" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                    <?php the_post_thumbnail( 'post-thumbnail' ); ?>
                </a>
            </figure>

        <?php
        endif; // End is_singular().
    }
endif;

if ( ! function_exists( 'brizy_starter_theme_entry_footer' ) ) :
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function brizy_starter_theme_entry_footer() {

        // Hide author, post date, category and tag text for pages.
        if ( 'post' === get_post_type() ) {

            // Posted by
            brizy_starter_theme_posted_by();

            // Posted on
            brizy_starter_theme_posted_on();

            $categories_list = get_the_category_list( __( ', ', 'brizy-starter-theme' ) );
            if ( $categories_list ) {
                printf(
                    '<span class="cat-links"><span class="screen-reader-text">%1$s</span>%2$s</span>',
                    __( 'Posted in', 'brizy-starter-theme' ),
                    $categories_list
                );
            }

            $tags_list = get_the_tag_list( '', __( ', ', 'brizy-starter-theme' ) );
            if ( $tags_list ) {
                printf(
                    '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
                    __( 'Tags:', 'brizy-starter-theme' ),
                    $tags_list
                );
            }
        }

        // Comment count.
        if ( ! is_singular() ) {
            brizy_starter_theme_comment_count();
        }
    }
endif;

if ( ! function_exists( 'brizy_starter_theme_posted_by' ) ) :
    /**
     * Prints HTML with meta information about theme author.
     */
    function brizy_starter_theme_posted_by() {
        printf(
            '<span class="byline"><span class="screen-reader-text">%1$s</span><span class="author vcard"><a class="url fn n" href="%2$s">%3$s</a></span></span>',
            __( 'Posted by', 'brizy-starter-theme' ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_html( get_the_author() )
        );
    }
endif;

if ( ! function_exists( 'brizy_starter_theme_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function brizy_starter_theme_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr( get_the_date( DATE_W3C ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( DATE_W3C ) ),
            esc_html( get_the_modified_date() )
        );

        printf(
            '<span class="posted-on"><a href="%1$s" rel="bookmark">%2$s</a></span>',
            esc_url( get_permalink() ),
            $time_string
        );
    }
endif;



if ( ! function_exists( 'brizy_starter_theme_comment_count' ) ) :
    /**
     * Prints HTML with the comment count for the current post.
     */
    function brizy_starter_theme_comment_count() {
        if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
            echo '<span class="comments-link">';

            comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'brizy-starter-theme' ), get_the_title() ) );

            echo '</span>';
        }
    }
endif;
