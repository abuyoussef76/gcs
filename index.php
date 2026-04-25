<?php
/**
 * GCS Theme — Homepage / Main Template
 */
get_header();
$opts = gcs_get_options();
?>

<!-- ===== HERO SLIDER ===== -->
<section class="gcs-slider" id="gcs-slider" aria-label="السلايدر الرئيسي">

  <?php for ($i = 1; $i <= 3; $i++) :
    $slide_img = get_theme_mod("gcs_hero_slide{$i}_image");
    $img_url   = $slide_img ? wp_get_attachment_image_url($slide_img, 'gcs-hero') : '';
    $tag   = $opts["hero_slide{$i}_tag"];
    $title = $opts["hero_slide{$i}_title"];
    $sub   = $opts["hero_slide{$i}_sub"];
    $active = $i === 1 ? 'active' : '';
  ?>
  <div class="slide <?php echo esc_attr($active); ?>" id="slide-<?php echo $i; ?>">
    <div class="slide-bg">
      <?php if ($img_url) : ?>
        <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($title); ?>" class="slide-img" loading="<?php echo $i === 1 ? 'eager' : 'lazy'; ?>">
      <?php else : ?>
        <div class="slide-fallback s<?php echo $i; ?>-bg"></div>
      <?php endif; ?>
    </div>
    <div class="slide-geo"><?php get_template_part('template-parts/slide-geo', null, ['slide' => $i]); ?></div>
    <div class="slide-overlay"></div>
    <div class="slide-content">
      <div class="slide-inner">
        <div class="slide-tag"><?php echo esc_html($tag); ?></div>
        <h1 class="slide-title"><?php echo wp_kses_post($title); ?></h1>
        <p class="slide-sub"><?php echo esc_html($sub); ?></p>
        <div class="slide-btns">
          <a href="#projects" class="btn-primary"><?php _e('شاهد أعمالنا', 'gcs-theme'); ?></a>
          <a href="#services" class="btn-outline"><?php _e('خدماتنا', 'gcs-theme'); ?></a>
        </div>
      </div>
    </div>
  </div>
  <?php endfor; ?>

  <!-- Dots -->
  <div class="slider-dots" id="slider-dots" aria-label="تنقل السلايدر">
    <button class="dot active" data-slide="0" aria-label="الشريحة 1"></button>
    <button class="dot" data-slide="1" aria-label="الشريحة 2"></button>
    <button class="dot" data-slide="2" aria-label="الشريحة 3"></button>
  </div>

  <!-- Arrows -->
  <div class="slider-arrows">
    <button class="arr-btn" id="slide-next" aria-label="التالي">&#8592;</button>
    <button class="arr-btn" id="slide-prev" aria-label="السابق">&#8594;</button>
  </div>

  <!-- Scroll indicator -->
  <div class="scroll-ind" aria-hidden="true">
    <div class="scroll-line"></div>
    <span>اكتشف</span>
  </div>

  <!-- Stats Bar -->
  <div class="stats-bar" role="region" aria-label="إحصائيات الشركة">
    <div class="stat">
      <div class="stat-icon" aria-hidden="true">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 9L12 2L21 9V20A1 1 0 0120 21H15V16H9V21H4A1 1 0 013 20V9Z"/></svg>
      </div>
      <div><div class="stat-num"><?php echo esc_html($opts['stat_projects']); ?></div><div class="stat-lbl">مشروع منجز</div></div>
    </div>
    <div class="stat">
      <div class="stat-icon" aria-hidden="true">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <div><div class="stat-num"><?php echo esc_html($opts['stat_years']); ?></div><div class="stat-lbl">سنة خبرة</div></div>
    </div>
    <div class="stat">
      <div class="stat-icon" aria-hidden="true">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
      </div>
      <div><div class="stat-num"><?php echo esc_html($opts['stat_clients']); ?></div><div class="stat-lbl">عميل راضٍ</div></div>
    </div>
    <div class="stat">
      <div class="stat-icon" aria-hidden="true">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      </div>
      <div><div class="stat-num"><?php echo esc_html($opts['stat_awards']); ?></div><div class="stat-lbl">جائزة تميز</div></div>
    </div>
  </div>
</section>

<!-- ===== MARQUEE ===== -->
<div class="marquee-wrap" aria-hidden="true">
  <div class="marquee-track">
    <?php
    $items = ['مقاولات عامة', 'ديكور داخلي فاخر', 'تشطيبات احترافية', 'واجهات وأسقف', 'تصميم حدائق', 'استشارات هندسية'];
    for ($r = 0; $r < 3; $r++) {
        foreach ($items as $item) {
            echo '<div class="marquee-item">' . esc_html($item) . '</div>';
        }
    }
    ?>
  </div>
</div>

