@extends('main_master')
@section('title')
    اضافة طلب صرف
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الموظف</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ اضافة طلب </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <form method="post" action="{{ route('applicant.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="project_name">اختيار المشروع </label><span style="color: red;">  *</span>
                    <select name="project_name" class="form-control" id="project_name">
                        <option value="" selected="" disabled="">اختيار المشروع</option>
                        @php
                            use Illuminate\Support\Facades\Auth;
                                $user = Auth::user()->name;
                                $user_name = App\Models\project_users::where('user_name', $user)->first();
                        @endphp
                        @if($user_name)
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('project_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group" id="section_name_div">
                    <label for="section_name">اسم القسم</label><span style="color: red;">  *</span>
                    <input type="text" name="section_name" class="form-control" id="section_name" readonly>
                    @error('section_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="step_name">اختر المرحلة</label><span style="color: red;">  *</span>
                    <select name="step_name" class="form-control" id="step_name">
                        <option value="" selected="" disabled=""> اختر المرحلة...</option>
                        <!-- Options for item_name will be populated dynamically with JavaScript -->
                    </select>
                    @error('step_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="item_name">اختر البند</label><span style="color: red;">  *</span>
                    <select name="item_name" class="form-control" id="item_name">
                        <option value="" selected="" disabled="">اختر البند...</option>
                        <!-- Options for item_name will be populated dynamically with JavaScript -->
                    </select>
                    @error('item_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="item_value">قيمة البند</label>
                    <input type="text" class="form-control" name="item_value" id="item_value" readonly>
                    @error('item_value')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="remaining_value"> المتبقي من قيمة البند</label>
                    <input type="text" class="form-control" name="remaining_value" id="remaining_value" readonly>
                    @error('remaining_value')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>التاريخ</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" id="dateInput" required name="date">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>المبلغ</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="price" id="price" placeholder="المبلغ...">
                    @error('price')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اختيار مستوى الاولوية </label><span class="text-danger">*</span>
                    <div class="controls">
                        <select name="priority_level" class="form-control">
                            <option value="" selected="" disabled="">اختر مستوى الأولوية...</option>
                            <option value="مهم">مهم</option>
                            <option value="منخفض"> منخفض</option>
                            <option value="عاجل">عاجل</option>
                        </select>
                        @error('priority_level')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم البنك</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" name="bank_name" placeholder="اسم البك...">
                    @error('bank_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم صاحب الحساب البنكي</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" name="bank_name_account" placeholder="اسم صاحب الحساب البنكي...">
                    @error('bank_name_account')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>رقم الحساب</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" name="account_number" placeholder="رقم الحساب...">
                    @error('account_number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>رقم العقد</label>
                    <input type="text" class="form-control" name="contract_number" placeholder="رقم العقد...">
                    @error('contract_number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>تاريخ استحقاق الدفعة</label><span class="text-danger">*</span>
                    <input type="date" class="form-control" name="payment_date"
                           min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" id="dateInput1" required>
                    @error('payment_date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="form-group">
                        <label for="order_name">البيان</label>
                        <textarea id="description" name="description"  class="form-control" placeholder="البيان..."></textarea>
                    </div>
                </div>
            </div>
        </div>
<br>

        <div class="d-flex justify-content-between">
            <input type="submit" class="btn btn-info" value="ارسال الطلب">
        </div>
        <br>
    </form>


    <script>
        $(document).ready(function () {
            // Handle project name selection
            $('#project_name').change(function () {
                var projectId = $(this).val();

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
    </script>
    <script>
        // Select the input field
        var input = document.getElementById('dateInput1');

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
    </script>
@endsection
