/**
 * GCS Theme — Enhanced Main JavaScript v2
 */
(function ($) {
  'use strict';
  const GCS = {
    init() {
      this.loader(); this.cursor(); this.navbar(); this.scrollProgress();
      this.slider(); this.reveal(); this.counter(); this.marquee();
      this.mobileMenu(); this.backToTop(); this.contactForm();
      this.filterProjects(); this.pageTransitions(); this.parallax();
      this.magneticButtons(); this.tiltCards(); this.ctaCircles(); this.lazyImages();
    },

    loader() {
      const loader = document.getElementById('gcs-loader');
      if (!loader) return;
      let p = 0;
      const bar = loader.querySelector('.loader-bar');
      const pct = loader.querySelector('.loader-pct');
      const tick = () => {
        p += Math.random() * 20; if (p > 100) p = 100;
        if (bar) bar.style.width = p + '%';
        if (pct) pct.textContent = Math.floor(p) + '%';
        if (p < 100) setTimeout(tick, 100 + Math.random() * 80);
        else setTimeout(() => { loader.classList.add('hidden'); document.body.classList.remove('loading'); setTimeout(() => loader.remove(), 700); }, 300);
      };
      document.body.classList.add('loading');
      setTimeout(tick, 80);
      window.addEventListener('load', () => { p = 100; if (bar) bar.style.width = '100%'; setTimeout(() => loader.classList.add('hidden'), 300); });
    },

    cursor() {
      const opts = window.GCS_OPTIONS || {};
      if (opts.show_cursor === '0' || window.innerWidth < 1024) return;
      const cur = document.getElementById('gcs-cursor'), ring = document.getElementById('gcs-cursor-ring');
      if (!cur || !ring) return;
      let mx = 0, my = 0, rx = 0, ry = 0;
      document.addEventListener('mousemove', e => { mx = e.clientX; my = e.clientY; cur.style.left = mx + 'px'; cur.style.top = my + 'px'; });
      const anim = () => { rx += (mx - rx) * .11; ry += (my - ry) * .11; ring.style.left = rx + 'px'; ring.style.top = ry + 'px'; requestAnimationFrame(anim); };
      anim();
      document.querySelectorAll('a,button,.srv,.proj-card,.testi-card,.why-feat,.arr-btn,.dot,input,textarea,select').forEach(el => {
        el.addEventListener('mouseenter', () => document.body.classList.add('cursor-hover'));
        el.addEventListener('mouseleave', () => document.body.classList.remove('cursor-hover'));
      });
      document.addEventListener('mouseleave', () => { cur.style.opacity='0'; ring.style.opacity='0'; });
      document.addEventListener('mouseenter', () => { cur.style.opacity='1'; ring.style.opacity='1'; });
      document.addEventListener('click', e => {
        const b = document.createElement('div');
        b.style.cssText = `position:fixed;left:${e.clientX}px;top:${e.clientY}px;width:6px;height:6px;border-radius:50%;background:var(--gold);transform:translate(-50%,-50%);pointer-events:none;z-index:9997;animation:cursorBurst .5s forwards`;
        document.body.appendChild(b); setTimeout(() => b.remove(), 500);
      });
    },

    navbar() {
      const nav = document.getElementById('gcs-nav'); if (!nav) return;
      let lastY = 0;
      const upd = () => {
        const y = window.scrollY;
        nav.classList.toggle('scrolled', y > 80);
        nav.style.transform = (y > 300 && y > lastY) ? 'translateY(-100%)' : 'translateY(0)';
        lastY = y;
      };
      window.addEventListener('scroll', upd, { passive: true }); upd();
      const secs = document.querySelectorAll('section[id]'), links = document.querySelectorAll('.nav-links li a[href^="#"]');
      window.addEventListener('scroll', () => {
        let cur = ''; secs.forEach(s => { if (window.scrollY >= s.offsetTop - 220) cur = s.id; });
        links.forEach(l => l.closest('li')?.classList.toggle('current-menu-item', l.getAttribute('href') === '#' + cur));
      }, { passive: true });
    },

    scrollProgress() {
      const bar = document.createElement('div'); bar.id = 'scroll-progress'; document.body.prepend(bar);
      window.addEventListener('scroll', () => { bar.style.width = Math.min((window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100, 100) + '%'; }, { passive: true });
    },

    slider() {
      const slides = document.querySelectorAll('.slide'), dots = document.querySelectorAll('.dot');
      if (!slides.length) return;
      let cur = 0, timer;
      const speed = parseInt(window.GCS_OPTIONS?.slider_autoplay_speed) || 6000;
      const goTo = n => {
        slides[cur].classList.remove('active'); slides[cur].classList.add('prev'); dots[cur]?.classList.remove('active');
        cur = ((n % slides.length) + slides.length) % slides.length;
        slides[cur].classList.add('active'); slides[cur].classList.remove('prev'); dots[cur]?.classList.add('active');
        setTimeout(() => slides.forEach(s => s.classList.remove('prev')), 1400);
        clearTimeout(timer); timer = setTimeout(() => goTo(cur + 1), speed);
      };
      document.getElementById('slide-next')?.addEventListener('click', () => goTo(cur + 1));
      document.getElementById('slide-prev')?.addEventListener('click', () => goTo(cur - 1));
      dots.forEach((d, i) => d.addEventListener('click', () => goTo(i)));
      let tx = 0;
      const sl = document.getElementById('gcs-slider');
      sl?.addEventListener('touchstart', e => { tx = e.touches[0].clientX; }, { passive: true });
      sl?.addEventListener('touchend', e => { const d = tx - e.changedTouches[0].clientX; if (Math.abs(d) > 50) goTo(cur + (d > 0 ? 1 : -1)); });
      document.addEventListener('keydown', e => { if (e.key === 'ArrowLeft') goTo(cur + 1); if (e.key === 'ArrowRight') goTo(cur - 1); });
      sl?.addEventListener('mouseenter', () => clearTimeout(timer));
      sl?.addEventListener('mouseleave', () => { timer = setTimeout(() => goTo(cur + 1), speed); });
      timer = setTimeout(() => goTo(cur + 1), speed);
    },

    reveal() {
      const els = document.querySelectorAll('.rv'); if (!els.length) return;
      new IntersectionObserver(entries => entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('on'); }), { threshold: 0.08, rootMargin: '0px 0px -50px 0px' }).observe && document.querySelectorAll('.rv').forEach(el => new IntersectionObserver(entries => entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('on'); }), { threshold: 0.08, rootMargin: '0px 0px -50px 0px' }).observe(el));
    },

    counter() {
      const counters = document.querySelectorAll('.stat-num'); if (!counters.length) return;
      const io = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (!entry.isIntersecting) return;
          const el = entry.target, raw = el.textContent.replace(/[^0-9]/g,'');
          if (!raw) return;
          const num = parseInt(raw), before = el.textContent.split(raw)[0].replace(/\d/g,''), after = el.textContent.replace(before,'').replace(raw,'');
          let start = 0;
          const ease = t => t < .5 ? 2*t*t : -1+(4-2*t)*t, dur = 2200, begin = performance.now();
          const frame = now => { const t = Math.min((now-begin)/dur,1); el.textContent = before+Math.floor(ease(t)*num)+after; if (t<1) requestAnimationFrame(frame); else el.textContent = before+num+after; };
          requestAnimationFrame(frame); io.unobserve(el);
        });
      }, { threshold: 0.5 });
      counters.forEach(c => io.observe(c));
    },

    marquee() {
      const t = document.querySelector('.marquee-track'); if (!t) return;
      t.addEventListener('mouseenter', () => t.style.animationPlayState = 'paused');
      t.addEventListener('mouseleave', () => t.style.animationPlayState = 'running');
    },

    mobileMenu() {
      const toggle = document.getElementById('nav-toggle'), menu = document.getElementById('nav-mobile'); if (!toggle || !menu) return;
      const close = () => { menu.classList.remove('open'); toggle.classList.remove('open'); document.body.style.overflow = ''; toggle.setAttribute('aria-expanded','false'); };
      toggle.addEventListener('click', () => { const open = !menu.classList.contains('open'); open ? menu.classList.add('open') : close(); toggle.classList.toggle('open',open); document.body.style.overflow = open?'hidden':''; toggle.setAttribute('aria-expanded',String(open)); });
      menu.querySelectorAll('a').forEach(l => l.addEventListener('click', close));
      document.addEventListener('keydown', e => { if (e.key==='Escape') close(); });
    },

    backToTop() {
      const btn = document.getElementById('back-to-top'); if (!btn) return;
      window.addEventListener('scroll', () => btn.classList.toggle('visible', window.scrollY > 600), { passive: true });
      btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    },

    contactForm() {
      const form = document.getElementById('gcs-contact-form'); if (!form) return;
      form.addEventListener('submit', async e => {
        e.preventDefault();
        const btn = form.querySelector('[type="submit"]'), msg = document.getElementById('form-message');
        const data = new FormData(form); data.append('action','gcs_contact'); data.append('nonce',window.gcs_ajax?.nonce||'');
        btn.disabled = true; const orig = btn.textContent; btn.innerHTML = '<span style="opacity:.6">جارٍ الإرسال…</span>';
        try {
          const res = await fetch(window.gcs_ajax?.url||'/wp-admin/admin-ajax.php', { method:'POST', body:data });
          const json = await res.json();
          if (msg) { msg.className = 'form-msg ' + (json.success?'success':'error'); msg.textContent = json.data?.message || (json.success?'تم الإرسال!':'حدث خطأ'); msg.style.display = 'block'; msg.scrollIntoView({ behavior:'smooth', block:'nearest' }); }
          if (json.success) form.reset();
        } catch { if (msg) { msg.className = 'form-msg error'; msg.textContent = 'خطأ في الاتصال.'; msg.style.display = 'block'; } }
        btn.disabled = false; btn.textContent = orig;
      });
      document.getElementById('foot-newsletter')?.addEventListener('submit', e => {
        e.preventDefault(); const btn = e.target.querySelector('button');
        btn.textContent = '✓'; btn.style.background = '#4caf50';
        setTimeout(() => { btn.textContent = 'اشترك'; btn.style.background = ''; e.target.querySelector('input').value = ''; }, 2500);
      });
    },

    filterProjects() {
      const filters = document.querySelectorAll('.proj-filter-btn'), cards = document.querySelectorAll('.proj-card-filterable'); if (!filters.length) return;
      filters.forEach(btn => {
        btn.addEventListener('click', () => {
          filters.forEach(b => { b.classList.remove('active'); b.style.color='var(--gray)'; b.style.borderBottomColor='transparent'; });
          btn.classList.add('active'); btn.style.color='var(--gold)'; btn.style.borderBottomColor='var(--gold)';
          const cat = btn.dataset.cat;
          cards.forEach(card => {
            const show = cat === 'all' || card.dataset.cat === cat;
            card.style.transition = 'opacity .35s, transform .35s';
            if (show) { card.style.display=''; requestAnimationFrame(() => { card.style.opacity='1'; card.style.transform='scale(1)'; }); }
            else { card.style.opacity='0'; card.style.transform='scale(.97)'; setTimeout(() => { card.style.display='none'; }, 350); }
          });
        });
      });
    },

    pageTransitions() {
      const ov = document.createElement('div');
      ov.style.cssText = 'position:fixed;inset:0;background:var(--dark);z-index:9500;pointer-events:none;opacity:0;transition:opacity .4s ease';
      document.body.appendChild(ov);
      window.addEventListener('load', () => { setTimeout(() => { ov.style.opacity='0'; ov.style.pointerEvents='none'; }, 100); });
      document.querySelectorAll('a[href]:not([href^="#"]):not([target="_blank"]):not([href^="tel"]):not([href^="mailto"]):not([href^="javascript"])').forEach(link => {
        link.addEventListener('click', e => {
          const href = link.href; if (!href || href === window.location.href || href.includes('#')) return;
          e.preventDefault(); ov.style.pointerEvents='all'; ov.style.opacity='1';
          setTimeout(() => { window.location.href = href; }, 420);
        });
      });
    },

    parallax() {
      if (window.innerWidth < 1024) return;
      const imgs = document.querySelectorAll('.slide-bg img');
      window.addEventListener('scroll', () => { const sy = window.scrollY; imgs.forEach(img => { img.style.transform = `translateY(${sy*.12}px) scale(1.06)`; }); }, { passive: true });
    },

    magneticButtons() {
      if (window.innerWidth < 1024) return;
      document.querySelectorAll('.btn-primary,.nav-cta,.arr-btn').forEach(btn => {
        btn.addEventListener('mousemove', e => { const r=btn.getBoundingClientRect(); btn.style.transform=`translate(${(e.clientX-r.left-r.width/2)*.18}px,${(e.clientY-r.top-r.height/2)*.18}px)`; });
        btn.addEventListener('mouseleave', () => { btn.style.transform=''; btn.style.transition='transform .4s cubic-bezier(.175,.885,.32,1.275)'; setTimeout(()=>btn.style.transition='',400); });
      });
    },

    tiltCards() {
      if (window.innerWidth < 1024) return;
      document.querySelectorAll('.srv,.testi-card,.why-feat').forEach(card => {
        card.addEventListener('mousemove', e => { const r=card.getBoundingClientRect(),x=(e.clientX-r.left)/r.width-.5,y=(e.clientY-r.top)/r.height-.5; card.style.transform=`perspective(800px) rotateY(${x*5}deg) rotateX(${-y*5}deg) scale(1.01)`; });
        card.addEventListener('mouseleave', () => { card.style.transform=''; });
      });
    },

    ctaCircles() {
      const cta = document.querySelector('.cta-sec'); if (!cta) return;
      [300,200,100].forEach((r,i) => {
        const c = document.createElement('div');
        c.style.cssText = `width:${r*2}px;height:${r*2}px;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);border-radius:50%;border:.5px solid rgba(201,168,76,.06);animation:expandCircle ${6+i*2}s ease-in-out ${i*2}s infinite;pointer-events:none`;
        cta.appendChild(c);
      });
    },

    lazyImages() {
      if (!('IntersectionObserver' in window)) return;
      const io = new IntersectionObserver(entries => {
        entries.forEach(entry => { if (entry.isIntersecting) { const img=entry.target; img.style.opacity='0'; img.style.transition='opacity .5s'; img.addEventListener('load',()=>img.style.opacity='1'); io.unobserve(img); } });
      }, { rootMargin:'200px' });
      document.querySelectorAll('img[loading="lazy"]').forEach(img => io.observe(img));
    },
  };

  // Inject dynamic keyframes
  const s = document.createElement('style');
  s.textContent = `
    @keyframes cursorBurst{0%{width:6px;height:6px;opacity:1}100%{width:40px;height:40px;opacity:0;margin-left:-17px;margin-top:-17px}}
    @keyframes expandCircle{0%{transform:translate(-50%,-50%) scale(.5);opacity:.6}100%{transform:translate(-50%,-50%) scale(1.8);opacity:0}}
    body.loading{overflow:hidden}
    .gcs-nav{transition:transform .35s cubic-bezier(.4,0,.2,1),background .4s,padding .4s}
    .rv{opacity:0;transform:translateY(36px);transition:opacity .8s,transform .8s}
    .rv.on{opacity:1;transform:translateY(0)}
    .rv.d1{transition-delay:.12s}.rv.d2{transition-delay:.24s}.rv.d3{transition-delay:.36s}.rv.d4{transition-delay:.48s}
  `;
  document.head.appendChild(s);

  document.addEventListener('DOMContentLoaded', () => {
    if (window.GCS_OPTIONS?.show_noise === '1') document.body.classList.add('has-noise');
    GCS.init();
  });

  window.GCS = GCS;
})(jQuery);
