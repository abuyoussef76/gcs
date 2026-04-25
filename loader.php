<?php
/**
 * GCS Theme — Page Loader
 * يُستدعى من header.php بعد wp_body_open
 */
$opts = gcs_get_options();
$logo_url = '';
if (has_custom_logo()) {
    $logo_id  = get_theme_mod('custom_logo');
    $logo_url = wp_get_attachment_image_url($logo_id, 'full');
}
?>
<div id="gcs-loader" role="status" aria-label="جارٍ تحميل الموقع">
  <div class="loader-logo">
    <?php if ($logo_url) : ?>
      <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($opts['company_name_ar']); ?>" style="width:80px;height:80px;object-fit:contain;filter:drop-shadow(0 0 12px rgba(201,168,76,.5))">
    <?php else : ?>
      <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
        <circle cx="40" cy="40" r="36" stroke="rgba(201,168,76,0.3)" stroke-width="1"/>
        <circle cx="40" cy="40" r="26" stroke="rgba(201,168,76,0.5)" stroke-width="1"/>
        <circle cx="40" cy="40" r="16" stroke="var(--gold)" stroke-width="1.5"/>
        <circle cx="40" cy="40" r="5" fill="var(--gold)"/>
        <text x="40" y="68" text-anchor="middle" fill="rgba(201,168,76,0.6)" font-size="9" font-family="Tajawal" letter-spacing="2">GCS</text>
      </svg>
    <?php endif; ?>
  </div>
  <div class="loader-bar-wrap">
    <div class="loader-bar"></div>
  </div>
  <div class="loader-pct" aria-live="polite">0%</div>
</div>
