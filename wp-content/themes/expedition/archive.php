<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package expedition
 */

get_header(); ?>
	<div class="wrapper page-inner-title">
		<div class="container">
		    <div class="row">
		        <div class="column-md-12 column-sd-12 column-xsd-12">
					<header class="entry-header">
						<?php
							the_archive_title( '<h1 class="entry-title">', '</h1>' );
							the_archive_description( '<div class="taxonomy-description">', '</div>' );
						?>
					</header><!-- .entry-header -->
		        </div>
		    </div>
		</div>
	</div>
	<?php 
	/**
	 * expedition_action_after_title hook
	 * @since Expedition 0.0.2
	 *
	 * @hooked null
	 */
	do_action( 'expedition_action_after_title' );
	?>
	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
			<?php
			if ( have_posts() ) : ?>
				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );
				endwhile;
				the_posts_navigation();
			else :
				get_template_part( 'template-parts/content', 'none' );

			endif; ?>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php get_sidebar(); ?>

	</div>
<?php
get_footer();
