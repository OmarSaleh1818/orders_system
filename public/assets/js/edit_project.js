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
