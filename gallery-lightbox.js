/**
 * GCS Theme - Gallery & Lightbox Integration
 * تكامل معرض الصور والـ Lightbox
 */

class GCSGallery {
  constructor(options = {}) {
    this.options = {
      selector: '.gcs-gallery',
      lightboxLib: options.lightboxLib || 'glightbox',
      columns: options.columns || 3,
      gap: options.gap || '2px',
      ...options
    };

    this.init();
  }

  init() {
    this.setupGalleries();
    this.initLightbox();
    this.setupHoverEffects();
  }

  setupGalleries() {
    const galleries = document.querySelectorAll(this.options.selector);
    galleries.forEach((gallery, index) => {
      gallery.classList.add('gcs-gallery-initialized');
      gallery.style.display = 'grid';
      gallery.style.gridTemplateColumns = `repeat(auto-fit, minmax(280px, 1fr))`;
      gallery.style.gap = this.options.gap;
      
      // Add wrapper for lazy loading
      const images = gallery.querySelectorAll('img');
      images.forEach(img => {
        if (!img.hasAttribute('loading')) {
          img.setAttribute('loading', 'lazy');
        }
      });
    });
  }

  initLightbox() {
    if (this.options.lightboxLib === 'glightbox') {
      this.initGLightbox();
    } else if (this.options.lightboxLib === 'fancybox') {
      this.initFancybox();
    } else if (this.options.lightboxLib === 'lightgallery') {
      this.initLightGallery();
    }
  }

  initGLightbox() {
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js';
    
    script.onload = () => {
      const lightbox = GLightbox({
        selector: '.gcs-gallery-item',
        touchNavigation: true,
        slideEffect: 'zoom',
        autoplayVideos: true,
      });

      // Add link styling
      const items = document.querySelectorAll('.gcs-gallery-item');
      items.forEach(item => {
        item.style.position = 'relative';
        item.style.cursor = 'pointer';
        
        const overlay = document.createElement('div');
        overlay.className = 'gallery-item-overlay';
        overlay.innerHTML = '<span class="gallery-icon">🔍</span>';
        item.appendChild(overlay);
      });
    };

    document.head.appendChild(script);

    // Add CSS
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css';
    document.head.appendChild(link);
  }

  initFancybox() {
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js';
    
    script.onload = () => {
      Fancybox.bind('[data-fancybox="gallery"]', {
        on: {
          reveal: (fancybox, $slide) => {
            console.log('Fancybox revealed');
          }
        }
      });
    };

    document.head.appendChild(script);

    // Add CSS
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css';
    document.head.appendChild(link);
  }

  initLightGallery() {
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/lightgallery@2/lightgallery.umd.js';
    
    script.onload = () => {
      const galleries = document.querySelectorAll(this.options.selector);
      galleries.forEach(gallery => {
        lightGallery(gallery, {
          plugins: [lgZoom, lgAutoplay],
          speed: 500,
          controls: true,
          showThumbByDefault: true,
        });
      });
    };

    document.head.appendChild(script);

    // Add CSS
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://cdn.jsdelivr.net/npm/lightgallery@2/css/lightgallery.css';
    document.head.appendChild(link);
  }

  setupHoverEffects() {
    const items = document.querySelectorAll('.gcs-gallery-item');
    items.forEach(item => {
      const img = item.querySelector('img');
      if (!img) return;

      item.addEventListener('mouseenter', () => {
        img.style.transform = 'scale(1.08)';
      });

      item.addEventListener('mouseleave', () => {
        img.style.transform = 'scale(1)';
      });
    });
  }

  /**
   * Add new image to gallery with animation
   */
  addImage(gallery, imageUrl, caption = '') {
    const item = document.createElement('div');
    item.className = 'gcs-gallery-item';
    item.innerHTML = `
      <a href="${imageUrl}" data-fancybox="gallery" title="${caption}">
        <img src="${imageUrl}" alt="${caption}" loading="lazy" />
      </a>
    `;

    item.style.animation = 'slideIn 0.5s ease-out';
    gallery.appendChild(item);
  }

  /**
   * Filter gallery items
   */
  filterGallery(filterClass) {
    const items = document.querySelectorAll('.gcs-gallery-item');
    items.forEach(item => {
      if (filterClass === '*' || item.classList.contains(filterClass)) {
        item.style.display = 'block';
        item.style.animation = 'fadeIn 0.3s ease-out';
      } else {
        item.style.display = 'none';
      }
    });
  }
}

// Initialize Gallery on page load
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    const lightboxLib = document.documentElement.getAttribute('data-lightbox') || 'glightbox';
    new GCSGallery({ lightboxLib });
  });
} else {
  const lightboxLib = document.documentElement.getAttribute('data-lightbox') || 'glightbox';
  new GCSGallery({ lightboxLib });
}

/* ─────────────────────────────────────
   GALLERY STYLES
   ───────────────────────────────────── */

const galleryStyles = `
.gcs-gallery {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2px;
  background: rgba(0, 188, 212, 0.1);
  border-radius: 16px;
  overflow: hidden;
  padding: 2px;
}

.gcs-gallery-item {
  position: relative;
  overflow: hidden;
  aspect-ratio: 1;
  background: #1a2332;
}

.gcs-gallery-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.gcs-gallery-item a {
  display: block;
  width: 100%;
  height: 100%;
  position: relative;
}

.gallery-item-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.gcs-gallery-item:hover .gallery-item-overlay {
  opacity: 1;
}

.gallery-icon {
  font-size: 2rem;
  animation: float 1s ease-in-out infinite;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@media (max-width: 768px) {
  .gcs-gallery {
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  }
}

/* GLightbox Custom Styles */
.glightbox-container {
  background: rgba(0, 0, 0, 0.95);
  backdrop-filter: blur(10px);
}

.gslide-image img {
  border-radius: 8px;
}

.glightbox-slide-link {
  position: relative;
}

/* Fancybox Custom Styles */
.fancybox__content {
  border-radius: 12px;
  box-shadow: 0 0 40px rgba(0, 188, 212, 0.3);
}

/* LightGallery Custom Styles */
.lg-backdrop {
  background: rgba(0, 0, 0, 0.95);
  backdrop-filter: blur(10px);
}

.lg-img-wrap img {
  border-radius: 8px;
}
`;

// Inject styles
const styleSheet = document.createElement('style');
styleSheet.textContent = galleryStyles;
document.head.appendChild(styleSheet);
