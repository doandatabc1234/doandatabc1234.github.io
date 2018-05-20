<?php
/**
 * Template Name: Gallery Page Template
 */

// Custom Gallery shortcode output
function pt_gallery( $blank = NULL, $attr ) {

    global $post;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] ) unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post ? $post->ID : 0,
        'itemtag'    => 'figure',
    		'icontag'    => 'div',
    		'captiontag' => 'figcaption',
        'columns'    => '3',
        'size'       => 'medium',
        'include'    => '',
        'exclude'    => '',
        'link'       => ''
    ), $attr, 'gallery'));

    $id = intval($id);

    if ( 'RAND' == $order ) $orderby = 'none';

    if ( !empty($include) ) {
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) ) return '';

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $icontag = tag_escape($icontag);
    $valid_tags = wp_kses_allowed_html( 'post' );
    if ( ! isset( $valid_tags[ $itemtag ] ) ) {
  		$itemtag = 'figure';
  	}
  	if ( ! isset( $valid_tags[ $captiontag ] ) ) {
  		$captiontag = 'figcaption';
  	}
  	if ( ! isset( $valid_tags[ $icontag ] ) ) {
  		$icontag = 'div';
  	}

    $columns = intval($columns);

    /* Get filters array */
    $all_filters = array();
    foreach ( $attachments as $attachment ) {
      if ( !empty($attachment->portfolio_filter) ) {
        $arr = explode(',', strtolower($attachment->portfolio_filter));
        foreach ($arr as $value) {
          $all_filters[] = trim($value);
        }
      }
    }
    $all_filters = array_unique($all_filters);
    array_unshift($all_filters, "phoney", "all");
    unset($all_filters[0]);

    /* Output Filters nav */
    $output_filters_nav = '';
    if ( !empty($all_filters) && count($all_filters) > 1 ) {
      $output_filters_nav = '<div class="portfolio-filters-wrapper"><label for="pt-filters">'.__('Sort Gallery: ', 'handystore').'</label>';
      $output_filters_nav .= '<ul>';
      foreach($all_filters as $key => $filter){
        if ($key == 1) {
          $output_filters_nav .= '<li class="gallery-filter filtr filtr-active" data-filter="'.esc_attr($key).'">'.esc_attr($filter).'</li>';
        } else {
          $output_filters_nav .= '<li class="gallery-filter filtr" data-filter="'.esc_attr($key).'">'.esc_attr($filter).'</li>';
        }
        unset($filter);
      }
      $output_filters_nav .= '</ul></div>';
    }

    /* Output Gallery */
    if ( count($all_filters) > 1 ) {
      $extra_class = "pt-gallery filtr-container galleryid-{$id} row";
    } else {
      $extra_class = "pt-gallery galleryid-{$id} row";
    }
    $output = "<div id='pt-gallery' class='{$extra_class}'>";

  	foreach ( $attachments as $id => $attachment ) {

      /* Add responsive classes */
      $layout_class = '';
      switch ($columns) {
          case '2':
              $layout_class = ' col-md-6 col-sm-12 col-xs-12';
              $atts['size'] = 'pt-gallery-l';
          break;
          case '3':
              $layout_class = ' col-md-4 col-sm-6 col-xs-12';
              $atts['size'] = 'pt-gallery-m';
          break;
          case '4':
              $layout_class = ' col-lg-3 col-md-4 col-sm-6 col-xs-12';
              $atts['size'] = 'pt-gallery-s';
          break;
          case '6':
              $layout_class = ' col-lg-2 col-md-4 col-sm-6 col-xs-12';
          break;
          default:
              $layout_class = ' col-md-4 col-sm-6 col-xs-12';
          break;
      }
      if ( count($all_filters) > 1 ) {
        $layout_class .= ' filtr-item';
      }

  		$attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "bikeway-gallery-$id" ) : '';
  		$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );

      /* Adding special filter args */
      $special_filters = get_post_meta( $id, 'portfolio_filter', true );
      $filter_arg = '';
      if ( count($all_filters) > 1 ) {
        $filter_arg = ' data-category="1';
        $special_filters_string = '';

        if( $special_filters && $special_filters != '' ) {
            $filter_arg .= ', ';
            $special_filter_cleared = array();
            $arr = explode( ",", strtolower($special_filters));
            $i = 1;

            foreach($arr as $special_filter){
                $special_filter_cleared[] = trim($special_filter);
                $filter_arg .= implode('', array_keys($all_filters, trim($special_filter)));
                if ($i == count($arr)) {
                  $filter_arg .= '"';
                } else {
                  $filter_arg .= ', ';
                }
                $i++;
            }

            $special_filters_string = implode(" / ", $special_filter_cleared);
        } else {
          $filter_arg .= '"';
        }
      }

  		$output .= "<{$itemtag} class='gallery-item{$layout_class}'{$filter_arg}>";
  		$output .= "
  			<{$icontag} class='gallery-icon'>
  				$image_output
  			</{$icontag}>";
        if ( $captiontag && trim($attachment->post_title) ) {
            $output .= "
                <{$captiontag} class='gallery-item-description'>
                <h3>" . wptexturize($attachment->post_title) . "</h3>";
            $output .= "<p class='btns-wrapper'>
                        <a class='quick-view' data-src='".esc_url($attachment->guid)."' href='".esc_url($attachment->guid)."' title='".esc_html__('Quick View', 'handystore')."' rel='nofollow'><i class='fa fa-search' aria-hidden='true'></i></a>
                        <a class='link-to-post' rel='bookmark' href='".esc_url(get_permalink($attachment->ID))."' title='".esc_html__( 'Click to learn more', 'handystore')."'><i class='fa fa-link' aria-hidden='true'></i></a>
                        </p>";
            $output .= "</{$captiontag}>";
        }
  		$output .= "</{$itemtag}>";
  	}

  	$output .= "
  		</div>\n";

    return $output_filters_nav.$output;

}
add_filter( 'post_gallery', 'pt_gallery', 10, 2);
?>

<?php get_header(); ?>

    <main class="site-content<?php if (function_exists('pt_main_content_class')) pt_main_content_class(); ?>" itemscope="itemscope" itemprop="mainContentOfPage"><!-- Main content -->

        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>
        <?php endif; ?>

    </main><!-- end of Main content -->

    <?php get_sidebar(); ?>

<?php get_footer(); ?>
