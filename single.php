<?php
/**
 * GCS Theme — Single Blog Post
 */
get_header();
while (have_posts()) : the_post();
$cats = get_the_category();
$read_time = ceil(str_word_count(strip_tags(get_the_content())) / 200);
?>

<!-- Hero -->
<section style="position:relative;padding:11rem 7rem 5rem;overflow:hidden">
  <?php if (has_post_thumbnail()) : ?>
    <div style="position:absolute;inset:0">
      <?php the_post_thumbnail('gcs-hero', ['style'=>'width:100%;height:100%;object-fit:cover;filter:brightness(.25)']); ?>
    </div>
  <?php else : ?>
    <div style="position:absolute;inset:0;background:linear-gradient(135deg,#1a1207,#060606)"></div>
  <?php endif; ?>
  <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(6,6,6,1) 0%,rgba(6,6,6,.5) 50%,rgba(6,6,6,.7) 100%)"></div>

  <div style="position:relative;z-index:2;max-width:800px" class="rv">
    <?php if ($cats) : ?>
      <a href="<?php echo esc_url(get_category_link($cats[0]->term_id)); ?>"
         style="display:inline-flex;align-items:center;gap:10px;font-size:.68rem;letter-spacing:4px;color:var(--gold);text-transform:uppercase;margin-bottom:1.5rem;text-decoration:none">
        <span style="display:block;width:24px;height:1px;background:var(--gold)"></span>
        <?php echo esc_html($cats[0]->name); ?>
      </a>
    <?php endif; ?>
    <h1 style="font-size:clamp(2rem,4.5vw,3.8rem);font-weight:900;line-height:1.15;margin-bottom:1.5rem"><?php the_title(); ?></h1>
    <div style="display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap">
      <div style="display:flex;align-items:center;gap:.6rem">
        <?php echo get_avatar(get_the_author_meta('email'), 38, '', '', ['style'=>'border-radius:50%;border:1px solid rgba(201,168,76,.4)']); ?>
        <span style="font-size:.85rem;color:rgba(247,242,232,.7)"><?php the_author(); ?></span>
      </div>
      <span style="font-size:.8rem;color:var(--gray2)"><?php the_date('j F Y'); ?></span>
      <span style="font-size:.8rem;color:var(--gray2)">⏱ <?php echo $read_time; ?> دقائق قراءة</span>
    </div>
  </div>
</section>

