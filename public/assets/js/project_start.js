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

function validateNumber(input) {
    let value = input.value;

    // Check if the number is negative
    if (value.includes('-')) {
        alert("يجب إدخال رقم صحيح");
        value = value.replace('-', ''); // Remove the negative sign
    }

    // Replace any invalid characters (letters, etc.) except numbers and decimal points
    value = value.replace(/[^0-9.]/g, '');
    
    // Prevent more than one decimal point
    if (value.split('.').length > 2) {
        value = value.substring(0, value.length - 1);
    }

    input.value = value;
}

$(document).ready(function() {

    $(document).on('click', '.add-more-form', function () {
        $('.paste-new-forms').append('<div class="main-form mt-3 border-bottom">\
            <div class="row">\
                <div class="col-md-3">\
                    <div class="form-group mb-2">\
                        <label>رقم الدفعة</label><span style="color: red;">  *</span>\
                        <input type="text" class="form-control" required name="batch_number[]" placeholder="رقم الدفعة...">\
                    </div>\
                </div>\
                <div class="col-md-3">\
                    <div class="form-group mb-2">\
                        <label>قيمة الدفعة</label><span style="color: red;">  *</span>\
                        <input type="text" class="form-control batch_value" required name="batch_value[]" placeholder="قيمة الدفعة..." oninput="validateNumber(this)">\
                    </div>\
                </div>\
                <div class="col-md-3">\
                    <div class="form-group mb-2">\
                        <label>تاريخ الاستحقاق</label><span style="color: red;">  *</span>\
                        <input type="date" class="form-control" required name="due_date[]" placeholder="تاريخ الاستحقاق...">\
                    </div>\
                </div>\
                <div class="col-md-3">\
                    <div class="form-group mb-2">\
                        <br>\
                        <button type="button" class="remove-btn btn btn-danger">إزالة</button>\
                    </div>\
                </div>\
            </div>\
        </div>');
    });
    // Remove form on clicking remove button
    $(document).on('click', '.remove-btn', function () {
        $(this).closest('.main-form').remove();
        updateTotal(); // Recalculate total after removing a form
    });

    // Calculate total when an item_value input changes
    $(document).on('input', '.batch_value', function () {
        var input = $(this); // Save reference to the current input
        updateTotal(input);
    });

    // Function to calculate total and validate it against after_tax
    function updateTotal(input = null) {
        var total = 0;
        var afterTax = parseFloat($('#after_tax').val()); // Get the after_tax value
        var currentValue = input ? parseFloat(input.val()) || 0 : 0; // Get current input value

        $('.batch_value').each(function () {
            var value = parseFloat($(this).val()) || 0;
            total += value;
        });

        if (total > afterTax && input) {
            alert("مجموع الدفعات يجب أن لا يتجاوز صافي قيمة المشروع بعد الضريبة");

            // Subtract the last added value to bring total back within limit
            total -= currentValue;

            // Clear the value of the input that caused the issue after the user clicks "OK"
            input.val(''); // Reset the current input field
        }

        // Update total input with the adjusted total
        $('#total').val(total); 
    }
    // Initial calculation of total
    updateTotal();
});


// Attach a submit event listener to the form
$('#projectForm').on('submit', function(e) {
    var total = 0;
    var afterTax = parseFloat($('#after_tax').val()); // Get after_tax value
    
    // Convert afterTax to an integer without decimals by multiplying by 100
    afterTax = Math.floor(afterTax * 100);

    // Loop through each batch_value and calculate the total
    $('.batch_value').each(function() {
        var value = parseFloat($(this).val()) || 0; // Ensure value is a number
        
        // Multiply by 100 to remove decimal part and convert to an integer
        value = Math.floor(value * 100);
        total += value;
    });

    // Validate if the total batch_value is less than or equal to after_tax
    if (total < afterTax) {
        e.preventDefault(); // Prevent form submission
        alert('مجموع الدفعات يجب أن يكون مطابق لصافي قيمة المشروع بعد الضريبة'); // Alert the user
    }
});
