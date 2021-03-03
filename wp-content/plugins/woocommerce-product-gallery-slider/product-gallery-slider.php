<?php
/*
Plugin Name: WooCommerce Product Gallery Slider
Plugin URI: https://woocommerce.com/products/product-gallery-slider/
Description: Transforms product galleries into a responsive jQuery slider.
Version: 1.4.2
Author: WooCommerce
Author URI: https://woocommerce.com
Requires at least: 3.1
Tested up to: 4.0

	Copyright: © 2009-2017 WooCommerce.
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * Required functions
 */
if ( ! function_exists( 'woothemes_queue_update' ) )
	require_once( 'woo-includes/woo-functions.php' );

/**
 * Plugin updates
 */
woothemes_queue_update( plugin_basename( __FILE__ ), '9349fd0295bd443b4374277b99b7b9a3', '18655' );

if ( is_woocommerce_active() ) {

	/**
	 * Localisation
	 **/
	load_plugin_textdomain( 'wc_product_gallery_slider', false, dirname( plugin_basename( __FILE__ ) ) . '/' );

	define( 'WC_PRODUCT_GALLERY_SLIDER_VERSION', '1.4.2' );

	/**
	 * woocommerce_product_gallery_slider class
	 **/
	if ( ! class_exists( 'WC_Product_Gallery_slider' ) ) {

		class WC_Product_Gallery_slider {

			public function __construct() {

				// Init settings
				$this->settings = array(
					array(
						'name' 		=> __( 'Product Gallery Slider', 'wc_product_gallery_slider' ),
						'type' 		=> 'title',
						'desc' 		=> '',
						'id' 		=> 'wc_product_gallery_slider_options'
					),
					array(
						'name' 		=> __( 'Enable on product detail pages', 'wc_product_gallery_slider' ),
						'desc' 		=> __( 'Display a gallery slider on all product detail pages. This setting can be overridden on a per-product basis.', 'wc_product_gallery_slider' ),
						'id' 		=> 'woocommerce_product_gallery_slider_enabled',
						'type' 		=> 'checkbox'
					),
					array(
						'name' 		=> __( 'Enable on product archives', 'wc_product_gallery_slider' ),
						'desc' 		=> __( 'Display all product thumbs as gallery sliders on product archives. This setting can be overridden on a per-product basis.', 'wc_product_gallery_slider' ),
						'id' 		=> 'woocommerce_product_gallery_slider_archives_enabled',
						'type' 		=> 'checkbox'
					),
					array(
						'name' 		=> __( 'Slideshow', 'wc_product_gallery_slider' ),
						'desc' 		=> __( 'Automatically rotate through product imagery.', 'wc_product_gallery_slider' ),
						'id' 		=> 'woocommerce_product_gallery_slider_slideshow',
						'type' 		=> 'checkbox'
					),
					array(
						'name' 		=> __( 'Navigation Style', 'wc_product_gallery_slider' ),
						'desc_tip' 	=> __( 'Style of the slider navigation', 'wc_product_gallery_slider' ),
						'id' 		=> 'woocommerce_product_gallery_slider_navigation_style',
						'css' 		=> 'min-width:175px;',
						'type' 		=> 'select',
						'options' 	=> array(
							'thumbnails'  	=> __( 'Thumbnails', 'wc_product_gallery_slider' ),
							'radios' 		=> __( 'Radio buttons', 'wc_product_gallery_slider' )
						)
					),
					array(
						'name' 		=> __( 'Transition Effect', 'wc_product_gallery_slider' ),
						'desc_tip' 	=> __( 'Effect for the product gallery slider.', 'wc_product_gallery_slider' ),
						'id' 		=> 'woocommerce_product_gallery_slider_effect',
						'css' 		=> 'min-width:175px;',
						'type' 		=> 'select',
						'options' 	=> array(
							'fade'  => __( 'Fade', 'wc_product_gallery_slider' ),
							'slide' => __( 'Slide', 'wc_product_gallery_slider' )
						)
					),
					array(
						'name' 		=> __( 'Slide Direction', 'wc_product_gallery_slider' ),
						'desc_tip' 	=> __( 'Slide animation direction. (Requires "slide" animation style)', 'wc_product_gallery_slider' ),
						'id' 		=> 'woocommerce_product_gallery_slider_direction',
						'css' 		=> 'min-width:175px;',
						'type' 		=> 'select',
						'options' 	=> array(
							'horizontal'  	=> __( 'Horizontal', 'wc_product_gallery_slider' ),
							'vertical' 		=> __( 'Vertical', 'wc_product_gallery_slider' )
						)
					),
					array(
						'name' 		=> __( 'Slideshow Speed', 'wc_product_gallery_slider' ),
						'desc_tip' 	=> __( 'The delay between each slide (in seconds).', 'wc_product_gallery_slider' ),
						'id' 		=> 'woocommerce_product_gallery_slider_slideshowspeed',
						'css' 		=> 'min-width:175px;',
						'type' 		=> 'select',
						'options' 	=> $this->_get_available_speed_options()
					),
					array(
						'name' 		=> __( 'Animation Speed', 'wc_product_gallery_slider' ),
						'desc_tip' 	=> __( 'The speed of each slide/fade animation (in seconds).', 'wc_product_gallery_slider' ),
						'id' 		=> 'woocommerce_product_gallery_slider_animationspeed',
						'css' 		=> 'min-width:175px;',
						'type' 		=> 'select',
						'options' 	=> $this->_get_available_speed_options()
					),
					array( 'type' => 'sectionend', 'id' => 'wc_product_gallery_slider_options'),
				);

				// Default options
				add_option( 'woocommerce_product_gallery_slider_effect', 'fade' );
				add_option( 'woocommerce_product_gallery_slider_navigation_style', 'thumbnails' );
				add_option( 'woocommerce_product_gallery_slider_enabled', 'yes' );
				add_option( 'woocommerce_product_gallery_slider_slideshow', 'yes' );
				add_option( 'woocommerce_product_gallery_slider_archives_enabled', 'yes' );
				add_option( 'woocommerce_product_gallery_slider_direction', 'horizontal' );
				add_option( 'woocommerce_product_gallery_slider_slideshowspeed', '7' );
				add_option( 'woocommerce_product_gallery_slider_animationspeed', '0.6' );

				// Hooks
  				add_action( 'wp', array( $this, 'setup_gallery_single' ), 20 );
  				add_action( 'wp', array( $this, 'setup_gallery_archives' ), 20 );

				// Admin
				add_action( 'woocommerce_settings_image_options_after', array( $this, 'admin_settings' ) );
				add_action( 'woocommerce_update_options_catalog', array( $this, 'save_admin_settings' ) );

				/* 2.1 */
				add_action( 'woocommerce_update_options_products', array( $this, 'save_admin_settings' ) );

				add_action( 'woocommerce_product_options_general_product_data', array( $this, 'write_panel' ) );
				add_action( 'woocommerce_process_product_meta', array( $this, 'write_panel_save' ) );
			}

	        /*-----------------------------------------------------------------------------------*/
			/* Class Functions */
			/*-----------------------------------------------------------------------------------*/

			/**
			 * Return a filtered array of all available speed setting options.
			 * @access private
			 * @since  1.4.0
			 * @return array
			 */
			private function _get_available_speed_options () {
				$options = array( '0.1' => '0.1', '0.2' => '0.2', '0.3' => '0.3', '0.4' => '0.4', '0.5' => '0.5', '0.6' => '0.6', '0.7' => '0.7', '0.8' => '0.8', '0.9' => '0.9' );
				for ( $i = 1; $i <= 10; $i++ ) {
					$options[(string)$i] = (string)$i;
				}
				return (array)apply_filters( 'woocommerce_product_gallery_slider_available_speed_options', $options );
			} // End _get_available_speed_options()

			function admin_settings() {
				woocommerce_admin_fields( $this->settings );
			}

			function save_admin_settings() {
				woocommerce_update_options( $this->settings );
			}

		    function write_panel() {
		    	echo '<div class="options_group">';

		    	woocommerce_wp_select( array( 'id' => '_woocommerce_product_gallery_slider_enabled', 'label' => __('Enable Gallery Slider (product page)', 'wc_product_gallery_slider'), 'description' => __('Choose whether to enable the slider for this product on product detail pages.', 'wc_product_gallery_slider'), 'options' => array(
		    		''  	=> __( 'Default', 'wc_product_gallery_slider' ),
					'yes'  	=> __( 'Yes', 'wc_product_gallery_slider' ),
					'no' 	=> __( 'No', 'wc_product_gallery_slider' )
		    	) ) );

		    	woocommerce_wp_select( array( 'id' => '_woocommerce_product_gallery_slider_archives_enabled', 'label' => __('Enable Gallery Slider (archives)', 'wc_product_gallery_slider'), 'description' => __('Choose whether to enable the slider for this product on product archives', 'wc_product_gallery_slider'), 'options' => array(
		    		''  	=> __( 'Default', 'wc_product_gallery_slider' ),
					'yes'  	=> __( 'Yes', 'wc_product_gallery_slider' ),
					'no' 	=> __( 'No', 'wc_product_gallery_slider' )
		    	) ) );

		    	echo '</div>';
		    }

		    function write_panel_save( $post_id ) {
		    	$woocommerce_product_gallery_slider_enabled 			= esc_attr( $_POST['_woocommerce_product_gallery_slider_enabled'] );
		    	$woocommerce_product_gallery_slider_archives_enabled 	= esc_attr( $_POST['_woocommerce_product_gallery_slider_archives_enabled'] );
		    	update_post_meta( $post_id, '_woocommerce_product_gallery_slider_enabled', $woocommerce_product_gallery_slider_enabled );
		    	update_post_meta( $post_id, '_woocommerce_product_gallery_slider_archives_enabled', $woocommerce_product_gallery_slider_archives_enabled );
		    }

			// Remove the WC product gallery and add our own
			function setup_gallery_single() {
				if ( is_product() ) {
					global $post;

					$enabled 			= get_option( 'woocommerce_product_gallery_slider_enabled' );
					$enabled_for_post 	= get_post_meta( $post->ID, '_woocommerce_product_gallery_slider_enabled', true );

					if ( $enabled_for_post == 'no' ) return;

					if ( ( $enabled == 'yes' && $enabled_for_post !== 'no' ) || ( $enabled == 'no' && $enabled_for_post == 'yes' ) ) {

						add_action( 'get_header', array( $this, 'setup_scripts_styles' ), 20 );

						remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
		  				remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );

						add_action( 'woocommerce_before_single_product_summary', array( $this, 'show_product_gallery' ), 30 );

						if ( in_array( 'woocommerce-image-zoom/woocommerce-professor-cloud.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && get_option( 'woocommerce_cloud_enableCloud' ) == 'true' ) :

		  					remove_action( 'woocommerce_before_single_product_summary', array( $this, 'show_product_gallery' ), 30 );

						endif;

		  			}
		  		}
			}

			// Galleries on archives
			function setup_gallery_archives() {
				if ( is_product_category() || is_shop() ) {
					global $post, $woocommerce;

					add_action( 'get_header', array( $this, 'setup_scripts_styles' ), 20);

					add_action( 'woocommerce_before_shop_loop_item', array( $this, 'show_product_gallery_archive' ), 10);

					remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

		  		}
			}

			function show_product_gallery_archive() {
				global $post, $product, $woocommerce;

				$small_thumbnail_size     = apply_filters('single_product_small_thumbnail_size', 'shop_catalog');
				$enabled_archives         = get_option( 'woocommerce_product_gallery_slider_archives_enabled' );
				$enabled_for_post_archive = get_post_meta( $post->ID, '_woocommerce_product_gallery_slider_archives_enabled', true );

				if ( ( $enabled_archives == 'yes' && $enabled_for_post_archive !== 'no' ) || ( $enabled_archives == 'no' && $enabled_for_post_archive == 'yes' ) ) {

					$attachments = version_compare( WC_VERSION, '3.0', '<' ) ? $product->get_gallery_attachment_ids() : $product->get_gallery_image_ids();
					$post_title 	= esc_attr( get_the_title( $post->ID ) );

					if ( $attachments ) {
						$loop = 0;
						$columns = apply_filters('woocommerce_product_thumbnails_columns', 3);
						echo '<div class="product-gallery"><ul class="slides">';

						if ( has_post_thumbnail()) {
							$small_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'shop_thumbnail');
							$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'shop_single');
							printf(
								'<li data-thumb="%s" data-thumb-alt="%s"><a href="%s" title="%s" rel="thumbnails" class="zoom ">%s</a></li>',
								esc_url( $small_image_url[0] ),
								esc_attr( $post_title ),
								esc_url( get_permalink( $post->ID ) ),
								esc_attr( $post_title ),
								get_the_post_thumbnail( $post->ID, 'shop_single' )
							);
	 					}

						foreach ( $attachments as $attachment_id ) {

							if ( get_post_meta( $attachment_id, '_woocommerce_exclude_image', true) == 1 )
								continue;

							$url        = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
							$post_title = get_the_title( $attachment_id );

							printf(
								'<li data-thumb="%s" data-thumb-alt="%s"><a href="%s" title="%s" rel="thumbnails" class="zoom ">%s</a></li>',
								esc_url( $url[0] ),
								esc_attr( $post_title ),
								esc_url( get_permalink( $post->ID ) ),
								esc_attr( $post_title ),
								wp_get_attachment_image( $attachment_id, $small_thumbnail_size )
							);

						}
						echo '</ul></div>';
					} else {
						woocommerce_template_loop_product_thumbnail();
					}

				} else {
					echo '<a href="' . get_permalink( $post->ID ). '" title="' . esc_attr( get_the_title( $post->ID ) ) . '" rel="thumbnails" class="zoom">';

					woocommerce_template_loop_product_thumbnail();

					echo '</a>';
				}
			}

			// Show all single product images in a <ul>
			function show_product_gallery() {
				global $post, $product, $woocommerce;

				$small_thumbnail_size 	= apply_filters( 'single_product_small_thumbnail_size', 'shop_single' );
				$attachments =  version_compare( WC_VERSION, '3.0', '<' ) ? $product->get_gallery_attachment_ids() : $product->get_gallery_image_ids();

				if ( $attachments ) {
					$loop 		= 0;
					$columns 	= apply_filters('woocommerce_product_thumbnails_columns', 3);
					$post_title = esc_attr( get_the_title( get_post_thumbnail_id( $post->ID ) ) );
					echo '<div class="product-gallery images"><ul class="slides">';

					if ( has_post_thumbnail()) {
						$small_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'shop_thumbnail');
						$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'shop_single');
						$full_image_url  = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
						$lightbox_rel    = '';
						if ( 'yes' == get_option( 'woocommerce_enable_lightbox' ) ) {
							$lightbox_rel = ' data-rel="prettyPhoto[product-gallery]"';
						}

						printf(
							'<li data-thumb="%s" data-thumb-alt="%s"><a href="%s" title="%s" rel="thumbnails" class="zoom"%s>%s</a></li>',
							esc_url( $small_image_url[0] ),
							esc_attr( $post_title ),
							esc_url( $full_image_url[0] ),
							esc_attr( $post_title ),
							$lightbox_rel,
							get_the_post_thumbnail( $post->ID, 'shop_single' )
						);

 					}

					foreach ( $attachments as $attachment_id ) {

						if ( get_post_meta( $attachment_id, '_woocommerce_exclude_image', true ) == 1 )
							continue;

						$loop++;

						$url        = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
						$url_large  = wp_get_attachment_image_src( $attachment_id, 'shop_single' );
						$image      = wp_get_attachment_image( $attachment_id, $small_thumbnail_size );
						$post_title = esc_attr( get_the_title( $attachment_id ) );
						if ( 'yes' == get_option( 'woocommerce_enable_lightbox' ) ) {
							$lightbox_rel = ' data-rel="prettyPhoto[product-gallery]"';
						}

						printf(
							'<li data-thumb="%s" data-thumb-alt="%s"><a href="%s" title="%s" rel="thumbnails" class="zoom %s%s" %s>%s</a></li>',
							esc_url( $url[0] ),
							esc_attr( $post_title ),
							esc_url( $url_large[0] ),
							esc_attr( $post_title ),
							( 1 == $loop || ( $loop - 1 ) % $columns == 0 ) ? 'first' : '',
							( $loop % $columns == 0 ) ? 'last' : '',
							$lightbox_rel,
							$image
						);
					}

					echo '</ul></div>';

				} else {
					woocommerce_show_product_images();
				}
			}

			// Setup scripts & styles
			function setup_scripts_styles() {
				wp_enqueue_script( 'flexslider', plugins_url( '/assets/js/jquery.flexslider.min.js', __FILE__ ), array( 'jquery' ) );
				add_action( 'wp_head',array( $this, 'fire_slider' ) );
				wp_enqueue_style( 'slider-styles', plugins_url( '/assets/css/style.css', __FILE__ ) );
			}

			// Fire the slider
			function fire_slider() {
				?>
					<script>
						jQuery(window).load(function() {
							jQuery('.product-gallery').flexslider({
								pauseOnHover: true,
								directionNav: false,
								<?php if ( get_option( 'woocommerce_product_gallery_slider_effect' ) == 'slide' ) {
									echo 'smoothHeight: true,';
								} ?>
								<?php if ( get_option( 'woocommerce_product_gallery_slider_navigation_style' ) == 'thumbnails' ) {
									echo 'controlNav: "thumbnails",';
								} ?>
								slideshow: <?php if ( get_option( 'woocommerce_product_gallery_slider_slideshow' ) == 'yes' ) { echo 'true'; } else { echo 'false'; } ?>,
								animation: "<?php echo get_option( 'woocommerce_product_gallery_slider_effect' ); ?>",
								direction: "<?php echo get_option( 'woocommerce_product_gallery_slider_direction' ); ?>",
								slideshowSpeed: "<?php echo floatval( get_option( 'woocommerce_product_gallery_slider_slideshowspeed' ) ) * 1000; ?>",
								animationSpeed: "<?php echo floatval( get_option( 'woocommerce_product_gallery_slider_animationspeed' ) ) * 1000; ?>"
							});
						});
					</script>
				<?php
			}
		}
		$WC_Product_Gallery_slider = new WC_Product_Gallery_slider();
	}
}
