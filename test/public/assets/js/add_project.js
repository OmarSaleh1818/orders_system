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
//
// function toggleInput(selectElement) {
//     var inputElement = selectElement.parentElement.querySelector('input[type="text"]');
//     if (selectElement.value === 'أخرى') {
//         selectElement.style.display = 'none';
//         inputElement.style.display = 'block';
//     } else {
//         inputElement.style.display = 'none';
//         selectElement.style.display = 'block';
//     }
// }

function toggleOtherOption(selectElement) {
    var container = selectElement.closest(".row");
    var otherItemInput = container.querySelector(".other-item-input");

    // Remove the existing input if it exists
    if (otherItemInput) {
        otherItemInput.remove();
    }

    if (selectElement.value === "أخرى") {
        // Create a new input element
        otherItemInput = document.createElement("input");
        otherItemInput.setAttribute("type", "text");
        otherItemInput.setAttribute("name", "other_item_name");
        otherItemInput.setAttribute("class", "form-control other-item-input col-md-3");
        otherItemInput.setAttribute("placeholder", "أدخل بند اخر");

        // Insert the new input after the select element
        container.appendChild(otherItemInput);
    }
}


$(document).ready(function() {
    let a = $('.items-container').length; // Get the initial count of items-containers
    $(document).on('click', '.add-more-step', function () {
        let stepCount = ++a;
        let addStep = `
            <div class="items-container mt-5" id="stepitems${stepCount}">
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>اسم المرحلة</label><span style="color: red;">  *</span>
                            <input type="hidden" value="0" id="step${stepCount}" name="number_step[]">
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

    $('.paste-new-forms').on('click', '.remove-step', function () {
        let stepCount = $(this).data('step');
        $('#stepitems' + stepCount).remove();
        a--; // Decrement the step count
    });
});
$(document).on('click', '.remove-btn', function() {
    // Get the step number from the data-step attribute of the remove button
    let stepNumber = $(this).data('step');
    // Decrement the value of the hidden input field
    let numberStepInput = $('#step' + stepNumber);
    numberStepInput.val(parseInt(numberStepInput.val()) - 1);
    // Remove the item container
    $(this).closest('.row').remove();
});

function addItem(id){

let rowToAdd = `  <div class="row" >
                    <div class="col-md-3" id="itemNameContainer">
                        <div class="form-group">
                            <label>بند الصرف</label><span style="color: red;"> *</span>
<!--                            <input type="text" class="form-control" required name="item_name[]" placeholder="بند الصرف..." style="display: none;">-->
                            <select name="item_name[]" required class="form-control" id="travel_arriveVia" onchange="toggleOtherOption(this)">
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
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>قيمة البند</label><span class="text-danger"> *</span>
                            <input type="number" class="form-control item-value" name="item_value[]" required placeholder="قيمة البند...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <br>
                            <button type="button" class="remove-btn btn btn-danger" onclick="removeItem(event)" id="btnremove${id}">إزالة</button>
                        </div>
                        <hr>
                    </div>
                    <div class="col-md-3">

                    </div>
                </div>`
    $(`#stepitems${id}`).append(rowToAdd);
    let itemNumber = +$(`#step${id}`).val();
    $(`#step${id}`).val(itemNumber+= 1);
}

function removeItem(event){
    event.target.parentNode.parentNode.parentNode.remove();

    // Update the item count
    let id = event.target.id.replace('btnremove', '');
    let itemNumber = +$(`#step${id}`).val();
    if (itemNumber > 0) {
        $(`#step${id}`).val(itemNumber - 1);
    }
    // Recalculate the total
    updateTotal();
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

        var beforeTax = totalProjectCosts / (1 - (targetProfitPercentage / 100));
        var valueTax = beforeTax * 0.15;
        var afterTax = beforeTax + valueTax;
        var actualProfitValue = beforeTax - totalProjectCosts;


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

        var beforeTax = totalCosts / (1 - (targetProfitPercentage / 100));
        var valueTax = beforeTax * 0.15;
        var afterTax = beforeTax + valueTax;
        var actualProfitValue = beforeTax - totalCosts;

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







