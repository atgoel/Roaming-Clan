<?php
/**
 * Shortcode [tours_grid] view.
 * For more detailed list see list of shortcode attributes.
 *
 * @var string  $title
 * @var boolean $title_underline
 * @var string  $sub_title
 * @var string  $image_size
 * @var string  $image_size_mobile
 * @var string  $btn_more_text           text for more button
 * @var string  $btn_more_link           url address for more button
 * @var string  $price_style             allowed values are: 'default', 'highlighted',
 * @var string  $description_words_limit limit for words that should be outputed for each item
 * @var string  $tour_category
 * @var string  $tour_category_ids
 * @var boolean $show_categories
 * @var string  $tour_ids
 * @var string  $show
 * @var int     $number
 * @var string  $columns
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

// $max_col = wp_is_mobile() ? 2 : 4;
$max_col = 4;

$column_size = !empty( $columns ) ? $columns : $number;
if ( $column_size > $max_col || $column_size < 1 ) {
	$column_size = $max_col;
}

$item_wrapper_class = 'col-md-'.( 12 / $column_size ).' col-xs-6 at-atgrid__item-wrap';

if ( $image_size_mobile && wp_is_mobile() ) {
	$image_size = $image_size_mobile;
}

if ( $column_size > 3 ) {
	if ( $css_class ) {
		$css_class .= ' ';
	}
	$css_class .= 'at-atgrid--small';
}

$is_wc_older_than_30 = version_compare( WC_VERSION, '3.0.0', '<');
?>

<div class="at-atgrid<?php if ( $css_class ) echo ' ' . esc_attr( $css_class ); ?>">
	<?php echo do_shortcode( '[title text="' . $title . '" subtitle="' . $sub_title . '" size="big" position="center" decoration="on" underline="' . $title_underline . '" style="dark"]' ); ?>
	<div class="row at-atgrid__row">
	<?php foreach ( $items as $item_index => $item ) : ?>
		<?php
		$post_id = $item->get_id();
		$item_post = $is_wc_older_than_30 ? $item->post : get_post( $post_id );
		$item_title = $item->get_title();
		$item_url = get_permalink( $post_id );
		$item_title = $item->get_title();
		$image_html = get_the_post_thumbnail( $post_id, $image_size );
		$price_html = $item->get_price_html();

		if ( $item_index > 0 && $item_index % $column_size == 0 ) {
			// echo '</div><div class="row at-atgrid__row">';
			echo '<div class="clearfix hidden-sm hidden-xs"></div>';
		}
		if ( $item_index > 0 && $item_index % 2 == 0 ) {
			echo '<div class="clearfix visible-sm visible-xs"></div>';
		}
		?>
		<div class="<?php echo esc_attr( $item_wrapper_class ); ?>">
			<div class="at-atgrid__item">
				<div class="at-atgrid__item__top">
					<?php printf('<a href="%s" class="at-atgrid__item__top__image">%s</a>',
						esc_url( $item_url ),
						$image_html
					); ?>
					<?php if ( 'highlighted' == $price_style ) { ?>
						<?php
						printf('<a href="%s" class="price-round"><span class="price-round__content">%s</span></a>',
							esc_url( $item_url ),
							$price_html
						);
						?>
					<?php } else { ?>
						<?php if ( $price_html ) {
							printf('<div class="at-atgrid__item__price"><a href="%s" class="at-atgrid__item__price__button">%s</a></div>',
								esc_url( $item_url ),
								$price_html
							);
						} ?>
					<?php } ?>
				</div>
				<div class="at-atgrid__item__content">
					<h3 class="at-atgrid__item__title"><a href="<?php echo esc_url( $item_url ); ?>"><?php echo esc_html( $item_title ); ?></a></h3>
					<div class="at-atgrid__item__description"><?php echo esc_html( $item_post->post_content ); ?></div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
</div>
