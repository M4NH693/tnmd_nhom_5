/**
 * BookStore - Main JavaScript
 */
document.addEventListener('DOMContentLoaded', function () {

    // === Header scroll effect ===
    const header = document.getElementById('header');
    if (header) {
        window.addEventListener('scroll', function () {
            header.classList.toggle('scrolled', window.scrollY > 30);
        });
    }

    // === Mobile menu toggle ===
    const mobileToggle = document.getElementById('mobileToggle');
    const navLinks = document.getElementById('navLinks');
    if (mobileToggle && navLinks) {
        mobileToggle.addEventListener('click', function () {
            navLinks.classList.toggle('open');
            const icon = mobileToggle.querySelector('i');
            icon.classList.toggle('fa-bars');
            icon.classList.toggle('fa-times');
        });
    }

    // === Auto-remove flash messages ===
    const flashes = document.querySelectorAll('.flash-message');
    flashes.forEach(function (flash) {
        setTimeout(function () {
            flash.style.display = 'none';
        }, 3500);
    });

    // === Payment option highlight ===
    const paymentOptions = document.querySelectorAll('.payment-option');
    paymentOptions.forEach(function (option) {
        option.addEventListener('click', function () {
            paymentOptions.forEach(function (o) { o.classList.remove('selected'); });
            option.classList.add('selected');
            option.querySelector('input[type=radio]').checked = true;
        });
    });

    // === Smooth scroll for anchor links ===
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // === Book card hover animation ===
    const bookCards = document.querySelectorAll('.book-card');
    bookCards.forEach(function (card) {
        card.addEventListener('mouseenter', function () {
            this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
        });
    });

    // === Intersection Observer for scroll animations ===
    const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Animate sections on scroll
    document.querySelectorAll('.section, .book-card, .category-card, .feature-card').forEach(function (el) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });

    // === Hero animation (stagger children) ===
    const heroCards = document.querySelectorAll('.hero-book-card');
    heroCards.forEach(function (card, index) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        card.style.transitionDelay = (index * 0.15) + 's';
        setTimeout(function () {
            card.style.opacity = '1';
            card.style.transform = index % 2 === 1 ? 'translateY(30px)' : 'translateY(0)';
        }, 100);
    });
});

/**
 * Quantity change helper for book detail page
 */
function changeQty(delta) {
    const input = document.getElementById('qtyInput');
    if (!input) return;
    let val = parseInt(input.value) + delta;
    const min = parseInt(input.min) || 1;
    const max = parseInt(input.max) || 999;
    if (val < min) val = min;
    if (val > max) val = max;
    input.value = val;
}
