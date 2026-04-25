<?php
/**
 * GCS Theme — Blog Archive (home.php)
 */
get_header(); ?>

<section class="page-hero">
  <div class="page-hero-content rv">
    <div class="page-hero-tag">المدونة</div>
    <h1 class="page-hero-title">مقالات & <span style="color:var(--gold)">أخبار</span></h1>
    <p class="page-hero-sub">آخر مستجدات عالم المقاولات والديكور والتصميم المعماري</p>
  </div>
</section>

<div style="padding:5rem 7rem;max-width:1440px;margin:0 auto">
  <?php if (have_posts()) : ?>

  <div style="display:grid;grid-template-columns:2fr 1fr;gap:5rem">

    <!-- Posts -->
    <div>
      <?php while (have_posts()) : the_post(); ?>
      <article class="rv" style="margin-bottom:3rem;padding-bottom:3rem;border-bottom:.5px solid rgba(201,168,76,.1)">
        <?php if (has_post_thumbnail()) : ?>
          <a href="<?php the_permalink(); ?>" style="display:block;overflow:hidden;margin-bottom:1.8rem;aspect-ratio:16/9">
            <?php the_post_thumbnail('gcs-thumb', ['style'=>'width:100%;height:100%;object-fit:cover;transition:transform .6s cubic-bezier(.4,0,.2,1)', 'onmouseenter'=>"this.style.transform='scale(1.04)'",'onmouseleave'=>"this.style.transform=''"]); ?>
          </a>
        <?php endif; ?>

        <div style="display:flex;align-items:center;gap:1.5rem;margin-bottom:1rem;flex-wrap:wrap">
          <?php $cats = get_the_category(); if ($cats) : ?>
            <a href="<?php echo esc_url(get_category_link($cats[0]->term_id)); ?>" style="font-size:.65rem;letter-spacing:3px;color:var(--gold);text-transform:uppercase;text-decoration:none">
              <?php echo esc_html($cats[0]->name); ?>
            </a>
          <?php endif; ?>
          <span style="font-size:.78rem;color:var(--gray2)"><?php the_date('j F Y'); ?></span>
          <span style="font-size:.78rem;color:var(--gray2)">⏱ <?php echo esc_html(ceil(str_word_count(strip_tags(get_the_content())) / 200)); ?> دقائق قراءة</span>
        </div>

        <h2 style="font-size:1.7rem;font-weight:900;line-height:1.3;margin-bottom:1rem">
          <a href="<?php the_permalink(); ?>" style="transition:color .3s" onmouseenter="this.style.color='var(--gold)'" onmouseleave="this.style.color=''"><?php the_title(); ?></a>
        </h2>
        <p style="font-size:.95rem;color:var(--gray);line-height:1.9;margin-bottom:1.5rem"><?php echo wp_trim_words(get_the_excerpt(), 30); ?></p>

        <div style="display:flex;align-items:center;justify-content:space-between">
          <a href="<?php the_permalink(); ?>" style="display:inline-flex;align-items:center;gap:8px;font-size:.85rem;color:var(--teal2);letter-spacing:.5px;transition:gap .3s" onmouseenter="this.style.gap='14px'" onmouseleave="this.style.gap='8px'">اقرأ المقال ←</a>
          <div style="display:flex;align-items:center;gap:.6rem">
            <?php echo get_avatar(get_the_author_meta('email'), 32, '', '', ['style'=>'border-radius:50%;border:1px solid rgba(201,168,76,.3)']); ?>
            <span style="font-size:.8rem;color:var(--gray)"><?php the_author(); ?></span>
          </div>
        </div>
      </article>
      <?php endwhile; ?>

      <!-- Pagination -->
      <div style="display:flex;justify-content:center;margin-top:2rem">
        <?php the_posts_pagination(['prev_text'=>'→','next_text'=>'←','mid_size'=>2]); ?>
      </div>
    </div>

    <!-- Sidebar -->
    <aside style="padding-top:.5rem">
      <!-- Search -->
      <div style="background:var(--dark2);padding:2rem;margin-bottom:2rem;border:.5px solid rgba(201,168,76,.12)">
        <h3 style="font-size:.75rem;letter-spacing:3px;color:var(--gold);text-transform:uppercase;margin-bottom:1.2rem">بحث</h3>
        <form method="get" action="<?php echo esc_url(home_url('/')); ?>" style="display:flex">
          <input type="search" name="s" placeholder="ابحث…" style="flex:1;padding:.7rem 1rem;background:var(--dark3);border:.5px solid rgba(201,168,76,.2);color:var(--white);font-family:var(--font-primary);font-size:.88rem;outline:none;direction:rtl">
          <button type="submit" style="padding:.7rem 1rem;background:var(--gold);color:var(--dark);border:none;cursor:pointer;font-size:.9rem">←</button>
        </form>
      </div>

      <!-- Recent Projects -->
      <?php $recent_projects = gcs_get_projects(4); if ($recent_projects) : ?>
      <div style="background:var(--dark2);padding:2rem;margin-bottom:2rem;border:.5px solid rgba(201,168,76,.12)">
        <h3 style="font-size:.75rem;letter-spacing:3px;color:var(--gold);text-transform:uppercase;margin-bottom:1.2rem">أحدث المشاريع</h3>
        <?php foreach ($recent_projects as $rp) :
          $t = get_the_post_thumbnail_url($rp->ID, [60,60]);
        ?>
        <a href="<?php echo esc_url(get_permalink($rp->ID)); ?>" style="display:flex;gap:.8rem;align-items:center;padding:.7rem 0;border-bottom:.5px solid rgba(255,255,255,.05);text-decoration:none;transition:opacity .3s" onmouseenter="this.style.opacity='.75'" onmouseleave="this.style.opacity='1'">
          <?php if ($t) : ?><img src="<?php echo esc_url($t); ?>" alt="" style="width:48px;height:48px;object-fit:cover;flex-shrink:0"><?php endif; ?>
          <span style="font-size:.85rem;color:var(--white);line-height:1.4"><?php echo esc_html($rp->post_title); ?></span>
        </a>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <!-- Categories -->
      <?php $cats = get_categories(['hide_empty'=>true]); if ($cats) : ?>
      <div style="background:var(--dark2);padding:2rem;margin-bottom:2rem;border:.5px solid rgba(201,168,76,.12)">
        <h3 style="font-size:.75rem;letter-spacing:3px;color:var(--gold);text-transform:uppercase;margin-bottom:1.2rem">التصنيفات</h3>
        <?php foreach ($cats as $cat) : ?>
          <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" style="display:flex;justify-content:space-between;align-items:center;padding:.6rem 0;border-bottom:.5px solid rgba(255,255,255,.05);color:var(--gray);font-size:.88rem;text-decoration:none;transition:color .3s" onmouseenter="this.style.color='var(--gold)'" onmouseleave="this.style.color='var(--gray)'">
            <span><?php echo esc_html($cat->name); ?></span>
            <span style="font-size:.75rem;background:rgba(201,168,76,.1);color:var(--gold);padding:2px 8px"><?php echo $cat->count; ?></span>
          </a>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <!-- CTA Box -->
      <div style="background:linear-gradient(135deg,#1a1207,#060606);padding:2.5rem;border:.5px solid rgba(201,168,76,.3);text-align:center">
        <div style="font-size:2rem;margin-bottom:1rem">🏗️</div>
        <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:.8rem">هل لديك مشروع؟</h3>
        <p style="font-size:.85rem;color:var(--gray);line-height:1.7;margin-bottom:1.5rem">تواصل معنا للحصول على استشارة مجانية</p>
        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-primary" style="width:100%;display:block;text-align:center">تواصل معنا</a>
      </div>

    </aside>
  </div>

  <?php else : ?>
    <div style="text-align:center;padding:6rem 0">
      <p style="color:var(--gray);font-size:1.1rem">لا توجد مقالات بعد.</p>
    </div>
  <?php endif; ?>
</div>

<?php get_footer(); ?>
