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
                grid.style.transformOrigin = 'center center';
            }
        }, { passive: true });

        grid.addEventListener('touchmove', (e) => {
            if (!pinching || e.touches.length !== 2) return;

            const ratio = getDistance(e.touches) / startDistance;

            // Purely visual feedback during the gesture — a smooth scale,
            // not a fractional column count (which CSS repeat() can't render).
            const liveScale = Math.min(1.6, Math.max(0.6, ratio));
            grid.style.transform = `scale(${liveScale})`;

            e.preventDefault();
        }, { passive: false });

        const endPinch = (e) => {
            if (!pinching) return;
            pinching = false;

            // Figure out the final ratio from whichever touch data is available on release.
            const touches = e.changedTouches && e.changedTouches.length === 2
                ? e.changedTouches
                : null;
            const endDistance = touches ? getDistance(touches) : startDistance;
            const ratio = endDistance / startDistance;

            // Spreading fingers apart (ratio > 1) = zoom in = fewer, bigger cards (down to 1).
            // Pinching fingers together (ratio < 1) = zoom out = more, smaller cards (up to 5).
            const newCols = Math.min(MAX_COLS, Math.max(MIN_COLS, Math.round(startCols / ratio)));

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
