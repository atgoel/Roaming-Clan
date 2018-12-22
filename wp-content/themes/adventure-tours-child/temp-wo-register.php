<?php /* Template Name: woo register */ 

get_header();
?>
<div class="container box">

<div class="registration-box">
<h3 style="text-align:center;">Join Roamingclan For Free</h1>

	

		<form method="post" class="register">

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="registration-row">
					
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" placeholder="Username*" required />
				</p>

			<?php endif; ?>

			<p class="registration-row">
				
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" placeholder="Email Address*" required />
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="registration-row">
					
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" placeholder="Password*" required />
				</p>

			<?php endif; ?>

			<!-- Spam Trap -->
			<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'woocommerce' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php do_action( 'register_form' ); ?>

			<p class="registration-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<input type="submit" class="woocommerce-Button button" name="register" value="Register" align="center" style="height: 45px;line-height: 45px;margin: 0;padding: 0 20px;border: none !important;color: #fff; text-transform: uppercase;background: rgba(237,133,38,0.8) !important;-webkit-transition: all 0.2s ease-in-out;-o-transition: all 0.2s ease-in-out; transition: all 0.2s ease-in-out; ">
			</p>
                        
 			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>
			
<?php echo do_shortcode('[wordpress_social_login]'); ?>
<p class="msg">Already a member?</p>
<div class="button">
<a href="https://roamingclan.com/login-roaming-clan-account/" class="btn btn-info" role="button" text-align="center">LOGIN</a>
</div>
</div>
<?php get_footer(); ?>
</div>

