<?php
/**
 * Template Name: صفحة التواصل
 */
get_header();
$opts = gcs_get_options();
wp_localize_script('gcs-main', 'gcs_ajax', [
    'url'   => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('gcs_contact_nonce'),
]);
?>

<section class="page-hero">
  <div class="page-hero-content rv">
    <div class="page-hero-tag">نجوم العاصمة الذهبية</div>
    <h1 class="page-hero-title">تواصل <span style="color:var(--gold)">معنا</span></h1>
    <p class="page-hero-sub">فريقنا جاهز لمساعدتك وتحقيق رؤيتك — تواصل معنا اليوم</p>
  </div>
</section>

<div class="contact-grid">

  <!-- Form -->
  <div class="rv">
    <div class="sec-tag">أرسل رسالة</div>
    <h2 class="sec-title" style="margin-bottom:2rem">نسمعك <span class="g">دائماً</span></h2>
    <form id="gcs-contact-form" class="contact-form" novalidate>
      <div class="form-grid-2">
        <div class="form-group">
          <label for="cf-name">الاسم الكامل *</label>
          <input type="text" id="cf-name" name="name" placeholder="محمد أحمد" required>
        </div>
        <div class="form-group">
          <label for="cf-email">البريد الإلكتروني *</label>
          <input type="email" id="cf-email" name="email" placeholder="example@email.com" required>
        </div>
      </div>
      <div class="form-grid-2">
        <div class="form-group">
          <label for="cf-phone">رقم الهاتف</label>
          <input type="tel" id="cf-phone" name="phone" placeholder="+966 50 000 0000">
        </div>
        <div class="form-group">
          <label for="cf-service">الخدمة المطلوبة</label>
          <select id="cf-service" name="service">
            <option value="">اختر الخدمة</option>
            <option>المقاولات العامة</option>
            <option>الديكور الداخلي</option>
            <option>التشطيبات الفاخرة</option>
            <option>الأسقف الزخرفية</option>
            <option>الحدائق والمسابح</option>
            <option>الاستشارات الهندسية</option>
            <option>أخرى</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="cf-budget">الميزانية التقريبية</label>
        <select id="cf-budget" name="budget">
          <option value="">اختر نطاق الميزانية</option>
          <option>أقل من ١٠٠,٠٠٠ ريال</option>
          <option>١٠٠,٠٠٠ — ٥٠٠,٠٠٠ ريال</option>
          <option>٥٠٠,٠٠٠ — ١,٠٠٠,٠٠٠ ريال</option>
          <option>أكثر من ١,٠٠٠,٠٠٠ ريال</option>
        </select>
      </div>
      <div class="form-group">
        <label for="cf-message">رسالتك *</label>
        <textarea id="cf-message" name="message" placeholder="اكتب تفاصيل مشروعك هنا…" required></textarea>
      </div>
      <div id="form-message" class="form-msg" style="display:none"></div>
      <button type="submit" class="btn-primary" style="width:100%;padding:1.1rem;font-size:1rem">إرسال الرسالة ←</button>
    </form>
  </div>

  <!-- Info -->
  <div class="contact-info rv d2">
    <div class="contact-info-card">
      <h3>معلومات التواصل</h3>
      <?php if ($opts['company_phone']) : ?>
      <div class="contact-info-item">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8 19.79 19.79 0 01.01 2.18 2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
        <a href="tel:<?php echo esc_attr($opts['company_phone']); ?>"><?php echo esc_html($opts['company_phone']); ?></a>
      </div>
      <?php endif; ?>
      <?php if ($opts['company_email']) : ?>
      <div class="contact-info-item">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        <a href="mailto:<?php echo esc_attr($opts['company_email']); ?>"><?php echo esc_html($opts['company_email']); ?></a>
      </div>
      <?php endif; ?>
      <?php if ($opts['company_address']) : ?>
      <div class="contact-info-item">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
        <?php echo esc_html($opts['company_address']); ?>
      </div>
      <?php endif; ?>
      <?php if ($opts['company_whatsapp']) : ?>
      <div class="contact-info-item">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        <a href="https://wa.me/<?php echo esc_attr(preg_replace('/\D/','',$opts['company_whatsapp'])); ?>" target="_blank">واتساب</a>
      </div>
      <?php endif; ?>
    </div>

    <div class="contact-info-card">
      <h3>ساعات العمل</h3>
      <div class="contact-info-item" style="justify-content:space-between"><span>الأحد — الخميس</span><span style="color:var(--white)">٨ ص — ٦ م</span></div>
      <div class="contact-info-item" style="justify-content:space-between"><span>الجمعة</span><span style="color:var(--white)">٩ ص — ١ م</span></div>
      <div class="contact-info-item" style="justify-content:space-between"><span>السبت</span><span style="color:var(--gold)">عطلة رسمية</span></div>
    </div>

    <div class="contact-info-card">
      <h3>تابعنا</h3>
      <div class="foot-social" style="margin-top:.5rem"><?php echo gcs_social_links(); ?></div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
