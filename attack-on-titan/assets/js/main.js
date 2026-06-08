// ============================================================
// Attack On Titan — Main JS
// ============================================================

document.addEventListener('DOMContentLoaded', () => {

    // ── Page Loader ──────────────────────────────────────────
    const loader = document.querySelector('.page-loader');
    if (loader) {
        window.addEventListener('load', () => {
            setTimeout(() => loader.classList.add('hidden'), 1200);
        });
    }

    // ── Navbar scroll effect ─────────────────────────────────
    const navbar = document.getElementById('navbar');
    if (navbar) {
        const onScroll = () => {
            navbar.classList.toggle('scrolled', window.scrollY > 60);
        };
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    // ── Mobile nav toggle ────────────────────────────────────
    const toggle = document.getElementById('navToggle');
    const navLinks = document.getElementById('navLinks');
    if (toggle && navLinks) {
        toggle.addEventListener('click', () => {
            navLinks.classList.toggle('open');
        });
        // Close on outside click
        document.addEventListener('click', e => {
            if (!toggle.contains(e.target) && !navLinks.contains(e.target)) {
                navLinks.classList.remove('open');
            }
        });
    }

    // ── Active nav link highlight ────────────────────────────
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') && link.getAttribute('href') !== '#' &&
            currentPath.includes(link.getAttribute('href').split('/').pop())) {
            link.classList.add('active');
        }
    });

    // ── Scroll reveal ────────────────────────────────────────
    const revealElements = document.querySelectorAll('.reveal');
    if (revealElements.length) {
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        revealElements.forEach(el => observer.observe(el));
    }

    // ── Auto-dismiss flash messages ──────────────────────────
    const flashes = document.querySelectorAll('.flash-msg');
    flashes.forEach(flash => {
        setTimeout(() => {
            flash.style.opacity = '0';
            flash.style.transform = 'translateX(100%)';
            flash.style.transition = 'all 0.4s ease';
            setTimeout(() => flash.remove(), 400);
        }, 3500);
    });

    // ── Confirm delete ───────────────────────────────────────
    document.querySelectorAll('[data-confirm]').forEach(btn => {
        btn.addEventListener('click', e => {
            if (!confirm(btn.dataset.confirm || 'Yakin ingin menghapus?')) {
                e.preventDefault();
            }
        });
    });

    // ── Parallax hero ────────────────────────────────────────
    const heroBg = document.querySelector('.hero-bg');
    if (heroBg) {
        window.addEventListener('scroll', () => {
            heroBg.style.transform = `translateY(${window.scrollY * 0.35}px)`;
        }, { passive: true });
    }

    // ── Star rating display ──────────────────────────────────
    document.querySelectorAll('.star-rating').forEach(el => {
        const rating = parseFloat(el.dataset.rating) || 0;
        const stars = Math.round(rating / 2);
        el.innerHTML = '★'.repeat(stars) + '☆'.repeat(5 - stars) + ` <span>${rating}</span>`;
    });

    // ── Card count-up animation ──────────────────────────────
    const countEls = document.querySelectorAll('.count-up');
    if (countEls.length) {
        const countObserver = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.dataset.target);
                    let current = 0;
                    const step = Math.ceil(target / 60);
                    const interval = setInterval(() => {
                        current = Math.min(current + step, target);
                        el.textContent = current.toLocaleString();
                        if (current >= target) clearInterval(interval);
                    }, 20);
                    countObserver.unobserve(el);
                }
            });
        }, { threshold: 0.5 });
        countEls.forEach(el => countObserver.observe(el));
    }

});

// ── Admin sidebar toggle ─────────────────────────────────────
function toggleSidebar() {
    document.querySelector('.admin-sidebar')?.classList.toggle('open');
}
