</div><!-- CONTAINER WRAP END -->
<?php do_action( 'bp_after_container_wrap' ); ?>

</div><!-- CONTAINER END -->
<?php do_action( 'bp_after_container' ); ?>

</div><!-- BODYCONTENT END -->
<?php do_action( 'bp_after_bodycontent' ); ?>

</div><!-- INNERWRAP BODYWRAP END -->
<?php do_action( 'bp_after_bodywrap' ); ?>

</div><!-- WRAPPER MAIN END -->
<?php do_action( 'bp_after_wrapper_main' ); ?>

</div><!-- WRAPPER END -->
<?php do_action( 'bp_after_wrapper' ); ?>

<?php do_action( 'bp_before_footer_top' ) ?>

<?php if ( is_active_sidebar( 'first-footer-widget-area' ) || is_active_sidebar( 'second-footer-widget-area' ) || is_active_sidebar( 'third-footer-widget-area' ) || is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?>

<footer class="footer-top">
<div class="innerwrap">
<div class="ftop">

<div class="footer-container-wrap">

<?php if ( is_active_sidebar( 'first-footer-widget-area' ) ) : ?>
<div class="fbox footer-one">
<div class="widget-area the-icons">
<?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
</div>
</div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'second-footer-widget-area' ) ) : ?>
<div class="fbox wider-cat footer-two">
<div class="widget-area the-icons">
<?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
</div>
</div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'third-footer-widget-area' ) ) : ?>
<div class="fbox footer-three">
<div class="widget-area the-icons">
<?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
</div>
</div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?>
<div class="fbox footer-four">
<div class="widget-area the-icons">
<?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?>
</div>
</div>
<?php endif; ?>

</div>
</div>
</div>

</footer>
<!-- FOOTER TOP END -->
<?php endif; ?>

<?php do_action( 'bp_after_footer_top' ); ?>

<?php do_action( 'bp_before_footer_bottom' ); ?>

<footer class="footer-bottom"<?php do_action('bp_section_footer'); ?>>
<div class="innerwrap">
<div class="fbottom">
<div class="footer-left">
<?php _e('Copyright &copy;', 'mesocolumn'); ?> <?php echo gmdate(__('Y', 'mesocolumn')); ?>. <?php bloginfo('name');?>
<?php do_action( 'bp_footer_left' ); ?>
</div>
<div class="footer-right">
<?php if ( function_exists( 'wp_nav_menu' ) ) { ?><?php wp_nav_menu( array('theme_location' => 'footer','container' => false,'depth' => 1,'fallback_cb' => 'none')); ?><?php } ?>
<?php if( has_nav_menu('footer') ) { echo '<br />'; } ?>
<?php do_action( 'bp_footer_right' ); ?>
</div>
</div>
</div>
</footer>
<!-- FOOTER BOTTOM END -->

<?php do_action( 'bp_after_footer_bottom' ); ?>

</div>
<!-- SECBODY END -->

<?php wp_footer(); ?>

<?php $footer_code = get_theme_option('footer_code'); echo stripcslashes(do_shortcode($footer_code)); ?>

</body>

</html>