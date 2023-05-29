<?php
get_header();
/**
 * The template for displaying archive pages.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<main id="content" class="site-main single-serv-container" role="main">

	<?php if ( apply_filters( 'hello_elementor_page_title', true ) ) : ?>
		<header class="page-header">
			<?php
            $archive_title = get_the_archive_title();
			$prefix = __('Archivos:', 'text-domain') . ' ';
			$archive_title = str_replace($prefix, '', $archive_title);
			echo '<h1 class="entry-title" style="text-align:center;">' . $archive_title . '</h1>';
			//the_archive_title( '<h1 class="entry-title">', '</h1>' );
			//the_archive_description( '<p class="archive-description">', '</p>' );
			?>
		</header>
	<?php endif; ?>
	<div class="page-content">
        <div class="services-crud-wrap">
            <div class="um um-directory">
                <div class="um-members-wrapper">
                    <div class="um-members um-members-grid masonry">
                		<?php
                		while ( have_posts() ) {
                			the_post();
                            include crud_plugin_base_PATH.'inc/loop-service.php';
                	    } ?>
                    </div>
                </div>
            </div>
        </div>
	</div>

	<?php wp_link_pages(); ?>

	<?php
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) :
		?>
		<nav class="pagination" role="navigation">
			<?php /* Translators: HTML arrow */ ?>
			<div class="nav-previous"><?php next_posts_link( sprintf( __( '%s older', 'hello-elementor' ), '<span class="meta-nav">&larr;</span>' ) ); ?></div>
			<?php /* Translators: HTML arrow */ ?>
			<div class="nav-next"><?php previous_posts_link( sprintf( __( 'newer %s', 'hello-elementor' ), '<span class="meta-nav">&rarr;</span>' ) ); ?></div>
		</nav>
	<?php endif; ?>
</main>

<?php

get_footer();