@extends('main_master')
@section('title')
    إضافة مشروع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">مدير المشروع</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ إضافة مشروع </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <form method="post" action="{{ route('project.store') }}">
        @csrf
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2>البيانات الرئيسية</h2>
            </div>
        </div>
        <br>
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
                    @error('project_days
')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>رقم التسعيرة</label><span style="color: red;"> *</span>
                    <input type="text" class="form-control" required name="price_number" id="priceNumberInput"
                           placeholder="رقم التسعيرة ..." value="{{ $formattedPriceNumber }}" readonly>
                    @error('price_number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
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
        </div>
        <div class="row">
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
            <div class="col-md-6">
                <div class="form-group">
                    <label>اختيار القسم </label><span class="text-danger"> *</span>
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
                    <label> كود المشروع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="project_code" placeholder=" كود المشروع...">
                    @error('project_code')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <h5>اختيار الموظفين <span class="text-danger"> *</span></h5>
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
        <div class="main-form">
            <hr>
            <div class="row">
                <div class="col text-center">
                    <h2> التكاليف المباشرة</h2>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>اسم المرحلة</label><span style="color: red;">  *</span>
                        <input type="hidden" value="1" id="step1" name="number_step[]">
                        <input type="text" class="form-control" required name="step_name[]" placeholder="اسم المرحلة...">
                    </div>
                </div>
            </div>
            <h4>
                <a href="javascript:void(0)" class="add-item float-right btn btn-primary" id="stepitemsclick,1" onclick="addItem(1)">أضف بند</a>
            </h4>
            <div class="items-container mt-5" id="stepitems1">
                <div class="row" >
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>بند الصرف</label><span style="color: red;"> *</span>
                            <input type="text" class="form-control" required name="item_name[]" placeholder="بند الصرف...">
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
                            <label>تاريخ الاستحقاق</label>
                            <input type="date" class="form-control" name="due_date[]"
                                   min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" placeholder="تاريخ الاستحقاق...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4>
            <a href="javascript:void(0)" class="add-more-step float-right btn btn-primary">أضف مرحلة</a>
        </h4>
        <br>
        <div class="paste-new-forms">

        </div>

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
        </div>
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2> التكاليف الغير مباشرة</h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>  المصروفات الإدارية (%) </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="management" id="management" required
                           placeholder=" المصروفات الإدارية...">
                    @error('management')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label> التكاليف الغير مباشرة </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="indirect_costs" id="indirect_costs" required readonly
                           placeholder="  التكاليف الغير مباشرة...">
                    @error('indirect_costs')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label> إجمالي التكاليف المباشرة والغير مباشرة</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="total_costs" id="total_costs" required readonly
                           placeholder="إجمالي التكاليف المباشرة والغير مباشرة...">
                    @error('total_costs')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2> تكلفة التمويل </h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label> فائدة المرابحة الشهرية (%) </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="monthly_benefit" id="monthly_benefit" required
                           placeholder="فائدة المرابحة الشهرية...">
                    @error('monthly_benefit')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>  الفترة بالشهر </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="per_month" id="per_month" required
                           placeholder=" الفترة بالشهر...">
                    @error('per_month')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label> إجمالي النسبة </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="percentage_total" id="percentage_total" required
                           placeholder="إجمالي النسبة..." readonly>
                    @error('percentage_total')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label> قيمة المرابحة </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="benefit_value" id="benefit_value" required
                           placeholder=" قيمة المرابحة..." readonly>
                    @error('benefit_value')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label> إجمالي تكاليف المشروع </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="total_project_costs" id="total_project_costs" required
                           placeholder="إجمالي تكاليف المشروع..." readonly>
                    @error('total_project_costs')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2> الربحية </h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>  نسبة الربح المستهدف (%) </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="target_profit_percentage" id="target_profit_percentage" required
                           placeholder=" نسبة الربح المستهدف...">
                    @error('target_profit_percentage')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> قيمة الربح المستهدف </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="target_profit_value" id="target_profit_value" required
                           placeholder=" قيمة الربح المستهدف..." readonly>
                    @error('target_profit_value')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>  نسبة الربح الفعلية (%) </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="actual_profit_percentage" id="actual_profit_percentage" required
                           placeholder="  نسبة الربح الفعلية..." readonly>
                    @error('actual_profit_percentage')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label> قيمة الربح الفعلية </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="actual_profit_value" id="actual_profit_value" required
                           placeholder=" قيمة الربح الفعلية..." readonly>
                    @error('actual_profit_value')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>  إجمالي قيمة المشروع  </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="total_project_value" id="total_project_value" required
                           placeholder="  إجمالي قيمة المشروع..." readonly>
                    @error('total_project_value')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2> خصم خاص </h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label> نسبة الخصم (%) </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="private_discount" id="private_discount" required
                           placeholder="    نسبة الخصم...">
                    @error('private_discount')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> قيمة الخصم </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="discount_value" id="discount_value" required
                           placeholder="   قيمة الخصم ..." readonly>
                    @error('private_discount')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2> الصافي </h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label> صافي قيمة المشروع قبل الضريبة </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="before_tax" id="before_tax" required
                           placeholder="  قبل الضريبة..." readonly>
                    @error('before_tax')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label> ضريبة القيمة المضافة </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="value_tax" id="value_tax" required
                           placeholder="   ضريبة القيمة المضافة..." readonly>
                    @error('value_tax')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label> صافي قيمة المشروع بعد الضريبة </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="after_tax" id="after_tax" required
                           placeholder="  بعد الضريبة..." readonly>
                    @error('after_tax')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <hr>
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


    <script src="{{ asset('assets/js/add_project.js') }}"></script>

@endsection
