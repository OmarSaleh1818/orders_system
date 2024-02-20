@extends('main_master')
@section('title')
    عرض المشروع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">  المدير المالي</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ عرض المشروع </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    @if(Session()->has('status'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>{{ Session()->get('status') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
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
                <label>المجموع</label><span style="color: red;">  *</span>
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
                <input type="text" class="form-control" name="management" id="management" required readonly
                       value="{{ $indirect_costs->management }}" placeholder=" المصروفات الإدارية...">
                @error('management')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> التكاليف الغير مباشرة </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="indirect_costs" id="indirect_costs" required readonly
                       value="{{ $indirect_costs->indirect_costs }}" placeholder="  التكاليف الغير مباشرة...">
                @error('indirect_costs')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> إجمالي التكاليف المباشرة والغير مباشرة</label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="total_costs" id="total_costs" required readonly
                       value="{{ $indirect_costs->total_costs }}" placeholder="إجمالي التكاليف المباشرة والغير مباشرة...">
                @error('total_costs')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>  تكلفة التمويل </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="cost_finance" required readonly
                       value="{{ $indirect_costs->discount_value }}" placeholder=" تكلفة التمويل...">
                @error('cost_finance')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> فائدة المرابحة الشهرية </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="monthly_benefit" required readonly
                       value="{{ $indirect_costs->monthly_benefit }}" placeholder="فائدة المرابحة الشهرية...">
                @error('monthly_benefit')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>  الفترة بالشهر </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="per_month" required readonly
                       value="{{ $indirect_costs->per_month }}" placeholder=" الفترة بالشهر...">
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
                <input type="text" class="form-control" name="percentage_total" required readonly
                       value="{{ $indirect_costs->percentage_total }}" placeholder="إجمالي النسبة...">
                @error('percentage_total')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> قيمة المرابحة </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="benefit_value" required readonly
                       value="{{ $indirect_costs->benefit_value }}" placeholder=" قيمة المرابحة...">
                @error('benefit_value')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> إجمالي تكاليف المشروع </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="total_project_costs" required readonly
                       value="{{ $indirect_costs->total_project_costs }}" placeholder="إجمالي تكاليف المشروع...">
                @error('total_project_costs')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>  نسبة الربح المستهدف  </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="target_profit_percentage" required readonly
                       value="{{ $indirect_costs->target_profit_percentage }}" placeholder=" نسبة الربح المستهدف...">
                @error('target_profit_percentage')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> قيمة الربح المستهدف </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="target_profit_value" required readonly
                       value="{{ $indirect_costs->target_profit_value }}" placeholder=" قيمة الربح المستهدف...">
                @error('target_profit_value')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>  نسبة الربح الفعلية </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="actual_profit_percentage" required readonly
                       value="{{ $indirect_costs->actual_profit_percentage }}" placeholder="  نسبة الربح الفعلية...">
                @error('actual_profit_percentage')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label> قيمة الربح الفعلية </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="actual_profit_value" required readonly
                       value="{{ $indirect_costs->actual_profit_value }}" placeholder=" قيمة الربح الفعلية...">
                @error('actual_profit_value')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>  إجمالي قيمة المشروع  </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="total_project_value" required readonly
                       value="{{ $indirect_costs->total_project_value }}" placeholder="  إجمالي قيمة المشروع...">
                @error('total_project_value')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> خصم خاص </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="private_discount" required readonly
                       value="{{ $indirect_costs->private_discount }}" placeholder="   خصم خاص...">
                @error('private_discount')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label> صافي قيمة المشروع قبل الضريبة </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="before_tax" required readonly
                       value="{{ $indirect_costs->before_tax }}" placeholder="  قبل الضريبة...">
                @error('before_tax')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> ضريبة القيمة المضافة </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="value_tax" required readonly
                       value="{{ $indirect_costs->value_tax }}" placeholder="   ضريبة القيمة المضافة...">
                @error('value_tax')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> صافي قيمة المشروع بعد الضريبة </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="after_tax" required readonly
                       value="{{ $indirect_costs->after_tax }}" placeholder="  بعد الضريبة...">
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

    <div class="row">
        <div class="col-md-6">
            <form method="post" action="{{ route('project.update.manager', $project->id) }}">
                @csrf
                <div class="form-group">
                    <label for="project_name">مدير المشروع </label><span style="color: red;"> *</span>
                    <select name="user_id" class="form-control">
                        <option value="" selected="" disabled="">مدير المشروع</option>
                        @php
                            $multisection = App\Models\MultiSections::where('section_name', $project->section_name)->get();
                        @endphp
                        @foreach ($multisection as $section)
                            <option value="{{ $section->user_id }}" {{ $section->user_id == $project->user_id ? 'selected' : ''}}>
                                {{ $section['sections']['name'] }}
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

    <br>
    <div class="d-flex justify-content-center" style="gap: 1rem;">
        @if($project->status_id == 1)
            <a href="{{ route('project.sure', $project->id) }}" class="btn btn-success" id="sure"> معتمد </a>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_modal_1">
                غير معتمد
            </button>
            <a href="{{ route('project.back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($project->status_id == 2)
            <td> <button class="btn btn-danger" disabled> غير معتمد</button></td>
            <a href="{{ route('project.back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($project->status_id == 6)
            <td> <button class="btn btn-success" disabled> تم الاعتماد</button></td>
            <a href="{{ route('project.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
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
                <form method="post" action="{{ route('project.reject', $project->id) }}">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <textarea id="description" name="manager_reason" required class="form-control" placeholder="السبب..."></textarea>
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
