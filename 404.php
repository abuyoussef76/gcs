<?php
/**
 * GCS Theme — 404 Page
 */
get_header(); ?>

<section class="error-404" style="min-height:100vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:10rem 2rem;position:relative;overflow:hidden">

  <!-- Background geo -->
  <div style="position:absolute;inset:0;overflow:hidden;pointer-events:none" aria-hidden="true">
    <svg width="100%" height="100%" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice" style="position:absolute;inset:0">
      <circle cx="720" cy="450" r="350" fill="none" stroke="rgba(201,168,76,0.05)" stroke-width="1"/>
      <circle cx="720" cy="450" r="250" fill="none" stroke="rgba(201,168,76,0.04)" stroke-width="0.5"/>
      <circle cx="720" cy="450" r="150" fill="none" stroke="rgba(201,168,76,0.06)" stroke-width="0.5"/>
      <line x1="0" y1="450" x2="370" y2="450" stroke="rgba(201,168,76,0.06)" stroke-width="0.5"/>
      <line x1="1070" y1="450" x2="1440" y2="450" stroke="rgba(201,168,76,0.06)" stroke-width="0.5"/>
    </svg>
    <div style="position:absolute;inset:0;background:radial-gradient(ellipse 60% 70% at 50% 50%,rgba(201,168,76,0.05),transparent)"></div>
  </div>

  <div style="position:relative;z-index:1">
    <!-- 404 number -->
    <div style="font-size:clamp(8rem,20vw,16rem);font-weight:900;line-height:1;color:transparent;-webkit-text-stroke:1px rgba(201,168,76,0.25);position:relative;margin-bottom:-1rem;animation:fadeUp .8s .1s both">
      404
      <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center">
        <div style="font-size:clamp(8rem,20vw,16rem);font-weight:900;color:transparent;-webkit-text-stroke:1px rgba(201,168,76,0.06);transform:scaleY(-1);-webkit-mask-image:linear-gradient(to bottom,rgba(0,0,0,0.15),transparent 70%);mask-image:linear-gradient(to bottom,rgba(0,0,0,0.15),transparent 70%)">404</div>
      </div>
    </div>

    <div style="animation:fadeUp .8s .3s both">
      <div style="display:inline-flex;align-items:center;gap:12px;font-size:.7rem;letter-spacing:5px;color:var(--gold);text-transform:uppercase;margin-bottom:1.5rem">
        <span style="display:block;width:36px;height:1px;background:var(--gold)"></span>
        الصفحة غير موجودة
        <span style="display:block;width:36px;height:1px;background:var(--gold)"></span>
      </div>
      <h1 style="font-size:clamp(1.8rem,4vw,3rem);font-weight:900;margin-bottom:1.2rem">
        عفواً — هذه الصفحة <span style="color:var(--gold)">غير متاحة</span>
      </h1>
      <p style="font-size:1rem;color:var(--gray);max-width:480px;margin:0 auto 3rem;line-height:1.85">
        ربما تمت إزالة الصفحة أو تغيير رابطها. استخدم البحث أو انتقل للصفحة الرئيسية.
      </p>
    </div>

    <!-- Search -->
    <div style="margin-bottom:2.5rem;animation:fadeUp .8s .5s both">
      <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" style="display:flex;max-width:420px;margin:0 auto;gap:0">
        <input type="search" name="s" placeholder="ابحث هنا…" value="<?php echo esc_attr(get_search_query()); ?>"
          style="flex:1;padding:.9rem 1.4rem;background:var(--dark3);border:.5px solid rgba(201,168,76,.25);color:var(--white);font-family:var(--font-primary);font-size:.95rem;outline:none;direction:rtl">
        <button type="submit" style="padding:.9rem 1.6rem;background:var(--gold);color:var(--dark);border:none;font-family:var(--font-primary);font-size:.95rem;font-weight:700;cursor:pointer">بحث</button>
      </form>
    </div>

    <!-- Links -->
    <div style="display:flex;gap:1.2rem;justify-content:center;flex-wrap:wrap;animation:fadeUp .8s .7s both">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">← الرئيسية</a>
      <a href="<?php echo esc_url(home_url('/projects')); ?>" class="btn-outline">أعمالنا</a>
      <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-outline">تواصل معنا</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
