<?php
/*
 *  footer banner
 */
function is_nccpt_ceu_article() {
 $nccpt_ceu_stored_meta = get_post_meta( get_the_ID() );
 if ( !empty($nccpt_ceu_stored_meta["ceu_value"]) &&  !empty($nccpt_ceu_stored_meta["store_url"]) ) {
   return true;
 } else {
   return false;
 }
}

function nccpt_ceu_banner($content) {
  if ( is_nccpt_ceu_article() ) {
    $nccpt_ceu_stored_meta = get_post_meta( get_the_ID() );
    $ceu_url =  $nccpt_ceu_stored_meta["store_url"][0];
    $ceu_value = $nccpt_ceu_stored_meta["ceu_value"][0];
    $nccpt_ceu_banner_string =<<< _HTML
  <div class="nccpt-ceu-banner">
    <h2>Read the Article?</h2>
    <p> Take the <a href="{$ceu_url}" target="_blank">Quiz</a> and earn {$ceu_value} CEUs.</p>
  </div>
_HTML;
    $nccpt_ceu_badge_string =<<< _BADGE
      <div class="nccpt-ceu-badge">
      <div class="nccpt-ceu-value">
      <span>{$ceu_value}</span>
      <span>CEUs</span>
      </div>
      </div>
_BADGE;
    $content .= $nccpt_ceu_badge_string;
    $content .= $nccpt_ceu_banner_string;
  }
  return $content;
};
