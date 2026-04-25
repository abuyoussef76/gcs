<?php
/**
 * GCS Theme — Single Project
 */
get_header();
while (have_posts()) : the_post();
$loc    = get_post_meta(get_the_ID(),'_project_location',true);
$year   = get_post_meta(get_the_ID(),'_project_year',true);
$type   = get_post_meta(get_the_ID(),'_project_type',true);
$area   = get_post_meta(get_the_ID(),'_project_area',true);
$client = get_post_meta(get_the_ID(),'_project_client',true);
$terms  = get_the_terms(get_the_ID(),'project_category');
$cat    = $terms ? $terms[0]->name : $type;
$hero   = get_the_post_thumbnail_url(get_the_ID(),'gcs-hero');
?>

<!-- Hero -->
<section style="height:80vh;min-height:500px;position:relative;overflow:hidden">
  <?php if ($hero) : ?>
    <img src="<?php echo esc_url($hero); ?>" alt="<?php the_title_attribute(); ?>" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover">
  <?php else : ?>
    <div style="position:absolute;inset:0;background:linear-gradient(135deg,#1a1207,#060606)"></div>
  <?php endif; ?>
  <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.85) 0%,rgba(0,0,0,.3) 60%,rgba(0,0,0,.5) 100%)"></div>
  <div style="position:absolute;bottom:0;right:0;left:0;padding:4rem 7rem">
    <?php if ($cat) : ?><div style="font-size:.65rem;letter-spacing:4px;color:var(--gold);text-transform:uppercase;margin-bottom:.8rem"><?php echo esc_html($cat); ?></div><?php endif; ?>
    <h1 style="font-size:clamp(2.5rem,5vw,4.5rem);font-weight:900;line-height:1.1;margin-bottom:1.5rem"><?php the_title(); ?></h1>
    <div style="display:flex;gap:2rem;flex-wrap:wrap">
      <?php if ($loc)    : ?><span style="font-size:.85rem;color:rgba(247,242,232,.6)">📍 <?php echo esc_html($loc); ?></span><?php endif; ?>
      <?php if ($year)   : ?><span style="font-size:.85rem;color:rgba(247,242,232,.6)">📅 <?php echo esc_html($year); ?></span><?php endif; ?>
      <?php if ($client) : ?><span style="font-size:.85rem;color:rgba(247,242,232,.6)">👤 <?php echo esc_html($client); ?></span><?php endif; ?>
    </div>
  </div>
</section>

