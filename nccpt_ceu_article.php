<?php
/*
Plugin Name: NCCPT CEU Articles
Plugin URI:
Description: Metabox
Version:     v160304
Author:      brian chavez
Author URI:  http://elephantaviator.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: nccpt_ceu
*/
//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )  {
	exit;
}

/*
 *  footer banner
 */

function nccpt_is_ceu_article() {
  if ( !empty($nccpt_ceu_stored_meta["ceu_value"]) &&  !empty($nccpt_ceu_stored_meta["store_url"]) ) {
    return true;
  } else {
    return false;
  }
}

function nccpt_banner($content) {


  if(is_singular() && is_main_query() && nccpt_is_ceu_article() ) {
    return $content . '<section><p> this the elephantaviator plug in test! </p> </section>';
  } else {
    return $content;
  }
};

add_filter('the_content', 'nccpt_banner');

/*

## add post meta.

add_post_meta( $post_id, $meta_key, $meta_value, $unique)

saving metabox data.

*/

function nccpt_ceu_crud($post_id) {
  // $post_id = get_the_ID();
  /* checking status */
  $is_autosave = wp_is_post_autosave($post_id);
  $is_revision = wp_is_post_revision($post_id);
  $is_nonce_valid = (isset($_POST['nccpt_ceu_metabox_nonce']) && wp_verify_nonce($_POST['nccpt_ceu_metabox_nonce'])) ? true : false;

  /*
  *  1. create an array containing names of all fields for metabox.
  *  2. iterate through each field name and run C.R.U.D. function.
  */
  $new_ceu_value = $_POST["ceu_value"];
  $old_ceu_value = get_post_meta( $post_id, "ceu_value", true);

  $new_store_url = $_POST["store_url"];
  $old_store_url = get_post_meta( $post_id, "store_url", true);

  if( $is_autosave || $is_revision || $is_nonce_valid ) {
  return;
  }

  /* saving ceu value */

 /*
  * 1. if a new meta value is added
  *    and there wasn't a previous value, Create it.
  * 2. If new meta value doesn't match old value, update it.
  * 3. If there is no new meta value, but an old one exists;
  *    Delete old value.
  */

  // 1
  if ($new_ceu_value && '' == $old_ceu_value) {
    add_post_meta($post_id, "ceu_value", $new_ceu_value);
  }
  // 2.
  if ($new_ceu_value != $old_ceu_value) {
    update_post_meta($post_id, "ceu_value", $new_ceu_value, $old_ceu_value);
  }
  // 3.
  if (''== $new_ceu_value) {
    delete_post_meta($post_id, "ceu_value");
  }

  /* for url */


  if ($new_store_url && '' == $old_store_url) {
    add_post_meta($post_id, "store_url", $new_store_url);
  }
  if ($new_store_url != $old_store_url) {
    update_post_meta($post_id, "store_url", $new_store_url, $old_store_url);
  }
  if ('' == $new_store_url) {
    delete_post_meta($post_id, "store_url");
  }
}

/*
	Create callback funciton
*/
function nccpt_ceu_meta_box_container($post) {
	/*
		this is where the meta box code actually goes.

		each input needs to be run though nounce(),
        validated with jquery,
        and sanitized
        before being added to DB.
	*/
  $post_id = get_the_ID();
  // create nonce for security
  wp_nonce_field(basename(__FILE__), 'nccpt_ceu_metabox_nonce');

  $nccpt_ceu_stored_meta = get_post_meta($post_id);

	?>


  <div class="modal-container">
    <div class="form-box">
      <p>
        <label for="ceu_value">
          <?php _e("CEU Value:"); ?>
        </label>
        <input name="ceu_value" type="text" class="widefat" <?php
          if ( !empty( $nccpt_ceu_stored_meta["ceu_value"] ) ) {
            echo sprintf('value="%s"', $nccpt_ceu_stored_meta["ceu_value"][0]);
          } else {
            echo sprintf('placeholder="%s"', __("Enter CEU Value")) ;
          }
          ?>>
      </p>
      <p>
        <label for="store_url"><?php _e("Store Url:"); ?></label>
        <input type="url" name="store_url" class="widefat" <?php
        if (!empty( $nccpt_ceu_stored_meta["store_url"] )) {
          echo sprintf('value="%s"', $nccpt_ceu_stored_meta["store_url"][0]);
        } else {
          echo sprintf('placeholder="%s"', __("Enter Store URL"));
        }
        ?>>
      </p>
    </div>
  </div>


    <?php
}


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

/*
 *  Adding meta box to filter.
 */
function nccpt_ceu_setup() {
  add_action( 'add_meta_boxes', 'nccpt_ceu_meta_box' );
  add_action( 'save_post', 'nccpt_ceu_crud');
}

/*
 * Define where metabox shows up.
 */

add_action('load-post.php', 'nccpt_ceu_setup');
add_action('load-post-new.php', 'nccpt_ceu_setup');
