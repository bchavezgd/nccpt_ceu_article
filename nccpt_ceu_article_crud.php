<?php
/*
 *  saving metabox data.
 */

function nccpt_ceu_crud($post_id) {
  /* checking status */
  $is_autosave = wp_is_post_autosave($post_id);
  $is_revision = wp_is_post_revision($post_id);
  $is_nonce_valid = (isset($_POST['nccpt_ceu_metabox_nonce']) && wp_verify_nonce($_POST['nccpt_ceu_metabox_nonce'])) ? true : false;

  if( $is_autosave || $is_revision || $is_nonce_valid ) {
    return;
  }

  /* saving, updating, deleting,  ceu and url values */
  // retrieve metadata
  $new_ceu_value = $_POST["ceu_value"];
  $old_ceu_value = get_post_meta( $post_id, "ceu_value", true);

  $new_store_url = esc_url($_POST["store_url"], ['http', 'https']);
  $old_store_url = get_post_meta( $post_id, "store_url", true);

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
  // 1
  if ($new_store_url && '' == $old_store_url) {
    add_post_meta($post_id, "store_url", $new_store_url);
  }
  // 2
  if ($new_store_url != $old_store_url) {
    update_post_meta($post_id, "store_url", $new_store_url, $old_store_url);
  }
  // 3
  if ('' == $new_store_url) {
    delete_post_meta($post_id, "store_url");
  }
}
