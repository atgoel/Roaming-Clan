<?php
/**
 * Shortcode [mailchimp_form] view.
 * For more detailed list see list of shortcode attributes.
 *
 * @var string $form_id
 * @var string $title
 * @var string $css_class
 * @var string $width_mode
 * @var string $bg_url
 * @var string $bg_repeat
 * @var string $view
 * 
 * @var string $mailchimp_list_id // to support 5.4.X
 * @var string $button_text
 *
 * @author    Themedelight
 * @package   Themedelight/AdventureTours
 * @version   1.0.8
 */

$is_modern_plugin = shortcode_exists( 'yikes-mailchimp' );

$is_missed_config = $is_modern_plugin ? empty( $form_id ) : empty( $mailchimp_list_id );
if ( $is_missed_config ) {
	printf( '<div class="form-subscribe"><div class="form-subscribe__shadow"></div>%s</div>',
		esc_html__( 'Please enter the MailChimp List ID settings in the MailChimp Form [mailchimp_form] shortcode.', 'adventure-tours-data-types' )
	);
	return;
}

?>
<div class="at-form-subscribe parallax-section <?php echo esc_attr( $css_class ); ?>">
<?php
	if ( $title ) {
		printf( '<div class="at-form-subscribe__title">%s</div>', esc_html( $title ) );
	}
	if ( $content ) { 
		printf( '<div class="at-form-subscribe__description">%s</div>', esc_html( $content ) );
	} 
	printf( '<div>%s</div>',
		do_shortcode( '[yks-mailchimp-list id="' . $mailchimp_list_id . '" submit_text="' . $button_text . '"] ' )
	);

	if ( $is_modern_plugin ) { // version 6.0.X
		printf( '<div>%s</div>',
			do_shortcode( '[yikes-mailchimp form="' . $form_id . '" submit="' . esc_html( $button_text ) . '"]' )
		);
	} else { // version 5.4.X
		printf( '<div>%s</div>',
			do_shortcode( '[yks-mailchimp-list id="' . $mailchimp_list_id . '" submit_text="' . esc_html( $button_text ) . '"] ' )
		);
	}
?>
</div>