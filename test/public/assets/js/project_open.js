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

function validateEndDate() {
    var startDate = new Date(document.getElementById('startDateInput').value);
    var endDate = new Date(document.getElementById('endDateInput').value);
    if (endDate <= startDate) {
        alert("تاريخ نهاية المشروع يجب أن يكون بعد تاريخ بداية المشروع");
        document.getElementById('endDateInput').value = "";
        document.getElementById('daysInput').value = "";
    } else {
        calculateDays();
    }
}

// count the days
function calculateDays() {
    var startDate = new Date(document.getElementById('startDateInput').value);
    var endDate = new Date(document.getElementById('endDateInput').value);
    // Calculate the difference in milliseconds between the two dates
    var differenceInMilliseconds = endDate - startDate;
    // Convert the difference to days
    var days = Math.ceil(differenceInMilliseconds / (1000 * 60 * 60 * 24));
    // Set the value of the "days" input field
    document.getElementById('daysInput').value = days;
}


// select customer type
$(document).ready(function () {
    $("#customerTypeSelect").change(function () {
        var selectedCustomerType = $(this).val();
        var customerNameInput = $("#customerNameInput");
        var benefitInput = $("#benefitInput");

        if (selectedCustomerType === "مانح") {
            // Show both customer name and benefit inputs
            customerNameInput.prop('disabled', false).show();
            benefitInput.prop('disabled', false).show();
        } else if (selectedCustomerType === "حكومي" || selectedCustomerType === "أهلي") {
            // Show both inputs and set their values to the same customer name
            customerNameInput.prop('disabled', false).show();
            benefitInput.prop('disabled', false).show().val(customerNameInput.val());
        } else {
            // Hide both inputs for other customer types
            customerNameInput.prop('disabled', true).hide();
            benefitInput.prop('disabled', true).hide();
        }
    });
});

$(document).ready(function () {

    $("#customerNameInput").on('input', function () {
        var selectedCustomerType = $("#customerTypeSelect").val();
        var customerNameInput = $(this);
        var benefitInput = $("#benefitInput");

        if (selectedCustomerType === "حكومي" || selectedCustomerType === "أهلي") {
            benefitInput.val(customerNameInput.val());
        }
    });
});


$(document).ready(function() {
    $('select[name="section_name"]').on('change', function() {
        var selectedSection = $(this).val();
        var usersDropdown = $('select[name="user_name[]"]');

        // Make an AJAX request to fetch related user names
        $.ajax({
            url: '/get-users-by-section',
            type: 'GET',
            data: { section_name: selectedSection },
            success: function(data) {
                // Clear existing options
                usersDropdown.empty();

                // Add new options based on the response
                $.each(data, function(index, username) {
                    usersDropdown.append($('<option>', {
                        value: username,
                        text: username
                    }));
                });
            },
            error: function() {
                console.log('Error fetching data.');
            }
        });
    });
});