<!-- Content -->
<div style="display:grid;grid-template-columns:1fr 320px;gap:5rem;padding:5rem 7rem;max-width:1440px;margin:0 auto">

  <article>
    <!-- Share bar -->
    <div style="display:flex;align-items:center;gap:1rem;padding:1rem 0;border-bottom:.5px solid rgba(201,168,76,.1);margin-bottom:3rem">
      <span style="font-size:.75rem;color:var(--gray);letter-spacing:2px">مشاركة:</span>
      <?php
      $url   = urlencode(get_permalink());
      $title = urlencode(get_the_title());
      $shares = [
        ['واتساب',  'https://wa.me/?text=' . $title . '%20' . $url,  '#25D366'],
        ['تويتر',   'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title, '#1DA1F2'],
        ['لينكدإن', 'https://www.linkedin.com/sharing/share-offsite/?url=' . $url, '#0A66C2'],
      ];
      foreach ($shares as $s) :
      ?>
        <a href="<?php echo esc_url($s[1]); ?>" target="_blank" rel="noopener"
           style="padding:.4rem 1rem;background:<?php echo $s[2]; ?>22;border:.5px solid <?php echo $s[2]; ?>44;color:<?php echo $s[2]; ?>;font-size:.78rem;letter-spacing:.5px;text-decoration:none;transition:background .3s"
           onmouseenter="this.style.background='<?php echo $s[2]; ?>44'" onmouseleave="this.style.background='<?php echo $s[2]; ?>22'">
          <?php echo esc_html($s[0]); ?>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Post content -->
    <div class="single-post-content" style="line-height:1.95;color:rgba(247,242,232,.85)">
      <?php the_content(); ?>
      <?php wp_link_pages(['before'=>'<div style="margin-top:2rem;display:flex;gap:.8rem"><span style="color:var(--gray);font-size:.85rem">الصفحات:</span>','after'=>'</div>']); ?>
    </div>

    <!-- Tags -->
    <?php $tags = get_the_tags(); if ($tags) : ?>
    <div style="margin-top:3rem;padding-top:2rem;border-top:.5px solid rgba(201,168,76,.1)">
      <span style="font-size:.75rem;color:var(--gray);letter-spacing:2px;margin-left:1rem">الوسوم:</span>
      <?php foreach ($tags as $tag) : ?>
        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
           style="display:inline-block;margin:.3rem;padding:.3rem .9rem;background:var(--dark3);border:.5px solid rgba(201,168,76,.2);font-size:.78rem;color:var(--gray);text-decoration:none;transition:all .3s"
           onmouseenter="this.style.borderColor='var(--gold)';this.style.color='var(--gold)'" onmouseleave="this.style.borderColor='rgba(201,168,76,.2)';this.style.color='var(--gray)'">
          <?php echo esc_html($tag->name); ?>
        </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Author box -->
    <div style="margin-top:3rem;background:var(--dark2);border:.5px solid rgba(201,168,76,.15);padding:2rem;display:flex;gap:1.5rem;align-items:flex-start">
      <?php echo get_avatar(get_the_author_meta('email'), 72, '', '', ['style'=>'border-radius:50%;border:1px solid rgba(201,168,76,.3);flex-shrink:0']); ?>
      <div>
        <div style="font-size:.65rem;letter-spacing:3px;color:var(--gold);text-transform:uppercase;margin-bottom:.4rem">كاتب المقال</div>
        <div style="font-size:1.05rem;font-weight:700;margin-bottom:.5rem"><?php the_author(); ?></div>
        <?php $bio = get_the_author_meta('description'); if ($bio) : ?>
          <p style="font-size:.88rem;color:var(--gray);line-height:1.75"><?php echo esc_html($bio); ?></p>
        <?php endif; ?>
      </div>
    </div>

    <!-- Prev / Next -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:2px;margin-top:3rem;background:rgba(201,168,76,.1)">
      <?php
      $prev = get_previous_post();
      $next = get_next_post();
      if ($prev) : ?>
        <a href="<?php echo esc_url(get_permalink($prev->ID)); ?>" style="background:var(--dark2);padding:1.8rem;text-decoration:none;display:block;transition:background .3s" onmouseenter="this.style.background='var(--dark3)'" onmouseleave="this.style.background='var(--dark2)'">
          <div style="font-size:.65rem;letter-spacing:3px;color:var(--gold);margin-bottom:.5rem">→ المقال السابق</div>
          <div style="font-size:.9rem;font-weight:600;line-height:1.4"><?php echo esc_html(wp_trim_words($prev->post_title, 8)); ?></div>
        </a>
      <?php else : ?><div></div><?php endif; ?>
      <?php if ($next) : ?>
        <a href="<?php echo esc_url(get_permalink($next->ID)); ?>" style="background:var(--dark2);padding:1.8rem;text-decoration:none;display:block;text-align:left;transition:background .3s" onmouseenter="this.style.background='var(--dark3)'" onmouseleave="this.style.background='var(--dark2)'">
          <div style="font-size:.65rem;letter-spacing:3px;color:var(--gold);margin-bottom:.5rem">المقال التالي ←</div>
          <div style="font-size:.9rem;font-weight:600;line-height:1.4"><?php echo esc_html(wp_trim_words($next->post_title, 8)); ?></div>
        </a>
      <?php endif; ?>
    </div>

    <!-- Comments -->
    <?php if (comments_open() || get_comments_number()) comments_template(); ?>
  </article>

  <!-- Sticky Sidebar -->
  <aside>
    <div style="position:sticky;top:6rem;display:flex;flex-direction:column;gap:2rem">

      <!-- TOC -->
      <div style="background:var(--dark2);padding:2rem;border:.5px solid rgba(201,168,76,.12)" id="toc-box">
        <h3 style="font-size:.72rem;letter-spacing:3px;color:var(--gold);text-transform:uppercase;margin-bottom:1.2rem">محتويات المقال</h3>
        <div id="gcs-toc" style="font-size:.85rem;color:var(--gray);line-height:2">
          <script>
          document.addEventListener('DOMContentLoaded',function(){
            const toc = document.getElementById('gcs-toc');
            const heads = document.querySelectorAll('.single-post-content h2,.single-post-content h3');
            if(!heads.length){document.getElementById('toc-box').style.display='none';return;}
            heads.forEach(function(h,i){
              h.id = 'heading-'+i;
              var a = document.createElement('a');
              a.href = '#heading-'+i;
              a.textContent = h.textContent;
              a.style.cssText = 'display:block;padding:.25rem 0;color:var(--gray);text-decoration:none;transition:color .3s;padding-right:'+(h.tagName==='H3'?'1rem':'0');
              a.onmouseenter = function(){this.style.color='var(--gold)'};
              a.onmouseleave = function(){this.style.color='var(--gray)'};
              toc.appendChild(a);
            });
          });
          </script>
        </div>
      </div>

      <!-- Related -->
      <?php
      $related = get_posts(['posts_per_page'=>3,'post__not_in'=>[get_the_ID()],'category__in'=>wp_get_post_categories(get_the_ID())]);
      if ($related) :
      ?>
      <div style="background:var(--dark2);padding:2rem;border:.5px solid rgba(201,168,76,.12)">
        <h3 style="font-size:.72rem;letter-spacing:3px;color:var(--gold);text-transform:uppercase;margin-bottom:1.2rem">مقالات ذات صلة</h3>
        <?php foreach ($related as $rp) :
          $t = get_the_post_thumbnail_url($rp->ID,[60,60]);
        ?>
        <a href="<?php echo esc_url(get_permalink($rp->ID)); ?>" style="display:flex;gap:.8rem;align-items:center;padding:.7rem 0;border-bottom:.5px solid rgba(255,255,255,.05);text-decoration:none;transition:opacity .3s" onmouseenter="this.style.opacity='.7'" onmouseleave="this.style.opacity='1'">
          <?php if ($t) : ?><img src="<?php echo esc_url($t); ?>" style="width:44px;height:44px;object-fit:cover;flex-shrink:0" alt=""><?php endif; ?>
          <span style="font-size:.83rem;color:var(--white);line-height:1.4"><?php echo esc_html(wp_trim_words($rp->post_title,8)); ?></span>
        </a>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <!-- CTA -->
      <div style="background:linear-gradient(135deg,#1a1207,#060606);padding:2rem;border:.5px solid rgba(201,168,76,.3);text-align:center">
        <div style="font-size:1.8rem;margin-bottom:.8rem">🏗️</div>
        <h3 style="font-size:1rem;font-weight:700;margin-bottom:.6rem">لديك مشروع؟</h3>
        <p style="font-size:.82rem;color:var(--gray);line-height:1.65;margin-bottom:1.3rem">استشارة مجانية من فريقنا المتخصص</p>
        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-primary" style="display:block;text-align:center;font-size:.88rem">تواصل معنا</a>
      </div>
    </div>
  </aside>
</div>

<?php endwhile; ?>

<!-- Single post content styles -->
<style>
.single-post-content h2 { font-size:1.6rem;font-weight:900;color:var(--white);margin:2.5rem 0 1rem;padding-bottom:.6rem;border-bottom:.5px solid rgba(201,168,76,.2); }
.single-post-content h3 { font-size:1.25rem;font-weight:700;color:var(--gold);margin:2rem 0 .8rem; }
.single-post-content p  { margin-bottom:1.4rem;font-size:.97rem; }
.single-post-content a  { color:var(--gold);border-bottom:1px solid rgba(201,168,76,.3);transition:border-color .3s; }
.single-post-content a:hover { border-color:var(--gold); }
.single-post-content img { max-width:100%;height:auto;margin:2rem 0;border:.5px solid rgba(201,168,76,.1); }
.single-post-content ul,.single-post-content ol { margin:.5rem 0 1.4rem 0;padding-right:1.5rem; }
.single-post-content li { margin-bottom:.5rem;color:rgba(247,242,232,.8);font-size:.95rem;line-height:1.7; }
.single-post-content ul li::marker { color:var(--gold); }
.single-post-content blockquote { border-right:3px solid var(--gold);margin:2rem 0;padding:1.2rem 1.5rem;background:rgba(201,168,76,.04);font-style:italic;color:rgba(247,242,232,.7);font-size:1.05rem;line-height:1.8; }
.single-post-content code { background:var(--dark3);color:var(--teal2);padding:.15rem .4rem;font-size:.88rem;border-radius:2px; }
.single-post-content pre { background:var(--dark3);border:.5px solid rgba(201,168,76,.15);padding:1.5rem;overflow-x:auto;margin:1.5rem 0;border-radius:2px; }
.single-post-content pre code { background:none;padding:0;color:var(--white); }
.single-post-content table { width:100%;border-collapse:collapse;margin:1.5rem 0; }
.single-post-content th { background:rgba(201,168,76,.1);color:var(--gold);padding:.8rem 1rem;text-align:right;font-size:.85rem;letter-spacing:.5px; }
.single-post-content td { padding:.8rem 1rem;border-bottom:.5px solid rgba(255,255,255,.06);font-size:.9rem;color:rgba(247,242,232,.8); }
</style>

<?php get_footer(); ?>
