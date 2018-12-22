<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package expedition
 */

get_header(); ?>

<div class="wrapper page-inner-title">
	<div class="container">
	    <div class="row">
	        <div class="column-md-12 column-sd-12 column-xsd-12">
				<header class="entry-header">
					<h1 class="entry-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'expedition' ); ?></h1>
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
<div id="content" class="site-content page404 container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
					<section class="error-404 not-found">
						<div class="page-content">
							<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'expedition' ); ?></p>
							<?php
								get_search_form();
								the_widget( 'WP_Widget_Recent_Posts' );
								// Only show the widget if site has multiple categories.
								if ( expedition_categorized_blog() ) :
							?>

							<div class="widget widget_categories">
								<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'expedition' ); ?></h2>
								<ul>
								<?php
									wp_list_categories( array(
										'orderby'    => 'count',
										'order'      => 'DESC',
										'show_count' => 1,
										'title_li'   => '',
										'number'     => 10,
									) );
								?>
								</ul>
							</div><!-- .widget -->

							<?php
								endif;
								/* translators: %1$s: smiley */
								$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'expedition' ), convert_smilies( ':)' ) ) . '</p>';
								the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
								the_widget( 'WP_Widget_Tag_Cloud' );
							?>

						</div><!-- .page-content -->
					</section><!-- .error-404 -->

				</main><!-- #main -->
			</div><!-- #primary -->
		</div>
	</div>
</div>

<?php
get_footer();
