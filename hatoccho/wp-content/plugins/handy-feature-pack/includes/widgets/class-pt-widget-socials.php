<?php /* Handy Social Networks */

if ( ! defined( 'ABSPATH' ) ) exit;

class pt_socials_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'pt_socials_widget', // Base ID
			__('Handy Social Icons', 'handy-feature-pack'), // Widget Name
			array(
				'classname' => 'pt-socials-widget',
				'description' => __('Handy special widget. Displays a list of social media website icons and a link to your profile.', 'handy-feature-pack'),
			),
			array(
				'width' => 600,
			)
		);
	}

	// Get Social Networks
	protected function get_social_networks() {
		return array(
			'facebook' => array(
				'icon' => 'facebook',
				'label' => '',
				'url' => ''
			),
			'linkedin' => array(
				'icon' => 'linkedin',
				'label' => '',
				'url' => ''
			),
			'twitter' => array(
				'icon' => 'twitter',
				'label' => '',
				'url' => ''
			),
			'google-plus' => array(
				'icon' => 'google-plus',
				'label' => '',
				'url' => ''
			),
			'youtube' => array(
				'icon' => 'youtube',
				'label' => '',
				'url' => ''
			),
			'instagram' => array(
				'icon' => 'instagram',
				'label' => '',
				'url' => ''
			),
			'github' => array(
				'icon' => 'github',
				'label' => '',
				'url' => ''
			),
			'rss' => array(
				'icon' => 'rss',
				'label' => '',
				'url' => ''
			),
			'pinterest' => array(
				'icon' => 'pinterest',
				'label' => '',
				'url' => ''
			),
			'flickr' => array(
				'icon' => 'flickr',
				'label' => '',
				'url' => ''
			),
			'bitbucket' => array(
				'icon' => 'bitbucket',
				'label' => '',
				'url' => ''
			),
			'tumblr' => array(
				'icon' => 'tumblr',
				'label' => '',
				'url' => ''
			),
			'dribbble' => array(
				'icon' => 'dribbble',
				'label' => '',
				'url' => ''
			),
			'vimeo' => array(
				'icon' => 'vimeo',
				'label' => '',
				'url' => ''
			),
			'wordpress' => array(
				'icon' => 'wordpress',
				'label' => '',
				'url' => ''
			),
			'delicious' => array(
				'icon' => 'delicious',
				'label' => '',
				'url' => ''
			),
			'digg' => array(
				'icon' => 'digg',
				'label' => '',
				'url' => ''
				),
			'behance' => array(
				'icon' => 'behance',
				'label' => '',
				'url' => ''
			),
		);
	}

	public function form( $instance ) {

		$defaults = array(
			'title' => '',
			'icon_size' => 'small',
			'show_title' => '',
			'layout_type' => '',
			'social_networks' => $this->get_social_networks(),
		);

		$instance = wp_parse_args((array) $instance, $defaults);

		$social_networks = $instance['social_networks'];
	?>
		<div class="social_icons_widget">

			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'handy-feature-pack'); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>

			<?php
			$icon_sizes = array(
				'Small (16px)' => 'small',
				'Medium (24px)' => 'medium',
				'Large (32px)' => 'large',
			);
			?>

			<p class="icon_options"><label for="<?php echo $this->get_field_id('icon_size'); ?>"><?php _e('Icon Size:', 'handy-feature-pack'); ?></label>
				<select id="<?php echo $this->get_field_id('icon_size'); ?>" name="<?php echo $this->get_field_name('icon_size'); ?>">
				<?php
				foreach($icon_sizes as $option => $value) :

					if(esc_attr($data['icon_size'] == $value)) { $selected = ' selected="selected"'; }
					else { $selected = ''; }
				?>

					<option value="<?php echo $value; ?>"<?php echo $selected; ?>><?php echo $option; ?></option>

				<?php endforeach; ?>
				</select>
			</p>

			<?php if(esc_attr($instance['show_title'] == 'hide')) { $checked = ' checked="checked"'; } else { $checked = ''; } ?>
			<p class="label_options"><input type="checkbox" id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>" value="hide"<?php echo $checked; ?> /> <label for="<?php echo $this->get_field_id('show_title'); ?>"><?php _e('Hide Title', 'handy-feature-pack'); ?></label></p>

			<?php if(esc_attr($instance['layout_type'] == 'inline')) { $checked = ' checked="checked"'; } else { $checked = ''; } ?>
			<p class="label_options"><input type="checkbox" id="<?php echo $this->get_field_id('layout_type'); ?>" name="<?php echo $this->get_field_name('layout_type'); ?>" value="inline"<?php echo $checked; ?> /> <label for="<?php echo $this->get_field_id('layout_type'); ?>"><?php _e('Inline Mode', 'handy-feature-pack'); ?></label></p>

			<?php if ($social_networks) {
					echo '<ul class="social_accounts">';
            		foreach ($social_networks as $key => $value) { ?>

					<li>
						<h4><?php echo esc_attr( $key ); ?></h4>

						<label for="<?php echo $this->get_field_name('social_networks'); ?>[<?php echo $key; ?>][label]"><?php _e('Label:', 'handy-feature-pack'); ?></label>
						<input class="widefat" type="text" id="<?php echo $this->get_field_name('social_networks'); ?>[<?php echo $key; ?>][label]" name="<?php echo $this->get_field_name('social_networks'); ?>[<?php echo $key; ?>][label]" value="<?php echo esc_attr( $value['label'] ); ?>" />

						<label for="<?php echo $this->get_field_name('social_networks'); ?>[<?php echo $key; ?>][url]"><?php _e('URL:', 'handy-feature-pack'); ?></label>
						<input class="widefat" type="text" id="<?php echo $this->get_field_name('social_networks'); ?>[<?php echo $key; ?>][url]" name="<?php echo $this->get_field_name('social_networks'); ?>[<?php echo $key; ?>][url]" value="<?php echo esc_url( $value['url'] ); ?>" />

						<input class="widefat" type="hidden" id="<?php echo $this->get_field_name('social_networks'); ?>[<?php echo $key; ?>][title]" name="<?php echo $this->get_field_name('social_networks'); ?>[<?php echo $key; ?>][title]" value="<?php echo esc_attr( $value['title'] ); ?>" />
						<input class="widefat" type="hidden" id="<?php echo $this->get_field_name('social_networks'); ?>[<?php echo $key; ?>][icon]" name="<?php echo $this->get_field_name('social_networks'); ?>[<?php echo $key; ?>][icon]" value="<?php echo esc_attr( $value['icon'] ); ?>" />
					</li>

                <?php }
                	echo "</ul>";
			} ?>

		</div>
		<?php
	}

	public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
        $instance['social_networks'] = $new_instance['social_networks'];
		$instance['icon_size'] = $new_instance['icon_size'];
		$instance['show_title'] = esc_attr($new_instance['show_title']);
		$instance['layout_type'] = esc_attr($new_instance['layout_type']);

		return $instance;
	}

	public function widget( $args, $instance ) {

		extract($args);

		$title = empty($instance['title']) ? 'Follow Us' : apply_filters('widget_title', $instance['title']);
		$icon_size = empty($instance['icon_size']) ? 'small' : $instance['icon_size'];
		$show_title = $instance['show_title'];
		$layout_type = $instance['layout_type'];
		$social_networks = $instance['social_networks'];

		echo $before_widget;

		if( $show_title !== 'hide' ) {
			echo $before_title;
			echo $title;
			echo $after_title;
		}

		if($layout_type == 'inline') { $ul_class = 'inline-mode '; $icon_class = ''; }
		else { $ul_class = ''; $icon_class = ' fa-fw'; }

		$ul_class .= 'icons-'.$icon_size;

		echo '<ul class="'.$ul_class.'">';
		foreach($social_networks as $network) :
			if ( $network['url'] && $network['url']!='' ) {
				echo '<li class="social-network">';
				echo '<a href="'.$network['url'].'" target="_blank" title="'.__('Connect us on ', 'handy-feature-pack').$network['title'].'"><i class="fa fa-'.$network['icon'].esc_attr($icon_class).'"></i><span>'.$network['label'].'</span></a>';
				echo '</li>';
			}
		endforeach;
		echo '</ul>';

		echo $after_widget;
	}
}