<!-- ===== SERVICES ===== -->
<section class="gcs-sec" id="services" aria-labelledby="services-title">
  <div class="rv">
    <div class="sec-tag">خدماتنا المتميزة</div>
    <h2 class="sec-title" id="services-title">كل ما تحتاجه في <span class="g">مكان واحد</span></h2>
    <div class="gold-bar"></div>
  </div>

  <div class="services-grid" role="list">
    <?php
    $services = gcs_get_services(6);
    if ($services) :
        foreach ($services as $idx => $srv) :
            $icon = get_post_meta($srv->ID, '_service_icon', true);
            $num  = ['١','٢','٣','٤','٥','٦'][$idx] ?? ($idx+1);
            $delay = $idx % 3 === 0 ? '' : ($idx % 3 === 1 ? ' d1' : ' d2');
    ?>
    <article class="srv rv<?php echo $delay; ?>" role="listitem">
      <div class="srv-num" aria-hidden="true"><?php echo esc_html($num); ?></div>
      <?php if ($icon) : echo wp_kses_post($icon);
      else : ?>
        <svg class="srv-icon" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M8 40V20L24 8L40 20V40"/><rect x="18" y="28" width="12" height="12"/></svg>
      <?php endif; ?>
      <h3 class="srv-name"><?php echo esc_html($srv->post_title); ?></h3>
      <p class="srv-desc"><?php echo esc_html(wp_trim_words($srv->post_excerpt ?: $srv->post_content, 20)); ?></p>
      <a href="<?php echo esc_url(get_permalink($srv->ID)); ?>" class="srv-link">اعرف أكثر ←</a>
    </article>
    <?php endforeach;
    else :
        get_template_part('template-parts/default-services');
    endif; ?>
  </div>
</section>

<!-- ===== PROJECTS ===== -->
<section class="proj-sec" id="projects" aria-labelledby="projects-title">
  <div class="proj-head rv">
    <div class="sec-tag">معرض أعمالنا</div>
    <h2 class="sec-title" id="projects-title">مشاريع تتحدث <span class="g">عن نفسها</span></h2>
    <a href="<?php echo esc_url(get_post_type_archive_link('gcs_project')); ?>" class="see-all-link">مشاهدة جميع المشاريع ←</a>
  </div>

  <div class="proj-scroll" role="list">
    <?php
    $projects = gcs_get_projects(8, true) ?: gcs_get_projects(8);
    $bg_classes = ['p1-bg','p2-bg','p3-bg','p4-bg','p5-bg'];
    if ($projects) :
        foreach ($projects as $idx => $proj) :
            $thumb  = get_the_post_thumbnail_url($proj->ID, 'gcs-project');
            $loc    = get_post_meta($proj->ID, '_project_location', true);
            $year   = get_post_meta($proj->ID, '_project_year',     true);
            $type   = get_post_meta($proj->ID, '_project_type',     true);
            $terms  = get_the_terms($proj->ID, 'project_category');
            $cat    = $terms ? $terms[0]->name : $type;
            $bgcls  = $bg_classes[$idx % count($bg_classes)];
    ?>
    <article class="proj-card" role="listitem">
      <div class="proj-bg <?php echo esc_attr($bgcls); ?>">
        <?php if ($thumb) : ?>
          <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($proj->post_title); ?>" loading="lazy">
        <?php else : ?>
          <?php get_template_part('template-parts/proj-pattern', null, ['idx' => $idx]); ?>
        <?php endif; ?>
      </div>
      <div class="proj-ov" aria-hidden="true"></div>
      <a href="<?php echo esc_url(get_permalink($proj->ID)); ?>" class="proj-link" aria-label="<?php echo esc_attr($proj->post_title); ?>">
        <div class="proj-info">
          <?php if ($cat) : ?><div class="proj-cat"><?php echo esc_html($cat); ?></div><?php endif; ?>
          <div class="proj-name"><?php echo esc_html($proj->post_title); ?></div>
          <?php if ($loc || $year) : ?><div class="proj-loc"><?php echo esc_html(trim("$year · $loc", ' · ')); ?></div><?php endif; ?>
        </div>
      </a>
    </article>
    <?php endforeach;
    else :
        get_template_part('template-parts/default-projects');
    endif; ?>
  </div>
</section>