<!-- Content + Details -->
<div style="display:grid;grid-template-columns:2fr 1fr;gap:5rem;padding:6rem 7rem;max-width:1440px;margin:0 auto">

  <!-- Description -->
  <div class="page-content rv">
    <div class="sec-tag">تفاصيل المشروع</div>
    <h2 class="sec-title" style="margin-bottom:2rem">نبذة <span class="g">عن المشروع</span></h2>
    <?php the_content(); ?>
    <?php if (!get_the_content()) : ?>
      <p style="color:var(--gray);line-height:1.9"><?php echo esc_html(get_the_excerpt()); ?></p>
    <?php endif; ?>

    <!-- Gallery -->
    <?php
    $gallery = get_post_meta(get_the_ID(),'_project_gallery',true);
    $imgs = get_attached_media('image', get_the_ID());
    if ($imgs) :
    ?>
    <div style="margin-top:3rem">
      <h3 style="font-size:1rem;letter-spacing:2px;color:var(--gold);text-transform:uppercase;margin-bottom:1.5rem">صور المشروع</h3>
      <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:2px">
        <?php foreach (array_slice($imgs,0,6) as $img) :
          echo '<img src="' . esc_url(wp_get_attachment_image_url($img->ID,'gcs-thumb')) . '" alt="' . esc_attr($img->post_title) . '" loading="lazy" style="width:100%;aspect-ratio:4/3;object-fit:cover;transition:transform .4s" onmouseenter="this.style.transform=\'scale(1.02)\'" onmouseleave="this.style.transform=\'\'">';
        endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>

  <!-- Sidebar Details -->
  <div class="rv d2">
    <div style="background:var(--dark2);border:.5px solid rgba(201,168,76,.2);padding:2.5rem;position:sticky;top:6rem">
      <h3 style="font-size:.8rem;letter-spacing:3px;color:var(--gold);text-transform:uppercase;margin-bottom:1.5rem">بيانات المشروع</h3>
      <?php
      $details = [
        ['الموقع',  $loc],   ['السنة',   $year],
        ['النوع',   $type],  ['المساحة', $area],
        ['العميل',  $client],
      ];
      foreach ($details as $d) :
        if (!$d[1]) continue;
      ?>
      <div style="padding:.9rem 0;border-bottom:.5px solid rgba(255,255,255,.06);display:flex;justify-content:space-between;align-items:center">
        <span style="font-size:.78rem;color:var(--gray);letter-spacing:.5px"><?php echo esc_html($d[0]); ?></span>
        <span style="font-size:.88rem;color:var(--white);font-weight:500"><?php echo esc_html($d[1]); ?></span>
      </div>
      <?php endforeach; ?>
      <?php if ($terms) :
        echo '<div style="padding:.9rem 0;border-bottom:.5px solid rgba(255,255,255,.06);display:flex;justify-content:space-between;align-items:center">';
        echo '<span style="font-size:.78rem;color:var(--gray)">التصنيف</span>';
        echo '<span style="font-size:.88rem;color:var(--gold)">' . esc_html($terms[0]->name) . '</span>';
        echo '</div>';
      endif; ?>
      <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-primary" style="width:100%;text-align:center;margin-top:2rem;display:block">
        اطلب مشروعاً مماثلاً
      </a>
    </div>
  </div>
</div>

<!-- Related Projects -->
<?php
$related = get_posts([
  'post_type'      => 'gcs_project',
  'posts_per_page' => 3,
  'post__not_in'   => [get_the_ID()],
  'orderby'        => 'rand',
]);
if ($related) :
?>
<section style="background:var(--dark2);padding:6rem 7rem">
  <div style="margin-bottom:3rem">
    <div class="sec-tag">استكشف المزيد</div>
    <h2 class="sec-title">مشاريع <span class="g">ذات صلة</span></h2>
  </div>
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2px;background:rgba(201,168,76,.1)">
    <?php foreach ($related as $i => $rp) :
      $t = get_the_post_thumbnail_url($rp->ID,'gcs-project');
      $rl = get_post_meta($rp->ID,'_project_location',true);
      $ry = get_post_meta($rp->ID,'_project_year',true);
    ?>
    <a href="<?php echo esc_url(get_permalink($rp->ID)); ?>" class="rv" style="position:relative;aspect-ratio:4/5;overflow:hidden;display:block <?php echo $i ? "transition-delay:".($i*.15)."s" : ''; ?>">
      <?php if ($t) : ?><img src="<?php echo esc_url($t); ?>" alt="<?php echo esc_attr($rp->post_title); ?>" loading="lazy" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform .6s cubic-bezier(.4,0,.2,1)" onmouseenter="this.style.transform='scale(1.06)'" onmouseleave="this.style.transform=''">
      <?php else : ?><div style="position:absolute;inset:0;background:var(--dark4)"></div><?php endif; ?>
      <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.85) 0%,transparent 60%)"></div>
      <div style="position:absolute;bottom:2rem;right:2rem;left:2rem">
        <div style="font-size:1.1rem;font-weight:700;margin-bottom:.3rem"><?php echo esc_html($rp->post_title); ?></div>
        <div style="font-size:.78rem;color:rgba(247,242,232,.5)"><?php echo esc_html(trim("$ry · $rl",' · ')); ?></div>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php endwhile; get_footer(); ?>
