<?php
/**
 * Shortcode [tour_search_form] view.
 * For more detailed list see list of shortcode attributes.
 *
 * @var string  $title
 * @var string  $note
 * @var string  $css_class
 * @var boolean $hide_text_feild
 * @var string  $view
 *
 * @author    Themedelight
 * @package   Themedelight/AdventureTours
 * @version   1.1.2
 */

?>
<div class="at-form-block block-after-indent<?php if ( $css_class ) { echo esc_attr( ' ' . $css_class ); } ?>">
<?php if ( $title ) { ?>
	<h3 class="at-form-block__title"><?php echo esc_html( $title ); ?></h3>
<?php } ?>

<?php if ( $note ) { ?>
	<div class="at-form-block__description"><?php echo esc_html( $note ); ?></div>
<?php } ?>
	<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div class="at-form-block__item at-form-block__field-width-icon">
			<input type="text" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'adventure-tours-data-types' ); ?>" value="<?php echo get_search_query(); ?>" name="s">
		</div>
		<input class="at-form-block__button" type="submit" value="<?php esc_attr_e( 'Search', 'adventure-tours-data-types' ); ?>">
	</form>
</div>
