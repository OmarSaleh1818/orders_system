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

$(document).ready(function() {

    let a = 1;
    $(document).on('click', '.add-more-step', function () {
        let stepCount = ++a;
        let addStep = `
                <div class="items-container mt-5" id="stepitems${stepCount}">
                        <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>اسم المرحلة</label><span style="color: red;">  *</span>
                                <input type="hidden" value="0" id="step${stepCount}" name="number_step[]">
                                <input type="text" class="form-control" required name="step_name[]" placeholder="اسم المرحلة...">
                            </div>
                        </div>
                    </div>
                    <h4>
                        <a href="javascript:void(0)" class="add-item float-right btn btn-primary" id="stepitemsclick,${stepCount}" onclick="addItem(${stepCount})">أضف بند</a>
                    </h4>
                </div>
               `
        $('.paste-new-forms').append(addStep);

    });

});

function addItem(id){

    let rowToAdd = `  <div class="row" >
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>بند الصرف</label><span style="color: red;"> *</span>
                            <input type="text" class="form-control" required name="item_name[]" placeholder="بند الصرف...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>قيمة البند</label><span class="text-danger"> *</span>
                            <input type="text" class="form-control item-value" name="item_value[]" placeholder="قيمة البند...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>تاريخ الاستحقاق</label>
                            <input type="date" class="form-control" name="due_date[]"
                                   min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" placeholder="تاريخ الاستحقاق...">
                        </div>
                    </div>
                                    <div class="col-md-2">
                    <div class="form-group">
                        <br>
                        <button type="button" class="remove-btn btn btn-danger" onclick="removeItem(event)" id="btnremove${id}">إزالة</button>
                    </div>
                    <hr>
                </div>
                </div>`
    $(`#stepitems${id}`).append(rowToAdd);
    let itemNumber = +$(`#step${id}`).val();
    $(`#step${id}`).val(itemNumber+= 1);
}

function removeItem(event){
    event.target.parentNode.parentNode.parentNode.remove();
}


// Calculate total when an item_value input changes
$(document).on('input', '.item-value', function () {
    updateTotal();
});
// Calculate total initially
updateTotal();
function updateTotal() {
    var total = 0;
    $('.item-value').each(function () {
        var value = parseFloat($(this).val()) || 0;
        total += value;
    });
    $('#total').val(total);
}

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


// التكاليف الغير مباشرة

// Wait for the DOM to load
document.addEventListener('DOMContentLoaded', function() {
    // Get the input fields
    var totalInput = document.getElementById('total');
    var managementInput = document.getElementById('management');
    var indirectCostsInput = document.getElementById('indirect_costs');
    var totalCosts = document.getElementById('total_costs');
    // Add an event listener to the management input field
    managementInput.addEventListener('input', function() {
        // Get the values from the input fields
        var total = parseFloat(totalInput.value);
        var managementPercentage = parseFloat(managementInput.value) / 100;

        // Calculate the indirect_costs
        var indirectCosts = total * managementPercentage;

        // Check if the calculated value is a valid number
        if (isNaN(indirectCosts)) {
            // Display an error message or handle the error case
            indirectCostsInput.value = 'Invalid input';
        } else {
            // Set the calculated value to the indirect_costs input field
            indirectCostsInput.value = indirectCosts.toFixed(2);
            totalCosts.value = (indirectCosts + total).toFixed(2);
        }
    });
});

// تكلفة التمويل
document.getElementById('per_month').addEventListener('input', updateValues);
document.getElementById('monthly_benefit').addEventListener('input', updateValues);
document.getElementById('target_profit_percentage').addEventListener('input', updateValues);
document.getElementById('private_discount').addEventListener('input', updateValues);

function updateValues() {
    var perMonth = parseFloat(document.getElementById('per_month').value);
    var monthlyBenefit = parseFloat(document.getElementById('monthly_benefit').value);
    var totalCosts = parseFloat(document.getElementById('total_costs').value);
    var targetProfitPercentage = parseFloat(document.getElementById('target_profit_percentage').value);
    var privateDiscount = parseFloat(document.getElementById('private_discount').value);

    // Check if the input is a valid number
    if (!isNaN(perMonth) && !isNaN(monthlyBenefit) && !isNaN(totalCosts)) {
        var percentageTotal = perMonth * (monthlyBenefit / 100);
        var benefitValue = totalCosts * percentageTotal;
        var totalProject = totalCosts + benefitValue;
        var targetProfitValue = (targetProfitPercentage / 100) * totalProject;
        var totalProjectValue = totalProject / (1 - (targetProfitPercentage / 100))
        var discountValue = totalProjectValue * (privateDiscount / 100);
        var beforeTax = totalProjectValue - discountValue;
        var valueTax = beforeTax * (15 / 100);
        var afterTax = beforeTax + valueTax;
        var actualProfitValue = beforeTax - totalProject;
        var actualProfitPercentage = (actualProfitValue / beforeTax) * 100;

        document.getElementById('percentage_total').value = percentageTotal.toFixed(2);
        document.getElementById('benefit_value').value = benefitValue.toFixed(2);
        document.getElementById('total_project_costs').value = totalProject.toFixed(2);
        document.getElementById('target_profit_value').value = targetProfitValue.toFixed(2);
        document.getElementById('total_project_value').value = totalProjectValue.toFixed(2);
        document.getElementById('discount_value').value = discountValue.toFixed(2);
        document.getElementById('before_tax').value = beforeTax.toFixed(2);
        document.getElementById('value_tax').value = valueTax.toFixed(2);
        document.getElementById('after_tax').value = afterTax.toFixed(2);
        document.getElementById('actual_profit_value').value = actualProfitValue.toFixed(2);
        document.getElementById('actual_profit_percentage').value = actualProfitPercentage.toFixed(2);
    } else {
        // Handle invalid input, for example, set the output fields to empty
        document.getElementById('percentage_total').value = '';
        document.getElementById('benefit_value').value = '';
        document.getElementById('total_project_costs').value = '';
        document.getElementById('target_profit_value').value = '';
        document.getElementById('total_project_value').value = '';
        document.getElementById('discount_value').value = '';
        document.getElementById('before_tax').value = '';
        document.getElementById('value_tax').value = '';
        document.getElementById('after_tax').value = '';
        document.getElementById('actual_profit_value').value = '';
        document.getElementById('actual_profit_percentage').value = '';
    }
}
