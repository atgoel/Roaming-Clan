<?php
/**
 * Shortcode [tour_reviews] view.
 * For more detailed list see list of shortcode attributes.
 *
 * @var string  $title
 * @var boolean $title_underline
 * @var string  $number
 * @var string  $words_limit
 * @var array   $reviews
 * @var string  $view
 *
 * @author    Themedelight
 * @package   Themedelight/AdventureTours
 * @version   2.1.3
 */

if ( ! $reviews ) {
	return;
}
?>
<div class="at-tour-reviews<?php if ( $css_class ) { echo esc_attr( ' ' . $css_class ); } ?>">
<?php if ( $title ) {
	echo do_shortcode( '[title text="' . $title . '" subtitle="" size="small" position="center" decoration="on" underline="' . $title_underline . '" style="dark"]' );
} ?>
<?php foreach ( $reviews as $review ) { ?>
	<div class="at-tour-reviews__item">
		<div class="at-tour-reviews__item__image-wrap"><?php echo get_avatar( $review->user_id > 0 ? $review->user_id : $review->comment_author_email, 95 ); ?></div>
		<div class="at-tour-reviews__item__info">
			<div class="at-tour-reviews__item__info__name"><?php echo esc_html( $review->comment_author ); ?></div>
			<h3 class="at-tour-reviews__item__title"><a href="<?php echo esc_url( get_permalink( $review->comment_post_ID ) ); ?>"><?php echo esc_html( $review->post_title ); ?></a></h3>
		</div>
		<div class="at-tour-reviews__item__description"><?php echo apply_filters('comment_text', $review->comment_content ); ?></div>
	</div>
<?php } ?>
</div>
