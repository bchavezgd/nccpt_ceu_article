<?php
/*
 *  footer banner
 */

 function is_nccpt_ceu_article() {
   $post_id = get_the_ID();
   $nccpt_ceu_stored_meta = get_post_meta($post_id);
   if ( !empty($nccpt_ceu_stored_meta["ceu_value"]) &&  !empty($nccpt_ceu_stored_meta["store_url"]) ) {
     return true;
   } else {
     return false;
   }
 }

function nccpt_ceu_banner($content) {
  if ( is_nccpt_ceu_article() ) {
    $post_id = get_the_ID();
    $nccpt_ceu_stored_meta = get_post_meta($post_id);
    $ceu_url =  $nccpt_ceu_stored_meta["store_url"][0];
    $ceu_value = $nccpt_ceu_stored_meta["ceu_value"][0];
    $nccpt_ceu_banner_string =<<< _HTML
  <div class="nccpt-ceu-banner">
    <h2>Read the Article?</h2>
    <p> Take the <a href="{$ceu_url}" target="_blank">Quiz</a> and earn {$ceu_value} CEUs.</p>
  </div>
_HTML;
    $content .= $nccpt_ceu_banner_string;
  }
  return $content;
};
