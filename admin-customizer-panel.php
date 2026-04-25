<?php
/**
 * GCS Theme — Advanced Customizer Panel
 * لوحة التحكم المتقدمة للتخصيص
 */

if (!defined('ABSPATH')) exit;

class GCS_Advanced_Customizer {

    public function __construct() {
        add_action('customize_register', [$this, 'register_customizer']);
        add_action('wp_head', [$this, 'output_custom_css']);
    }

    /**
     * Register Customizer Panels & Sections
     */
    public function register_customizer($wp_customize) {
        
        // Remove default colors section
        $wp_customize->remove_section('colors');

        /* ─────────────────────────────────────
           MAIN PANEL
           ───────────────────────────────────── */
        
        $wp_customize->add_panel('gcs_main_panel', [
            'title' => __('🎨 GCS Theme Settings', 'gcs-theme'),
            'priority' => 10,
        ]);

        /* ─────────────────────────────────────
           COLORS SECTION
           ───────────────────────────────────── */
        
        $wp_customize->add_section('gcs_colors_section', [
            'title' => __('🎯 Colors', 'gcs-theme'),
            'panel' => 'gcs_main_panel',
            'priority' => 10,
        ]);

        // Primary Cyan
        $wp_customize->add_setting('gcs_primary_cyan', [
            'default' => '#00BCD4',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ]);

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gcs_primary_cyan', [
            'label' => __('Primary Cyan Color', 'gcs-theme'),
            'description' => __('اللون الأساسي (من الشعار)', 'gcs-theme'),
            'section' => 'gcs_colors_section',
            'settings' => 'gcs_primary_cyan',
        ]));

        // Accent Gold
        $wp_customize->add_setting('gcs_accent_gold', [
            'default' => '#FFD700',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ]);

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gcs_accent_gold', [
            'label' => __('Accent Gold Color', 'gcs-theme'),
            'description' => __('لون الذهب للتأكيد', 'gcs-theme'),
            'section' => 'gcs_colors_section',
            'settings' => 'gcs_accent_gold',
        ]));

        // Dark Background
        $wp_customize->add_setting('gcs_dark_bg', [
            'default' => '#0F1419',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ]);

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gcs_dark_bg', [
            'label' => __('Dark Background', 'gcs-theme'),
            'description' => __('لون الخلفية الداكن', 'gcs-theme'),
            'section' => 'gcs_colors_section',
            'settings' => 'gcs_dark_bg',
        ]));

        // Text Primary Color
        $wp_customize->add_setting('gcs_text_primary', [
            'default' => '#FFFFFF',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ]);

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'gcs_text_primary', [
            'label' => __('Primary Text Color', 'gcs-theme'),
            'description' => __('لون النص الأساسي', 'gcs-theme'),
            'section' => 'gcs_colors_section',
            'settings' => 'gcs_text_primary',
        ]));

        /* ─────────────────────────────────────
           TYPOGRAPHY SECTION
           ───────────────────────────────────── */
        
        $wp_customize->add_section('gcs_typography_section', [
            'title' => __('✍️ Typography', 'gcs-theme'),
            'panel' => 'gcs_main_panel',
            'priority' => 20,
        ]);

        // Body Font Size
        $wp_customize->add_setting('gcs_font_size_base', [
            'default' => '16',
            'transport' => 'postMessage',
            'sanitize_callback' => 'absint',
        ]);

        $wp_customize->add_control('gcs_font_size_base', [
            'label' => __('Base Font Size (px)', 'gcs-theme'),
            'description' => __('حجم الخط الأساسي', 'gcs-theme'),
            'section' => 'gcs_typography_section',
            'settings' => 'gcs_font_size_base',
            'type' => 'number',
            'input_attrs' => [
                'min' => 12,
                'max' => 24,
                'step' => 1,
            ],
        ]);

        // Line Height
        $wp_customize->add_setting('gcs_line_height', [
            'default' => '1.6',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ]);

        $wp_customize->add_control('gcs_line_height', [
            'label' => __('Line Height', 'gcs-theme'),
            'description' => __('ارتفاع السطر', 'gcs-theme'),
            'section' => 'gcs_typography_section',
            'settings' => 'gcs_line_height',
            'type' => 'select',
            'choices' => [
                '1.4' => '1.4',
                '1.5' => '1.5',
                '1.6' => '1.6',
                '1.8' => '1.8',
                '2' => '2',
            ],
        ]);

        /* ─────────────────────────────────────
           HERO SLIDER SECTION
           ───────────────────────────────────── */
        
        $wp_customize->add_section('gcs_hero_section', [
            'title' => __('🎬 Hero Slider', 'gcs-theme'),
            'panel' => 'gcs_main_panel',
            'priority' => 30,
        ]);

        // Enable Video Background
        $wp_customize->add_setting('gcs_hero_video_enabled', [
            'default' => false,
            'transport' => 'postMessage',
            'sanitize_callback' => rest_sanitize_boolean,
        ]);

        $wp_customize->add_control('gcs_hero_video_enabled', [
            'label' => __('Enable Video Background', 'gcs-theme'),
            'description' => __('فعّل خلفية فيديو بدل الصور', 'gcs-theme'),
            'section' => 'gcs_hero_section',
            'settings' => 'gcs_hero_video_enabled',
            'type' => 'checkbox',
        ]);

        // Slider Speed
        $wp_customize->add_setting('gcs_slider_speed', [
            'default' => '6000',
            'transport' => 'postMessage',
            'sanitize_callback' => 'absint',
        ]);

        $wp_customize->add_control('gcs_slider_speed', [
            'label' => __('Slider Speed (ms)', 'gcs-theme'),
            'description' => __('سرعة الانتقال بين الشرائح', 'gcs-theme'),
            'section' => 'gcs_hero_section',
            'settings' => 'gcs_slider_speed',
            'type' => 'number',
            'input_attrs' => [
                'min' => 2000,
                'max' => 15000,
                'step' => 1000,
            ],
        ]);

        // Auto Play
        $wp_customize->add_setting('gcs_slider_autoplay', [
            'default' => true,
            'transport' => 'postMessage',
            'sanitize_callback' => rest_sanitize_boolean,
        ]);

        $wp_customize->add_control('gcs_slider_autoplay', [
            'label' => __('Auto Play', 'gcs-theme'),
            'description' => __('تشغيل تلقائي للشرائح', 'gcs-theme'),
            'section' => 'gcs_hero_section',
            'settings' => 'gcs_slider_autoplay',
            'type' => 'checkbox',
        ]);

        /* ─────────────────────────────────────
           ANIMATIONS SECTION
           ───────────────────────────────────── */
        
        $wp_customize->add_section('gcs_animations_section', [
            'title' => __('⚡ Animations', 'gcs-theme'),
            'panel' => 'gcs_main_panel',
            'priority' => 40,
        ]);

        // Enable Animations
        $wp_customize->add_setting('gcs_animations_enabled', [
            'default' => true,
            'transport' => 'postMessage',
            'sanitize_callback' => rest_sanitize_boolean,
        ]);

        $wp_customize->add_control('gcs_animations_enabled', [
            'label' => __('Enable Animations', 'gcs-theme'),
            'description' => __('فعّل الأنيميشنات', 'gcs-theme'),
            'section' => 'gcs_animations_section',
            'settings' => 'gcs_animations_enabled',
            'type' => 'checkbox',
        ]);

        // Animation Speed
        $wp_customize->add_setting('gcs_animation_speed', [
            'default' => 'normal',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ]);

        $wp_customize->add_control('gcs_animation_speed', [
            'label' => __('Animation Speed', 'gcs-theme'),
            'description' => __('سرعة الأنيميشنات', 'gcs-theme'),
            'section' => 'gcs_animations_section',
            'settings' => 'gcs_animation_speed',
            'type' => 'select',
            'choices' => [
                'slow' => __('Slow', 'gcs-theme'),
                'normal' => __('Normal', 'gcs-theme'),
                'fast' => __('Fast', 'gcs-theme'),
            ],
        ]);

        /* ─────────────────────────────────────
           HEADER & LOGO SECTION
           ───────────────────────────────────── */
        
        $wp_customize->add_section('gcs_header_section', [
            'title' => __('🏢 Header & Logo', 'gcs-theme'),
            'panel' => 'gcs_main_panel',
            'priority' => 50,
        ]);

        // Logo Size
        $wp_customize->add_setting('gcs_logo_size', [
            'default' => '52',
            'transport' => 'postMessage',
            'sanitize_callback' => 'absint',
        ]);

        $wp_customize->add_control('gcs_logo_size', [
            'label' => __('Logo Size (px)', 'gcs-theme'),
            'description' => __('حجم الشعار', 'gcs-theme'),
            'section' => 'gcs_header_section',
            'settings' => 'gcs_logo_size',
            'type' => 'number',
            'input_attrs' => [
                'min' => 30,
                'max' => 100,
                'step' => 5,
            ],
        ]);

        // Logo Glow
        $wp_customize->add_setting('gcs_logo_glow', [
            'default' => true,
            'transport' => 'postMessage',
            'sanitize_callback' => rest_sanitize_boolean,
        ]);

        $wp_customize->add_control('gcs_logo_glow', [
            'label' => __('Logo Glow Effect', 'gcs-theme'),
            'description' => __('تأثير التوهج على الشعار', 'gcs-theme'),
            'section' => 'gcs_header_section',
            'settings' => 'gcs_logo_glow',
            'type' => 'checkbox',
        ]);

        /* ─────────────────────────────────────
           GALLERY & LIGHTBOX SECTION
           ───────────────────────────────────── */
        
        $wp_customize->add_section('gcs_gallery_section', [
            'title' => __('🖼️ Gallery & Lightbox', 'gcs-theme'),
            'panel' => 'gcs_main_panel',
            'priority' => 60,
        ]);

        // Lightbox Library
        $wp_customize->add_setting('gcs_lightbox_library', [
            'default' => 'glightbox',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field',
        ]);

        $wp_customize->add_control('gcs_lightbox_library', [
            'label' => __('Lightbox Library', 'gcs-theme'),
            'description' => __('مكتبة عرض الصور', 'gcs-theme'),
            'section' => 'gcs_gallery_section',
            'settings' => 'gcs_lightbox_library',
            'type' => 'select',
            'choices' => [
                'glightbox' => 'GLightbox',
                'fancybox' => 'Fancybox',
                'lightgallery' => 'LightGallery',
            ],
        ]);

        // Gallery Columns
        $wp_customize->add_setting('gcs_gallery_columns', [
            'default' => '3',
            'transport' => 'postMessage',
            'sanitize_callback' => 'absint',
        ]);

        $wp_customize->add_control('gcs_gallery_columns', [
            'label' => __('Gallery Columns', 'gcs-theme'),
            'description' => __('عدد الأعمدة', 'gcs-theme'),
            'section' => 'gcs_gallery_section',
            'settings' => 'gcs_gallery_columns',
            'type' => 'select',
            'choices' => [
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
            ],
        ]);

        /* ─────────────────────────────────────
           PERFORMANCE SECTION
           ───────────────────────────────────── */
        
        $wp_customize->add_section('gcs_performance_section', [
            'title' => __('⚙️ Performance', 'gcs-theme'),
            'panel' => 'gcs_main_panel',
            'priority' => 70,
        ]);

        // Lazy Loading
        $wp_customize->add_setting('gcs_lazy_loading', [
            'default' => true,
            'transport' => 'postMessage',
            'sanitize_callback' => rest_sanitize_boolean,
        ]);

        $wp_customize->add_control('gcs_lazy_loading', [
            'label' => __('Enable Lazy Loading', 'gcs-theme'),
            'description' => __('تحميل الصور عند الحاجة', 'gcs-theme'),
            'section' => 'gcs_performance_section',
            'settings' => 'gcs_lazy_loading',
            'type' => 'checkbox',
        ]);

        // Minify CSS
        $wp_customize->add_setting('gcs_minify_css', [
            'default' => true,
            'transport' => 'postMessage',
            'sanitize_callback' => rest_sanitize_boolean,
        ]);

        $wp_customize->add_control('gcs_minify_css', [
            'label' => __('Minify CSS', 'gcs-theme'),
            'description' => __('تقليل حجم ملفات CSS', 'gcs-theme'),
            'section' => 'gcs_performance_section',
            'settings' => 'gcs_minify_css',
            'type' => 'checkbox',
        ]);
    }

    /**
     * Output Custom CSS based on customizer settings
     */
    public function output_custom_css() {
        $primary_cyan = get_theme_mod('gcs_primary_cyan', '#00BCD4');
        $accent_gold = get_theme_mod('gcs_accent_gold', '#FFD700');
        $dark_bg = get_theme_mod('gcs_dark_bg', '#0F1419');
        $text_primary = get_theme_mod('gcs_text_primary', '#FFFFFF');
        $font_size_base = get_theme_mod('gcs_font_size_base', '16');
        $line_height = get_theme_mod('gcs_line_height', '1.6');
        $logo_size = get_theme_mod('gcs_logo_size', '52');
        $animation_speed = get_theme_mod('gcs_animation_speed', 'normal');

        $css = ":root {\n";
        $css .= "  --primary-cyan: {$primary_cyan};\n";
        $css .= "  --accent-gold: {$accent_gold};\n";
        $css .= "  --dark-bg: {$dark_bg};\n";
        $css .= "  --text-primary: {$text_primary};\n";
        $css .= "  --font-size-base: {$font_size_base}px;\n";
        $css .= "  --line-height-base: {$line_height};\n";
        $css .= "}\n\n";

        $css .= ".nav-logo img, .nav-logo .custom-logo {\n";
        $css .= "  width: {$logo_size}px;\n";
        $css .= "  height: {$logo_size}px;\n";
        $css .= "}\n\n";

        if ($animation_speed === 'slow') {
            $css .= ":root { --transition-smooth: 0.5s cubic-bezier(0.4, 0, 0.2, 1); }\n";
        } elseif ($animation_speed === 'fast') {
            $css .= ":root { --transition-smooth: 0.15s cubic-bezier(0.4, 0, 0.2, 1); }\n";
        }

        if (!get_theme_mod('gcs_logo_glow', true)) {
            $css .= ".nav-logo img, .nav-logo .custom-logo { filter: none !important; }\n";
        }

        // Output CSS
        echo '<style id="gcs-customizer-css">' . $css . '</style>';
    }
}

// Initialize
new GCS_Advanced_Customizer();
