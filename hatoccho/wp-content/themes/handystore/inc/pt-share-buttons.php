<?php
/*
 * Handy Share buttons System
 */

class ptShareButtons {

	public function getAll() {
		$included_socialnets = handy_get_option('share_networks');
		foreach ($included_socialnets as $soc_net => $value) {
			if ($value === '1') {
				$button_array[] = self::buildSocialButton($soc_net);
			}
		}
		return '<div class="social-links"><span>'. apply_filters( 'handy_share_btns_welcome_text', esc_html__('Share this:', 'handystore') ) .'</span>'.implode('', $button_array).'</div>';
	}

	private function buildSocialButton($soc_net) {
		$charmap = array(
			'facebook' => 'facebook',
			'twitter' => 'twitter',
			'pinterest' => 'pinterest',
			'google' => 'google-plus',
			'mail' => 'envelope',
			'linkedin' => 'linkedin',
			'vk' => 'vk',
			'tumblr' => 'tumblr',
		);
		$titlemap = array(
			'facebook' => esc_html__('Share this article on Facebook', 'handystore'),
			'twitter' => esc_html__('Share this article on Twitter', 'handystore'),
			'pinterest' => esc_html__('Share an image on Pinterest', 'handystore'),
			'google' => esc_html__('Share this article on Google+', 'handystore'),
			'mail' => esc_html__('Email this article to a friend', 'handystore'),
			'linkedin' => esc_html__('Share this article on LinkedIn', 'handystore'),
			'vk' => esc_html__('Share this article on Vkontakte', 'handystore'),
			'tumblr' => esc_html__('Share this article on Tumblr', 'handystore'),
		);

		return '<div class="pt-post-share" data-service="'.esc_attr($soc_net).'" data-postID="'.get_the_ID().'">
					<a href="'.$this->getSocialUrl($soc_net).'" target="_blank">
						<i class="fa fa-'.esc_attr($charmap[$soc_net]).'" title="'.esc_attr($titlemap[$soc_net]).'"></i>
					</a>
					<span class="sharecount">('.esc_html($this->getShareCount($soc_net)).')</span>
				</div>';
	}

	private function getSocialUrl($soc_net) {
		global $post;
		if (class_exists('Woocommerce') && is_product()) {
			$text = urlencode( __("A great product: ", 'handystore').$post->post_title );
		} else {
			$text = urlencode( __("A great post: ", 'handystore').$post->post_title);
		}
		$escaped_url = urlencode(get_permalink());
		$image = has_post_thumbnail( $post->ID ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' ) : '';

		switch ($soc_net) {
			case "twitter" :
				$api_link = 'https://twitter.com/intent/tweet?source=webclient&amp;original_referer='.$escaped_url.'&amp;text='.esc_attr($text).'&amp;url='.$escaped_url;
				break;

			case "facebook" :
				$api_link = 'https://www.facebook.com/sharer/sharer.php?u='.$escaped_url;
				break;

			case "google" :
				$api_link = 'https://plus.google.com/share?url='.$escaped_url;
				break;

			case "pinterest" :
				if (isset($image) && $image != '') {
					$api_link = 'http://pinterest.com/pin/create/bookmarklet/?media='.esc_url($image[0]).'&amp;url='.$escaped_url.'&amp;title='.esc_attr(get_the_title()).'&amp;description='.esc_html( $post->post_excerpt );
				}
				else {
					$api_link = "javascript:void((function(){var%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)})());";
				}
				break;

			case "mail" :
				$subject = esc_html__('Check this!', 'handystore');
				$body = esc_html__('See more at: ', 'handystore');
				$api_link = 'mailto:?subject='.str_replace('&amp;','%26',rawurlencode($subject)).'&body='.str_replace('&amp;','%26',rawurlencode($body).$escaped_url);
				break;

			case "linkedin" :
				$api_link = 'https://www.linkedin.com/shareArticle?mini=true&url='.$escaped_url.'&title='.$text;
				break;

			case "vk" :
				$api_link = 'http://vk.com/share.php?url='.$escaped_url.'&title='.$text.'&noparse=true';
				break;

			case "tumblr" :
				$api_link = 'https://www.tumblr.com/widgets/share/tool?canonicalUrl='.$escaped_url.'&title='.$text;
				break;
		}

		return $api_link;
	}

	private function getShareCount($soc_net) {
		$count = get_post_meta( get_the_ID(), "_post_".$soc_net."_shares", true ); // get post shares
		if( empty( $count ) ) {
			add_post_meta( get_the_ID(), "_post_".$soc_net."_shares", 0, true ); // create post shares meta if not exist
			$count = 0;
		}
		return $count;
	}
}

/* Frontend output */
function pt_share_buttons_output() {
	if (!is_feed() && !is_home()) {
		$my_buttons = new ptShareButtons;
		$out = $my_buttons->getAll();
	}
	echo $out;
}

/* Enqueue scripts */
function pt_share_scripts() {
	wp_enqueue_script( 'pt-share-buttons', get_template_directory_uri() . '/js/post-share.js', array('jquery'), '1.0', true );
	wp_localize_script( 'pt-share-buttons', 'ajax_var', array(
		'url' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'ajax-nonce' )
		)
	);
}
add_action( 'init', 'pt_share_scripts' );

/* Share post counters */
add_action( 'wp_ajax_nopriv_pt_post_share_count', 'pt_post_share_count' );
add_action( 'wp_ajax_pt_post_share_count', 'pt._post_share_count' );

function pt_post_share_count() {
	$nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ();

	$post_id = $_POST['post_id']; // post id
	$service = $_POST['service'];
	$count = get_post_meta( $post_id, "_post_".$service."_shares", true ); // post like count

	if ( function_exists ( 'wp_cache_post_change' ) ) { // invalidate WP Super Cache if exists
		$GLOBALS["super_cache_enabled"]=1;
		wp_cache_post_change( $post_id );
	}
	update_post_meta( $post_id, "_post_".$service."_shares", ++$count ); // +1 count post meta
	echo esc_attr($count); // update count on front end

	die();
}
