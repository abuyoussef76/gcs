<?php
/**
 * GCS Theme - Functions & Definitions
 * نجوم العاصمة الذهبية - ملف الوظائف الرئيسي
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'GCS_VERSION', '1.0.0' );
define( 'GCS_DIR', get_template_directory() );
define( 'GCS_URI', get_template_directory_uri() );

/* =============================================
   1. THEME SETUP
   ============================================= */
function gcs_setup() {
    load_theme_textdomain( 'gcs-theme', GCS_DIR . '/languages' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'custom-logo', [
        'height'      => 120,
        'width'       => 120,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support( 'woocommerce' );

    // Image sizes
    add_image_size( 'gcs-hero',    1920, 1080, true );
    add_image_size( 'gcs-project', 800,  1000, true );
    add_image_size( 'gcs-thumb',   600,  400,  true );

    // Menus
    register_nav_menus([
        'primary'   => __( 'القائمة الرئيسية', 'gcs-theme' ),
        'footer'    => __( 'قائمة الفوتر', 'gcs-theme' ),
        'services'  => __( 'قائمة الخدمات', 'gcs-theme' ),
    ]);
}
add_action( 'after_setup_theme', 'gcs_setup' );

/* =============================================
   2. ENQUEUE SCRIPTS & STYLES
   ============================================= */
function gcs_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style( 'gcs-fonts',
        'https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&family=Amiri:ital,wght@0,400;0,700;1,400&display=swap',
        [], null
    );
    // Main CSS
    wp_enqueue_style( 'gcs-main', GCS_URI . '/assets/css/main.css', ['gcs-fonts'], GCS_VERSION );
    wp_enqueue_style( 'gcs-animations', GCS_URI . '/assets/css/animations.css', ['gcs-main'], GCS_VERSION );
    // RTL override if needed
    if ( is_rtl() ) {
        wp_enqueue_style( 'gcs-rtl', GCS_URI . '/assets/css/rtl.css', ['gcs-main'], GCS_VERSION );
    }
    // Main JS
    wp_enqueue_script( 'gcs-main', GCS_URI . '/assets/js/main.js', ['jquery'], GCS_VERSION, true );

    // Pass customizer values to JS
    wp_localize_script( 'gcs-main', 'GCS_OPTIONS', gcs_get_options() );

    if ( is_singular() && comments_open() && get_option('thread_comments') ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'gcs_enqueue_assets' );

/* =============================================
   3. GET ALL THEME OPTIONS
   ============================================= */
function gcs_get_options() {
    return [
        // Colors
        'color_primary'   => get_theme_mod( 'gcs_color_primary',   '#C9A84C' ),
        'color_secondary' => get_theme_mod( 'gcs_color_secondary',  '#0097A7' ),
        'color_dark'      => get_theme_mod( 'gcs_color_dark',       '#060606' ),
        'color_text'      => get_theme_mod( 'gcs_color_text',       '#F7F2E8' ),
        // Company Info
        'company_name_ar' => get_theme_mod( 'gcs_company_name_ar',  'نجوم العاصمة الذهبية' ),
        'company_name_en' => get_theme_mod( 'gcs_company_name_en',  'Golden Capital Stars Co.' ),
        'company_tagline' => get_theme_mod( 'gcs_company_tagline',  'مقاولات وديكور فاخر' ),
        'company_phone'   => get_theme_mod( 'gcs_company_phone',    '+966 50 000 0000' ),
        'company_email'   => get_theme_mod( 'gcs_company_email',    'info@gcs.sa' ),
        'company_address' => get_theme_mod( 'gcs_company_address',  'المملكة العربية السعودية' ),
        'company_whatsapp'=> get_theme_mod( 'gcs_company_whatsapp', '' ),
        // Social
        'social_instagram'=> get_theme_mod( 'gcs_social_instagram', '' ),
        'social_twitter'  => get_theme_mod( 'gcs_social_twitter',   '' ),
        'social_linkedin' => get_theme_mod( 'gcs_social_linkedin',  '' ),
        'social_youtube'  => get_theme_mod( 'gcs_social_youtube',   '' ),
        // Stats
        'stat_projects'   => get_theme_mod( 'gcs_stat_projects',    '٥٠٠+' ),
        'stat_years'      => get_theme_mod( 'gcs_stat_years',       '٢٠+' ),
        'stat_clients'    => get_theme_mod( 'gcs_stat_clients',     '٣٠٠+' ),
        'stat_awards'     => get_theme_mod( 'gcs_stat_awards',      '١٥' ),
        // Hero
        'hero_slide1_tag'   => get_theme_mod( 'gcs_hero_slide1_tag',   'مقاولات عامة وديكور فاخر' ),
        'hero_slide1_title' => get_theme_mod( 'gcs_hero_slide1_title', 'نبني أحلامك بإتقان لا مثيل له' ),
        'hero_slide1_sub'   => get_theme_mod( 'gcs_hero_slide1_sub',   'شركة نجوم العاصمة الذهبية — رائدة في المقاولات العامة وتصميم الديكور الداخلي الفاخر.' ),
        'hero_slide2_tag'   => get_theme_mod( 'gcs_hero_slide2_tag',   'تصميم ديكور داخلي' ),
        'hero_slide2_title' => get_theme_mod( 'gcs_hero_slide2_title', 'فضاءات تلهم وجمال يدوم' ),
        'hero_slide2_sub'   => get_theme_mod( 'gcs_hero_slide2_sub',   'تصاميم داخلية تجمع الأصالة بالحداثة مع أرقى الخامات والتشطيبات.' ),
        'hero_slide3_tag'   => get_theme_mod( 'gcs_hero_slide3_tag',   'مشاريع تجارية وسكنية' ),
        'hero_slide3_title' => get_theme_mod( 'gcs_hero_slide3_title', '٥٠٠+ مشروع منجز باحترافية' ),
        'hero_slide3_sub'   => get_theme_mod( 'gcs_hero_slide3_sub',   'من الفلل الفاخرة إلى المجمعات التجارية الكبرى.' ),
        // Footer
        'footer_about'    => get_theme_mod( 'gcs_footer_about', 'شركة رائدة في المقاولات العامة وتصميم الديكور الداخلي الفاخر. نبني أحلامك بأعلى معايير الجودة والاحترافية.' ),
        'footer_copy'     => get_theme_mod( 'gcs_footer_copy',  '© ٢٠٢٥ شركة نجوم العاصمة الذهبية — جميع الحقوق محفوظة' ),
        // Typography
        'font_primary'    => get_theme_mod( 'gcs_font_primary',  'Tajawal' ),
        'font_size_base'  => get_theme_mod( 'gcs_font_size_base', '16' ),
        // Layout
        'slider_autoplay_speed' => get_theme_mod( 'gcs_slider_autoplay_speed', '6000' ),
        'show_cursor'     => get_theme_mod( 'gcs_show_cursor', '1' ),
        'show_noise'      => get_theme_mod( 'gcs_show_noise', '1' ),
    ];
}

/* =============================================
   4. CUSTOMIZER — FULL CONTROL PANEL
   ============================================= */
function gcs_customize_register( $wp_customize ) {

    // ── PANEL: GCS Theme Options ──
    $wp_customize->add_panel( 'gcs_panel', [
        'title'       => '🏗️ إعدادات نجوم العاصمة',
        'description' => 'تحكم كامل في تصميم وإعدادات الموقع',
        'priority'    => 10,
    ]);

    /* ---- SECTION: Company Info ---- */
    $wp_customize->add_section( 'gcs_company', [
        'title'    => '🏢 معلومات الشركة',
        'panel'    => 'gcs_panel',
        'priority' => 10,
    ]);
    $company_fields = [
        'gcs_company_name_ar'  => [ 'label' => 'اسم الشركة بالعربي',    'default' => 'نجوم العاصمة الذهبية' ],
        'gcs_company_name_en'  => [ 'label' => 'اسم الشركة بالإنجليزي', 'default' => 'Golden Capital Stars Co.' ],
        'gcs_company_tagline'  => [ 'label' => 'الشعار النصي',           'default' => 'مقاولات وديكور فاخر' ],
        'gcs_company_phone'    => [ 'label' => 'رقم الهاتف',             'default' => '+966 50 000 0000' ],
        'gcs_company_email'    => [ 'label' => 'البريد الإلكتروني',      'default' => 'info@gcs.sa' ],
        'gcs_company_address'  => [ 'label' => 'العنوان',                'default' => 'المملكة العربية السعودية' ],
        'gcs_company_whatsapp' => [ 'label' => 'رقم الواتساب',           'default' => '' ],
    ];
    foreach ( $company_fields as $id => $args ) {
        $wp_customize->add_setting( $id, [ 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ] );
        $wp_customize->add_control( $id, [ 'label' => $args['label'], 'section' => 'gcs_company', 'type' => 'text' ] );
    }

    /* ---- SECTION: Colors ---- */
    $wp_customize->add_section( 'gcs_colors', [
        'title'    => '🎨 الألوان',
        'panel'    => 'gcs_panel',
        'priority' => 20,
    ]);
    $color_fields = [
        'gcs_color_primary'   => [ 'label' => 'اللون الذهبي الرئيسي',  'default' => '#C9A84C' ],
        'gcs_color_secondary' => [ 'label' => 'اللون الثانوي (فيروزي)', 'default' => '#0097A7' ],
        'gcs_color_dark'      => [ 'label' => 'لون الخلفية الداكن',     'default' => '#060606' ],
        'gcs_color_text'      => [ 'label' => 'لون النصوص',             'default' => '#F7F2E8' ],
    ];
    foreach ( $color_fields as $id => $args ) {
        $wp_customize->add_setting( $id, [ 'default' => $args['default'], 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ] );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, [
            'label'   => $args['label'],
            'section' => 'gcs_colors',
        ]));
    }

    /* ---- SECTION: Typography ---- */
    $wp_customize->add_section( 'gcs_typography', [
        'title'    => '🔤 الخطوط',
        'panel'    => 'gcs_panel',
        'priority' => 25,
    ]);
    $wp_customize->add_setting( 'gcs_font_primary', [ 'default' => 'Tajawal', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'gcs_font_primary', [
        'label'   => 'الخط الرئيسي',
        'section' => 'gcs_typography',
        'type'    => 'select',
        'choices' => [
            'Tajawal' => 'Tajawal (تجوال)',
            'Almarai' => 'Almarai (المرعي)',
            'Cairo'   => 'Cairo (القاهرة)',
            'Amiri'   => 'Amiri (أميري)',
            'Noto Naskh Arabic' => 'Noto Naskh',
        ],
    ]);
    $wp_customize->add_setting( 'gcs_font_size_base', [ 'default' => '16', 'sanitize_callback' => 'absint' ] );
    $wp_customize->add_control( 'gcs_font_size_base', [
        'label'   => 'حجم الخط الأساسي (px)',
        'section' => 'gcs_typography',
        'type'    => 'number',
        'input_attrs' => [ 'min' => 14, 'max' => 20, 'step' => 1 ],
    ]);

    /* ---- SECTION: Hero Slider ---- */
    $wp_customize->add_section( 'gcs_hero', [
        'title'    => '🎬 سلايدر الهيرو',
        'panel'    => 'gcs_panel',
        'priority' => 30,
    ]);
    // Slide images
    for ( $i = 1; $i <= 3; $i++ ) {
        $wp_customize->add_setting( "gcs_hero_slide{$i}_image", [ 'default' => '', 'sanitize_callback' => 'absint' ] );
        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, "gcs_hero_slide{$i}_image", [
            'label'     => "صورة/فيديو السلايد {$i}",
            'section'   => 'gcs_hero',
            'mime_type' => 'image',
        ]));
        $slide_fields = [
            "gcs_hero_slide{$i}_tag"   => "وسم السلايد {$i}",
            "gcs_hero_slide{$i}_title" => "عنوان السلايد {$i}",
            "gcs_hero_slide{$i}_sub"   => "وصف السلايد {$i}",
        ];
        foreach ( $slide_fields as $fid => $flabel ) {
            $wp_customize->add_setting( $fid, [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
            $wp_customize->add_control( $fid, [ 'label' => $flabel, 'section' => 'gcs_hero', 'type' => 'text' ] );
        }
    }
    $wp_customize->add_setting( 'gcs_slider_autoplay_speed', [ 'default' => '6000', 'sanitize_callback' => 'absint' ] );
    $wp_customize->add_control( 'gcs_slider_autoplay_speed', [
        'label'       => 'سرعة التبديل التلقائي (ms)',
        'section'     => 'gcs_hero',
        'type'        => 'number',
        'input_attrs' => [ 'min' => 2000, 'max' => 15000, 'step' => 500 ],
    ]);

    /* ---- SECTION: Stats Bar ---- */
    $wp_customize->add_section( 'gcs_stats', [
        'title'    => '📊 الإحصائيات',
        'panel'    => 'gcs_panel',
        'priority' => 35,
    ]);
    $stats = [
        'gcs_stat_projects' => 'عدد المشاريع',
        'gcs_stat_years'    => 'سنوات الخبرة',
        'gcs_stat_clients'  => 'العملاء',
        'gcs_stat_awards'   => 'الجوائز',
    ];
    foreach ( $stats as $sid => $slabel ) {
        $wp_customize->add_setting( $sid, [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $sid, [ 'label' => $slabel, 'section' => 'gcs_stats', 'type' => 'text' ] );
    }

    /* ---- SECTION: Social Media ---- */
    $wp_customize->add_section( 'gcs_social', [
        'title'    => '📱 وسائل التواصل',
        'panel'    => 'gcs_panel',
        'priority' => 40,
    ]);
    $socials = [
        'gcs_social_instagram' => 'رابط إنستغرام',
        'gcs_social_twitter'   => 'رابط تويتر/X',
        'gcs_social_linkedin'  => 'رابط لينكدإن',
        'gcs_social_youtube'   => 'رابط يوتيوب',
    ];
    foreach ( $socials as $sid => $slabel ) {
        $wp_customize->add_setting( $sid, [ 'default' => '', 'sanitize_callback' => 'esc_url_raw' ] );
        $wp_customize->add_control( $sid, [ 'label' => $slabel, 'section' => 'gcs_social', 'type' => 'url' ] );
    }

    /* ---- SECTION: Footer ---- */
    $wp_customize->add_section( 'gcs_footer', [
        'title'    => '🔻 الفوتر',
        'panel'    => 'gcs_panel',
        'priority' => 50,
    ]);
    $wp_customize->add_setting( 'gcs_footer_about', [ 'default' => '', 'sanitize_callback' => 'sanitize_textarea_field' ] );
    $wp_customize->add_control( 'gcs_footer_about', [ 'label' => 'نص عن الشركة في الفوتر', 'section' => 'gcs_footer', 'type' => 'textarea' ] );
    $wp_customize->add_setting( 'gcs_footer_copy', [ 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'gcs_footer_copy', [ 'label' => 'نص حقوق النشر', 'section' => 'gcs_footer', 'type' => 'text' ] );

    /* ---- SECTION: Advanced Effects ---- */
    $wp_customize->add_section( 'gcs_effects', [
        'title'    => '✨ المؤثرات البصرية',
        'panel'    => 'gcs_panel',
        'priority' => 60,
    ]);
    $wp_customize->add_setting( 'gcs_show_cursor', [ 'default' => '1', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'gcs_show_cursor', [
        'label'   => 'مؤشر الماوس المخصص',
        'section' => 'gcs_effects',
        'type'    => 'select',
        'choices' => [ '1' => 'مفعّل', '0' => 'معطّل' ],
    ]);
    $wp_customize->add_setting( 'gcs_show_noise', [ 'default' => '1', 'sanitize_callback' => 'sanitize_text_field' ] );
    $wp_customize->add_control( 'gcs_show_noise', [
        'label'   => 'تأثير الضجيج (Noise Texture)',
        'section' => 'gcs_effects',
        'type'    => 'select',
        'choices' => [ '1' => 'مفعّل', '0' => 'معطّل' ],
    ]);
}
add_action( 'customize_register', 'gcs_customize_register' );

/* =============================================
   5. CUSTOMIZER LIVE PREVIEW
   ============================================= */
function gcs_customize_preview_js() {
    wp_enqueue_script( 'gcs-customizer-preview',
        GCS_URI . '/assets/js/customizer-preview.js',
        [ 'customize-preview' ], GCS_VERSION, true
    );
}
add_action( 'customize_preview_init', 'gcs_customize_preview_js' );

/* =============================================
   6. DYNAMIC CSS (inject CSS vars from customizer)
   ============================================= */
function gcs_dynamic_css() {
    $opts = gcs_get_options();
    $primary   = esc_attr( $opts['color_primary'] );
    $secondary = esc_attr( $opts['color_secondary'] );
    $dark      = esc_attr( $opts['color_dark'] );
    $text      = esc_attr( $opts['color_text'] );
    $font      = esc_attr( $opts['font_primary'] );
    $fsize     = absint( $opts['font_size_base'] );
    echo "<style id='gcs-dynamic-css'>
    :root {
        --gold: {$primary};
        --gold2: " . gcs_lighten( $primary, 20 ) . ";
        --gold3: " . gcs_darken( $primary, 25 ) . ";
        --teal: {$secondary};
        --teal2: " . gcs_lighten( $secondary, 15 ) . ";
        --dark: {$dark};
        --dark2: " . gcs_lighten( $dark, 4 ) . ";
        --dark3: " . gcs_lighten( $dark, 8 ) . ";
        --dark4: " . gcs_lighten( $dark, 14 ) . ";
        --white: {$text};
        --font-primary: '{$font}', sans-serif;
        --font-size-base: {$fsize}px;
    }
    body { font-family: var(--font-primary); font-size: var(--font-size-base); }
    </style>\n";
}
add_action( 'wp_head', 'gcs_dynamic_css', 99 );

/* -- Helper: lighten/darken hex colors -- */
function gcs_hex_to_rgb( $hex ) {
    $hex = ltrim( $hex, '#' );
    if ( strlen($hex) === 3 ) $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    return [ hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)) ];
}
function gcs_lighten( $hex, $pct ) {
    [$r,$g,$b] = gcs_hex_to_rgb($hex);
    $r = min(255, (int)($r + (255-$r)*$pct/100));
    $g = min(255, (int)($g + (255-$g)*$pct/100));
    $b = min(255, (int)($b + (255-$b)*$pct/100));
    return sprintf('#%02x%02x%02x', $r, $g, $b);
}
function gcs_darken( $hex, $pct ) {
    [$r,$g,$b] = gcs_hex_to_rgb($hex);
    $r = max(0, (int)($r * (1-$pct/100)));
    $g = max(0, (int)($g * (1-$pct/100)));
    $b = max(0, (int)($b * (1-$pct/100)));
    return sprintf('#%02x%02x%02x', $r, $g, $b);
}

/* =============================================
   7. CUSTOM POST TYPES
   ============================================= */
function gcs_register_post_types() {
    // Projects — المشاريع
    register_post_type( 'gcs_project', [
        'labels' => [
            'name'          => 'المشاريع',
            'singular_name' => 'مشروع',
            'add_new'       => 'إضافة مشروع',
            'add_new_item'  => 'إضافة مشروع جديد',
            'edit_item'     => 'تعديل المشروع',
            'all_items'     => 'كل المشاريع',
        ],
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => [ 'slug' => 'projects' ],
        'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
        'menu_icon'    => 'dashicons-building',
        'show_in_rest' => true,
    ]);
    // Services — الخدمات
    register_post_type( 'gcs_service', [
        'labels' => [
            'name'          => 'الخدمات',
            'singular_name' => 'خدمة',
            'add_new'       => 'إضافة خدمة',
            'add_new_item'  => 'إضافة خدمة جديدة',
            'edit_item'     => 'تعديل الخدمة',
            'all_items'     => 'كل الخدمات',
        ],
        'public'       => true,
        'has_archive'  => false,
        'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'menu_icon'    => 'dashicons-hammer',
        'show_in_rest' => true,
    ]);
    // Testimonials — التقييمات
    register_post_type( 'gcs_testimonial', [
        'labels' => [
            'name'          => 'آراء العملاء',
            'singular_name' => 'تقييم',
            'add_new'       => 'إضافة تقييم',
            'add_new_item'  => 'إضافة تقييم جديد',
            'edit_item'     => 'تعديل التقييم',
            'all_items'     => 'كل التقييمات',
        ],
        'public'       => false,
        'show_ui'      => true,
        'supports'     => [ 'title', 'editor', 'thumbnail' ],
        'menu_icon'    => 'dashicons-format-quote',
        'show_in_rest' => true,
    ]);
    // Team — الفريق
    register_post_type( 'gcs_team', [
        'labels' => [
            'name'          => 'فريق العمل',
            'singular_name' => 'عضو',
            'add_new'       => 'إضافة عضو',
            'all_items'     => 'كل الأعضاء',
        ],
        'public'       => false,
        'show_ui'      => true,
        'supports'     => [ 'title', 'editor', 'thumbnail' ],
        'menu_icon'    => 'dashicons-groups',
        'show_in_rest' => true,
    ]);
}
add_action( 'init', 'gcs_register_post_types' );

/* =============================================
   8. TAXONOMIES
   ============================================= */
function gcs_register_taxonomies() {
    register_taxonomy( 'project_category', 'gcs_project', [
        'labels'       => [ 'name' => 'تصنيفات المشاريع', 'singular_name' => 'تصنيف', 'add_new_item' => 'إضافة تصنيف' ],
        'hierarchical' => true,
        'rewrite'      => [ 'slug' => 'project-category' ],
        'show_in_rest' => true,
    ]);
    register_taxonomy( 'service_category', 'gcs_service', [
        'labels'       => [ 'name' => 'تصنيفات الخدمات', 'singular_name' => 'تصنيف' ],
        'hierarchical' => true,
        'show_in_rest' => true,
    ]);
}
add_action( 'init', 'gcs_register_taxonomies' );

/* =============================================
   9. META BOXES — PROJECT DETAILS
   ============================================= */
function gcs_add_meta_boxes() {
    add_meta_box( 'gcs_project_meta', 'تفاصيل المشروع', 'gcs_project_meta_callback', 'gcs_project', 'normal', 'high' );
    add_meta_box( 'gcs_service_meta', 'تفاصيل الخدمة',  'gcs_service_meta_callback',  'gcs_service',  'normal', 'high' );
    add_meta_box( 'gcs_testi_meta',   'تفاصيل التقييم', 'gcs_testi_meta_callback',   'gcs_testimonial', 'normal', 'high' );
    add_meta_box( 'gcs_team_meta',    'تفاصيل العضو',   'gcs_team_meta_callback',    'gcs_team',  'normal', 'high' );
}
add_action( 'add_meta_boxes', 'gcs_add_meta_boxes' );

function gcs_project_meta_callback( $post ) {
    wp_nonce_field( 'gcs_project_meta', 'gcs_project_meta_nonce' );
    $loc    = get_post_meta( $post->ID, '_project_location', true );
    $year   = get_post_meta( $post->ID, '_project_year',     true );
    $type   = get_post_meta( $post->ID, '_project_type',     true );
    $area   = get_post_meta( $post->ID, '_project_area',     true );
    $client = get_post_meta( $post->ID, '_project_client',   true );
    $featured = get_post_meta( $post->ID, '_project_featured', true );
    echo '<style>.gcs-meta-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;padding:10px 0}</style>';
    echo '<div class="gcs-meta-grid">';
    gcs_meta_field( 'الموقع',    '_project_location', $loc );
    gcs_meta_field( 'السنة',     '_project_year',     $year );
    gcs_meta_field( 'النوع',     '_project_type',     $type );
    gcs_meta_field( 'المساحة',   '_project_area',     $area );
    gcs_meta_field( 'العميل',    '_project_client',   $client );
    echo '</div>';
    echo '<label style="display:flex;align-items:center;gap:8px;margin-top:10px"><input type="checkbox" name="_project_featured" value="1"' . checked($featured,'1',false) . '> مشروع مميز (يظهر في الهوم)</label>';
}

function gcs_service_meta_callback( $post ) {
    wp_nonce_field( 'gcs_service_meta', 'gcs_service_meta_nonce' );
    $icon  = get_post_meta( $post->ID, '_service_icon',  true );
    $order = get_post_meta( $post->ID, '_service_order', true );
    echo '<div class="gcs-meta-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;padding:10px 0">';
    gcs_meta_field( 'أيقونة SVG (كود HTML)', '_service_icon',  $icon,  'textarea' );
    gcs_meta_field( 'ترتيب الظهور',          '_service_order', $order, 'number' );
    echo '</div>';
}

function gcs_testi_meta_callback( $post ) {
    wp_nonce_field( 'gcs_testi_meta', 'gcs_testi_meta_nonce' );
    $author = get_post_meta( $post->ID, '_testi_author', true );
    $loc    = get_post_meta( $post->ID, '_testi_loc',    true );
    $rating = get_post_meta( $post->ID, '_testi_rating', true );
    echo '<div class="gcs-meta-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;padding:10px 0">';
    gcs_meta_field( 'اسم العميل',   '_testi_author', $author );
    gcs_meta_field( 'الموقع/المنصب', '_testi_loc',   $loc );
    echo '<div><label>التقييم (1-5)</label><br><select name="_testi_rating" style="width:100%;margin-top:5px">';
    for ( $i = 5; $i >= 1; $i-- ) echo "<option value='{$i}'" . selected($rating,$i,false) . ">{$i} نجوم</option>";
    echo '</select></div>';
    echo '</div>';
}

function gcs_team_meta_callback( $post ) {
    wp_nonce_field( 'gcs_team_meta', 'gcs_team_meta_nonce' );
    $pos    = get_post_meta( $post->ID, '_team_position', true );
    $email  = get_post_meta( $post->ID, '_team_email',    true );
    $linked = get_post_meta( $post->ID, '_team_linkedin',  true );
    echo '<div class="gcs-meta-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;padding:10px 0">';
    gcs_meta_field( 'المنصب الوظيفي', '_team_position', $pos );
    gcs_meta_field( 'البريد الإلكتروني', '_team_email', $email );
    gcs_meta_field( 'رابط لينكدإن',   '_team_linkedin', $linked );
    echo '</div>';
}

function gcs_meta_field( $label, $name, $value, $type = 'text' ) {
    echo "<div><label style='font-weight:600;display:block;margin-bottom:5px'>{$label}</label>";
    if ( $type === 'textarea' ) {
        echo "<textarea name='{$name}' rows='3' style='width:100%'>" . esc_textarea($value) . "</textarea>";
    } else {
        echo "<input type='{$type}' name='{$name}' value='" . esc_attr($value) . "' style='width:100%'>";
    }
    echo '</div>';
}

/* =============================================
   10. SAVE META BOXES
   ============================================= */
function gcs_save_meta( $post_id ) {
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    if ( ! current_user_can('edit_post', $post_id) ) return;

    $metas = [
        '_project_location', '_project_year', '_project_type',
        '_project_area', '_project_client', '_project_featured',
        '_service_icon', '_service_order',
        '_testi_author', '_testi_loc', '_testi_rating',
        '_team_position', '_team_email', '_team_linkedin',
    ];
    foreach ( $metas as $key ) {
        if ( isset($_POST[$key]) ) {
            update_post_meta( $post_id, $key, sanitize_text_field($_POST[$key]) );
        }
    }
}
add_action( 'save_post', 'gcs_save_meta' );

/* =============================================
   11. WIDGETS
   ============================================= */
function gcs_register_sidebars() {
    register_sidebar([
        'name'          => 'الشريط الجانبي',
        'id'            => 'sidebar-main',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
    register_sidebar([
        'name'          => 'فوتر - العمود الأول',
        'id'            => 'footer-1',
        'before_widget' => '<div class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ]);
}
add_action( 'widgets_init', 'gcs_register_sidebars' );

/* =============================================
   12. CONTACT FORM AJAX HANDLER
   ============================================= */
function gcs_handle_contact() {
    check_ajax_referer( 'gcs_contact_nonce', 'nonce' );
    $name    = sanitize_text_field( $_POST['name'] ?? '' );
    $email   = sanitize_email( $_POST['email'] ?? '' );
    $phone   = sanitize_text_field( $_POST['phone'] ?? '' );
    $service = sanitize_text_field( $_POST['service'] ?? '' );
    $message = sanitize_textarea_field( $_POST['message'] ?? '' );

    if ( empty($name) || empty($email) || empty($message) ) {
        wp_send_json_error(['message' => 'يرجى ملء جميع الحقول المطلوبة']);
    }

    $to      = get_theme_mod( 'gcs_company_email', get_option('admin_email') );
    $subject = "رسالة جديدة من {$name} — موقع نجوم العاصمة";
    $body    = "الاسم: {$name}\nالبريد: {$email}\nالهاتف: {$phone}\nالخدمة: {$service}\n\nالرسالة:\n{$message}";
    $headers = [ 'Content-Type: text/plain; charset=UTF-8', "Reply-To: {$email}" ];

    if ( wp_mail( $to, $subject, $body, $headers ) ) {
        wp_send_json_success(['message' => 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.']);
    } else {
        wp_send_json_error(['message' => 'حدث خطأ أثناء الإرسال، يرجى المحاولة مرة أخرى.']);
    }
}
add_action( 'wp_ajax_gcs_contact',        'gcs_handle_contact' );
add_action( 'wp_ajax_nopriv_gcs_contact', 'gcs_handle_contact' );

/* =============================================
   13. HELPER FUNCTIONS
   ============================================= */
function gcs_opt( $key ) {
    $opts = gcs_get_options();
    return $opts[$key] ?? '';
}

function gcs_social_links() {
    $socials = [
        'instagram' => [ 'label' => 'Instagram', 'icon' => 'ig' ],
        'twitter'   => [ 'label' => 'Twitter/X',  'icon' => 'tw' ],
        'linkedin'  => [ 'label' => 'LinkedIn',   'icon' => 'in' ],
        'youtube'   => [ 'label' => 'YouTube',    'icon' => 'yt' ],
    ];
    $out = '';
    foreach ( $socials as $key => $data ) {
        $url = gcs_opt("social_{$key}");
        if ( $url ) {
            $out .= '<a href="' . esc_url($url) . '" class="soc" target="_blank" rel="noopener" aria-label="' . esc_attr($data['label']) . '">' . esc_html($data['icon']) . '</a>';
        }
    }
    return $out;
}

function gcs_get_services( $limit = 6 ) {
    return get_posts([
        'post_type'      => 'gcs_service',
        'posts_per_page' => $limit,
        'orderby'        => 'meta_value_num',
        'meta_key'       => '_service_order',
        'order'          => 'ASC',
    ]);
}

function gcs_get_projects( $limit = 6, $featured = false ) {
    $args = [
        'post_type'      => 'gcs_project',
        'posts_per_page' => $limit,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];
    if ( $featured ) {
        $args['meta_query'] = [[ 'key' => '_project_featured', 'value' => '1' ]];
    }
    return get_posts($args);
}

function gcs_get_testimonials( $limit = 3 ) {
    return get_posts([
        'post_type'      => 'gcs_testimonial',
        'posts_per_page' => $limit,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
}

/* =============================================
   14. FLUSH REWRITE ON THEME SWITCH
   ============================================= */
function gcs_flush_rewrite() { flush_rewrite_rules(); }
add_action( 'after_switch_theme', 'gcs_flush_rewrite' );

/* =============================================
   INCLUDE SECTIONS BUILDER & AJAX
   ============================================= */
require_once GCS_DIR . '/inc/sections-builder.php';

function gcs_the_sections($post_id = null) {
    $id = $post_id ?: get_the_ID();
    $sections = get_post_meta($id, '_gcs_sections', true);
    if ($sections) gcs_render_sections($sections);
}

function gcs_ajax_nonce_inline() {
    echo '<script>var gcs_ajax = ' . wp_json_encode(['url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('gcs_contact_nonce')]) . ';</script>';
}
add_action('wp_head', 'gcs_ajax_nonce_inline');
