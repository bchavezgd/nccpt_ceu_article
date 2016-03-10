<?php
/*
Plugin Name: NCCPT CEU Articles
Plugin URI:  https://github.com/bchavezgd/nccpt_ceu_article
Description: For storing and displaying CEU Values and product link for articles that need it. 
Version:     v160309
Author:      Brian Chavez
Author URI:  http://elephantaviator.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: nccpt_ceu
*/
//Exit if accessed directly
if (!defined('ABSPATH')){exit;}


include 'nccpt_ceu_article_banner.php';
include 'nccpt_ceu_article_crud.php';

// metabox callback
include 'nccpt_ceu_article_metabox.php';


/*
 * Adds Metabox (container) to the main column on the ceu article edit screens.
 */
function nccpt_ceu_meta_box() {
	add_meta_box(
	  'ceu-meta-box',
	  esc_html__('CEUs', 'nccpt_ceu'),
	  'nccpt_ceu_meta_box_container',
	  'post',
	  'side',
	  'default'
	);
}

/* Adding meta box to filter. */
function nccpt_ceu_setup() {
  add_action( 'add_meta_boxes', 'nccpt_ceu_meta_box' );
  add_action( 'save_post', 'nccpt_ceu_crud');
}

/* adding banner to post */
add_filter( 'the_content', 'nccpt_ceu_banner');

/* adding banner specific styles */
function nccpt_ceu_styles() {
  wp_register_style('nccpt_ceu_styles', plugins_url('nccpt_ceu_style.css', __FILE__) );
  wp_enqueue_style('nccpt_ceu_styles');
}
add_action( 'wp_enqueue_scripts' , 'nccpt_ceu_styles');

/* Define where metabox shows up. */
add_action('load-post.php', 'nccpt_ceu_setup');
add_action('load-post-new.php', 'nccpt_ceu_setup');
