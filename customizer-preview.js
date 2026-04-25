/**
 * GCS Theme — Customizer Live Preview
 */
(function($) {
  'use strict';

  const colorMap = {
    'gcs_color_primary':   '--gold',
    'gcs_color_secondary': '--teal',
    'gcs_color_dark':      '--dark',
    'gcs_color_text':      '--white',
  };

  Object.entries(colorMap).forEach(([setting, cssVar]) => {
    wp.customize(setting, val => val.bind(v => {
      document.documentElement.style.setProperty(cssVar, v);
    }));
  });

  // Company name
  wp.customize('gcs_company_name_ar', val => val.bind(v => {
    document.querySelectorAll('.nav-logo-ar, .foot-brand-name').forEach(el => el.textContent = v);
  }));
  wp.customize('gcs_company_name_en', val => val.bind(v => {
    document.querySelectorAll('.nav-logo-en').forEach(el => el.textContent = v);
  }));

  // Stats
  ['projects','years','clients','awards'].forEach((stat, i) => {
    wp.customize('gcs_stat_' + stat, val => val.bind(v => {
      const els = document.querySelectorAll('.stat-num');
      if (els[i]) els[i].textContent = v;
    }));
  });

  // Footer about
  wp.customize('gcs_footer_about', val => val.bind(v => {
    document.querySelectorAll('.foot-about').forEach(el => el.textContent = v);
  }));

  // Footer copyright
  wp.customize('gcs_footer_copy', val => val.bind(v => {
    document.querySelectorAll('.footer-bottom p').forEach(el => el.textContent = v);
  }));

  // Slider content
  [1,2,3].forEach(i => {
    wp.customize('gcs_hero_slide' + i + '_tag', val => val.bind(v => {
      const el = document.querySelector('#slide-' + i + ' .slide-tag');
      if (el) el.textContent = v;
    }));
    wp.customize('gcs_hero_slide' + i + '_title', val => val.bind(v => {
      const el = document.querySelector('#slide-' + i + ' .slide-title');
      if (el) el.innerHTML = v;
    }));
    wp.customize('gcs_hero_slide' + i + '_sub', val => val.bind(v => {
      const el = document.querySelector('#slide-' + i + ' .slide-sub');
      if (el) el.textContent = v;
    }));
  });

})(jQuery);
