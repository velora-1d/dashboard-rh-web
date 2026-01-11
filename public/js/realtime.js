/**
 * REALTIME CLOCK AND CALENDAR
 * Updates digital clock and calendar every second
 */

function initRealtimeClock() {
    const clockElement = document.getElementById('realtime-clock');
    const dateElement = document.getElementById('realtime-date');

    if (!clockElement && !dateElement) return;

    function updateTime() {
        const now = new Date();

        // Format time (HH:MM:SS)
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;

        // Format date (Day, DD Month YYYY)
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        const dayName = days[now.getDay()];
        const date = now.getDate();
        const monthName = months[now.getMonth()];
        const year = now.getFullYear();
        const dateString = `${dayName}, ${date} ${monthName} ${year}`;

        // Update DOM
        if (clockElement) clockElement.textContent = timeString;
        if (dateElement) dateElement.textContent = dateString;
    }

    // Update immediately and then every second
    updateTime();
    setInterval(updateTime, 1000);
}

// Initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initRealtimeClock);
} else {
    initRealtimeClock();
}
