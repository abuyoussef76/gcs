<?php
/**
 * GCS Theme — Generic Page Template
 */
get_header();
while (have_posts()) : the_post();
$page_tag   = get_post_meta(get_the_ID(), '_page_tag', true) ?: get_the_title();
$page_sub   = get_post_meta(get_the_ID(), '_page_subtitle', true);
$hero_img   = get_the_post_thumbnail_url(get_the_ID(), 'gcs-hero');
?>

<!-- PAGE HERO -->
<section class="page-hero" <?php if ($hero_img) echo 'style="background-image:url(' . esc_url($hero_img) . ');background-size:cover;background-position:center"'; ?>>
  <?php if ($hero_img) : ?><div class="page-hero-overlay" style="position:absolute;inset:0;background:rgba(6,6,6,.7)"></div><?php endif; ?>
  <div class="page-hero-content rv">
    <div class="page-hero-tag"><?php echo esc_html($page_tag); ?></div>
    <h1 class="page-hero-title"><?php the_title(); ?></h1>
    <?php if ($page_sub) : ?><p class="page-hero-sub"><?php echo esc_html($page_sub); ?></p><?php endif; ?>
  </div>
</section>

<!-- FLEXIBLE CONTENT SECTIONS -->
<?php
$sections = get_post_meta(get_the_ID(), '_gcs_sections', true);
if ($sections && is_array($sections)) :
    foreach ($sections as $sec) :
        get_template_part('template-parts/sections/section', $sec['type'] ?? 'text', $sec);
    endforeach;
endif;
?>

<!-- PAGE CONTENT -->
<div class="page-content-wrap">
  <div class="page-content rv">
    <?php the_content(); ?>
    <?php wp_link_pages(); ?>
  </div>
</div>

<?php endwhile; get_footer(); ?>
