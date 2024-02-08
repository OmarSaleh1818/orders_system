@extends('main_master')
@section('title')
    عرض المشروع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> المدير المالي</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ عرض المشروع </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
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
                <label>تاريخ بداية المشروع</label><span style="color: red;"> *</span>
                <input type="date" class="form-control" value="{{ $project->start_date }}" readonly name="start_date">
                @error('startDate')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>تاريخ نهاية المشروع</label><span style="color: red;"> *</span>
                <input type="date" class="form-control" value="{{ $project->end_date }}" readonly>
                @error('endDate')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>مدة المشروع بالأيام</label><span style="color: red;"> *</span>
                <input type="text" class="form-control" name="project_days" value="{{ $project->project_days }}"
                       readonly>
                @error('days')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
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
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>نوع العميل</label><span style="color: red;">*</span>
                <div class="controls">
                    <select name="customer_type" class="form-control" >
                        <option value="" selected disabled>نوع العميل</option>
                        <option value="مانح" disabled {{ $project->customer_type === 'مانح' ? 'selected' : '' }}>مانح</option>
                        <option value="حكومي" disabled {{ $project->customer_type === 'حكومي' ? 'selected' : '' }}>حكومي</option>
                        <option value="أهلي" disabled {{ $project->customer_type === 'أهلي' ? 'selected' : '' }}>أهلي</option>
                        <option value="أفراد" disabled {{ $project->customer_type === 'أفراد' ? 'selected' : '' }}>أفراد</option>
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
                <input type="text" class="form-control" name="customer_name" value="{{ $project->customer_name }}" readonly>
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
                <input type="text" class="form-control" name="benefit" value="{{ $project->benefit }}" readonly>
                @error('benefit')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label> القسم </label><span class="text-danger">*</span>
                <div class="controls">
                    <select name="section_name" class="form-control">
                        <option value="" selected="" disabled="">اختيار القسم </option>
                        @foreach($sections as $item)
                            <option value="{{ $item->section_name }}" {{ $item->section_name == $project->section_name
                                         ? 'selected' : ''}} disabled="">{{ $item->section_name }}</option>
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
                <input type="text" class="form-control" required name="project_code" readonly value="{{ $project->project_code }}">
                @error('project_code')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label> الموظفين </label><span class="text-danger">*</span>
                <div class="controls">
                    <select name="user_name[]" multiple="multiple" class="form-control">
                        @foreach($project_users as $users)
                            <option value="{{ $users->user_name }}" disabled>{{ $users->user_name }}</option>
                        @endforeach
                    </select>
                    @error('section_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <hr>
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
                <label>المجموع</label><span style="color: red;">  *</span>
                <input type="text" class="form-control" required name="total"  value="{{ $project->total }}" readonly>
                @error('total')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>

    </div>

    <br>
    <div class="d-flex justify-content-center" style="gap: 1rem;">
        @if($project->status_id == 1)
            <button class="btn btn-secondary" disabled> في الانتظار <i class="far fa-clock" aria-hidden="true"></i></button>
            <a href="{{ route('back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($project->status_id == 2)
            <button class="btn btn-danger" disabled> غير معتمد</button>
            <a href="{{ route('back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($project->status_id == 6)
            <button class="btn btn-success" disabled> تم الاعتماد</button>
            <a href="{{ route('back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @endif
    </div>
    <br>

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

@endsection
