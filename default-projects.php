<?php /* Default Projects Fallback */ ?>
<?php
$projects = [
  ['p1-bg','فيلا سكنية','فيلا النخبة — الرياض','٢٠٢٤ · تشطيب كامل'],
  ['p2-bg','مجمع تجاري','برج السلام — جدة','٢٠٢٣ · مقاولات كاملة'],
  ['p3-bg','ديكور داخلي','قصر الأميرة — الدمام','٢٠٢٣ · ديكور فاخر'],
  ['p4-bg','حديقة وترفيه','مجمع الواحة — أبوظبي','٢٠٢٢ · تصميم متكامل'],
  ['p5-bg','واجهة مبنى','برج الأعمال — الكويت','٢٠٢٢ · واجهات وأسقف'],
];
foreach ($projects as $p) : ?>
<article class="proj-card">
  <div class="proj-bg <?php echo esc_attr($p[0]); ?>">
    <svg width="370" height="490" viewBox="0 0 370 490" style="position:absolute;inset:0;width:100%;height:100%">
      <defs><pattern id="pg<?php echo $p[0]; ?>" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M0 20h40M20 0v40" stroke="rgba(201,168,76,0.1)" stroke-width="0.5"/></pattern></defs>
      <rect width="370" height="490" fill="url(#pg<?php echo $p[0]; ?>)"/>
    </svg>
  </div>
  <div class="proj-ov"></div>
  <a href="#" class="proj-link">
    <div class="proj-info">
      <div class="proj-cat"><?php echo esc_html($p[1]); ?></div>
      <div class="proj-name"><?php echo esc_html($p[2]); ?></div>
      <div class="proj-loc"><?php echo esc_html($p[3]); ?></div>
    </div>
  </a>
</article>
<?php endforeach; ?>
