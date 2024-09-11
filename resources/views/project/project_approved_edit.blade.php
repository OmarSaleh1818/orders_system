@extends('main_master')
@section('title')
    تعديل بَدْء مشروع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> المشاريع</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ تعديل بَدْء مشروع </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <form method="post" action="{{ route('project.approved.update', $openProject->id) }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden"  name="project_id" value="{{ $openProject['project']['id'] }}">
        <div class="row">
            @if($openProject->status_id == 12)
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="order_name">السبب من عدم اعتماد </label>
                            <textarea id="description" name="reject_reason"  class="form-control"  readonly>{{ $projectApprovedReject->reject_reason }}</textarea>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2>بدء مشروع </h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>التاريخ</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" value="{{ $start_project->date }}" required name="date">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم المشروع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" readonly name="project_name" value="{{ $openProject['project']['project_name'] }}">
                    @error('project_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label> القسم</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="section_name"
                           value="{{ $openProject['project']['section_name'] }}" placeholder=" القسم..." readonly>
                    @error('section_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>العرض الفني الموقع</label><span style="color: red;"> *</span>
                    <input type="file" class="form-control" name="art_show" placeholder="إرفاق عرض فني...">
                    @if($start_project->art_show)
                        <p>الملف الحالي: <a href="{{ asset($start_project->art_show) }}">{{ $start_project->art_show }}</a></p>
                    @endif
                    @error('art_show')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>  العرض المالي الموقع</label><span style="color: red;">  *</span>
                    <input type="file" class="form-control"  name="finance_show">
                    @if($start_project->finance_show)
                        <p>الملف الحالي: <a href="{{ asset($start_project->finance_show) }}">{{ $start_project->finance_show }}</a></p>
                    @endif
                    @error('finance_show')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>  العقد الموقع</label><span style="color: red;">  *</span>
                    <input type="file" class="form-control" name="draft_show">
                    @if($start_project->draft_show)
                        <p>الملف الحالي: <a href="{{ asset($start_project->draft_show) }}">{{ $start_project->draft_show }}</a></p>
                    @endif
                    @error('draft_show')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label> صافي قيمة المشروع بعد الضريبة</label>
                    <input type="text" class="form-control" readonly name="after_tax" id="after_tax" value="{{ $openProject['projectStart']['after_tax'] }}">
                    @error('after_tax')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2> الدفعات </h2>
            </div>
        </div>
        <br>
        @foreach($multi_batch as $multi)
            <input type="hidden" name="multi[]" value="{{$multi->id }}">
            <div class="main-form mt-3 border-bottom">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label>رقم الدفعة</label><span style="color: red;">  *</span>
                            <input type="text" class="form-control" required name="batch_number[]" value="{{ $multi->batch_number }}">
                            @error('batch_number')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label>قيمة الدفعة</label><span style="color: red;">  *</span>
                            <input type="text" class="form-control batch_value" required name="batch_value[]" value="{{ $multi->batch_value }}" oninput="validateNumber(this)">
                            @error('batch_value')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label>تاريخ الاستحقاق</label><span style="color: red;">  *</span>
                            <input type="date" class="form-control" required name="due_date[]" value="{{ $multi->due_date }}">
                            @error('due_date')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>مجموع الدفعات</label><span style="color: red;">  *</span>
                    <input type="number" class="form-control" required name="total" id="total"
                           value="{{ $start_project->total }}" readonly>
                    @error('total')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="form-group">
                        <label for="order_name">ملاحظات</label>
                        <textarea id="description" name="description"  class="form-control" placeholder="ملاحظات...">
                            {{ $start_project->description }}
                        </textarea>
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <input type="submit" class="btn btn-info" value=" حفظ وإرسال">
        </div>
        <br>
    </form>


    <script>
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

       // Function to calculate the total of batch values
        function calculateTotal() {
            var total = 0;
            var batchValues = document.querySelectorAll('.batch_value');
            batchValues.forEach(function(input) {
                var value = parseFloat(input.value) || 0; // Handle empty or invalid inputs
                total += value;
            });
            document.getElementById('total').value = total;
            validateTotal();
        }

        // Function to validate that total is less than or equal to after_tax
        function validateTotal() {
            var afterTax = parseFloat(document.getElementById('after_tax').value);
            var total = parseFloat(document.getElementById('total').value);
            
            if (total > afterTax) {
                alert("مجموع الدفعات يجب أن لا يتجاوز صافي قيمة المشروع بعد الضريبة");
                
                // Find the last batch_value input that caused the issue and clear it
                var batchValues = document.querySelectorAll('.batch_value');
                for (var i = batchValues.length - 1; i >= 0; i--) {
                    var batchValue = parseFloat(batchValues[i].value);
                    if (!isNaN(batchValue) && batchValue !== 0) {
                        batchValues[i].value = ''; // Clear the last entered value that caused the issue
                        break;
                    }
                }

                // Clear the total
                document.getElementById('total').value = '';
            }
        }

        // Add event listeners to all batch_value inputs to recalculate total on input change
        document.addEventListener('input', function(event) {
            if (event.target.classList.contains('batch_value')) {
                calculateTotal();
            }
        });
    </script>

@endsection
