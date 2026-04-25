<?php
/**
 * GCS Theme — Footer
 */
$opts = gcs_get_options();
?>

<!-- ===== FOOTER ===== -->
<footer class="gcs-footer" role="contentinfo">
  <div class="footer-top">
    <div class="footer-grid">

      <!-- Brand -->
      <div class="foot-brand">
        <div class="foot-logo-wrap">
          <?php if ( has_custom_logo() ) : the_custom_logo();
          else : ?>
            <svg width="52" height="52" viewBox="0 0 52 52" fill="none"><circle cx="26" cy="26" r="24" stroke="var(--gold)" stroke-width="1"/><text x="26" y="32" text-anchor="middle" fill="var(--gold)" font-size="13" font-family="Tajawal" font-weight="700">GCS</text></svg>
          <?php endif; ?>
          <span class="foot-brand-name"><?php echo esc_html($opts['company_name_ar']); ?></span>
        </div>
        <p class="foot-about"><?php echo esc_html($opts['footer_about']); ?></p>
        <div class="foot-contact-list">
          <?php if ($opts['company_phone']) : ?>
            <a href="tel:<?php echo esc_attr($opts['company_phone']); ?>" class="foot-contact-item">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8 19.79 19.79 0 01.01 2.18 2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
              <?php echo esc_html($opts['company_phone']); ?>
            </a>
          <?php endif; ?>
          <?php if ($opts['company_email']) : ?>
            <a href="mailto:<?php echo esc_attr($opts['company_email']); ?>" class="foot-contact-item">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              <?php echo esc_html($opts['company_email']); ?>
            </a>
          <?php endif; ?>
          <?php if ($opts['company_address']) : ?>
            <span class="foot-contact-item">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
              <?php echo esc_html($opts['company_address']); ?>
            </span>
          <?php endif; ?>
        </div>
      </div>

      <!-- Services Links -->
      <div class="foot-col">
        <h4>خدماتنا</h4>
        <?php
        $services = gcs_get_services(5);
        if ($services) :
            echo '<ul>';
            foreach ($services as $s) :
                echo '<li><a href="' . esc_url(get_permalink($s->ID)) . '">' . esc_html($s->post_title) . '</a></li>';
            endforeach;
            echo '</ul>';
        else: ?>
        <ul>
          <li><a href="#">المقاولات العامة</a></li>
          <li><a href="#">الديكور الداخلي</a></li>
          <li><a href="#">التشطيبات الفاخرة</a></li>
          <li><a href="#">الأسقف الزخرفية</a></li>
          <li><a href="#">الحدائق والمسابح</a></li>
        </ul>
        <?php endif; ?>
      </div>

      <!-- Company Links -->
      <div class="foot-col">
        <h4>الشركة</h4>
        <?php wp_nav_menu([
            'theme_location' => 'footer',
            'container'      => false,
            'depth'          => 1,
            'fallback_cb'    => function() {
                echo '<ul>';
                $pages = ['من نحن' => 'about', 'أعمالنا' => 'projects', 'فريقنا' => 'team', 'المدونة' => 'blog', 'وظائف' => 'careers'];
                foreach ($pages as $label => $slug) {
                    echo '<li><a href="' . esc_url(home_url('/'.$slug)) . '">' . esc_html($label) . '</a></li>';
                }
                echo '</ul>';
            }
        ]); ?>
      </div>

      <!-- Newsletter / Quick Contact -->
      <div class="foot-col">
        <h4>النشرة البريدية</h4>
        <p style="font-size:.83rem;color:var(--gray);margin-bottom:1rem;line-height:1.7">اشترك لتصلك آخر مشاريعنا وعروضنا الحصرية</p>
        <form class="foot-newsletter" id="foot-newsletter">
          <input type="email" placeholder="بريدك الإلكتروني" required>
          <button type="submit">اشترك</button>
        </form>
        <div class="foot-social" style="margin-top:1.5rem">
          <?php echo gcs_social_links(); ?>
        </div>
      </div>

    </div>
  </div>

  <div class="footer-bottom">
    <p><?php echo esc_html($opts['footer_copy'] ?: '© ' . date('Y') . ' ' . $opts['company_name_ar'] . ' — جميع الحقوق محفوظة'); ?></p>
    <div class="foot-bottom-links">
      <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">سياسة الخصوصية</a>
      <a href="<?php echo esc_url(home_url('/terms')); ?>">الشروط والأحكام</a>
    </div>
  </div>
</footer>

<!-- Back to top -->
<button class="back-to-top" id="back-to-top" aria-label="العودة للأعلى">
  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="18 15 12 9 6 15"/></svg>
</button>

<!-- WhatsApp Float -->
<?php if ($opts['company_whatsapp']) : ?>
<a href="https://wa.me/<?php echo esc_attr(preg_replace('/\D/','',$opts['company_whatsapp'])); ?>"
   class="whatsapp-float" target="_blank" rel="noopener" aria-label="واتساب">
  <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
