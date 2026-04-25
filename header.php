<?php
/**
 * GCS Theme — Header
 * يحتوي على الـ Nav + Hero Slider في الصفحة الرئيسية
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( gcs_opt('show_cursor') === '1' ) : ?>
<div id="gcs-cursor"></div>
<div id="gcs-cursor-ring"></div>
<?php endif; ?>

<!-- ===== NAVBAR ===== -->
<nav class="gcs-nav" id="gcs-nav" role="navigation" aria-label="القائمة الرئيسية">
  <div class="nav-inner">

    <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo" aria-label="<?php bloginfo('name'); ?>">
      <?php if ( has_custom_logo() ) :
        the_custom_logo();
      else : ?>
        <div class="nav-logo-placeholder">
          <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><circle cx="24" cy="24" r="22" stroke="var(--gold)" stroke-width="1.5"/><text x="24" y="29" text-anchor="middle" fill="var(--gold)" font-size="12" font-family="Tajawal" font-weight="700">GCS</text></svg>
        </div>
      <?php endif; ?>
      <div class="nav-logo-text">
        <span class="nav-logo-ar"><?php echo esc_html( gcs_opt('company_name_ar') ); ?></span>
        <span class="nav-logo-en"><?php echo esc_html( gcs_opt('company_name_en') ); ?></span>
      </div>
    </a>

    <?php
    wp_nav_menu([
        'theme_location' => 'primary',
        'menu_class'     => 'nav-links',
        'container'      => false,
        'fallback_cb'    => 'gcs_fallback_menu',
    ]);
    ?>

    <div class="nav-actions">
      <a href="<?php echo esc_url( gcs_opt('company_whatsapp') ? 'https://wa.me/' . preg_replace('/\D/','',$_opts['company_whatsapp'] ?? '') : '#contact' ); ?>"
         class="nav-cta" id="nav-cta">
        تواصل معنا
      </a>
      <button class="nav-toggle" id="nav-toggle" aria-label="قائمة الجوال">
        <span></span><span></span><span></span>
      </button>
    </div>

  </div>
  <!-- Mobile menu -->
  <div class="nav-mobile" id="nav-mobile">
    <?php wp_nav_menu([ 'theme_location' => 'primary', 'menu_class' => 'nav-mobile-links', 'container' => false ]); ?>
  </div>
</nav>
<!-- /NAV -->

<?php
function gcs_fallback_menu() {
    echo '<ul class="nav-links">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">الرئيسية</a></li>';
    echo '<li><a href="#services">خدماتنا</a></li>';
    echo '<li><a href="#projects">أعمالنا</a></li>';
    echo '<li><a href="#why">لماذا نحن</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact')) . '">تواصل</a></li>';
    echo '</ul>';
}
