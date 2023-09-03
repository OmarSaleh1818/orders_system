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
    <form method="post" action="{{ route('applicant.store') }}">
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
        <div class="main-form mt-3 border-bottom">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>بنود الصرف</label><span style="color: red;">  *</span>
                        <input type="text" class="form-control" required name="item_name[]" placeholder="بنود الصرف...">
                        @error('item_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>قيمة البند</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" id="item_value" name="item_value[]" placeholder=" قيمة البند...">
                        @error('item_value')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
            <h4>
                <a href="javascript:void(0)" class="add-more-form float-left btn btn-primary">ADD MORE</a>
            </h4>
            <br>

        <div class="paste-new-forms"></div>
        <br>
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

        <br>

        <div class="d-flex justify-content-between">
            <input type="submit" class="btn btn-info" value=" تأكيد">
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
                $('.paste-new-forms').append('<div class="main-form mt-3 border-bottom">\
                    <div class="row">\
                         <div class="col-md-5">\
                            <div class="form-group">\
                                <label>بنود الصرف</label><span style="color: red;">  *</span>\
                                <input type="text" class="form-control" required name="item_name[]" placeholder="بنود الصرف...">\
                                @error('item_name')\
                                 <span class="text-danger"> {{ $message }}</span>\
                                @enderror\
                            </div>\
                        </div>\
                        <div class="col-md-5">\
                            <div class="form-group">\
                                <label>قيمة البند</label><span class="text-danger">*</span>\
                                <input type="text" class="form-control" id="item_value2" name="item_value[]" placeholder=" قيمة البند...">\
                                @error('item_value')\
                                <span class="text-danger"> {{ $message }}</span>\
                                @enderror\
                            </div>\
                        </div>\
                        <div class="col-md-2">\
                            <div class="form-group mb-2">\
                                <br>\
                                <button type="button" class="remove-btn btn btn-danger">Remove</button>\
                            </div>\
                        </div>\
                    </div>\
                </div>');
            });
        });
    </script>
    <script>

        $(document).on('input', '#item_value', function(e) {
            myFunction();
        });
        function myFunction() {
            var item_value = $('#item_value').val();
            var item_value2 = $('#item_value2').val();
            if(item_value =="") item_value=0;
            if(item_value2 =="") item_value2=0;
            $('#total').val(parseFloat(item_value + item_value2));
        }
        console.log(item_value2);
    </script>

@endsection
