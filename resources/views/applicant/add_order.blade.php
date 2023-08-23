@extends('main_master')
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
    <form method="post" action="#">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>رقم الطلب</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="id" placeholder="رقم الطلب...">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>التاريخ</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" id="dateInput" required name="date">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <h5>اختيار القسم <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <select name="section" class="form-control">
                            <option value="" selected="" disabled="">اختيار القسم </option>

                                <option value="">الدعم المؤسسي</option>
                                <option value="">بناء الطاقات</option>
                                <option value="">المالية</option>
                                <option value="">نديم</option>
                                <option value="">الكفاءة الاستراتيجية</option>
                                <option value="">مجتمع المشاريع التنموية</option>

                        </select>
                        @error('section')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>المبلغ</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="price" placeholder="المبلغ...">
                    @error('price')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>البيان</label><span class="text-danger">*</span></h5>
                    <input type="text" class="form-control" name="order_name" placeholder="البيان...">
                    @error('order_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>رقم الحساب</label><span class="text-danger">*</span></h5>
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
                    <label>اسم البنك</label><span class="text-danger">*</span></h5>
                    <input type="text" class="form-control" name="bank_name" placeholder="اسم البك...">
                    @error('bank_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم صاحب الحساب البنكي</label><span class="text-danger">*</span></h5>
                    <input type="text" class="form-control" name="bank_name_account" placeholder="اسم صاحب الحساب البنكي...">
                    @error('bank_name_account')
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
                    <label>اسم المشروع</label>
                    <input type="text" class="form-control" name="project_name" placeholder="اسم المشروع...">
                    @error('project_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>تاريخ استحقاق الدفعة</label><span class="text-danger">*</span></h5>
                    <input type="date" class="form-control" name="payment_date"
                           min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" id="dateInput1" required>
                    @error('payment_date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <h5>اختيار مستوى الاولوية <span class="text-danger">*</span></h5>
                    <div class="controls">
                        <select name="priority_level" class="form-control">
                            <option value="" selected="" disabled="">اختيار مستوى الاولوية </option>

                            <option value="">مهم</option>
                            <option value=""> منخفض</option>
                            <option value="">عاجل</option>

                        </select>
                        @error('priority_level')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
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
