const toggleButton = document.getElementById('toggleButton');
const formContainer = document.getElementById('formContainer');
const toggleButton1 = document.getElementById('toggleButton1');
const formContainer1 = document.getElementById('formContainer1');

function hideAllFormContainers() {
    formContainer.style.display = 'none';
    formContainer1.style.display = 'none';
}

toggleButton.addEventListener('click', (event) => {
    event.preventDefault(); // Prevent the default form submission behavior
    hideAllFormContainers();
    formContainer.style.display = 'block';
});

toggleButton1.addEventListener('click', (event) => {
    event.preventDefault(); // Prevent the default form submission behavior
    hideAllFormContainers();
    formContainer1.style.display = 'block';
});

// get section name local transfer
$(document).ready(function () {
    // Handle project name selection
    $('#project_name').change(function () {
        var projectId = $(this).val();

        // Get the project code from the server
        $.get('/get-order-number/' + projectId, function (data) {
            var projectCode = data.project_code;

            // Get the last order number from the applicants table
            $.get('/get-last-order-number/' + projectId, function (data) {
                var lastOrderNumber = data.last_order_number;

                // Extract the last three numbers and increment
                var currentSuffix = parseInt(lastOrderNumber.slice(-3));
                var suffix = ('00' + (currentSuffix + 1)).slice(-3); // Increment and pad with zeros

                var newProjectCode = projectCode + '-' + suffix;
                $('#order_number').val(newProjectCode);
            });
        });

        // Make an AJAX request to get the section name
        $.get('/get-section-name/' + projectId, function (data) {
            $('#section_name').val(data.section_name);
        });

        // Make an AJAX request to get the step names
        $.get('/get-step-names/' + projectId, function (data) {
            $('#step_name').empty().append('<option value="" selected="" disabled="">اختر المرحلة</option>');

            $.each(data.step_names, function (index, stepName) {
                $('#step_name').append('<option value="' + stepName + '">' + stepName + '</option>');
            });
        });
    });

    // Handle step name selection
    $('#step_name').change(function () {
        var stepName = $(this).val(); // Get the selected step name

        // Make an AJAX request to get the item names based on step name
        $.get('/get-item-names/' + encodeURIComponent(stepName), function (data) {
            $('#item_name').empty().append('<option value="" selected="" disabled="">اختر البند</option>');

            $.each(data.item_names, function (index, itemName) {
                $('#item_name').append('<option value="' + itemName + '">' + itemName + '</option>');
            });
        });
    });

    $('#item_name').change(function () {
        var itemName = $(this).val();
        var projectId = $('#project_name').val(); // Get the selected project ID

        // Fetch and display the item_value for the selected item_name
        $.ajax({
            url: '/get-item-value/' + itemName,
            method: 'GET',
            data: { project_name: projectId }, // Send the project_name as a parameter
            success: function (data) {
                $('#item_value').val(data);
            }
        });

        $.ajax({
            url: '/get-remaining-value/' + itemName,
            method: 'GET',
            data: { project_name: projectId }, // Send the project_name as a parameter
            success: function (data) {
                $('#remaining_value').val(data);
            }
        });
    });
});

// Function to check if price is greater than remaining value
function checkPrice() {
    var priceInput = document.getElementById("price").value;
    var remainingValueInput = document.getElementById("remaining_value").value;

    if (parseFloat(priceInput) > parseFloat(remainingValueInput)) {
        alert("المبلغ اكبر من المتبقي من قيمة البند");
        document.getElementById("price").value = ""; // Clear the price input
    }
}

// Attach the checkPrice function to the "blur" event of the price input
document.getElementById("price").addEventListener("blur", checkPrice);

//////////////////////////////////////////////////////////////////////

