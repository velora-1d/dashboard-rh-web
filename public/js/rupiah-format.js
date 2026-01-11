// Format nominal with thousand separators (Indonesian format)
function formatRupiah(input) {
    let value = input.value.replace(/\D/g, ''); // Remove non-digits
    if (value) {
        value = parseInt(value).toLocaleString('id-ID');
    }
    input.value = value;
}

// Parse nominal before submit (remove dots)
function parseRupiah(input) {
    input.value = input.value.replace(/\./g, ''); // Remove dots
}

// Auto-format all nominal inputs on page load
document.addEventListener('DOMContentLoaded', function () {
    const nominalInputs = document.querySelectorAll('input[name="nominal"]');

    nominalInputs.forEach(input => {
        // Format on input
        input.addEventListener('input', function () {
            formatRupiah(this);
        });

        // Parse before submit
        const form = input.closest('form');
        if (form) {
            form.addEventListener('submit', function () {
                parseRupiah(input);
            });
        }
    });
});
