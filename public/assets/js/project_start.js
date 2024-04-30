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

$(document).ready(function() {

    $(document).on('click', '.remove-btn', function () {
        $(this).closest('.main-form').remove();
    });

    $(document).on('click', '.add-more-form', function () {
        $('.paste-new-forms').append('<div class="main-form mt-3 border-bottom">\
                    <div class="row">\
                        <div class="col-md-3">\
                            <div class="form-group mb-2">\
                                <label>رقم الدفعة</label><span style="color: red;">  *</span>\
                                <input type="text" class="form-control" name="batch_number[]" placeholder="رقم الدفعة...">\
                            </div>\
                        </div>\
                        <div class="col-md-3">\
                            <div class="form-group mb-2">\
                                <label>قيمة الدفعة</label><span style="color: red;">  *</span>\
                                <input type="text" class="form-control" name="batch_value[]" placeholder="قيمة الدفعة...">\
                            </div>\
                        </div>\
                        <div class="col-md-3">\
                            <div class="form-group mb-2">\
                                <label>تاريخ الاستحقاق</label><span style="color: red;">  *</span>\
                                <input type="date" class="form-control" name="due_date[]" placeholder="تاريخ الاستحقاق...">\
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
});
