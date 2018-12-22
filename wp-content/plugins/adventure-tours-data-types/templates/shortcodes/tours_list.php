<?php
/**
 * Shortcode [tours_list] view list.
 * For more detailed list see list of shortcode attributes.
 *
 * @var string  $title
 * @var boolean $title_underline
 * @var string  $sub_title
 * @var string  $image_size
 * @var string  $image_size_mobile
 * @var string  $btn_more_text           text for more button
 * @var string  $btn_more_link           url address for more button
 * @var string  $description_words_limit limit for words that should be outputed for each item
 * @var string  $tour_category
 * @var string  $tour_category_ids
 * @var boolean $show_categories
 * @var string  $tour_ids
 * @var strgin  $show
 * @var int     $number
 * @var string  $css_class
 * @var string  $orderby
 * @var string  $order
 * @var string  $view
 * @var array   $items                   collection of tours that should be rendered.
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

$is_wc_older_than_30 = version_compare( WC_VERSION, '3.0.0', '<');
?>

<div class="at-atlist<?php if ( $css_class ) echo ' ' . esc_attr( $css_class ); ?>">
<?php echo do_shortcode( '[title text="' . $title . '" subtitle="' . $sub_title . '" size="big" position="center" decoration="on" underline="' . $title_underline . '" style="dark"]' ); ?>
<?php foreach ( $items as $item_index => $item ) : ?>
	<?php
		$item_id = $item->get_id();
		$item_post = $is_wc_older_than_30 ? $item->post : get_post( $item_id );
		$item_title = $item->get_title();
		$permalink = get_permalink( $item_id );
		$thumb_html = get_the_post_thumbnail( $item_id, $image_size );
		$price_html = $item->get_price_html();
	?>
	<div class="at-atlist__item margin-bottom">
		<div class="at-atlist__item__image">
		<?php printf('<a class="at-atlist__item__image-wrap" href="%s">%s</a>',
			esc_url( $permalink ),
			$thumb_html
		); ?>
		</div>
		<div class="at-atlist__item__content">
			<div class="at-atlist__item__content__items">
				<div class="at-atlist__item__content__item">
					<h2 class="at-atlist__item__title"><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $item_title ); ?></a></h2>
					<div class="at-atlist__item__description"><?php echo esc_html( $item_post->post_content ); ?></div>
				</div>
				<div class="at-atlist__item__content__item at-atlist__item__content__item--alternative">
					<?php if ( $price_html ) {
						printf( '<div class="at-atlist__item__price"><a href="%s">%s</a></div>',
							esc_url( $permalink ),
							$price_html
						);
					} ?>
					<div class="at-atlist__item__price-label"><?php esc_html_e( 'per person', 'adventure-tours' ); ?></div>
					<div class="at-atlist__item__read-more"><a href="<?php echo esc_url( $permalink ); ?>" class="atbtn atbtn--small atbtn--rounded atbtn--light"><?php esc_html_e( 'view tour', 'adventure-tours' ); ?></a></div>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>