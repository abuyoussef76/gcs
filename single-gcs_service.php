<?php
/**
 * GCS Theme — Single Service
 */
get_header();
while (have_posts()) : the_post();
$icon  = get_post_meta(get_the_ID(),'_service_icon',true);
$hero  = get_the_post_thumbnail_url(get_the_ID(),'gcs-hero');
?>
<section class="page-hero" <?php if ($hero) echo 'style="background:url(' . esc_url($hero) . ') center/cover"'; ?>>
  <?php if ($hero) : ?><div style="position:absolute;inset:0;background:rgba(6,6,6,.6)"></div><?php endif; ?>
  <div class="page-hero-content rv">
    <div class="page-hero-tag">خدماتنا</div>
    <h1 class="page-hero-title"><?php the_title(); ?></h1>
    <p class="page-hero-sub"><?php echo esc_html(get_the_excerpt()); ?></p>
  </div>
</section>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:5rem;padding:6rem 7rem;max-width:1440px;margin:0 auto">
  <div class="page-content rv">
    <?php if ($icon) : ?><div style="color:var(--gold);margin-bottom:2rem"><?php echo wp_kses_post($icon); ?></div><?php endif; ?>
    <?php the_content(); ?>
  </div>
  <div class="rv d2">
    <!-- Related Services -->
    <?php
    $others = get_posts(['post_type'=>'gcs_service','posts_per_page'=>5,'post__not_in'=>[get_the_ID()],'orderby'=>'menu_order','order'=>'ASC']);
    if ($others) :
    ?>
    <div style="background:var(--dark2);border:.5px solid rgba(201,168,76,.2);padding:2rem;margin-bottom:2rem">
      <h3 style="font-size:.8rem;letter-spacing:3px;color:var(--gold);text-transform:uppercase;margin-bottom:1.2rem">خدمات أخرى</h3>
      <?php foreach ($others as $o) : ?>
        <a href="<?php echo esc_url(get_permalink($o->ID)); ?>" style="display:flex;align-items:center;gap:.8rem;padding:.8rem 0;border-bottom:.5px solid rgba(255,255,255,.06);color:var(--gray);font-size:.9rem;transition:color .3s" onmouseenter="this.style.color='var(--gold)'" onmouseleave="this.style.color='var(--gray)'">
          <span style="color:var(--gold);font-size:.6rem">◆</span>
          <?php echo esc_html($o->post_title); ?>
        </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-primary" style="display:block;text-align:center;width:100%">اطلب هذه الخدمة ←</a>
  </div>
</div>

<!-- Flexible sections -->
<?php gcs_the_sections(); ?>

<?php endwhile; get_footer(); ?>
