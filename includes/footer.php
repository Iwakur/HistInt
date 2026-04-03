    <?php if (isset($showNavigation) && $showNavigation): ?>
        </main>
    <?php endif; ?>

    <script src="assets/js/main.js"></script>

    <?php if (isset($sceneJavaScript) && $sceneJavaScript): ?>
    <script>
        // Scene-specific JavaScript for ember effects and image interactions
        const emberContainer = document.getElementById('embers');
        if (emberContainer) {
            const emberCount = 24;

            for (let i = 0; i < emberCount; i++) {
                const ember = document.createElement('span');
                ember.className = 'ember';
                ember.style.left = Math.random() * 100 + 'vw';
                ember.style.animationDuration = (7 + Math.random() * 8) + 's';
                ember.style.animationDelay = (Math.random() * 6) + 's';
                ember.style.opacity = (0.22 + Math.random() * 0.5).toFixed(2);
                ember.style.transform = `scale(${0.7 + Math.random() * 0.9})`;
                emberContainer.appendChild(ember);
            }
        }

        // Image hover effect for scene images
        const imageBox = document.querySelector('.scene-image-box img');
        if (imageBox) {
            imageBox.addEventListener('mousemove', (event) => {
                const rect = imageBox.getBoundingClientRect();
                const x = (event.clientX - rect.left) / rect.width;
                const y = (event.clientY - rect.top) / rect.height;

                const rotateY = (x - 0.5) * 4;
                const rotateX = (0.5 - y) * 4;

                imageBox.style.transform = `scale(1.02) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
                imageBox.style.transition = 'transform 0.12s ease';
            });

            imageBox.addEventListener('mouseleave', () => {
                imageBox.style.transform = 'scale(1) rotateX(0deg) rotateY(0deg)';
                imageBox.style.transition = 'transform 0.25s ease';
            });
        }
    </script>
    <?php endif; ?>
</body>
</html>