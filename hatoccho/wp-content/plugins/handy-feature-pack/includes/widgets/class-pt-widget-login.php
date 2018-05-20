<?php /* Plumtree AJAX Login/Register */

if ( ! defined( 'ABSPATH' ) ) exit;

class pt_login_widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'pt_login_widget', // Base ID
			__('Handy Login/Register', 'handy-feature-pack'), // Name
			array('description' => __( "Handy special widget. An AJAX Login/Register form for your site.", 'handy-feature-pack' ), )
		);
	}

	public function form($instance) {
		$defaults = array(
			'title' => 'Log In',
			'inline' => false,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title: ', 'handy-feature-pack' ) ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("inline"); ?>" name="<?php echo $this->get_field_name("inline"); ?>" <?php checked( (bool) $instance["inline"] ); ?> />
			<label for="<?php echo $this->get_field_id("inline"); ?>"><?php _e( 'Show in line?', 'handy-feature-pack' ); ?></label>
		</p>
	<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['inline'] = $new_instance['inline'];

		return $instance;
	}

	public function widget($args, $instance) {
		extract($args);

		$title = apply_filters('widget_title', $instance['title'] );
		$inline = ( isset($instance['inline']) ? $instance['inline'] : false );

		echo $before_widget;
		if ($title) { echo $before_title . $title . $after_title; }
		?>

		<?php if ( is_user_logged_in() ) { ?>
			<?php if ($inline) { ?>
				<?php if ( class_exists('WooCommerce') ) : ?>
					<a class="login_button inline" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','handy-feature-pack'); ?>"><i class="fa fa-home"></i><?php _e('My Account','handy-feature-pack'); ?></a>
				<?php endif; ?>
				<a class="login_button inline" href="<?php echo wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ); ?>" title="<?php _e('Log out of this account', 'handy-feature-pack');?>"><i class="fa fa-sign-out"></i><?php _e('Log out', 'handy-feature-pack');?></a>
			<?php } else { ?>
				<p class="logged-in-as">
					<?php $current_user = wp_get_current_user(); ?>
					<?php printf( __( 'Hello <strong>%1$s</strong>.', 'handy-feature-pack' ),
						$current_user->display_name); ?>
				</p>
				<a class="login_button" href="<?php echo wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ); ?>" title="<?php _e('Log out of this account', 'handy-feature-pack');?>"><?php _e('Log out', 'handy-feature-pack');?><i class="fa fa-angle-right"></i></a>
				<?php if ( class_exists('WooCommerce') ) : ?>
					<a class="login_button" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','handy-feature-pack'); ?>"><?php _e('My Account','handy-feature-pack'); ?><i class="fa fa-angle-right"></i></a>
				<?php endif; ?>
			<?php } } else { ?>

			<form id="login" class="ajax-auth" method="post">
				<h3><?php _e('New to site? ', 'handy-feature-pack');?><a id="pop_signup" href=""><?php _e('Create an Account', 'handy-feature-pack');?></a></h3>
				<h1><?php _e('Login', 'handy-feature-pack');?></h1>
				<p class="status"></p>
				<?php wp_nonce_field('ajax-login-nonce', 'security'); ?>
				<p>
					<label for="username"><?php _e('Username', 'handy-feature-pack');?><span class="required">*</span></label>
					<input id="username" type="text" class="required" name="username" required aria-required="true">
				</p>
				<p>
					<label for="password"><?php _e('Password', 'handy-feature-pack');?><span class="required">*</span></label>
					<input id="password" type="password" class="required" name="password" required aria-required="true">
				</p>
				<input class="submit_button" type="submit" value="<?php esc_html_e('Login', 'handy-feature-pack'); ?>">
				<a class="text-link" href="<?php echo wp_lostpassword_url(); ?>"><?php _e('Lost password?', 'handy-feature-pack');?></a>
				<a class="close" href=""><?php _e('(close)', 'handy-feature-pack');?></a>
				<?php if ( function_exists('oa_social_login_render_login_form') ) {
					echo '<div class="social-networks-login">';
					do_action('oa_social_login');
					echo '</div>';
				} ?>
			</form>

			<form id="register" class="ajax-auth" method="post">
				<h3><?php _e('Already have an account? ', 'handy-feature-pack');?><a id="pop_login"  href=""><?php _e('Login', 'handy-feature-pack');?></a></h3>
				<h1><?php _e('Signup', 'handy-feature-pack');?></h1>
				<p class="status"></p>
				<?php wp_nonce_field('ajax-register-nonce', 'signonsecurity'); ?>
				<p>
					<label for="signonname"><?php _e('Username', 'handy-feature-pack');?><span class="required">*</span></label>
					<input id="signonname" type="text" name="signonname" class="required" required aria-required="true" pattern="<?php echo apply_filters('register_form_username_pattern', '[a-zA-Z0-9 ]+'); ?>" title="<?php esc_html_e('Digits and Letters only.', 'handy-feature-pack'); ?>">
				</p>
				<p>
					<label for="email"><?php _e('Email', 'handy-feature-pack');?><span class="required">*</span></label>
					<input id="email" type="text" class="required email" name="email" required aria-required="true">
				</p>
				<p>
					<label for="signonpassword"><?php _e('Password', 'handy-feature-pack');?><span class="required">*</span></label>
					<input id="signonpassword" type="password" class="required" name="signonpassword" required aria-required="true">
				</p>
				<?php // Apply to become a vendor
				if ( class_exists('WC_Vendors') && class_exists( 'WooCommerce' ) ) :
					if ( WC_Vendors::$pv_options->get_option( 'show_vendor_registration' ) ) :
						$terms_page = WC_Vendors::$pv_options->get_option( 'terms_to_apply_page' ); ?>
						<input class="input-checkbox" id="apply_for_vendor_widget" <?php checked( isset( $_POST[ 'apply_for_vendor_widget' ] ), true ) ?> type="checkbox" name="apply_for_vendor_widget" value="1"/>
						<label for="apply_for_vendor_widget" class="checkbox-label">
							<?php echo apply_filters('wcvendors_vendor_registration_checkbox', __( 'Apply to become a vendor? ', 'handy-feature-pack' )); ?>
						</label>
					<?php if ( $terms_page && $terms_page !='' ) : ?>
						<p class="agree-to-terms" style="display:none">
							<input class="input-checkbox" id="agree_to_terms_widget" <?php checked( isset( $_POST[ 'agree_to_terms_widget' ] ), true ) ?> type="checkbox" name="agree_to_terms_widget" value="1"/>
							<label for="agree_to_terms_widget" class="checkbox-label">
								<?php printf( __( 'I have read and accepted the <a target="_blank" href="%s">terms and conditions</a>', 'handy-feature-pack' ), get_permalink( $terms_page ) ); ?>
							</label>
						</p>
					<?php  endif; ?>
						<script type="text/javascript">
							jQuery(function () {
								if (jQuery('#apply_for_vendor_widget').is(':checked')) {
									jQuery('.agree-to-terms').show();
								}
								jQuery('#apply_for_vendor_widget').on('click', function () {
									jQuery('.agree-to-terms').slideToggle();
								});
							})
						</script>
					<?php endif; ?>
				<?php endif; ?>
				<input class="submit_button" type="submit" value="<?php esc_html_e('Register', 'handy-feature-pack'); ?>">
				<a class="close" href="#"><?php _e('(close)', 'handy-feature-pack');?></a>
			</form>

			<?php if ($inline) { ?>
				<a class="login_button inline" id="show_login" href=""><i class="fa fa-user"></i><?php _e('Login', 'handy-feature-pack'); ?></a>
				<a class="login_button inline" id="show_signup" href=""><i class="fa fa-pencil"></i><?php _e('Register', 'handy-feature-pack'); ?></a>
			<?php } else { ?>
				<p class="welcome-msg">
					<?php _e( 'Welcome to our store!', 'handy-feature-pack' ); ?>
				</p>
				<a class="login_button" id="show_login" href=""><?php _e('Login', 'handy-feature-pack'); ?><i class="fa fa-angle-right"></i></a>
				<a class="login_button" id="show_signup" href=""><?php _e('Register', 'handy-feature-pack'); ?><i class="fa fa-angle-right"></i></a>

			<?php } } ?>

		<?php
		echo $after_widget;
	}

}
