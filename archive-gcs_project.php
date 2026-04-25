<?php
/**
 * GCS Theme — Projects Archive
 */
get_header();
$cats = get_terms(['taxonomy'=>'project_category','hide_empty'=>true]);
?>

<section class="page-hero">
  <div class="page-hero-content rv">
    <div class="page-hero-tag">معرض الأعمال</div>
    <h1 class="page-hero-title">مشاريعنا <span style="color:var(--gold)">المتميزة</span></h1>
    <p class="page-hero-sub">أكثر من ٥٠٠ مشروع منجز — كل مشروع قصة نجاح تُحكى</p>
  </div>
</section>

<!-- Filter Bar -->
<?php if ($cats) : ?>
<div style="padding:3rem 7rem 0;background:var(--dark2)">
  <div style="display:flex;gap:1rem;flex-wrap:wrap;border-bottom:.5px solid rgba(201,168,76,.15);padding-bottom:0">
    <button class="proj-filter-btn active" data-cat="all" style="padding:.7rem 1.8rem;background:transparent;border:none;color:var(--gold);font-family:var(--font-primary);font-size:.85rem;letter-spacing:1px;cursor:none;border-bottom:2px solid var(--gold);margin-bottom:-1px;transition:all .3s">الكل</button>
    <?php foreach ($cats as $cat) : ?>
    <button class="proj-filter-btn" data-cat="<?php echo esc_attr($cat->slug); ?>" style="padding:.7rem 1.8rem;background:transparent;border:none;color:var(--gray);font-family:var(--font-primary);font-size:.85rem;letter-spacing:1px;cursor:none;border-bottom:2px solid transparent;margin-bottom:-1px;transition:all .3s" onmouseenter="if(!this.classList.contains('active'))this.style.color='var(--white)'" onmouseleave="if(!this.classList.contains('active'))this.style.color='var(--gray)'"><?php echo esc_html($cat->name); ?></button>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>

<!-- Projects Grid -->
<div style="background:var(--dark2);padding:2px 7rem 7rem">
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2px;background:rgba(201,168,76,.1);margin-top:2px">
  <?php
  $paged = get_query_var('paged') ?: 1;
  $q = new WP_Query(['post_type'=>'gcs_project','posts_per_page'=>12,'paged'=>$paged]);
  $bgs = ['p1-bg','p2-bg','p3-bg','p4-bg','p5-bg'];
  $i = 0;
  while ($q->have_posts()) : $q->the_post();
    $loc   = get_post_meta(get_the_ID(),'_project_location',true);
    $year  = get_post_meta(get_the_ID(),'_project_year',true);
    $type  = get_post_meta(get_the_ID(),'_project_type',true);
    $terms = get_the_terms(get_the_ID(),'project_category');
    $cat   = $terms ? $terms[0]->name : $type;
    $slug  = $terms ? $terms[0]->slug : '';
    $thumb = get_the_post_thumbnail_url(get_the_ID(),'gcs-project');
    $bg    = $bgs[$i % count($bgs)];
  ?>
  <article class="proj-card-filterable rv" data-cat="<?php echo esc_attr($slug); ?>"
    style="aspect-ratio:3/4;position:relative;overflow:hidden;transition:opacity .4s,transform .4s">
    <div class="proj-bg <?php echo esc_attr($bg); ?>" style="position:absolute;inset:0;transition:transform .6s cubic-bezier(.4,0,.2,1)">
      <?php if ($thumb) : ?>
        <img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" style="width:100%;height:100%;object-fit:cover">
      <?php endif; ?>
    </div>
    <div class="proj-ov" style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.92) 0%,rgba(0,0,0,.2) 55%,transparent 100%)"></div>
    <a href="<?php the_permalink(); ?>" style="position:absolute;inset:0;display:flex;align-items:flex-end">
      <div style="padding:2rem;transform:translateY(8px);transition:transform .4s;width:100%">
        <?php if ($cat) : ?><div style="font-size:.65rem;letter-spacing:4px;color:var(--gold);text-transform:uppercase;margin-bottom:.4rem"><?php echo esc_html($cat); ?></div><?php endif; ?>
        <div style="font-size:1.25rem;font-weight:700"><?php the_title(); ?></div>
        <?php if ($loc || $year) : ?><div style="font-size:.8rem;color:rgba(247,242,232,.5);margin-top:.3rem"><?php echo esc_html(trim("$year · $loc",' · ')); ?></div><?php endif; ?>
      </div>
    </a>
  </article>
  <?php $i++; endwhile; wp_reset_postdata(); ?>
  </div>

  <!-- Pagination -->
  <?php if ($q->max_num_pages > 1) : ?>
  <div style="display:flex;justify-content:center;gap:1rem;margin-top:4rem">
    <?php
    echo paginate_links([
      'total'     => $q->max_num_pages,
      'current'   => $paged,
      'prev_text' => '→',
      'next_text' => '←',
      'type'      => 'list',
    ]);
    ?>
  </div>
  <?php endif; ?>
</div>

<!-- CTA -->
<section class="cta-sec">
  <div class="rv cta-inner">
    <h2 class="cta-title">هل مشروعك <span class="g">القادم</span> جاهز؟</h2>
    <p class="cta-sub">تواصل معنا اليوم واحصل على استشارة مجانية</p>
    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-primary">احجز استشارة مجانية ←</a>
  </div>
</section>

<?php get_footer(); ?>
