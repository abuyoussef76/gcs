<?php
/**
 * Default services fallback (when no CPT data)
 */
$services = [
  ['١','مقاولات عامة','تنفيذ مشاريع البناء والإنشاء بأعلى معايير الجودة، من الفلل والقصور إلى المجمعات التجارية الكبرى.'],
  ['٢','ديكور داخلي فاخر','تصاميم داخلية راقية تجمع بين الأصالة والحداثة مع أجود المواد والتشطيبات العالمية.'],
  ['٣','الواجهات والتشطيبات','تصميم وتنفيذ واجهات مبانٍ مبهرة وتشطيبات نهائية بالرخام والجرانيت وأخشاب طبيعية.'],
  ['٤','الأسقف الزخرفية','أسقف مشغولة بإتقان من الجبس والخشب المزخرف والإضاءة المدمجة بأحدث التقنيات.'],
  ['٥','الحدائق والمسابح','تصميم وإنشاء المسابح والحدائق والشلالات والمساحات الخارجية الفاخرة.'],
  ['٦','استشارات هندسية','فريق من نخبة المهندسين والمصممين لتقديم الاستشارات الفنية وإعداد المخططات.'],
];
$icons = [
  '<svg class="srv-icon" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M8 40V20L24 8L40 20V40"/><rect x="18" y="28" width="12" height="12"/></svg>',
  '<svg class="srv-icon" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="4" y="8" width="40" height="32" rx="2"/><line x1="4" y1="16" x2="44" y2="16"/><line x1="12" y1="26" x2="36" y2="26"/><line x1="12" y1="32" x2="28" y2="32"/></svg>',
  '<svg class="srv-icon" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="6" y="10" width="36" height="28" rx="1"/><line x1="6" y1="18" x2="42" y2="18"/><line x1="20" y1="18" x2="20" y2="38"/></svg>',
  '<svg class="srv-icon" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="24" cy="24" r="18"/><circle cx="24" cy="24" r="8"/><path d="M24 6v6M24 36v6M6 24h6M36 24h6"/></svg>',
  '<svg class="srv-icon" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 38L18 14L28 28L34 20L42 38Z"/><circle cx="34" cy="14" r="4"/></svg>',
  '<svg class="srv-icon" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10 8h28v32H10z"/><line x1="16" y1="16" x2="32" y2="16"/><line x1="16" y1="22" x2="32" y2="22"/><circle cx="36" cy="36" r="8"/><line x1="32" y1="36" x2="40" y2="36"/><line x1="36" y1="32" x2="36" y2="40"/></svg>',
];
foreach ($services as $i => $srv) :
  $delay = $i % 3 === 0 ? '' : ($i % 3 === 1 ? ' d1' : ' d2');
?>
<article class="srv rv<?php echo $delay; ?>">
  <div class="srv-num"><?php echo $srv[0]; ?></div>
  <?php echo $icons[$i]; ?>
  <h3 class="srv-name"><?php echo esc_html($srv[1]); ?></h3>
  <p class="srv-desc"><?php echo esc_html($srv[2]); ?></p>
  <a href="<?php echo esc_url(home_url('/services')); ?>" class="srv-link">اعرف أكثر ←</a>
</article>
<?php endforeach; ?>
