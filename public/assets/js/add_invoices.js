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
////////////////////////////////////////////

$(document).ready(function () {
    // Handle project name selection
    $('#project_name').change(function () {
        var projectId = $(this).val();

        // Make an AJAX request to get the section name
        $.get('/get-section-name/' + projectId, function (data) {
            $('#section_name').val(data.section_name);
        });

    });

});

////////////////////////////////////////////////

$(document).ready(function() {

    $(document).on('click', '.remove-btn', function () {
        $(this).closest('.main-form').remove();
        calculateTotal();
    });

    $(document).on('click', '.add-more-form', function () {
        $('.paste-new-forms').append('<div class="main-form mt-3 border-bottom">\
                    <div class="row">\
                        <div class="col-md-4">\
                            <div class="form-group mb-2">\
                                <label> المنتج </label><span style="color: red;">  *</span>\
                                <input type="text" class="form-control" name="product[]" required placeholder="المنتج ...">\
                            </div>\
                        </div>\
                        <div class="col-md-2">\
                            <div class="form-group mb-2">\
                                <label> العدد </label><span style="color: red;">  *</span>\
                                <input type="number" class="form-control number" name="number[]" required placeholder="العدد ..."  oninput="calculateTotalPrice()">\
                            </div>\
                        </div>\
                        <div class="col-md-2">\
                            <div class="form-group mb-2">\
                                <label> السعر الفردي </label><span style="color: red;">  *</span>\
                                <input type="number" class="form-control individual_price" name="individual_price[]" required placeholder="سعر فردي شامل الضريبة ..." oninput="calculateTotalPrice()">\
                                <label>  (شامل الضريبة) </label> \
                            </div>\
                        </div>\
                        <div class="col-md-2">\
                            <div class="form-group mb-2">\
                                <label> الإجمالي </label><span style="color: red;">  *</span>\
                                <input type="number" class="form-control total_price" readonly name="total_price[]" placeholder=" الإجمالي ...">\
                            </div>\
                        </div>\
                        <div class="col-md-2">\
                            <div class="form-group mb-2">\
                                <br>\
                                <button type="button" class="remove-btn btn btn-danger">إزالة</button>\
                            </div>\
                        </div>\
                    </div>\
                </div>');
    });
});
///// ///////////////////


// Calculate total
function calculateTotal() {
    const totalInputs = document.querySelectorAll('.total_price');
    let total = 0;

    totalInputs.forEach(totalInput => {
        total += parseFloat(totalInput.value) || 0;
    });

    document.getElementById('total').value = total.toFixed(2); // Update the total input with the calculated value
}

///////////////////////////////////////////////////////

// clculate total_price
function calculateTotalPrice() {
    const numberInputs = document.querySelectorAll('.number');
    const individualPriceInputs = document.querySelectorAll('.individual_price');
    const totalPriceInputs = document.querySelectorAll('.total_price');

    numberInputs.forEach((numberInput, index) => {
        const individualPriceInput = individualPriceInputs[index];
        const totalPriceInput = totalPriceInputs[index];

        const number = parseFloat(numberInput.value) || 0;
        const individualPrice = parseFloat(individualPriceInput.value) || 0;

        const totalPrice = number * individualPrice;
        totalPriceInput.value = totalPrice.toFixed(2); // Round to 2 decimal places
    });
    calculateTotal();
}


///////////////////////////
