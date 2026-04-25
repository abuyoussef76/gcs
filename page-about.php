<?php
/**
 * Template Name: صفحة من نحن
 */
get_header();
$opts = gcs_get_options();
?>

<section class="page-hero">
  <div class="page-hero-content rv">
    <div class="page-hero-tag">تعرف علينا</div>
    <h1 class="page-hero-title">قصة <span style="color:var(--gold)">نجوم العاصمة</span></h1>
    <p class="page-hero-sub">رحلة من الإتقان والتميز منذ أكثر من عقدين في عالم المقاولات والديكور</p>
  </div>
</section>

<!-- Story Section -->
<section class="gcs-sec" style="display:grid;grid-template-columns:1fr 1fr;gap:6rem;align-items:center;padding:7rem">
  <div class="rv">
    <div class="sec-tag">قصتنا</div>
    <h2 class="sec-title">من البداية <span class="g">حتى القمة</span></h2>
    <div class="gold-bar"></div>
    <?php the_content(); ?>
    <?php if (!get_the_content()) : ?>
    <p style="color:var(--gray);line-height:1.9;margin-bottom:1.2rem">تأسست شركة نجوم العاصمة الذهبية للمقاولات والديكور منذ أكثر من عقدين بهدف واحد: تقديم أرقى مستويات الجودة في عالم البناء والتصميم.</p>
    <p style="color:var(--gray);line-height:1.9;margin-bottom:1.2rem">بدأنا بمشاريع سكنية صغيرة وتطورنا لنصبح شركة رائدة تنفذ أضخم المشاريع التجارية والسكنية في المنطقة.</p>
    <p style="color:var(--gray);line-height:1.9">نؤمن بأن كل مشروع هو فرصة لخلق شيء استثنائي — شيء يتحدث عن نفسه ويدوم عبر الأجيال.</p>
    <?php endif; ?>
  </div>
  <div class="rv d2" style="position:relative;height:500px">
    <?php if (has_post_thumbnail()) : the_post_thumbnail('gcs-hero', ['style'=>'width:100%;height:100%;object-fit:cover']); else : ?>
    <div style="width:100%;height:100%;background:linear-gradient(135deg,#1a1207,#060606);border:1px solid rgba(201,168,76,.2);display:flex;align-items:center;justify-content:center">
      <?php if (has_custom_logo()) the_custom_logo(); ?>
    </div>
    <?php endif; ?>
    <div style="position:absolute;bottom:-24px;left:-24px;background:var(--gold);padding:2rem;text-align:center">
      <div style="font-size:2.5rem;font-weight:900;color:var(--dark)"><?php echo esc_html($opts['stat_years']); ?></div>
      <div style="font-size:.75rem;font-weight:700;color:var(--dark);letter-spacing:1px">سنة من التميز</div>
    </div>
  </div>
</section>

<!-- Mission & Vision -->
<section style="background:var(--dark2);padding:7rem">
  <div style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:2px;background:rgba(201,168,76,.12)">
    <?php
    $pillars = [
      ['🎯','رؤيتنا','أن نكون الخيار الأول في مجال المقاولات والديكور الفاخر في المنطقة العربية، بمعايير جودة تضاهي الشركات العالمية.'],
      ['💡','رسالتنا','تقديم حلول بنائية وتصميمية مبتكرة تجمع بين الجمال والوظيفية، مع الالتزام بأعلى معايير الجودة والمواعيد.'],
      ['⭐','قيمنا','الأمانة والشفافية في التعامل، الجودة في كل تفصيلة، الابتكار في التصميم، والحرص على رضا العملاء دائماً.'],
    ];
    foreach ($pillars as $i => $p) : ?>
    <div class="rv <?php echo $i ? "d{$i}" : ''; ?>" style="background:var(--dark2);padding:3rem 2.5rem;cursor:default;transition:background .3s" onmouseenter="this.style.background='var(--dark3)'" onmouseleave="this.style.background='var(--dark2)'">
      <div style="font-size:2.5rem;margin-bottom:1.2rem"><?php echo $p[0]; ?></div>
      <h3 style="font-size:1.3rem;font-weight:700;color:var(--gold);margin-bottom:1rem"><?php echo esc_html($p[1]); ?></h3>
      <p style="font-size:.9rem;color:var(--gray);line-height:1.85"><?php echo esc_html($p[2]); ?></p>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Stats -->
