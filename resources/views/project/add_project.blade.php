@extends('main_master')
@section('title')
    اضافة مشروع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">مدير المشروع</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ اضافة مشروع </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <form method="post" action="{{ route('project.store') }}">
        @csrf

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
                    <label>اسم المشروع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="project_name" placeholder="اسم المشروع...">
                    @error('project_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>اسم المرحلة</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="step_name[]" placeholder="اسم المرحلة...">
                    @error('step_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <h4>
            <a href="javascript:void(0)" class="add-more-step float-right btn btn-primary">أضف مرحلة </a>
        </h4>
        <div class="main-form mt-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>بند الصرف</label><span style="color: red;">  *</span>
                        <input type="text" class="form-control" required name="item_name[]" placeholder="بند الصرف...">
                        @error('item_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>قيمة البند</label><span class="text-danger">*</span>
                        <input type="text" class="form-control item-value" name="item_value[]" placeholder=" قيمة البند...">
                        @error('item_value')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label> تاريخ الاستحقاق</label>
                        <input type="date" class="form-control" name="due_date[]" placeholder=" تاريخ الاستحقاق...">
                        @error('due_date')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <h4>
            <a href="javascript:void(0)" class="add-more-form float-right btn btn-primary">أضف بند </a>
        </h4>
        <br>
        <div class="paste-new-forms"></div>
        <br>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>المجموع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="total" id="total" placeholder="المجموع..." readonly>
                    @error('total')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اختيار القسم </label><span class="text-danger">*</span>
                    <div class="controls">
                        <select name="section_name" class="form-control">
                            <option value="" selected="" disabled="">اختيار القسم </option>
                            @foreach($sections as $item)
                                <option value="{{ $item->section_name }}">{{ $item->section_name }}</option>
                            @endforeach

                        </select>
                        @error('section_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <h5>اختيار الموظفين <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <select name="user_name[]" multiple="multiple" class="form-control">
                            <option value="" selected="" disabled="">اختيار الموظفين</option>

                        </select>
                        @error('users_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
{{--        <div class="row">--}}
{{--            <div class="col-md-12">--}}
{{--                <div class="form-group">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="order_name">ملاحظات</label>--}}
{{--                        <textarea id="description" name="description"  class="form-control" placeholder="ملاحظات..."></textarea>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <br>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <input type="submit" class="btn btn-info" value=" حفظ وإرسال">
        </div>
        <br>
    </form>
    <script>
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
    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on('click', '.remove-btn', function () {
                $(this).closest('.main-form').remove();
            });

            $(document).on('click', '.add-more-form', function () {
                $('.paste-new-forms').append('<div class="main-form mt-3">\
                    <div class="row">\
                        <div class="col-md-4">\
                            <div class="form-group">\
                                <label>بند الصرف</label><span style="color: red;">  *</span>\
                                <input type="text" class="form-control" required name="item_name[]" placeholder="بند الصرف...">\
                                @error('item_name')\
                                    <span class="text-danger"> {{ $message }}</span>\
                                @enderror\
                            </div>\
                        </div>\
                         <div class="col-md-3">\
                             <div class="form-group">\
                                <label>قيمة البند</label><span class="text-danger">*</span>\
                                <input type="text" class="form-control item-value" name="item_value[]" placeholder=" قيمة البند...">\
                                @error('item_value')\
                                    <span class="text-danger"> {{ $message }}</span>\
                                @enderror\
                            </div>\
                        </div>\
                        <div class="col-md-3">\
                            <div class="form-group">\
                                <label> تاريخ الاستحقاق</label><span class="text-danger">*</span>\
                                <input type="date" class="form-control" name="due_date[]" placeholder=" تاريخ الاستحقاق...">\
                                @error('due_date')\
                                    <span class="text-danger"> {{ $message }}</span>\
                                @enderror\
                            </div>\
                        </div>\
                        <div class="col-md-2">\
                            <div class="form-group">\
                                <br>\
                                <button type="button" class="remove-btn btn btn-danger">ازالة</button>\
                            </div>\
                        </div>\
                    </div>\
                </div>');
            });

            $(document).on('click', '.add-more-step', function () {
                $('.paste-new-forms').append('<div class="main-form mt-3">\
                    <div class="row border-top red">\
                        <div class="col-md-4">\
                             <div class="form-group">\
                                <label>اسم المرحلة</label><span style="color: red;">  *</span>\
                                <input type="text" class="form-control" required name="step_name[]" placeholder="اسم المرحلة...">\
                                @error('step_name')\
                                    <span class="text-danger"> {{ $message }}</span>\
                                @enderror\
                            </div>\
                        </div>\
                    </div>\
                    <div class="row">\
                        <div class="col-md-4">\
                            <div class="form-group">\
                                <label>بند الصرف</label><span style="color: red;">  *</span>\
                                <input type="text" class="form-control" required name="item_name[]" placeholder="بند الصرف...">\
                                @error('item_name')\
                                    <span class="text-danger"> {{ $message }}</span>\
                                @enderror\
                            </div>\
                        </div>\
                         <div class="col-md-3">\
                             <div class="form-group">\
                                <label>قيمة البند</label><span class="text-danger">*</span>\
                                <input type="text" class="form-control item-value" name="item_value[]" placeholder=" قيمة البند...">\
                                @error('item_value')\
                                    <span class="text-danger"> {{ $message }}</span>\
                                @enderror\
                            </div>\
                        </div>\
                        <div class="col-md-3">\
                            <div class="form-group">\
                                <label> تاريخ الاستحقاق</label><span class="text-danger">*</span>\
                                <input type="date" class="form-control" name="due_date[]" placeholder=" تاريخ الاستحقاق...">\
                                @error('due_date')\
                                    <span class="text-danger"> {{ $message }}</span>\
                                @enderror\
                            </div>\
                        </div>\
                        <div class="col-md-2">\
                            <div class="form-group">\
                                <br>\
                                <button type="button" class="remove-btn btn btn-danger">ازالة</button>\
                            </div>\
                        </div>\
                    </div>\
                    <h4>\
                        <a href="javascript:void(0)" class="add-more-form float-right btn btn-primary">أضف بند </a>\
                    </h4>\
                    <br>\
                </div>');
            });

        });
    </script>
    <script>

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
    </script>
    <script>
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
    </script>

@endsection
