/**
 * Reveal elements on scroll using Intersection Observer
 */
function initRevealOnScroll() {
    const revealElements = document.querySelectorAll('.reveal');

    if (!revealElements.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    revealElements.forEach(element => {
        observer.observe(element);
    });
}

/**
 * Generate falling embers animation
 */
function createEmbers() {
    const embersContainer = document.getElementById('embers');
    if (!embersContainer) return;

    function createEmber() {
        const ember = document.createElement('div');
        ember.className = 'ember';

        const size = Math.random() * 6 + 3;
        const duration = Math.random() * 3 + 2;
        const delay = Math.random() * 0.5;
        const xOffset = Math.random() * window.innerWidth;

        ember.style.cssText = `
            width: ${size}px;
            height: ${size}px;
            left: ${xOffset}px;
            animation-duration: ${duration}s;
            animation-delay: ${delay}s;
        `;

        embersContainer.appendChild(ember);

        setTimeout(() => {
            ember.remove();
        }, (duration + delay) * 1000);
    }

    // Create initial batch
    for (let i = 0; i < 5; i++) {
        setTimeout(createEmber, i * 200);
    }

    // Continuous generation
    setInterval(createEmber, 500);
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    initRevealOnScroll();
    createEmbers();
});
