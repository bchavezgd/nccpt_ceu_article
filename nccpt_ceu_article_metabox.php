<?php
/*
	Create callback funciton
*/
function nccpt_ceu_meta_box_container($post) {
  wp_nonce_field(basename(__FILE__), 'nccpt_ceu_metabox_nonce');
  $nccpt_ceu_stored_meta = get_post_meta( get_the_ID() );

	?>
  <div class="modal-container">
    <div class="form-box">
      <p>
        <label for="ceu_value">
          <?php _e("CEU Value:"); ?>
        </label>
        <input name="ceu_value" type="number" max="1.0" step="0.01" class="widefat" <?php

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
