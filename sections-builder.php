<?php
/**
 * GCS Theme — Flexible Sections Builder
 * لوحة إنشاء أقسام مرنة لكل صفحة
 */

if (!defined('ABSPATH')) exit;

/* =============================================
   REGISTER SECTIONS META BOX ON ALL PAGES
   ============================================= */
function gcs_sections_meta_box() {
    add_meta_box(
        'gcs_sections_builder',
        '🔧 منشئ الأقسام المرنة',
        'gcs_sections_builder_callback',
        ['page', 'gcs_service'],
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'gcs_sections_meta_box');

function gcs_sections_builder_callback($post) {
    wp_nonce_field('gcs_sections_nonce', 'gcs_sections_nonce_field');
    $sections = get_post_meta($post->ID, '_gcs_sections', true) ?: [];
    ?>
    <style>
    .gcs-builder { font-family: -apple-system, sans-serif; }
    .gcs-builder .section-item {
        background: #1a1a2e; border: 1px solid #C9A84C33;
        border-radius: 4px; margin-bottom: 12px; overflow: hidden;
    }
    .gcs-builder .section-header {
        background: #0e0e1a; padding: 12px 16px;
        display: flex; align-items: center; justify-content: space-between;
        cursor: pointer; color: #C9A84C; font-weight: 600; font-size: 13px;
    }
    .gcs-builder .section-body { padding: 16px; display: none; }
    .gcs-builder .section-body.open { display: block; }
    .gcs-builder input[type="text"],
    .gcs-builder textarea,
    .gcs-builder select {
        width: 100%; padding: 8px 10px; background: #0a0a0a;
        border: 1px solid #C9A84C44; color: #F7F2E8;
        font-family: inherit; font-size: 13px; margin-bottom: 10px;
        border-radius: 2px;
    }
    .gcs-builder label { display: block; color: #888880; font-size: 12px; margin-bottom: 4px; letter-spacing: .5px; }
    .gcs-builder .add-section-btn {
        background: #C9A84C; color: #060606; border: none;
        padding: 10px 20px; font-weight: 700; font-size: 13px;
        cursor: pointer; border-radius: 2px; margin: 4px;
    }
    .gcs-builder .remove-btn { background: #c0392b; color: white; border: none; padding: 6px 12px; font-size: 12px; cursor: pointer; border-radius: 2px; float: left; }
    .gcs-builder .drag-handle { cursor: move; color: #555; font-size: 16px; margin-left: 8px; }
    .gcs-field-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .gcs-section-types { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px; border-bottom: 1px solid #C9A84C22; padding-bottom: 12px; }
    </style>

    <div class="gcs-builder">
        <div class="gcs-section-types">
            <strong style="color:#C9A84C;width:100%;margin-bottom:4px;font-size:12px;letter-spacing:1px">➕ إضافة قسم جديد:</strong>
            <?php
            $types = [
                'hero_inner'   => '🖼️ هيرو داخلي',
                'text_image'   => '📝 نص + صورة',
                'services_row' => '🔧 صف خدمات',
                'stats_bar'    => '📊 إحصائيات',
                'testimonials' => '💬 تقييمات',
                'gallery'      => '🖼️ معرض صور',
                'cta_banner'   => '📣 CTA Banner',
                'team_row'     => '👥 فريق العمل',
                'faq'          => '❓ أسئلة شائعة',
                'video'        => '🎬 فيديو',
                'separator'    => '➖ فاصل',
                'custom_html'  => '💻 HTML مخصص',
            ];
            foreach ($types as $type => $label) :
            ?>
            <button type="button" class="add-section-btn" onclick="gcsAddSection('<?php echo esc_attr($type); ?>')">
                <?php echo esc_html($label); ?>
            </button>
            <?php endforeach; ?>
        </div>

        <div id="gcs-sections-container">
            <?php foreach ($sections as $idx => $section) :
                gcs_render_section_fields($idx, $section);
            endforeach; ?>
        </div>
        <input type="hidden" name="gcs_sections_count" id="gcs_sections_count" value="<?php echo count($sections); ?>">
    </div>

    <script>
    let gcsCount = <?php echo count($sections); ?>;

    function gcsAddSection(type) {
        const idx = gcsCount++;
        document.getElementById('gcs_sections_count').value = gcsCount;
        fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=gcs_get_section_fields&type=' + type + '&idx=' + idx + '&nonce=<?php echo wp_create_nonce('gcs_section_ajax'); ?>')
            .then(r => r.text())
            .then(html => {
                document.getElementById('gcs-sections-container').insertAdjacentHTML('beforeend', html);
            });
    }

    function gcsToggleSection(idx) {
        const body = document.getElementById('section-body-' + idx);
        body.classList.toggle('open');
    }

    function gcsRemoveSection(idx) {
        if (confirm('حذف هذا القسم؟')) {
            document.getElementById('section-item-' + idx).remove();
        }
    }

    // Sortable via drag
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('gcs-sections-container');
        if (!container) return;
        let dragging = null;
        container.addEventListener('dragstart', e => { dragging = e.target.closest('.section-item'); dragging.style.opacity = '.4'; });
        container.addEventListener('dragend',   e => { if(dragging) dragging.style.opacity = '1'; dragging = null; });
        container.addEventListener('dragover',  e => {
            e.preventDefault();
            const after = getDragAfterElement(container, e.clientY);
            if (dragging) after ? container.insertBefore(dragging, after) : container.appendChild(dragging);
        });
        function getDragAfterElement(container, y) {
            const draggables = [...container.querySelectorAll('.section-item:not(.dragging)')];
            return draggables.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                return offset < 0 && offset > closest.offset ? { offset, element: child } : closest;
            }, { offset: Number.NEGATIVE_INFINITY }).element;
        }
    });
    </script>
    <?php
}

/* =============================================
   AJAX: Render section fields
   ============================================= */
function gcs_get_section_fields_ajax() {
    check_ajax_referer('gcs_section_ajax', 'nonce');
    $type = sanitize_key($_GET['type'] ?? 'text_image');
    $idx  = absint($_GET['idx'] ?? 0);
    gcs_render_section_fields($idx, ['type' => $type]);
    wp_die();
}
add_action('wp_ajax_gcs_get_section_fields', 'gcs_get_section_fields_ajax');

function gcs_render_section_fields($idx, $section) {
    $type   = $section['type'] ?? 'text_image';
    $labels = [
        'hero_inner'   => '🖼️ هيرو داخلي',
        'text_image'   => '📝 نص + صورة',
        'services_row' => '🔧 صف خدمات',
        'stats_bar'    => '📊 إحصائيات',
        'testimonials' => '💬 تقييمات',
        'gallery'      => '🖼️ معرض صور',
        'cta_banner'   => '📣 CTA Banner',
        'team_row'     => '👥 فريق العمل',
        'faq'          => '❓ أسئلة شائعة',
        'video'        => '🎬 فيديو',
        'separator'    => '➖ فاصل',
        'custom_html'  => '💻 HTML مخصص',
    ];
    $f = "sections[{$idx}]";
    ?>
    <div class="section-item" id="section-item-<?php echo $idx; ?>" draggable="true">
        <div class="section-header" onclick="gcsToggleSection(<?php echo $idx; ?>)">
            <span>
                <span class="drag-handle">⠿</span>
                <?php echo esc_html($labels[$type] ?? $type); ?>
            </span>
            <button type="button" class="remove-btn" onclick="event.stopPropagation();gcsRemoveSection(<?php echo $idx; ?>)">حذف ✕</button>
        </div>
        <div class="section-body open" id="section-body-<?php echo $idx; ?>">
            <input type="hidden" name="<?php echo $f; ?>[type]" value="<?php echo esc_attr($type); ?>">

            <?php
            // ── Background color/style ──
            echo '<div class="gcs-field-grid">';
            echo '<div><label>لون الخلفية</label><select name="' . $f . '[bg]">';
            $bgs = ['dark' => 'داكن (#060606)', 'dark2' => 'داكن ثانوي', 'gold' => 'ذهبي', 'custom' => 'مخصص'];
            foreach ($bgs as $bv => $bl) {
                $sel = selected($section['bg'] ?? 'dark', $bv, false);
                echo "<option value='$bv' $sel>$bl</option>";
            }
            echo '</select></div>';
            echo '<div><label>تباعد (padding)</label><select name="' . $f . '[padding]">';
            foreach (['normal'=>'عادي','large'=>'كبير','small'=>'صغير','none'=>'بدون'] as $pv => $pl) {
                $sel = selected($section['padding'] ?? 'normal', $pv, false);
                echo "<option value='$pv' $sel>$pl</option>";
            }
            echo '</select></div>';
            echo '</div>';

            // ── Fields per type ──
            switch ($type) {
                case 'hero_inner':
                    echo '<label>العنوان الرئيسي</label><input type="text" name="' . $f . '[title]" value="' . esc_attr($section['title'] ?? '') . '">';
                    echo '<label>الوصف</label><textarea name="' . $f . '[text]" rows="3">' . esc_textarea($section['text'] ?? '') . '</textarea>';
                    echo '<label>رابط الصورة الخلفية (URL)</label><input type="text" name="' . $f . '[image]" value="' . esc_attr($section['image'] ?? '') . '">';
                    echo '<label>نص الزر</label><input type="text" name="' . $f . '[btn_text]" value="' . esc_attr($section['btn_text'] ?? '') . '">';
                    echo '<label>رابط الزر</label><input type="text" name="' . $f . '[btn_url]" value="' . esc_attr($section['btn_url'] ?? '') . '">';
                    break;

                case 'text_image':
                    echo '<div class="gcs-field-grid">';
                    echo '<div><label>موضع الصورة</label><select name="' . $f . '[img_pos]"><option value="right"' . selected($section['img_pos']??'right','right',false) . '>يمين</option><option value="left"' . selected($section['img_pos']??'right','left',false) . '>يسار</option></select></div>';
                    echo '<div><label>الوسم (badge)</label><input type="text" name="' . $f . '[tag]" value="' . esc_attr($section['tag'] ?? '') . '"></div>';
                    echo '</div>';
                    echo '<label>العنوان</label><input type="text" name="' . $f . '[title]" value="' . esc_attr($section['title'] ?? '') . '">';
                    echo '<label>النص</label><textarea name="' . $f . '[text]" rows="4">' . esc_textarea($section['text'] ?? '') . '</textarea>';
                    echo '<label>رابط الصورة</label><input type="text" name="' . $f . '[image]" value="' . esc_attr($section['image'] ?? '') . '">';
                    echo '<label>نص الزر (اختياري)</label><input type="text" name="' . $f . '[btn_text]" value="' . esc_attr($section['btn_text'] ?? '') . '">';
                    echo '<label>رابط الزر</label><input type="text" name="' . $f . '[btn_url]"  value="' . esc_attr($section['btn_url'] ?? '') . '">';
                    break;

                case 'stats_bar':
                    echo '<p style="color:#888;font-size:12px;margin-bottom:12px">يعرض الإحصائيات من لوحة تحكم القالب تلقائياً</p>';
                    echo '<label>عنوان اختياري</label><input type="text" name="' . $f . '[title]" value="' . esc_attr($section['title'] ?? '') . '">';
                    break;

                case 'cta_banner':
                    echo '<label>العنوان</label><input type="text" name="' . $f . '[title]" value="' . esc_attr($section['title'] ?? 'هل أنت مستعد؟') . '">';
                    echo '<label>الوصف</label><input type="text" name="' . $f . '[text]"  value="' . esc_attr($section['text']  ?? '') . '">';
                    echo '<div class="gcs-field-grid">';
                    echo '<div><label>نص الزر</label><input type="text" name="' . $f . '[btn_text]" value="' . esc_attr($section['btn_text'] ?? 'تواصل معنا') . '"></div>';
                    echo '<div><label>رابط الزر</label><input type="text" name="' . $f . '[btn_url]"  value="' . esc_attr($section['btn_url'] ?? '/contact') . '"></div>';
                    echo '</div>';
                    break;

                case 'video':
                    echo '<label>رابط يوتيوب أو Vimeo</label><input type="url" name="' . $f . '[video_url]" value="' . esc_attr($section['video_url'] ?? '') . '" placeholder="https://youtube.com/embed/...">';
                    echo '<label>صورة الغلاف (poster)</label><input type="text" name="' . $f . '[image]" value="' . esc_attr($section['image'] ?? '') . '">';
                    echo '<label>عنوان (اختياري)</label><input type="text" name="' . $f . '[title]" value="' . esc_attr($section['title'] ?? '') . '">';
                    break;

                case 'faq':
                    echo '<label>عنوان القسم</label><input type="text" name="' . $f . '[title]" value="' . esc_attr($section['title'] ?? 'الأسئلة الشائعة') . '">';
                    echo '<p style="color:#888;font-size:12px">أضف الأسئلة والأجوبة (سطر السؤال: السؤال | الجواب)</p>';
                    echo '<textarea name="' . $f . '[faq_items]" rows="6" placeholder="ما هي خدماتكم الرئيسية؟ | نقدم المقاولات العامة والديكور الفاخر والتشطيبات&#10;كيف أتواصل معكم؟ | يمكنك الاتصال بنا أو ملء نموذج التواصل">' . esc_textarea($section['faq_items'] ?? '') . '</textarea>';
                    break;

                case 'gallery':
                    echo '<label>عنوان المعرض</label><input type="text" name="' . $f . '[title]" value="' . esc_attr($section['title'] ?? 'معرض الصور') . '">';
                    echo '<label>روابط الصور (رابط في كل سطر)</label>';
                    echo '<textarea name="' . $f . '[gallery_urls]" rows="5" placeholder="https://example.com/image1.jpg&#10;https://example.com/image2.jpg">' . esc_textarea($section['gallery_urls'] ?? '') . '</textarea>';
                    echo '<div class="gcs-field-grid">';
                    echo '<div><label>عدد الأعمدة</label><select name="' . $f . '[cols]"><option value="2"' . selected($section['cols']??'3','2',false) . '>٢</option><option value="3"' . selected($section['cols']??'3','3',false) . '>٣</option><option value="4"' . selected($section['cols']??'3','4',false) . '>٤</option></select></div>';
                    echo '</div>';
                    break;

                case 'separator':
                    echo '<label>نوع الفاصل</label><select name="' . $f . '[sep_type]"><option value="line"' . selected($section['sep_type']??'line','line',false) . '>خط ذهبي</option><option value="space"' . selected($section['sep_type']??'line','space',false) . '>مسافة فقط</option><option value="diamond"' . selected($section['sep_type']??'line','diamond',false) . '>ماسة</option></select>';
                    break;

                case 'custom_html':
                    echo '<label style="color:#e74c3c">⚠️ HTML مخصص (للمطورين فقط)</label>';
                    echo '<textarea name="' . $f . '[html]" rows="8" style="font-family:monospace;font-size:12px">' . esc_textarea($section['html'] ?? '') . '</textarea>';
                    break;

                default:
                    echo '<p style="color:#888;font-size:12px">هذا القسم يعرض المحتوى تلقائياً من البيانات المحفوظة.</p>';
            }
            ?>
        </div>
    </div>
    <?php
}

/* =============================================
   SAVE SECTIONS
   ============================================= */
function gcs_save_sections($post_id) {
    if (!isset($_POST['gcs_sections_nonce_field'])) return;
    if (!wp_verify_nonce($_POST['gcs_sections_nonce_field'], 'gcs_sections_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $sections = $_POST['sections'] ?? [];
    $clean = [];
    foreach ($sections as $s) {
        $clean[] = array_map('sanitize_textarea_field', $s);
    }
    update_post_meta($post_id, '_gcs_sections', $clean);
}
add_action('save_post', 'gcs_save_sections');

/* =============================================
   RENDER SECTIONS ON FRONTEND
   ============================================= */
function gcs_render_sections($sections) {
    if (!$sections || !is_array($sections)) return;
    $opts = gcs_get_options();

    foreach ($sections as $sec) {
        $type    = $sec['type'] ?? '';
        $bg      = $sec['bg'] ?? 'dark';
        $pad     = $sec['padding'] ?? 'normal';
        $bg_map  = ['dark'=>'var(--dark)','dark2'=>'var(--dark2)','gold'=>'var(--gold)','custom'=>$sec['custom_bg']??'var(--dark)'];
        $pad_map = ['normal'=>'5rem 7rem','large'=>'8rem 7rem','small'=>'3rem 7rem','none'=>'0 7rem'];
        $style   = "background:{$bg_map[$bg]};padding:{$pad_map[$pad]}";

        switch ($type) {

            case 'hero_inner':
                $img = $sec['image'] ?? '';
                echo '<section style="' . esc_attr($style) . ';position:relative;min-height:400px;display:flex;align-items:center">';
                if ($img) echo '<div style="position:absolute;inset:0;background:url(' . esc_url($img) . ') center/cover;opacity:.3"></div>';
                echo '<div style="position:relative;z-index:1" class="rv">';
                if ($sec['title']) echo '<h2 style="font-size:clamp(2rem,4vw,3.5rem);font-weight:900;margin-bottom:1rem">' . wp_kses_post($sec['title']) . '</h2>';
                if ($sec['text'])  echo '<p style="color:var(--gray);max-width:600px;line-height:1.85;margin-bottom:2rem">' . esc_html($sec['text']) . '</p>';
                if ($sec['btn_text']) echo '<a href="' . esc_url($sec['btn_url']) . '" class="btn-primary">' . esc_html($sec['btn_text']) . ' ←</a>';
                echo '</div></section>';
                break;

            case 'text_image':
                $right = ($sec['img_pos'] ?? 'right') === 'right';
                echo '<section style="' . esc_attr($style) . '">';
                echo '<div style="display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center;max-width:1440px;margin:0 auto">';
                if ($right) { gcs_sec_text($sec); gcs_sec_img($sec); }
                else        { gcs_sec_img($sec); gcs_sec_text($sec); }
                echo '</div></section>';
                break;

            case 'stats_bar':
                echo '<section style="' . esc_attr($style) . '">';
                if ($sec['title']) echo '<h2 style="text-align:center;font-size:clamp(1.8rem,3vw,2.8rem);font-weight:900;margin-bottom:3rem" class="rv">' . wp_kses_post($sec['title']) . '</h2>';
                echo '<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:2px;background:rgba(201,168,76,.12);max-width:900px;margin:0 auto">';
                $stats = [[$opts['stat_projects'],'مشروع منجز'],[$opts['stat_years'],'سنة خبرة'],[$opts['stat_clients'],'عميل سعيد'],[$opts['stat_awards'],'جائزة']];
                foreach ($stats as $i => $s) echo '<div class="rv d' . $i . '" style="background:var(--dark2);padding:3rem 1.5rem;text-align:center"><div class="stat-num" style="font-size:2.5rem;font-weight:900;color:var(--gold)">' . esc_html($s[0]) . '</div><div style="font-size:.75rem;color:var(--gray);letter-spacing:2px">' . esc_html($s[1]) . '</div></div>';
                echo '</div></section>';
                break;

            case 'cta_banner':
                echo '<section style="' . esc_attr($style) . ';text-align:center;position:relative;overflow:hidden">';
                echo '<div style="position:absolute;inset:0;background:radial-gradient(ellipse 60% 60% at 50% 50%,rgba(201,168,76,.08),transparent)"></div>';
                echo '<div style="position:relative" class="rv">';
                if ($sec['title']) echo '<h2 style="font-size:clamp(2rem,4vw,3.5rem);font-weight:900;margin-bottom:1rem">' . wp_kses_post($sec['title']) . '</h2>';
                if ($sec['text'])  echo '<p style="color:var(--gray);margin-bottom:2.5rem">' . esc_html($sec['text']) . '</p>';
                if ($sec['btn_text']) echo '<a href="' . esc_url($sec['btn_url']) . '" class="btn-primary">' . esc_html($sec['btn_text']) . ' ←</a>';
                echo '</div></section>';
                break;

            case 'video':
                echo '<section style="' . esc_attr($style) . '">';
                if ($sec['title']) echo '<h2 style="text-align:center;font-size:clamp(1.8rem,3vw,2.8rem);font-weight:900;margin-bottom:3rem" class="rv">' . wp_kses_post($sec['title']) . '</h2>';
                if ($sec['video_url']) {
                    echo '<div style="position:relative;padding-top:56.25%;max-width:900px;margin:0 auto;background:var(--dark3)" class="rv">';
                    echo '<iframe src="' . esc_url($sec['video_url']) . '" style="position:absolute;inset:0;width:100%;height:100%;border:none" allowfullscreen></iframe>';
                    echo '</div>';
                }
                echo '</section>';
                break;

            case 'faq':
                echo '<section style="' . esc_attr($style) . '">';
                echo '<div style="max-width:800px;margin:0 auto">';
                if ($sec['title']) echo '<h2 style="font-size:clamp(1.8rem,3vw,2.8rem);font-weight:900;margin-bottom:3rem;text-align:center" class="rv">' . esc_html($sec['title']) . '</h2>';
                $items = explode("\n", $sec['faq_items'] ?? '');
                foreach ($items as $i => $item) {
                    $parts = explode('|', $item, 2);
                    if (count($parts) < 2) continue;
                    $q = trim($parts[0]); $a = trim($parts[1]);
                    echo '<div class="rv" style="border-bottom:.5px solid rgba(201,168,76,.15);padding:1.2rem 0">';
                    echo '<div style="font-size:1rem;font-weight:700;color:var(--gold);margin-bottom:.6rem;cursor:pointer" onclick="this.nextElementSibling.style.display=this.nextElementSibling.style.display===\'none\'?\'block\':\'none\'">' . esc_html($q) . ' ▾</div>';
                    echo '<div style="font-size:.9rem;color:var(--gray);line-height:1.85">' . esc_html($a) . '</div>';
                    echo '</div>';
                }
                echo '</div></section>';
                break;

            case 'gallery':
                echo '<section style="' . esc_attr($style) . '">';
                if ($sec['title']) echo '<h2 style="font-size:clamp(1.8rem,3vw,2.8rem);font-weight:900;margin-bottom:3rem;text-align:center" class="rv">' . esc_html($sec['title']) . '</h2>';
                $cols = $sec['cols'] ?? 3;
                $urls = array_filter(array_map('trim', explode("\n", $sec['gallery_urls'] ?? '')));
                echo '<div style="display:grid;grid-template-columns:repeat(' . (int)$cols . ',1fr);gap:2px">';
                foreach ($urls as $url) {
                    echo '<div class="rv" style="overflow:hidden;aspect-ratio:4/3"><img src="' . esc_url($url) . '" loading="lazy" style="width:100%;height:100%;object-fit:cover;transition:transform .5s cubic-bezier(.4,0,.2,1)" onmouseenter="this.style.transform=\'scale(1.06)\'" onmouseleave="this.style.transform=\'\'"></div>';
                }
                echo '</div></section>';
                break;

            case 'separator':
                $sep = $sec['sep_type'] ?? 'line';
                echo '<div style="padding:2rem 7rem">';
                if ($sep === 'line')    echo '<div style="height:1px;background:linear-gradient(to left,var(--gold),transparent)"></div>';
                elseif ($sep === 'diamond') echo '<div style="text-align:center;color:var(--gold);font-size:1.5rem">◆</div>';
                echo '</div>';
                break;

            case 'custom_html':
                if (current_user_can('unfiltered_html')) {
                    echo '<section style="' . esc_attr($style) . '">' . ($sec['html'] ?? '') . '</section>';
                }
                break;
        }
    }
}

function gcs_sec_text($sec) {
    echo '<div class="rv">';
    if ($sec['tag'])  echo '<div class="sec-tag">' . esc_html($sec['tag']) . '</div>';
    if ($sec['title']) echo '<h2 class="sec-title">' . wp_kses_post($sec['title']) . '</h2><div class="gold-bar"></div>';
    if ($sec['text'])  echo '<p style="color:var(--gray);line-height:1.9;margin-bottom:1.5rem">' . esc_html($sec['text']) . '</p>';
    if ($sec['btn_text']) echo '<a href="' . esc_url($sec['btn_url']) . '" class="btn-primary">' . esc_html($sec['btn_text']) . ' ←</a>';
    echo '</div>';
}

function gcs_sec_img($sec) {
    echo '<div class="rv d2">';
    if ($sec['image']) echo '<img src="' . esc_url($sec['image']) . '" alt="" style="width:100%;aspect-ratio:4/3;object-fit:cover;border:.5px solid rgba(201,168,76,.2)">';
    echo '</div>';
}
