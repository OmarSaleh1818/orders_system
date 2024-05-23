@extends('main_master')
@section('title')
    عرض بيانات المشروع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">  المشاريع</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ عرض بيانات المشروع </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(Session()->has('status'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>{{ Session()->get('status') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
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
                <input type="date" class="form-control" value="{{ $project->date }}" name="date" readonly>
                @error('date')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>اسم المشروع</label><span style="color: red;">  *</span>
                <input type="text" class="form-control" required name="project_name" value="{{ $project->project_name }}" readonly>
                @error('project_name')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>القسم </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" required name="project_name" value="{{ $project->section_name }}" readonly>
                @error('section_name')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
        @cannot('اعتماد القانونية للمشروع')
        <div class="col-md-6">
            <div class="form-group">
                <label>رقم التسعيرة</label><span style="color: red;"> *</span>
                <input type="text" class="form-control" required name="price_number" value="{{ $project->price_number }}" readonly>
                @error('price_number')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col text-center">
            <h2> التكاليف المباشرة</h2>
        </div>
    </div>
    <br>
    @foreach($steps as $step)
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم المرحلة</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="step_name[]" value="{{ $step->step_name }}" readonly>
                    @error('step_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        @foreach($multi_project as $multi)
            @if($multi->step_id == $step->id)
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>بند الصرف</label><span style="color: red;">  *</span>
                            <input type="text" class="form-control" required name="item_name[]"  value="{{ $multi->item_name }}" readonly>
                            @error('item_name')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>قيمة البند</label><span class="text-danger">*</span>
                            <input type="text" class="form-control item-value" name="item_value[]" value="{{ $multi->item_value }}" readonly>
                            @error('item_value')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        <hr>
    @endforeach
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>مجموع التكاليف المباشرة</label><span style="color: red;">  *</span>
                <input type="text" class="form-control" required name="total"  value="{{ $project->total }}" readonly>
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
                <input type="text" class="form-control" name="management" id="management" value="{{ $indirect_costs->management }}" required
                       placeholder=" المصروفات الإدارية..." readonly>
                @error('management')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> التكاليف الغير مباشرة </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="indirect_costs" id="indirect_costs" value="{{ $indirect_costs->indirect_costs }}" readonly
                       placeholder="  التكاليف الغير مباشرة...">
                @error('indirect_costs')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> إجمالي التكاليف المباشرة والغير مباشرة</label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="total_costs" id="total_costs" value="{{ $indirect_costs->total_costs }}" readonly
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
                <label> فائدة المرابحة الشهرية (%) </label><span style="color: red;"> *</span>
                <input type="text" class="form-control" name="monthly_benefit" id="monthly_benefit" value="{{ $indirect_costs->monthly_benefit }}"
                       placeholder="فائدة المرابحة الشهرية..." readonly>
                @error('monthly_benefit')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label> الفترة بالشهر </label><span style="color: red;"> *</span>
                <input type="text" class="form-control" name="per_month" id="per_month" value="{{ $indirect_costs->per_month }}"
                       placeholder=" الفترة بالشهر..." readonly>
                @error('per_month')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label> إجمالي النسبة </label><span style="color: red;"> *</span>
                <input type="text" class="form-control" name="percentage_total" id="percentage_total" value="{{ $indirect_costs->percentage_total }}"
                       placeholder="إجمالي النسبة..." readonly>
                @error('percentage_total')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> قيمة المرابحة </label><span style="color: red;"> *</span>
                <input type="text" class="form-control" name="benefit_value" id="benefit_value" value="{{ $indirect_costs->benefit_value }}"
                       placeholder=" قيمة المرابحة..." readonly>
                @error('benefit_value')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> إجمالي تكاليف المشروع </label><span style="color: red;"> *</span>
                <input type="text" class="form-control" name="total_project_costs" id="total_project_costs" value="{{ $indirect_costs->total_project_costs }}"
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
                <input type="text" class="form-control" name="target_profit_percentage" id="target_profit_percentage" value="{{ $indirect_costs->target_profit_percentage }}"
                       placeholder=" نسبة الربح المستهدف..." readonly>
                @error('target_profit_percentage')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label> قيمة الربح المستهدف </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="target_profit_value" id="target_profit_value" value="{{ $indirect_costs->target_profit_value }}"
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
                <input type="text" class="form-control" name="actual_profit_percentage" id="actual_profit_percentage" value="{{ $indirect_costs->actual_profit_percentage }}"
                       placeholder="  نسبة الربح الفعلية..." readonly>
                @error('actual_profit_percentage')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> قيمة الربح الفعلية </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="actual_profit_value" id="actual_profit_value" value="{{ $indirect_costs->actual_profit_value }}"
                       placeholder=" قيمة الربح الفعلية..." readonly>
                @error('actual_profit_value')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>  إجمالي قيمة المشروع  </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="total_project_value" id="total_project_value" value="{{ $indirect_costs->total_project_value }}"
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
            <h2> الصافي </h2>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label> صافي قيمة المشروع قبل الضريبة </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="before_tax" id="before_tax" value="{{ $indirect_costs->before_tax }}"
                       placeholder="  قبل الضريبة..." readonly>
                @error('before_tax')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> ضريبة القيمة المضافة </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="value_tax" id="value_tax" value="{{ $indirect_costs->value_tax }}"
                       placeholder="   ضريبة القيمة المضافة..." readonly>
                @error('value_tax')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> صافي قيمة المشروع بعد الضريبة </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="after_tax" id="after_tax" value="{{ $indirect_costs->after_tax }}"
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
                    <textarea id="description" name="description"  class="form-control" readonly
                              placeholder="ملاحظات...">{{ $project->description }}</textarea>
                </div>
            </div>
        </div>
    </div>
    <br>
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
                <label>تاريخ فتح المشروع</label>
                <input type="date" class="form-control" id="dateInput" value="{{ $openProject->date }}" readonly name="date">
                @error('date')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>تاريخ بداية المشروع</label>
                <input type="date" class="form-control" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                       id="startDateInput" value="{{ $openProject->start_date }}" readonly name="start_date">
                @error('start_date')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>تاريخ نهاية المشروع</label>
                <input type="date" class="form-control" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                       readonly name="end_date" value="{{ $openProject->end_date }}" id="endDateInput" onchange="validateEndDate()">
                @error('end_date')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>مدة المشروع بالأيام</label>
                <input type="text" class="form-control" required name="project_days" value="{{ $openProject->project_days }}"
                       id="daysInput" placeholder="مدة المشروع بالأيام ..."
                       readonly>
                @error('project_days')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>نوع العميل</label>
                <input type="text" class="form-control" name="customer_type" value="{{ $openProject->customer_type }}"
                       readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>اسم العميل</label>
                <input type="text" class="form-control" name="customer_name" id="customerNameInput" readonly
                       value="{{ $openProject->customer_name }}" placeholder="اسم العميل...">
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
                <input type="text" class="form-control" name="benefit" id="benefitInput" readonly
                       value="{{ $openProject->benefit }}" placeholder="الجهة المستفيدة...">
                @error('benefit')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label> كود المشروع</label>
                <input type="text" class="form-control" readonly name="project_code"
                       value="{{ $openProject->project_code }}" placeholder=" كود المشروع...">
                @error('project_code')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        @cannot('اعتماد المدير المالي لبدء المشروع')
            <div class="col-md-6">
                <div class="form-group">
                    <label>مسودة العرض فني</label>
                    <a href="{{ asset($openProject->art_show) }}" class="btn btn-primary btn-sm">تحميل  <i class="fa fa-download" aria-hidden="true"></i></a>
                </div>
            </div>
        @endcannot
        <div class="col-md-6">
            <div class="form-group">
                <h5> الموظفين </h5>
                <div class="controls">
                    @foreach($project_users as $item)
                        <div class="checkbox" style="display: inline-block; margin-right: 10px;">
                            <label>
                                <input type="checkbox" name="user_name[]" value="{{ $item->user_name }}" checked disabled>
                                {{ $item->user_name }}
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
                <label>مسودة العرض مالي</label>
                <a href="{{ asset($openProject->finance_show) }}" class="btn btn-primary btn-sm">تحميل  <i class="fa fa-download" aria-hidden="true"></i></a>
            </div>
        </div>
        @endcannot
        <div class="col-md-6">
            <div class="form-group">
                <label> مسودة العقد</label>
                <a href="{{ asset($openProject->draft_show) }}" class="btn btn-primary btn-sm">تحميل  <i class="fa fa-download" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="form-group">
                    <label for="order_name">ملاحظات</label>
                    <textarea id="description" name="description"  class="form-control" placeholder="ملاحظات..." readonly>{{ $openProject->description }}</textarea>
                </div>
            </div>
        </div>
    </div>
    <br>
    <hr>
    @cannot('اعتماد القانونية للمشروع')
    <div class="row">
        <div class="col text-center">
            <h2>بدء مشروع </h2>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>تاريخ بدء المشروع</label><span style="color: red;">  *</span>
                <input type="date" class="form-control" value="{{ $start_project->date }}" required name="date" readonly>
                @error('date')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
        @cannot('اعتماد المدير المالي لبدء المشروع')
            <div class="col-md-6">
                <div class="form-group">
                    <label> العرض الفني الموقع</label><span style="color: red;">  *</span>
                    <a href="{{ asset($start_project->art_show) }}" class="btn btn-primary btn-sm">تحميل  <i class="fa fa-download" aria-hidden="true"></i></a>
                </div>
            </div>
        @endcannot
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>  العرض المالي الموقع</label><span style="color: red;">  *</span>
                <a href="{{ asset($start_project->finance_show) }}" class="btn btn-primary btn-sm">تحميل  <i class="fa fa-download" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label> العقد الموقع</label><span style="color: red;">  *</span>
                <a href="{{ asset($start_project->draft_show) }}" class="btn btn-primary btn-sm">تحميل  <i class="fa fa-download" aria-hidden="true"></i></a>
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
    <div class="main-form mt-3 border-bottom">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group mb-2">
                    <label>رقم الدفعة</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="batch_number[]" readonly value="{{ $multi->batch_number }}">
                    @error('batch_number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-2">
                    <label>قيمة الدفعة</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="batch_value[]" readonly value="{{ $multi->batch_value }}">
                    @error('batch_value')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-2">
                    <label>تاريخ الاستحقاق</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" name="due_date[]" readonly value="{{ $multi->due_date }}">
                    @error('due_date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="row">
        <div class="col-md-3">
            <div class="form-group mb-2">
                <label>مجموع الدفعات</label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="total" readonly value="{{ $start_project->total }}">
                @error('total')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <br>
    @can('اعتماد المدير لفتح المشروع')
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="{{ route('project.update.manager', $project->id) }}">
                    @csrf
                    <input type="hidden" name="openProject_user_id" value="{{ $openProject->user_id }}">
                    <div class="form-group">
                        <label for="project_name">مدير المشروع </label><span style="color: red;"> *</span>
                        <select name="user_id" class="form-control">
                            <option value="" selected="" disabled="">مدير المشروع</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id == $project->user_id ? 'selected' : ''}}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <input type="submit" class="btn btn-primary" value=" إسناد المشروع">
                </form>
            </div>
        </div>
    @endcan
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="form-group">
                    <label for="order_name">ملاحظات</label>
                    <textarea id="description" name="description" readonly class="form-control">{{ $start_project->description }}</textarea>
                </div>
            </div>
        </div>
    </div>

    @endcannot

    <br>

    <div class="d-flex justify-content-center" style="gap: 1rem;">
        @if($openProject->status_id == 4)
            @can('اعتماد المدير المالي لبدء المشروع')
                <a href="{{ route('project.approved.sure', $openProject->id) }}" class="btn btn-success" id="sure"> معتمد </a>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_modal_1">
                    غير معتمد
                </button>
            @endcan
            <button class="btn btn-secondary" disabled> في انتظار المدير المالي <i class="far fa-clock" aria-hidden="true"></i></button>
            <a href="{{ route('open.project.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($openProject->status_id == 5)
            @can('اعتماد المدير لبدء المشروع')
                <a href="{{ route('project.approvedManager.sure', $openProject->id) }}" class="btn btn-success" id="sure"> معتمد </a>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_modal_1">
                    غير معتمد
                </button>
            @endcan
            <button class="btn btn-secondary" disabled> في انتظار المدير <i class="far fa-clock" aria-hidden="true"></i></button>
            <a href="{{ route('open.project.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($openProject->status_id == 12)
            <button class="btn btn-danger" disabled> غير معتمد</button>
            <a href="{{ route('open.project.back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($openProject->status_id == 6)
            <a href="{{ route('price.sure', $project->id) }}" class="btn btn-success" id="sure"> معتمد </a>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_modal_1">
                غير معتمد
            </button>
            <button class="btn btn-secondary" disabled> في الانتظار <i class="far fa-clock" aria-hidden="true"></i></button>
            <button class="btn btn-success" disabled> تم اعتماد المدير المالي</button>
            <a href="{{ route('back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($openProject->status_id == 7)
            <a href="{{ route('add.project.open', $project->id) }}" class="btn btn-secondary">  فتح مشروع  </a>
            <button class="btn btn-success" disabled> تم اعتماد المدير </button>
            <a href="{{ route('open.project.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>

        @elseif($openProject->status_id == 13)
            <button class="btn btn-success" disabled> تم اعتماد المشروع </button>
            <a href="{{ route('open.project.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>

        @endif
    </div>
    <br>
    <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel"><strong> سبب عدم الاعتماد</strong></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('project.approved.reject', $openProject->id) }}">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <textarea id="description" name="reject_reason" required class="form-control" placeholder="السبب..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">عدم الاعتماد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
