<?php /* The template for displaying 404 pages (Not Found) */
get_header(); ?>

		<main class="site-content<?php if (function_exists('pt_main_content_class')) pt_main_content_class(); ?>" itemscope="itemscope" itemprop="mainContentOfPage"><!-- Main content -->

			<header class="page-header">
				<h1 class="page-title"><?php _e( "Oops! That page can't be found.", 'handystore' ); ?></h1>
			</header>

			<div class="page-content">
				<img src="<?php echo apply_filters( 'handy_default_404_img', get_template_directory_uri().'/images/404.jpg' ); ?>" title="<?php _e( "Oops! That page can't be found.", 'handystore' ); ?>" alt="<?php _e('Not Found .404 page', 'handystore'); ?>"/> 
				<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'handystore' ); ?></p>
				<?php get_search_form(); ?>
			</div>

		</main><!-- end of Main content -->

		<?php get_sidebar();?>

<?php get_footer(); ?>
