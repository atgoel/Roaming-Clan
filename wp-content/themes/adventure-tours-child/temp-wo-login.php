<?php /* Template Name: woo login */ 

get_header(); ?>
<div class="container box">
<h3 style="text-align:center;">Log In To Roamingclan</h1>
<?php
echo do_shortcode('[woocommerce_my_account]');

echo do_shortcode('[wordpress_social_login]');

?>
<p class="msg">Don't have account?</p>

<div class="button">
<a href="https://roamingclan.com/roaming-clan-account/" class="btn btn-info" role="button" text-align="center">JOIN</a>
</div>
<?php get_footer(); ?>

<?php echo do_shortcode('[wordpress_social_login]'); ?>
</div>
