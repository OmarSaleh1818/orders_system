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


let stepCount = 1;
$(document).on('click', '.add-more-step', function () {
    stepCount++;
    let addStep = `
        <div class="items-container mt-5" id="stepitems${stepCount}">
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>اسم المرحلة</label><span style="color: red;"> *</span>
                        <input type="hidden" value="${stepCount}" id="step${stepCount}" name="step_id[]">
                        <input type="text" class="form-control" required name="step_name[]" placeholder="اسم المرحلة...">
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="remove-step float-right btn btn-danger ml-2" data-step="${stepCount}">إزالة المرحلة</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h4>
                        <a href="javascript:void(0)" class="add-item float-right btn btn-primary" id="stepitemsclick,${stepCount}" onclick="addItem(${stepCount})">أضف بند</a>
                    </h4>
                </div>
            </div>
        </div>
    `;
    $('.paste-new-forms').append(addStep);
});

$(document).on('click', '.remove-step', function () {
    let stepNumber = $(this).data('step');
    $('#stepitems' + stepNumber).remove();
    stepCount--;
    updateTotal(); // Update total when a step is removed
});

function addItem(stepId) {
    let rowToAdd = `
        <div class="row">
            <input type="hidden" name="step_item_id[]" value="${stepId}">
            <div class="col-md-3">
                <div class="form-group">
                    <label>بند الصرف</label><span style="color: red;"> *</span>
                    <select name="item_name[]" required class="form-control" onchange="toggleOtherOption(this)">
                        <option value="" selected="" disabled="">اختيار بند الصرف</option>
                        <option value="مدربين">مدربين</option>
                        <option value="مستشارين">مستشارين</option>
                        <option value="سكن">سكن</option>
                        <option value="طيران">طيران</option>
                        <option value="مطبوعات">مطبوعات</option>
                        <option value="انتدابات">انتدابات</option>
                        <option value="قاعات">قاعات</option>
                        <option value="مواصلات">مواصلات</option>
                        <option value="اختبارات">اختبارات</option>
                        <option value="تغطية إعلامية">تغطية إعلامية</option>
                        <option value="تصاميم">تصاميم</option>
                        <option value="منسقين">منسقين</option>
                        <option value="اعتمادات">اعتمادات</option>
                        <option value="اشتراكات تقنية">اشتراكات تقنية</option>
                        <option value="ميسر ورشة">ميسر ورشة</option>
                        <option value="مقدم">مقدم</option>
                        <option value="ترجمة">ترجمة</option>
                        <option value="شراء حقوق">شراء حقوق</option>
                        <option value="تسويق">تسويق</option>
                        <option value="هدايا">هدايا</option>
                        <option value="أخرى">أخرى</option>
                    </select>
                </div>
                <div class="form-group other-item-name" style="display:none;">
                    <input type="text" class="form-control" name="other_item_name[]" placeholder="اسم البند الآخر...">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>قيمة البند</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control item-value" name="item_value[]" required placeholder="قيمة البند..." oninput="validateNumber(this)">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <br>
                    <button type="button" class="remove-btn btn btn-danger" onclick="removeItem(event)">إزالة</button>
                </div>
                <hr>
            </div>
        </div>
    `;
    $(`#stepitems${stepId}`).append(rowToAdd);
}

function toggleOtherOption(selectElement) {
    const otherItemContainer = selectElement.closest('.form-group').nextElementSibling;
    if (selectElement.value === 'أخرى') {
        otherItemContainer.style.display = 'block';
        otherItemContainer.querySelector('input').setAttribute('required', 'required');
    } else {
        otherItemContainer.style.display = 'none';
        otherItemContainer.querySelector('input').removeAttribute('required');
    }
}

