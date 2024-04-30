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
    let a = 1;
    $(document).on('click', '.add-more-step', function () {
        let stepCount = ++a;
        let addStep = `
            <hr>
            <div class="items-container mt-5" id="stepitems${stepCount}">
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
    });
});

function addItem(id){

let rowToAdd = `  <div class="row" >
                    <div class="col-md-3" id="itemNameContainer">
                        <div class="form-group">
                            <label>بند الصرف</label><span style="color: red;"> *</span>
<!--                            <input type="text" class="form-control" required name="item_name[]" placeholder="بند الصرف..." style="display: none;">-->
                            <select name="item_name[]" class="form-control" id="travel_arriveVia" onchange="toggleOtherOption(this)">
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
                            <input type="text" class="form-control item-value" name="item_value[]" placeholder="قيمة البند...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>تاريخ اول صرف من البند</label>
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

const toggleButton = document.getElementById('toggleButton');
const formContainer = document.getElementById('formContainer');

toggleButton.addEventListener('click', (event) => {
    event.preventDefault(); // Prevent the default form submission behavior
    if (formContainer.style.display === 'none') {
        formContainer.style.display = 'block';
    } else {
        formContainer.style.display = 'none';
    }
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
    var targetProfitValueInput = document.getElementById('target_profit_value');
    var totalProjectValueInput = document.getElementById('total_project_value');
    var beforeTaxInput = document.getElementById('before_tax');
    var valueTaxInput = document.getElementById('value_tax');
    var afterTaxInput = document.getElementById('after_tax');
    var actualProfitPercentageInput = document.getElementById('actual_profit_percentage');
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

        if (isNaN(totalProjectCosts) || totalProjectCosts === 0) {
            totalProjectCostsInput.value = '0';
            totalProjectCosts = 0;
        }

        var targetProfitValue = (targetProfitPercentage / 100) * totalProjectCosts;
        var totalProjectValue = totalProjectCosts / (1 - (targetProfitPercentage / 100));
        var beforeTax = totalProjectValue;
        var valueTax = beforeTax * 0.15;
        var afterTax = beforeTax + valueTax;
        var actualProfitValue = beforeTax - totalCosts;
        var actualProfitPercentage = (actualProfitValue / beforeTax) * 100;

        percentageTotalInput.value = percentageTotal.toFixed(2);
        benefitValueInput.value = benefitValue.toFixed(2);
        totalProjectCostsInput.value = totalProjectCosts.toFixed(2);
        targetProfitValueInput.value = targetProfitValue.toFixed(2);
        totalProjectValueInput.value = totalProjectValue.toFixed(2);
        beforeTaxInput.value = beforeTax.toFixed(2);
        valueTaxInput.value = valueTax.toFixed(2);
        afterTaxInput.value = afterTax.toFixed(2);
        actualProfitPercentageInput.value = actualProfitPercentage.toFixed(2);
        actualProfitValueInput.value = actualProfitValue.toFixed(2);
    }

    // Add event listeners
    perMonthInput.addEventListener('input', calculateValues);
    monthlyBenefitInput.addEventListener('input', calculateValues);
    targetProfitPercentageInput.addEventListener('input', calculateValues);
    totalProjectCostsInput.addEventListener('input', calculateValues);
});




// document.getElementById('per_month').addEventListener('input', updateValues);
// document.getElementById('monthly_benefit').addEventListener('input', updateValues);
// document.getElementById('target_profit_percentage').addEventListener('input', updateValues);
//
// function updateValues() {
//     var perMonth = parseFloat(document.getElementById('per_month').value);
//     var monthlyBenefit = parseFloat(document.getElementById('monthly_benefit').value);
//     var totalCosts = parseFloat(document.getElementById('total_costs').value);
//     var targetProfitPercentage = parseFloat(document.getElementById('target_profit_percentage').value);
//
//     // Check if the input is a valid number
//     if (!isNaN(perMonth) && !isNaN(monthlyBenefit) && !isNaN(totalCosts)) {
//         var percentageTotal = perMonth * (monthlyBenefit / 100);
//         var benefitValue = totalCosts * percentageTotal;
//         var totalProject = totalCosts + benefitValue;
//         var targetProfitValue = (targetProfitPercentage / 100) * totalProject;
//         var totalProjectValue = totalProject / (1 - (targetProfitPercentage / 100);
//         var beforeTax = totalProjectValue
//         var valueTax = beforeTax * (15 / 100);
//         var afterTax = beforeTax + valueTax;
//         var actualProfitValue = beforeTax - totalProject;
//         var actualProfitPercentage = (actualProfitValue / beforeTax) * 100;
//
//         document.getElementById('percentage_total').value = percentageTotal.toFixed(2);
//         document.getElementById('benefit_value').value = benefitValue.toFixed(2);
//         document.getElementById('total_project_costs').value = totalProject.toFixed(2);
//         document.getElementById('target_profit_value').value = targetProfitValue.toFixed(2);
//         document.getElementById('total_project_value').value = totalProjectValue.toFixed(2);
//         document.getElementById('before_tax').value = beforeTax.toFixed(2);
//         document.getElementById('value_tax').value = valueTax.toFixed(2);
//         document.getElementById('after_tax').value = afterTax.toFixed(2);
//         document.getElementById('actual_profit_value').value = actualProfitValue.toFixed(2);
//         document.getElementById('actual_profit_percentage').value = actualProfitPercentage.toFixed(2);
//     } else {
//         // Handle invalid input, for example, set the output fields to empty
//         document.getElementById('percentage_total').value = '';
//         document.getElementById('benefit_value').value = '';
//         document.getElementById('total_project_costs').value = '';
//         document.getElementById('target_profit_value').value = '';
//         document.getElementById('total_project_value').value = '';
//         document.getElementById('discount_value').value = '';
//         document.getElementById('before_tax').value = '';
//         document.getElementById('value_tax').value = '';
//         document.getElementById('after_tax').value = '';
//         document.getElementById('actual_profit_value').value = '';
//         document.getElementById('actual_profit_percentage').value = '';
//     }
// }





