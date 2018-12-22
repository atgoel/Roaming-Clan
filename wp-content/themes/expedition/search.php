<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package expedition
 */

get_header(); ?>
<div class="wrapper page-inner-title">
	<div class="container">
	    <div class="row">
	        <div class="column-md-12 column-sd-12 column-xsd-12">
				<header class="entry-header">
					<h1 class="entry-title"><?php printf( esc_html__( 'Search Results for: %s', 'expedition' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
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
	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'expedition' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->
	<?php
		get_sidebar();
	?>
</div>
<?php
get_footer();
