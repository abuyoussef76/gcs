<?php
$testis = [
  ['أ','أحمد الحربي','رجل أعمال — الرياض','"تعاملنا مع نجوم العاصمة في بناء فيلتنا وكانت التجربة استثنائية. الاحترافية والدقة في التنفيذ تجاوزت كل توقعاتنا."'],
  ['س','سارة المنصور','مديرة تنفيذية — جدة','"الديكور الداخلي الذي نفّذوه لمنزلنا كان تحفة فنية. كل تفصيلة تعكس ذوقاً رفيعاً وخبرة حقيقية في عالم التصميم."'],
  ['م','محمد الغامدي','مدير مشاريع — الدمام','"سلّموا مشروعنا التجاري قبل الموعد بأسبوعين مع الحفاظ على أعلى معايير الجودة. شريك موثوق دائماً."'],
];
foreach ($testis as $i => $t) :
  $delay = $i ? " d{$i}" : '';
?>
<article class="testi-card rv<?php echo $delay; ?>">
  <div class="testi-stars">★★★★★</div>
  <div class="testi-q">"</div>
  <blockquote class="testi-txt"><?php echo esc_html($t[3]); ?></blockquote>
  <div class="testi-auth">
    <div class="auth-av"><?php echo esc_html($t[0]); ?></div>
    <div>
      <div class="auth-name"><?php echo esc_html($t[1]); ?></div>
      <div class="auth-loc"><?php echo esc_html($t[2]); ?></div>
    </div>
  </div>
</article>
<?php endforeach; ?>
