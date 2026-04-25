/**
 * GCS Theme - Dark/Light Mode Switcher
 * نظام تبديل الوضع الليلي والنهاري
 */

class GCSThemeSwitcher {
  constructor() {
    this.currentMode = this.getStoredMode() || this.getSystemPreference();
    this.init();
  }

  init() {
    this.applyTheme(this.currentMode);
    this.createSwitcherUI();
    this.setupEventListeners();
  }

  getStoredMode() {
    return localStorage.getItem('gcs-theme-mode');
  }

  getSystemPreference() {
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  }

  setStoredMode(mode) {
    localStorage.setItem('gcs-theme-mode', mode);
  }

  applyTheme(mode) {
    const html = document.documentElement;
    const isDark = mode === 'dark';

    if (isDark) {
      html.classList.remove('light-mode');
      html.classList.add('dark-mode');
    } else {
      html.classList.remove('dark-mode');
      html.classList.add('light-mode');
    }

    this.currentMode = mode;
    this.setStoredMode(mode);
  }

  createSwitcherUI() {
    const switcher = document.createElement('div');
    switcher.className = 'theme-switcher';
    switcher.innerHTML = `
      <button class="theme-toggle-btn" aria-label="تبديل الوضع" title="Dark/Light Mode">
        <span class="theme-icon">${this.currentMode === 'dark' ? '🌙' : '☀️'}</span>
      </button>
    `;

    document.body.appendChild(switcher);
  }

  setupEventListeners() {
    const btn = document.querySelector('.theme-toggle-btn');
    if (!btn) return;

    btn.addEventListener('click', () => {
      const newMode = this.currentMode === 'dark' ? 'light' : 'dark';
      this.toggleTheme(newMode);
    });

    // Listen to system preference changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
      if (!this.getStoredMode()) {
        this.applyTheme(e.matches ? 'dark' : 'light');
        this.updateUI();
      }
    });
  }

  toggleTheme(mode) {
    this.applyTheme(mode);
    this.updateUI();
    this.animateSwitch();
  }

  updateUI() {
    const icon = document.querySelector('.theme-icon');
    if (icon) {
      icon.textContent = this.currentMode === 'dark' ? '🌙' : '☀️';
    }
  }

  animateSwitch() {
    const btn = document.querySelector('.theme-toggle-btn');
    if (!btn) return;
    
    btn.style.transform = 'scale(0.8) rotate(180deg)';
    setTimeout(() => {
      btn.style.transform = 'scale(1) rotate(0deg)';
    }, 150);
  }
}

// Initialize on DOM ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    new GCSThemeSwitcher();
  });
} else {
  new GCSThemeSwitcher();
}

/* ─────────────────────────────────────
   PREFERS-REDUCED-MOTION
   ───────────────────────────────────── */

if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
  document.documentElement.style.scrollBehavior = 'auto';
}
