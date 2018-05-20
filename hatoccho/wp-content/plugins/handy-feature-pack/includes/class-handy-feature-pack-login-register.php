<?php

/* Enqueue scripts & styles */
function pt_login_scripts() {

	wp_enqueue_script( 'pt-ajax-auth',  HANDY_FEATURE_PACK_URL . '/public/js/ajax-auth.js', array('jquery'), '1.0', true );

  wp_localize_script( 'pt-ajax-auth', 'ajax_auth_object', array(
    'ajaxurl' => admin_url( 'admin-ajax.php' ),
    'loadingmessage' => __('Sending user info, please wait...', 'handy-feature-pack')
  ));

  // Enable the user with no privileges to run ajax_login() in AJAX
  add_action( 'wp_ajax_nopriv_ajaxlogin', 'pt_ajax_login' );
	// Enable the user with no privileges to run ajax_register() in AJAX
	add_action( 'wp_ajax_nopriv_ajaxregister', 'pt_ajax_register' );
}

add_action('init', 'pt_login_scripts');

function pt_ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
  	// Call auth_user_login
		pt_auth_user_login($_POST['username'], $_POST['password'], __('Login', 'handy-feature-pack'), false);

    die();
}

function pt_registration_handle($username, $email, $password, $become_vendor, $terms) {
    $errors = new WP_Error();
    if ( get_user_by( 'login', $username ) ) {
        $errors->add( 'login_exists', __('This username is already registered.', 'handy-feature-pack') );
    }
    if ( get_user_by( 'email', $email ) ) {
        $errors->add( 'email_exists', __('This email address is already registered.', 'handy-feature-pack') );
    }
    if ( class_exists('WCV_Vendors') && class_exists( 'WooCommerce' ) && $become_vendor == 1 ) {
        $terms_page = WC_Vendors::$pv_options->get_option( 'terms_to_apply_page' );
        if ( $terms_page && $terms_page!='' && $terms=='' ) {
            $errors->add( 'must_accept_terms', __('You must accept the terms and conditions to become a vendor.', 'handy-feature-pack') );
        }
    }
    $err_var = $errors->get_error_codes();
    if ( ! empty( $err_var ) )
        return $errors;
}

function pt_ajax_register(){
    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-register-nonce', 'security' );

    // Check for errors before creating new user
    $user_check = pt_registration_handle($_POST['username'],$_POST['email'],$_POST['password'],$_POST['become_vendor'],$_POST['accept_terms']);
    if ( is_wp_error($user_check) ){
        $error  = $user_check->get_error_codes() ;

        if(in_array('login_exists', $error))
            echo json_encode(array('loggedin'=>false, 'message'=> ($user_check->get_error_message('login_exists'))));
        elseif(in_array('email_exists',$error))
            echo json_encode(array('loggedin'=>false, 'message'=> ($user_check->get_error_message('email_exists'))));
        elseif(in_array('must_accept_terms',$error))
        echo json_encode(array('loggedin'=>false, 'message'=> ($user_check->get_error_message('must_accept_terms'))));
    } else {
    		// Nonce is checked, get the POST data and sign user on
        $info = array();
        $info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user($_POST['username']) ;
        $info['user_pass'] = sanitize_text_field($_POST['password']);
        $info['user_email'] = sanitize_email( $_POST['email']);

    		// Register the user
        $user_register = wp_insert_user( $info );

				$become_a_vendor = false;
        if ( class_exists('WC_Vendors') && $_POST[ 'become_vendor' ] == 1 ) {
						$become_a_vendor = true;
        }

				// Notify admin and user about Registration
    		$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

		    $message  = sprintf( esc_html__('New user registration on your site %s:', 'handy-feature-pack'), $blogname) . "\r\n\r\n";
		    $message .= sprintf( esc_html__('Username: %s', 'handy-feature-pack'), $info['user_login'] ) . "\r\n\r\n";
		    $message .= sprintf( esc_html__('Email: %s', 'handy-feature-pack'), $info['user_email'] ) . "\r\n";

    		@wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration', 'handy-feature-pack'), $blogname), $message);

				$message  = esc_html__('Hi there,', 'handy-feature-pack') . "\r\n\r\n";
        $message .= sprintf(esc_html__("Welcome to %s! Here's how to log in:", 'handy-feature-pack'), $blogname) . "\r\n\r\n";
        $message .= wp_login_url() . "\r\n";
        $message .= sprintf(esc_html__('Username: %s', 'handy-feature-pack'), $info['user_login']) . "\r\n";
        $message .= sprintf(esc_html__('Password: %s', 'handy-feature-pack'), $info['user_pass']) . "\r\n\r\n";
        $message .= sprintf(esc_html__('If you have any problems, please contact me at %s.', 'handy-feature-pack'), get_option('admin_email')) . "\r\n\r\n";
        $message .= esc_html__('This is an automatically generated email, please do not reply!', 'handy-feature-pack');

				if ( !$become_a_vendor ) {
        	wp_mail($info['user_email'], sprintf(esc_html__('[%s] Your username and password', 'handy-feature-pack'), $blogname), $message);
				}

    		// Login to new account
        pt_auth_user_login($info['nickname'], $info['user_pass'], __('Registration', 'handy-feature-pack'), $become_a_vendor);
    }
    die();
}

function pt_auth_user_login($user_login, $password, $login, $become_a_vendor) {
	$info = array();
  $info['user_login'] = $user_login;
  $info['user_password'] = $password;
  $info['remember'] = true;

	$secure_cookie = false;
	if ( ( !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ) || $_SERVER['SERVER_PORT'] == 443 ) {
		$secure_cookie = true;
	}
	elseif ( ( !empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) || ( !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on' ) ) {
		$secure_cookie = true;
	}

	$user_signon = wp_signon( $info, $secure_cookie );
    if ( is_wp_error($user_signon) ){
			echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.', 'handy-feature-pack')));
    } else {
			wp_set_current_user($user_signon->ID);
			$redirect_url = get_home_url();
			if ( class_exists( 'Woocommerce' ) ) {
				$redirect_url = get_permalink( get_option('woocommerce_myaccount_page_id') );
			}
			if ( class_exists( 'WC_Vendors') && $become_a_vendor == true ) {
				$redirect_url = get_permalink( WC_Vendors::$pv_options->get_option( 'vendor_dashboard_page' ) );
			}
			if ( class_exists( 'WCVendors_Pro') && $become_a_vendor == true ) {
				$redirect_url = WCVendors_Pro_Dashboard::get_dashboard_page_url() . '?terms=1';
			}
      echo json_encode(array('loggedin'=>true, 'redirect_url'=>apply_filters('handy-redirect-url-after-register', $redirect_url), 'message'=>$login.__(' successful, redirecting...', 'handy-feature-pack')));
    }

	die();
}
