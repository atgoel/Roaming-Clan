<?php
/**
 * Shortcode [product_carousel] view.
 * For more detailed list see list of shortcode attributes.
 *
 * @var string  $title
 * @var boolean $title_underline
 * @var string  $sub_title
 * @var string  $image_size
 * @var string  $image_size_mobile
 * @var string  $bg_url
 * @var string  $arrow_style
 * @var string  $description_words_limit
 * @var string  $product_category
 * @var string  $product_category_ids
 * @var srging  $product_ids
 * @var strgin  $show
 * @var int     $number
 * @var int     $slides_number
 * @var string  $css_class
 * @var string  $orderby
 * @var string  $order
 * @var string  $view
 * @var array   $items                   collection of products that should be rendered.s
 *
 * @author    Themedelight
 * @package   Themedelight/AdventureTours
 * @version   2.2.0
 */

if ( ! $items ) {
	return;
}

if ( $image_size_mobile && wp_is_mobile() ) {
	$image_size = $image_size_mobile;
}

$element_css_class = 'at-atgrid' .
	( $css_class ? ' ' . $css_class : '' );

$is_wc_older_than_30 = version_compare( WC_VERSION, '3.0.0', '<');
?>
<div class="<?php echo esc_attr( $element_css_class ); ?>">
<?php
	if ( $title || $sub_title ) {
		echo do_shortcode( '[title text="' . addslashes( $title ) . '" subtitle="' . addslashes( $sub_title ) . '" size="big" position="center" decoration="on" underline="' . addslashes( $title_underline ) . '" style="dark"]' );
	}
?>
	<div class="row at-atgrid__slider__container">
		<?php foreach ( $items as $item ) : ?>
		<?php
			$post_id = $item->get_id();
			$item_post = $is_wc_older_than_30 ? $item->post : get_post( $post_id );
			$item_title = $item->get_title();
			$item_url = get_permalink( $post_id );
			$image_html = get_the_post_thumbnail( $post_id, $image_size );
			$price_html = $item->get_price_html();
		?>
			<div class="col-md-4 at-atgrid__item">
				<div class="at-atgrid__item__top">
					<?php printf( '<a href="%s" class="at-atgrid__item__top__image-wrap">%s</a>',
						esc_url( $item_url ),
						$image_html ? $image_html : $placeholder_image
					); ?>
					<?php if ( $price_html ) {
						printf( '<div class="at-atgrid__item__price"><a href="%s" class="at-atgrid__item__price__button">%s</a></div>',
							esc_url( $item_url ),
							$price_html
						);
					} ?>
				</div>

				<div class="at-atgrid__item__content">
					<h3 class="at-atgrid__item__title"><a href="<?php echo esc_url( $item_url ); ?>"><?php echo esc_html( $item_title ); ?></a></h3>
					<div class="at-atgrid__item__description"><?php echo esc_html( $item_post->post_content ); ?></div>
				</div>
			</div>
		<?php endforeach; ?>
	</div><!-- .at-atgrid__slider__container -->
</div><!-- .at-atgrid -->
