<?php
/**
 * Shortcode [contact_info] view.
 * For more detailed list see list of shortcode attributes.
 *
 * @var string $address
 * @var string $phone
 * @var string $mobile
 * @var string $email
 * @var string $skype
 * @var string $css_class
 * @var string $view
 *
 * @author    Themedelight
 * @package   Themedelight/AdventureTours
 * @version   2.1.1
 */

?>
<div class="at-contact-info<?php if ( ! empty( $css_class ) ) { echo ' ' . esc_attr( $css_class ); }; ?>">
	<?php if ( $address ) { ?>
		<div class="at-contact-info__item">
			<div class="at-contact-info__item__icon"><i class="fa fa-map-marker"></i></div>
			<div class="at-contact-info__item__text"><?php echo esc_html( $address ); ?></div>
		</div>
	<?php } ?>
	<?php if ( $phone ) { ?>
		<div class="at-contact-info__item">
			<div class="at-contact-info__item__icon"><i class="fa fa-phone"></i></div>
			<div class="at-contact-info__item__text"><?php echo esc_html( $phone ); ?></div>
		</div>
	<?php } ?>
	<?php if ( $mobile ) { ?>
		<div class="at-contact-info__item">
			<div class="at-contact-info__item__icon"><i class="fa fa-mobile"></i></div>
			<div class="at-contact-info__item__text"><?php echo esc_html( $mobile ); ?></div>
		</div>
	<?php } ?>
	<?php if ( $email ) { ?>
		<div class="at-contact-info__item">
			<div class="at-contact-info__item__icon"><i class="fa fa-envelope"></i></div>
			<div class="at-contact-info__item__text"><?php echo esc_html( $email ); ?></div>
		</div>
	<?php } ?>
	<?php if ( $skype ) { ?>
		<div class="at-contact-info__item">
			<div class="at-contact-info__item__icon"><i class="fa fa-skype"></i></div>
			<div class="at-contact-info__item__text"><?php echo esc_html( $skype ); ?></div>
		</div>
	<?php } ?>
</div>
