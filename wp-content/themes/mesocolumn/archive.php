<?php get_header();
$getsinglecat = get_query_var('cat');
if($getsinglecat) {
$singlecat = get_category ($getsinglecat);
$catslug = $singlecat->slug;
$getcategoryslug = get_category_by_slug($catslug);
$cat_id = $getcategoryslug->term_id;
}
?>

<?php do_action( 'bp_before_content' ) ?>

<!-- CONTENT START -->
<div class="content">
<div class="content-inner">

<?php do_action( 'bp_before_blog_home' ) ?>

<!-- POST ENTRY START -->
<div id="post-entry" class="archive_tn_cat_color_<?php echo dez_get_strip_variable($cat_id); ?>">
<div class="post-entry-inner">

<?php do_action( 'bp_before_blog_entry' ); ?>

<?php get_template_part( 'content' ); ?>

<?php get_template_part( 'lib/templates/paginate' ); ?>

<?php do_action( 'bp_after_blog_entry' ); ?>

</div>
</div>
<!-- POST ENTRY END -->

<?php do_action( 'bp_after_blog_home' ) ?>

</div><!-- CONTENT INNER END -->
</div><!-- CONTENT END -->

<?php do_action( 'bp_after_content' ) ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>