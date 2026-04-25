<?php
/**
 * GCS Theme — Search Results
 */
get_header();
$query = get_search_query();
?>

<section class="page-hero">
  <div class="page-hero-content rv">
    <div class="page-hero-tag">نتائج البحث</div>
    <h1 class="page-hero-title">البحث عن: <span style="color:var(--gold)"><?php echo esc_html($query); ?></span></h1>
    <?php if (have_posts()) : ?>
      <p class="page-hero-sub"><?php printf('تم العثور على %d نتيجة', $wp_query->found_posts); ?></p>
    <?php endif; ?>
  </div>
</section>

<!-- Search Bar -->
<div style="padding:3rem 7rem;background:var(--dark2);border-bottom:.5px solid rgba(201,168,76,.1)">
  <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" style="display:flex;max-width:600px;gap:0">
    <input type="search" name="s" value="<?php echo esc_attr($query); ?>" placeholder="بحث جديد…"
      style="flex:1;padding:.9rem 1.4rem;background:var(--dark3);border:.5px solid rgba(201,168,76,.25);color:var(--white);font-family:var(--font-primary);font-size:.95rem;outline:none;direction:rtl">
    <button type="submit" style="padding:.9rem 2rem;background:var(--gold);color:var(--dark);border:none;font-family:var(--font-primary);font-size:.95rem;font-weight:700;cursor:pointer;white-space:nowrap">بحث ←</button>
  </form>
</div>

<div style="padding:5rem 7rem;max-width:1440px;margin:0 auto">
  <?php if (have_posts()) : ?>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2px;background:rgba(201,168,76,.1)">
      <?php while (have_posts()) : the_post(); ?>
      <article style="background:var(--dark2);padding:2.5rem;transition:background .3s" onmouseenter="this.style.background='var(--dark3)'" onmouseleave="this.style.background='var(--dark2)'">
        <?php if (has_post_thumbnail()) : ?>
          <a href="<?php the_permalink(); ?>" style="display:block;overflow:hidden;margin-bottom:1.5rem;aspect-ratio:16/9">
            <?php the_post_thumbnail('gcs-thumb', ['style'=>'width:100%;height:100%;object-fit:cover;transition:transform .5s','onmouseenter'=>"this.style.transform='scale(1.04)'", 'onmouseleave'=>"this.style.transform=''"]); ?>
          </a>
        <?php endif; ?>
        <div style="font-size:.65rem;letter-spacing:3px;color:var(--gold);text-transform:uppercase;margin-bottom:.6rem">
          <?php echo esc_html(get_post_type_labels(get_post_type_object(get_post_type()))->singular_name ?? get_post_type()); ?>
        </div>
        <h2 style="font-size:1.15rem;font-weight:700;margin-bottom:.8rem;line-height:1.4">
          <a href="<?php the_permalink(); ?>" style="transition:color .3s" onmouseenter="this.style.color='var(--gold)'" onmouseleave="this.style.color=''"><?php the_title(); ?></a>
        </h2>
        <p style="font-size:.88rem;color:var(--gray);line-height:1.8;margin-bottom:1.2rem"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
        <a href="<?php the_permalink(); ?>" style="font-size:.8rem;color:var(--teal2);letter-spacing:.5px">اقرأ أكثر ←</a>
      </article>
      <?php endwhile; ?>
    </div>

    <!-- Pagination -->
    <div style="display:flex;justify-content:center;margin-top:4rem">
      <?php
      the_posts_pagination(['prev_text'=>'→','next_text'=>'←','mid_size'=>2]);
      ?>
    </div>

  <?php else : ?>
    <div style="text-align:center;padding:6rem 0">
      <div style="font-size:4rem;margin-bottom:1.5rem;opacity:.3">🔍</div>
      <h2 style="font-size:1.8rem;font-weight:700;margin-bottom:1rem">لا توجد نتائج لـ "<?php echo esc_html($query); ?>"</h2>
      <p style="color:var(--gray);margin-bottom:2rem">جرب كلمات بحث مختلفة أو تصفح أقسام الموقع</p>
      <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">الرئيسية</a>
        <a href="<?php echo esc_url(get_post_type_archive_link('gcs_project')); ?>" class="btn-outline">أعمالنا</a>
        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-outline">تواصل</a>
      </div>
    </div>
  <?php endif; ?>
</div>

<?php get_footer(); ?>
