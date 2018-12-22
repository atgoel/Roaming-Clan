<?php
/** 
 * The template for displaying the country switcher
 *
 * This template can be overridden by copying it to yourtheme/woocommerce-product-price-based-on-countries/country-selector.php.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/ 
 * @author 		oscargare
 * @version     1.7.7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'wcpbc_manual_country_script' ) ) {

	function wcpbc_manual_country_script() {
		?>
		<form method="post" id="wcpbc-widget-country-switcher-form" class="wcpbc-widget-country-switcher">
			<input type="hidden" name="wcpbc-manual-country" value="" />
		</form>
		<script type="text/javascript">
			jQuery( document ).ready( function( $ ){
				$('body').on('change', 'select.wcpbc-country-switcher', function(){
					var country = $(this).val();
					$('#wcpbc-widget-country-switcher-form input[name="wcpbc-manual-country"]').val(country);
					$('#wcpbc-widget-country-switcher-form').submit();
				} );
			} );	
		</script>
		<?php
	}
}
add_action( 'wp_print_footer_scripts', 'wcpbc_manual_country_script' );


if ( $countries ) : ?>
		
<select class="wcpbc-country-switcher country-switcher">
	<?php foreach ( $countries as $key => $value ) : ?>
		<option value="<?php echo $key; ?>" <?php selected( $key, $selected_country ); ?> ><?php echo $value; ?></option>
	<?php endforeach; ?>
</select>					
	
<?php endif; ?>