// get section name international transfer
$(document).ready(function () {
    // Handle project name selection
    $('#project_name1').change(function () {
        var projectId = $(this).val();

        $.get('/get-order-number/' + projectId, function (data) {
            var projectCode = data.project_code;
            var suffix = '-001'; // Default suffix

            // Check if the project code already has a suffix
            if (projectCode.match(/-\d{3}$/)) {
                // Extract the current suffix and increment it
                var currentSuffix = parseInt(projectCode.slice(-3));
                suffix = '-' + ('00' + (currentSuffix + 1)).slice(-3); // Increment and pad with zeros
            }

            var newProjectCode = projectCode + suffix;
            $('#order_number1').val(newProjectCode);
        });

        // Make an AJAX request to get the section name
        $.get('/get-section-name/' + projectId, function (data) {
            $('#section_name1').val(data.section_name);
        });

        // Make an AJAX request to get the step names
        $.get('/get-step-names/' + projectId, function (data) {
            $('#step_name1').empty().append('<option value="" selected="" disabled="">اختر المرحلة</option>');

            $.each(data.step_names, function (index, stepName) {
                $('#step_name1').append('<option value="' + stepName + '">' + stepName + '</option>');
            });
        });
    });

    // Handle step name selection
    $('#step_name1').change(function () {
        var stepName = $(this).val(); // Get the selected step name

        // Make an AJAX request to get the item names based on step name
        $.get('/get-item-names/' + encodeURIComponent(stepName), function (data) {
            $('#item_name1').empty().append('<option value="" selected="" disabled="">اختر البند</option>');

            $.each(data.item_names, function (index, itemName) {
                $('#item_name1').append('<option value="' + itemName + '">' + itemName + '</option>');
            });
        });
    });

    $('#item_name1').change(function () {
        var itemName = $(this).val();
        var projectId = $('#project_name1').val(); // Get the selected project ID

        // Fetch and display the item_value for the selected item_name
        $.ajax({
            url: '/get-item-value/' + itemName,
            method: 'GET',
            data: { project_name: projectId }, // Send the project_name as a parameter
            success: function (data) {
                $('#item_value1').val(data);
            }
        });

        $.ajax({
            url: '/get-remaining-value/' + itemName,
            method: 'GET',
            data: { project_name: projectId }, // Send the project_name as a parameter
            success: function (data) {
                $('#remaining_value1').val(data);
            }
        });
    });
});

// Function to check if price is greater than remaining value
function checkPrice1() {
    var priceInput = document.getElementById("price1").value;
    var remainingValueInput = document.getElementById("remaining_value1").value;

    if (parseFloat(priceInput) > parseFloat(remainingValueInput)) {
        alert("المبلغ اكبر من المتبقي من قيمة البند");
        document.getElementById("price1").value = ""; // Clear the price input
    }
}

// Attach the checkPrice function to the "blur" event of the price input
document.getElementById("price1").addEventListener("blur", checkPrice1);

//////////////////////////////////////////////////////////////////////
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

//////////////////////////////////////////////

// Select the input field
var input1 = document.getElementById('dateInput1');

// Create a new Date object for the current date
var currentDate1 = new Date();

// Format the date as YYYY-MM-DD for the input value
var formattedDate1 = currentDate1.toISOString().split('T')[0];

// Set the initial value of the input field to the current date
input1.value = formattedDate1;

// Add an event listener to allow the user to change the date
input1.addEventListener('input', function(event) {
    var selectedDate = event.target.value;
    console.log(selectedDate); // Output the selected date
});
///////////////////////////////////////////////////

// تاريخ اليوم للتحويل الدولي
var input2 = document.getElementById('dateInput2');

// Create a new Date object for the current date
var currentDate2 = new Date();

// Format the date as YYYY-MM-DD for the input value
var formattedDate2 = currentDate2.toISOString().split('T')[0];

// Set the initial value of the input field to the current date
input2.value = formattedDate2;

// Add an event listener to allow the user to change the date
input2.addEventListener('input', function(event) {
    var selectedDate = event.target.value;
    console.log(selectedDate); // Output the selected date
});
/////////////////////////////////////////////////////////