<section style="padding:6rem 7rem;text-align:center">
  <div class="rv" style="margin-bottom:4rem">
    <div class="sec-tag" style="justify-content:center">أرقام تتحدث عن نفسها</div>
    <h2 class="sec-title"><?php echo esc_html($opts['stat_years']); ?> سنة من <span class="g">الإنجازات</span></h2>
  </div>
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:2px;background:rgba(201,168,76,.12);max-width:900px;margin:0 auto">
    <?php
    $stats = [
      [$opts['stat_projects'],'مشروع منجز'],
      [$opts['stat_years'],'سنة خبرة'],
      [$opts['stat_clients'],'عميل سعيد'],
      [$opts['stat_awards'],'جائزة تميز'],
    ];
    foreach ($stats as $i => $s) : ?>
    <div class="rv <?php echo $i ? "d{$i}" : ''; ?>" style="padding:3rem 1.5rem;background:var(--dark2)">
      <div class="stat-num" style="font-size:3rem;font-weight:900;color:var(--gold);line-height:1;margin-bottom:.5rem"><?php echo esc_html($s[0]); ?></div>
      <div style="font-size:.78rem;color:var(--gray);letter-spacing:2px"><?php echo esc_html($s[1]); ?></div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Team -->
<?php
$team = get_posts(['post_type'=>'gcs_team','posts_per_page'=>8,'orderby'=>'menu_order','order'=>'ASC']);
if ($team) :
?>
<section style="padding:7rem;background:var(--dark2)">
  <div class="rv" style="margin-bottom:4rem">
    <div class="sec-tag">القائد خلف النجاح</div>
    <h2 class="sec-title">فريق <span class="g">نخبة المحترفين</span></h2>
  </div>
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:2px;background:rgba(201,168,76,.1)">
    <?php foreach ($team as $i => $member) :
      $pos   = get_post_meta($member->ID,'_team_position',true);
      $thumb = get_the_post_thumbnail_url($member->ID,[300,300]);
      $delay = $i % 4 === 0 ? '' : ' d' . ($i%4);
    ?>
    <div class="rv<?php echo $delay; ?>" style="background:var(--dark2);overflow:hidden;transition:background .3s" onmouseenter="this.style.background='var(--dark3)'" onmouseleave="this.style.background='var(--dark2)'">
      <?php if ($thumb) : ?>
        <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($member->post_title); ?>" style="width:100%;aspect-ratio:1;object-fit:cover;filter:grayscale(30%)">
      <?php else : ?>
        <div style="width:100%;aspect-ratio:1;background:var(--dark4);display:flex;align-items:center;justify-content:center;font-size:3rem;color:var(--gold)"><?php echo mb_substr($member->post_title,0,1); ?></div>
      <?php endif; ?>
      <div style="padding:1.5rem 1.5rem 2rem">
        <div style="font-size:1rem;font-weight:700"><?php echo esc_html($member->post_title); ?></div>
        <?php if ($pos) : ?><div style="font-size:.78rem;color:var(--gold);margin-top:.3rem;letter-spacing:.5px"><?php echo esc_html($pos); ?></div><?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<!-- Certifications / Awards -->
<section style="padding:6rem 7rem;text-align:center">
  <div class="rv">
    <div class="sec-tag" style="justify-content:center">شهاداتنا وجوائزنا</div>
    <h2 class="sec-title">اعتراف <span class="g">دولي</span> بالتميز</h2>
    <div class="gold-bar" style="margin:1.5rem auto 3rem"></div>
    <div style="display:flex;flex-wrap:wrap;gap:2rem;justify-content:center">
      <?php
      $certs = ['ISO 9001:2015','شهادة الجودة السعودية','جائزة التميز الخليجي','عضوية هيئة المقاولين'];
      foreach ($certs as $cert) : ?>
      <div style="background:var(--dark2);border:.5px solid rgba(201,168,76,.25);padding:1.2rem 2rem;font-size:.85rem;letter-spacing:1px;color:var(--gray)">
        <span style="color:var(--gold);margin-left:.5rem">✦</span><?php echo esc_html($cert); ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
