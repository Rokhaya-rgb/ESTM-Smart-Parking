// Animations de l'interface : compteurs, apparition au défilement, flash des places,
// halo qui suit la souris, ombre de la barre de navigation.
// Tout est désactivé si l'utilisateur demande moins de mouvement.

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const easeOutCubic = (t) => 1 - Math.pow(1 - t, 3);

/** Fait défiler un nombre de 0 jusqu'à sa valeur (éléments portant data-count). */
function countUp(el) {
    const target = parseFloat(el.dataset.count);
    if (Number.isNaN(target)) return;
    if (reduceMotion) {
        el.textContent = String(target);
        return;
    }

    const duration = 1100;
    const start = performance.now();

    const frame = (now) => {
        const progress = Math.min(1, (now - start) / duration);
        el.textContent = String(Math.round(target * easeOutCubic(progress)));
        if (progress < 1) requestAnimationFrame(frame);
    };
    requestAnimationFrame(frame);
}

/** Révèle les blocs .reveal quand ils entrent dans l'écran. */
function initReveal() {
    const items = [...document.querySelectorAll('.reveal')];
    if (!items.length) return;

    if (reduceMotion || !('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -6% 0px' },
    );
    items.forEach((el) => observer.observe(el));
}

/**
 * Quand une place change d'état (attribut data-status modifié par Livewire),
 * un halo bleu et un petit rebond attirent le regard.
 * Web Animations API : l'effet n'est pas coupé par le rafraîchissement du DOM.
 */
function initSlotFlash() {
    const grid = document.querySelector('[data-slot-grid]');
    if (!grid || reduceMotion) return;

    new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            const tile = mutation.target;
            if (!(tile instanceof HTMLElement)) return;
            tile.animate(
                [
                    { boxShadow: '0 0 0 0 rgba(95,152,238,0)', transform: 'scale(1)' },
                    { boxShadow: '0 0 0 5px rgba(95,152,238,0.55)', transform: 'scale(1.06)', offset: 0.3 },
                    { boxShadow: '0 0 0 22px rgba(95,152,238,0)', transform: 'scale(1)' },
                ],
                { duration: 1500, easing: 'cubic-bezier(0.22, 1, 0.36, 1)' },
            );
        });
    }).observe(grid, { subtree: true, attributes: true, attributeFilter: ['data-status'] });
}

/** Halo lumineux qui suit la souris sur les éléments .spot. */
function initSpotlight() {
    if (reduceMotion) return;
    document.addEventListener('pointermove', (event) => {
        const spot = event.target.closest && event.target.closest('.spot');
        if (!spot) return;
        const rect = spot.getBoundingClientRect();
        spot.style.setProperty('--mx', `${event.clientX - rect.left}px`);
        spot.style.setProperty('--my', `${event.clientY - rect.top}px`);
    }, { passive: true });
}

/** Ombre sous la barre de navigation dès que la page défile. */
function initNavShadow() {
    const nav = document.querySelector('.app-nav');
    if (!nav) return;
    const update = () => nav.classList.toggle('scrolled', window.scrollY > 8);
    update();
    window.addEventListener('scroll', update, { passive: true });
}

function init() {
    document.querySelectorAll('[data-count]').forEach(countUp);
    initReveal();
    initSlotFlash();
    initSpotlight();
    initNavShadow();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
