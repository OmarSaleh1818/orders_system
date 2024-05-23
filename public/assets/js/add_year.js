// Select the input field
var input = document.getElementById('dateInput');
// Create a new Date object for the current date
var currentDate = new Date();
// Format the date as YYYY-MM-DD for the input value
var formattedDate = currentDate.toISOString().split('T')[0];
// Set the initial value of the input field to the current date
input.value = formattedDate;
// Add an event listener to allow the user to change the date
input.addEventListener('input', function(event) {
    var selectedDate = event.target.value;
    console.log(selectedDate); // Output the selected date
});

var input = document.getElementById('startDateInput');
var currentDate = new Date()
var formattedDate = currentDate.toISOString().split('T')[0];

input.value = formattedDate;

input.addEventListener('input', function(event) {
    var selectedDate = event.target.value;
    console.log(selectedDate);
});

//////////////// ////////////////////

// Calculate total when a section_price input changes
document.addEventListener('DOMContentLoaded', function() {
    const sectionPriceInputs = document.querySelectorAll('.section-price');
    const totalInput = document.getElementById('total');

    function calculateTotal() {
        let total = 0;
        sectionPriceInputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            total += value;
        });
        totalInput.value = total;
    }

    sectionPriceInputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
    });

    // Initial calculation
    calculateTotal();
});

// Calculate total Cash when a section_price input changes
document.addEventListener('DOMContentLoaded', function() {
    const sectionPriceInputs = document.querySelectorAll('.section_cash');
    const totalInput = document.getElementById('total_cash');

    function calculateTotalCash() {
        let total = 0;
        sectionPriceInputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            total += value;
        });
        totalInput.value = total;
    }

    sectionPriceInputs.forEach(input => {
        input.addEventListener('input', calculateTotalCash);
    });

    // Initial calculation
    calculateTotalCash();
});

document.addEventListener('DOMContentLoaded', function() {
    const sectionPriceInputs = document.querySelectorAll('.section_earn');
    const totalInput = document.getElementById('total_earn');

    function calculateTotalEarn() {
        let total = 0;
        sectionPriceInputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            total += value;
        });
        totalInput.value = total;
    }

    sectionPriceInputs.forEach(input => {
        input.addEventListener('input', calculateTotalEarn);
    });

    // Initial calculation
    calculateTotalEarn();
});
