@extends('main_master')
@section('title')
    فتح مشروع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">مدير المشروع</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ فتح مشروع </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <form method="post" action="{{ route('project.open.store', $projects->id) }}" enctype="multipart/form-data">
        @csrf
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2>فتح مشروع </h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم المشروع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" readonly name="project_name" value="{{ $projects->project_name }}" placeholder="اسم المشروع...">
                    @error('project_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> رقم التسعيرة </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" readonly name="project_code" value="{{ $projects->price_number }}" placeholder="اسم المشروع...">
                    @error('project_code')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>تاريخ فتح المشروع</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" id="dateInput" required
                           min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" name="date">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>تاريخ بداية المشروع</label><span style="color: red;"> *</span>
                    <input type="date" class="form-control" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                           id="startDateInput" required name="start_date">
                    @error('start_date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>تاريخ نهاية المشروع</label><span style="color: red;"> *</span>
                    <input type="date" class="form-control" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                           required name="end_date" id="endDateInput" onchange="validateEndDate()">
                    @error('end_date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>مدة المشروع بالأيام</label><span style="color: red;"> *</span>
                    <input type="text" class="form-control" required name="project_days" id="daysInput" placeholder="مدة المشروع بالأيام ..."
                           readonly>
                    @error('project_days')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>نوع العميل</label><span style="color: red;">*</span>
                    <div class="controls">
                        <select name="customer_type" class="form-control" id="customerTypeSelect">
                            <option value="" selected disabled>نوع العميل</option>
                            <option value="مانح">مانح</option>
                            <option value="حكومي">حكومي</option>
                            <option value="أهلي">أهلي</option>
                            <option value="أفراد">أفراد</option>
                        </select>
                        @error('customer_type')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم العميل</label>
                    <input type="text" class="form-control" name="customer_name" id="customerNameInput"
                           placeholder="اسم العميل...">
                    @error('customer_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>الجهة المستفيدة</label>
                    <input type="text" class="form-control" name="benefit" id="benefitInput"
                           placeholder="الجهة المستفيدة...">
                    @error('benefit')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label> القسم</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="section_name" value="{{ $projects->section_name }}" placeholder=" القسم..." readonly>
                    @error('section_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> كود المشروع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="project_code" value="{{ $newProjectCode }}" readonly>
                    @error('project_code')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>مسودة العرض فني</label><span style="color: red;">  *</span>
                    <input type="file" class="form-control" name="art_show"
                           placeholder=" إرفاق عرض فني...">
                    @error('art_show')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <h5>اختيار الموظفين <span class="text-danger"> *</span></h5>
                    <div class="controls">
                        @foreach($users as $item)
                            <div class="checkbox" style="display: inline-block; margin-right: 10px;">
                                <label>
                                    <input type="checkbox" name="user_name[]" value="{{ $item->name }}">
                                    {{ $item->name }}
                                </label>
                            </div>
                        @endforeach
                        @error('user_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label> مسودة العرض مالي</label><span style="color: red;">  *</span>
                    <input type="file" class="form-control" required name="finance_show" >
                    @error('finance_show')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> مسودة العقد</label><span style="color: red;">  *</span>
                    <input type="file" class="form-control" name="draft_show" required>
                    @error('draft_show')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="form-group">
                        <label for="order_name">ملاحظات</label>
                        <textarea id="description" name="description"  class="form-control" placeholder="ملاحظات..."></textarea>
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
        window.onload = function() {
            var date = new Date();
            var year = date.getFullYear().toString().substr(-2);
            var code = "B-001-" + year;

            // Find the input field and set its value
            document.getElementById("project_code").value = code;
        };
    </script>
    <script src="{{ asset('assets/js/project_open.js') }}"></script>

@endsection
