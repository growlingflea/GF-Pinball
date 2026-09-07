document.addEventListener('DOMContentLoaded', () => {
    const MIN_COLS = 2;
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

        const getDistance = (touches) => {
            const [a, b] = touches;
            return Math.hypot(a.clientX - b.clientX, a.clientY - b.clientY);
        };

        grid.addEventListener('touchstart', (e) => {
            if (e.touches.length === 2) {
                pinching = true;
                startDistance = getDistance(e.touches);
                startCols = parseFloat(getComputedStyle(grid).getPropertyValue('--grid-cols')) || 3;
                grid.style.transition = 'none';
            }
        }, { passive: true });

        grid.addEventListener('touchmove', (e) => {
            if (!pinching || e.touches.length !== 2) return;

            const ratio = getDistance(e.touches) / startDistance;

            // Spreading fingers apart (ratio > 1) = zoom in = fewer, bigger cards.
            // Pinching fingers together (ratio < 1) = zoom out = more, smaller cards.
            const liveCols = Math.min(MAX_COLS, Math.max(MIN_COLS, startCols / ratio));
            grid.style.setProperty('--grid-cols', liveCols.toFixed(2));

            e.preventDefault();
        }, { passive: false });

        const endPinch = () => {
            if (!pinching) return;
            pinching = false;

            const currentCols = parseFloat(getComputedStyle(grid).getPropertyValue('--grid-cols'));
            const snapped = Math.min(MAX_COLS, Math.max(MIN_COLS, Math.round(currentCols)));

            grid.style.transition = 'gap 0.15s ease';
            grid.style.setProperty('--grid-cols', snapped);

            localStorage.setItem(STORAGE_KEY, snapped);
        };

        grid.addEventListener('touchend', endPinch);
        grid.addEventListener('touchcancel', endPinch);
    });
});