function removeItem(event) {
    event.target.closest('.row').remove();
    updateTotal(); // Update total when an item is removed
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("myForm").addEventListener("submit", function(event) {
        // Get all hidden input elements with the name 'number_step[]'
        var steps = document.querySelectorAll("input[name='number_step[]']");
        var isValid = true;

        steps.forEach(function(step) {
            if (step.value == 0) {
                isValid = false;
                // Display an alert
                alert("كل مرحلة يجب ان تحتوي على الأقل بند واحد.");
            }
        });

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
});

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
document.addEventListener('DOMContentLoaded', function() {
    // Get the input fields
    var monthlyBenefitInput = document.getElementById('monthly_benefit');
    var perMonthInput = document.getElementById('per_month');
    var percentageTotalInput = document.getElementById('percentage_total');
    var benefitValueInput = document.getElementById('benefit_value');
    var totalProjectCostsInput = document.getElementById('total_project_costs');
    var totalCostsInput = document.getElementById('total_costs');
    var targetProfitPercentageInput = document.getElementById('target_profit_percentage');
    var beforeTaxInput = document.getElementById('before_tax');
    var valueTaxInput = document.getElementById('value_tax');
    var afterTaxInput = document.getElementById('after_tax');
    var actualProfitValueInput = document.getElementById('actual_profit_value');

    // Calculate values function
    function calculateValues() {
        var perMonth = parseFloat(perMonthInput.value) || 0;
        var monthlyBenefit = parseFloat(monthlyBenefitInput.value) || 0;
        var totalCosts = parseFloat(totalProjectCostsInput.value) || 0;
        var targetProfitPercentage = parseFloat(targetProfitPercentageInput.value) || 0;

        var percentageTotal = perMonth * (monthlyBenefit / 100);
        var benefitValue = parseFloat(totalCostsInput.value) * percentageTotal;
        var totalProjectCosts = parseFloat(totalCostsInput.value) + benefitValue;
        var actualProfitValue = totalProjectCosts * (targetProfitPercentage / 100);

        var beforeTax = totalProjectCosts + actualProfitValue;
        var valueTax = beforeTax * 0.15;
        var afterTax = beforeTax + valueTax;


        percentageTotalInput.value = percentageTotal.toFixed(2);
        benefitValueInput.value = benefitValue.toFixed(2);
        totalProjectCostsInput.value = totalProjectCosts.toFixed(2);
        beforeTaxInput.value = beforeTax.toFixed(2);
        valueTaxInput.value = valueTax.toFixed(2);
        afterTaxInput.value = afterTax.toFixed(2);
        actualProfitValueInput.value = actualProfitValue.toFixed(2);
    }

    // Add event listeners
    perMonthInput.addEventListener('input', calculateValues);
    monthlyBenefitInput.addEventListener('input', calculateValues);
    targetProfitPercentageInput.addEventListener('input', calculateValues);
    totalProjectCostsInput.addEventListener('input', calculateValues);
});


const toggleButton = document.getElementById('toggleButton');
const formContainer = document.getElementById('formContainer');
const inputs = formContainer.querySelectorAll('input[type="number"]:not(#total_project_costs)');
let totalProjectCostsValue = 0; // Variable to store the total_project_costs value
const totalCostsInput = document.getElementById('total_costs');
const targetProfitPercentageInput = document.getElementById('target_profit_percentage');
const beforeTaxInput = document.getElementById('before_tax');
const valueTaxInput = document.getElementById('value_tax');
const afterTaxInput = document.getElementById('after_tax');
const actualProfitValueInput = document.getElementById('actual_profit_value');

toggleButton.addEventListener('click', (event) => {
    event.preventDefault(); // Prevent the default form submission behavior
    if (formContainer.style.display === 'none') {
        // Show the form
        formContainer.style.display = 'block';
        toggleButton.classList.remove('btn-primary'); // Remove btn-danger class
        toggleButton.classList.add('btn-danger'); // Add btn-primary class
        toggleButton.innerText = 'إلغاء تكلفة التمويل'; // Change button text
    } else {
        // Hide the form
        formContainer.style.display = 'none';
        toggleButton.classList.remove('btn-danger'); // Remove btn-primary class
        toggleButton.classList.add('btn-primary'); // Add btn-danger class
        toggleButton.innerText = 'تفعيل تكلفة التمويل'; // Change button text
        // Set total_project_costs to total_costs
        document.getElementById('total_project_costs').value = totalProjectCostsValue;
        // Reset other input values to empty string
        inputs.forEach(input => input.value = '');

        // Calculate values based on total_costs
        var totalCosts = parseFloat(totalCostsInput.value) || 0;
        var targetProfitPercentage = parseFloat(targetProfitPercentageInput.value) || 0;

        var actualProfitValue = totalCosts * (targetProfitPercentage / 100);
        var beforeTax = totalCosts + actualProfitValue;
        var valueTax = beforeTax * 0.15;
        var afterTax = beforeTax + valueTax;
       

        beforeTaxInput.value = beforeTax.toFixed(2);
        valueTaxInput.value = valueTax.toFixed(2);
        afterTaxInput.value = afterTax.toFixed(2);
        actualProfitValueInput.value = actualProfitValue.toFixed(2);
    }
});

// Save the value of total_project_costs before hiding the form
document.getElementById('total_costs').addEventListener('input', (event) => {
    totalProjectCostsValue = event.target.value;
});