<!-- ===== WHY US ===== -->
<section class="why-sec" id="why" aria-labelledby="why-title">
  <div class="why-vis rv" aria-hidden="true">
    <div class="why-main-box">
      <?php if (has_custom_logo()) : the_custom_logo();
      else : ?>
        <svg width="180" height="180" viewBox="0 0 200 200" fill="none">
          <rect x="20" y="20" width="160" height="160" stroke="rgba(201,168,76,0.3)" stroke-width="1"/>
          <rect x="40" y="40" width="120" height="120" stroke="rgba(201,168,76,0.2)" stroke-width="0.5"/>
          <circle cx="100" cy="100" r="40" stroke="rgba(201,168,76,0.4)" stroke-width="1"/>
          <circle cx="100" cy="100" r="20" stroke="rgba(201,168,76,0.6)" stroke-width="1"/>
          <circle cx="100" cy="100" r="5" fill="rgba(201,168,76,0.8)"/>
        </svg>
      <?php endif; ?>
    </div>
    <div class="why-sec-box"></div>
    <div class="why-teal-line"></div>
    <div class="why-badge" aria-label="<?php echo esc_attr($opts['stat_years']); ?> من التميز">
      <div class="why-badge-n"><?php echo esc_html($opts['stat_years']); ?></div>
      <div class="why-badge-t">سنة تميز</div>
    </div>
  </div>

  <div class="why-content">
    <div class="sec-tag rv">لماذا تختارنا</div>
    <h2 class="sec-title rv" id="why-title">الجودة ليست<br><span class="g">خياراً — هي التزام</span></h2>
    <div class="gold-bar rv"></div>
    <div class="why-feats">
      <?php
      $feats = [
        ['★', 'فريق نخبة من المهندسين', 'أكثر من ١٥٠ مهندساً ومصمماً بخبرات تمتد لعقود في أرقى المشاريع.'],
        ['◈', 'أجود خامات التشطيب', 'مواد مستوردة من أوروبا وآسيا لجمالية دائمة وجودة لا تتآكل.'],
        ['⬡', 'التسليم في الموعد', 'جدول زمني دقيق وضمان تسليم مشروعك في الموعد دون تنازل عن الجودة.'],
        ['◇', 'ضمان شامل بعد التسليم', 'فريق صيانة متاح على مدار الساعة وضمان كامل على جميع أعمالنا.'],
      ];
      foreach ($feats as $idx => $feat) :
        $delay = $idx === 0 ? '' : " d{$idx}";
      ?>
      <div class="why-feat rv<?php echo $delay; ?>">
        <div class="why-feat-ico" aria-hidden="true"><?php echo $feat[0]; ?></div>
        <div>
          <div class="why-feat-h"><?php echo esc_html($feat[1]); ?></div>
          <div class="why-feat-p"><?php echo esc_html($feat[2]); ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <a href="<?php echo esc_url(home_url('/about')); ?>" class="btn-primary" style="margin-top:2rem;display:inline-block">اعرف أكثر عنا ←</a>
  </div>
</section>

<!-- ===== TESTIMONIALS ===== -->
<section class="testi-sec" id="testimonials" aria-labelledby="testi-title">
  <div class="rv">
    <div class="sec-tag">آراء عملائنا</div>
    <h2 class="sec-title" id="testi-title">ثقتهم <span class="g">أكبر جائزة</span></h2>
  </div>
  <div class="testi-grid" role="list">
    <?php
    $testis = gcs_get_testimonials(3);
    if ($testis) :
        foreach ($testis as $idx => $t) :
            $author = get_post_meta($t->ID, '_testi_author', true);
            $loc    = get_post_meta($t->ID, '_testi_loc',    true);
            $rating = get_post_meta($t->ID, '_testi_rating', true) ?: 5;
            $init   = mb_substr($author ?: $t->post_title, 0, 1);
            $delay  = $idx === 0 ? '' : " d{$idx}";
    ?>
    <article class="testi-card rv<?php echo $delay; ?>" role="listitem">
      <div class="testi-stars" aria-label="<?php echo esc_attr($rating); ?> نجوم">
        <?php echo str_repeat('★', $rating) . str_repeat('☆', 5-$rating); ?>
      </div>
      <div class="testi-q" aria-hidden="true">"</div>
      <blockquote class="testi-txt"><?php echo esc_html(wp_trim_words($t->post_content, 35)); ?></blockquote>
      <div class="testi-auth">
        <?php if (has_post_thumbnail($t->ID)) :
            echo get_the_post_thumbnail($t->ID, [44,44], ['class'=>'auth-av auth-img','alt'=>esc_attr($author)]);
        else : ?>
          <div class="auth-av" aria-hidden="true"><?php echo esc_html($init); ?></div>
        <?php endif; ?>
        <div>
          <div class="auth-name"><?php echo esc_html($author ?: $t->post_title); ?></div>
          <?php if ($loc) : ?><div class="auth-loc"><?php echo esc_html($loc); ?></div><?php endif; ?>
        </div>
      </div>
    </article>
    <?php endforeach;
    else :
        get_template_part('template-parts/default-testimonials');
    endif; ?>
  </div>
</section>

<!-- ===== CTA ===== -->
<section class="cta-sec" id="contact" aria-labelledby="cta-title">
  <div class="rv cta-inner">
    <h2 class="cta-title" id="cta-title">هل أنت مستعد لبناء<br><span class="g">مشروعك الأحلام؟</span></h2>
    <p class="cta-sub">تواصل مع فريق <?php echo esc_html($opts['company_name_ar']); ?> واحصل على استشارة مجانية</p>
    <div class="cta-btns">
      <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-primary">احجز استشارة مجانية ←</a>
      <?php if ($opts['company_phone']) : ?>
        <a href="tel:<?php echo esc_attr($opts['company_phone']); ?>" class="btn-outline">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-5-5 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
          <?php echo esc_html($opts['company_phone']); ?>
        </a>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
