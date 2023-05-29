<?php //global $post;
get_header();
/**
 * The template for displaying singular post-types: posts, pages and user-defined custom post types.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

while ( have_posts() ) :
    the_post();
    $post_ID = get_the_ID();
    $user_info = get_userdata(get_the_author_meta( 'ID' ));
    $userName = urlencode(strtolower($user_info->user_login));
    $profilePageID = UM()->options()->get( 'core_user' );
    $coverIMG = get_the_post_thumbnail_url( $post_ID, 'full' );
    $author_id = get_post_field( 'post_author', $post_ID );
    um_fetch_user( $author_id) ;
    $profileURL = um_user_profile_url();

    ?>
<main id="content" <?php post_class( 'site-main single-serv-container' ); ?> role="main">
    <div class="container-service">
        <div class="service-cover" 
        style="background-size: cover; background-position: center;background-image: url(<?php echo $coverIMG; ?>);"></div>
        <div class="services-crud-list-services-el-header">
            <div class="services-crud-categories">
                <?php the_terms($post_ID,'service-category','','',''); ?>
            </div>
            <div class="send-message-service">
                <div>
                Por: <b><a href="<?php echo $profileURL; ?>"><?php the_author_meta( 'display_name' ); ?></a></b>
                </div>
                <?php echo do_shortcode( '[ultimatemember_message_button user_id="' . $author_id . '" class="um-message-button"]' ); ?>
            </div>
        </div>
        <?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
            <header class="page-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </header>
        <?php endif; ?>
        <div class="page-content">
            <?php the_content(); ?>
            <div class="post-tags">
                <?php the_tags( '<span class="tag-links">' . __( 'Tagged ', 'hello-elementor' ), null, '</span>' ); ?>
            </div>
            <?php wp_link_pages(); ?>
        </div>
    </div>
</main>

    <?php
endwhile;

get_footer();