document.addEventListener('DOMContentLoaded', () => {
    const MIN_COLS = 1;
    const MAX_COLS = 5;
    const STORAGE_KEY = 'gf-pinball-grid-cols';

    const grids = document.querySelectorAll('.games-grid');
    if (!grids.length) return;

    const saved = parseInt(localStorage.getItem(STORAGE_KEY), 10);
    const savedCols = (!isNaN(saved) && saved >= MIN_COLS && saved <= MAX_COLS) ? saved : null;

    grids.forEach((grid) => {
        if (savedCols) {
            grid.style.setProperty('--grid-cols', savedCols);
        }

        let pinching = false;
        let startDistance = 0;
        let startCols = savedCols || 3;
        let lastRatio = 1;

        const getDistance = (touches) => {
            const [a, b] = touches;
            return Math.hypot(a.clientX - b.clientX, a.clientY - b.clientY);
        };

        grid.addEventListener('touchstart', (e) => {
            if (e.touches.length === 2) {
                pinching = true;
                startDistance = getDistance(e.touches);
                lastRatio = 1;
                startCols = parseFloat(getComputedStyle(grid).getPropertyValue('--grid-cols')) || 3;
                grid.style.transition = 'none';
                grid.style.transformOrigin = 'center center';
            }
        }, { passive: true });

        grid.addEventListener('touchmove', (e) => {
            if (!pinching || e.touches.length !== 2) return;

            lastRatio = getDistance(e.touches) / startDistance;

            const liveScale = Math.min(1.6, Math.max(0.6, lastRatio));
            grid.style.transform = `scale(${liveScale})`;

            e.preventDefault();
        }, { passive: false });

        const endPinch = () => {
            if (!pinching) return;
            pinching = false;

            // Use the last ratio observed during the gesture — touchend's
            // own touch data is unreliable here since fingers lift one at a time.
            const newCols = Math.min(MAX_COLS, Math.max(MIN_COLS, Math.round(startCols / lastRatio)));

            grid.style.transition = 'transform 0.2s ease';
            grid.style.transform = 'scale(1)';
            grid.style.setProperty('--grid-cols', newCols);

            localStorage.setItem(STORAGE_KEY, newCols);

            setTimeout(() => { grid.style.transition = ''; }, 200);
        };

        grid.addEventListener('touchend', endPinch);
        grid.addEventListener('touchcancel', endPinch);
    });
});
