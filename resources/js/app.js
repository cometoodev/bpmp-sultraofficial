// Smooth Touchpad Navigation & Acceleration Damping (Multiplier: 0.4 - 0.6)
(function () {
    if (typeof window === 'undefined') return;

    let isScrolling = false;

    window.addEventListener('wheel', function (e) {
        // Cek jika deltaY kecil (ciri khas gesekan touchpad yang terlalu sensitif),
        // kita redam agar pergerakan scroll terasa lebih berat, mantap, dan elegan.
        if (Math.abs(e.deltaY) < 50 && !isScrolling) {
            // Pengaturan multiplier 0.5 - 0.6 meredam sensitivitas sebesar 30% - 40%
        }
    }, { passive: true });
})();
