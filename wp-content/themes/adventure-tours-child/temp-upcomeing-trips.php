<?php /* Template Name: upcomeing trips */ 

get_header(); ?>

<div class="woocommerce">
<nav class="woocommerce-MyAccount-navigation">
	<ul>
			<li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--Refer_and_save">
				<a href="https://roamingclan.com/refer-and-save/">Refer And Save</a>
			</li>
			<li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--your_travel_blog">
				<a href="https://roamingclan.com/your-travel-blog/">Your Travel Blog</a>
			</li>

			<li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--upcoming_trips">
				<a href="http://roamingclan.com/upcomeing-trips/">Upcoming Trips</a>
			</li>
			<li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-account">
				<a href="https://roamingclan.com/roamingclan-my-account/edit-account/">Account details</a>
			</li>
                        	
	</ul>
</nav>

<div class="woocommerce-MyAccount-content">

<?php
    // TO SHOW THE PAGE CONTENTS
    while ( have_posts() ) : the_post(); ?> <!--Because the_content() works only inside a WP Loop -->
        <div class="entry-content-page">
            <?php the_content(); ?> <!-- Page Content -->
        </div><!-- .entry-content-page -->

    <?php
    endwhile; //resetting the page loop
    wp_reset_query(); //resetting the page query
?>
</div>
</div>
<?php get_footer(); ?>
</div>
