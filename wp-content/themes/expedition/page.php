<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
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
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php
		get_sidebar();
	?>
	
</div>
<?php

get_footer();
