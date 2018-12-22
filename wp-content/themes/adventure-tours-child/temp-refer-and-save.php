<?php /* Template Name: refer and save */ 

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

<?php echo "Refer your friends and get a $30 coupon for your next trip when they sign up for a trip."; ?>
	
<?php echo do_shortcode('[WOO_GENS_RAF_ADVANCE guest_text="Text to show when user is not logged in"]');?>

</div>
</div>
</div>
<?php get_footer(); ?>
</div>
