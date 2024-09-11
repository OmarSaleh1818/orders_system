@extends('main_master')
@section('title')
    عرض المشروع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">  تسعير المشاريع </h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ عرض المشروع </span>
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
                <label>القسم </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" required name="project_name" value="{{ $project->section_name }}" readonly>
                @error('section_name')
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>بند الصرف</label><span style="color: red;">  *</span>
                            <input type="text" class="form-control" required name="item_name[]"  value="{{ $multi->item_name }}" readonly>
                            @error('item_name')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
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
                <label> قيمة الربح الفعلية </label><span style="color: red;">  *</span>
                <input type="text" class="form-control" name="actual_profit_value" id="actual_profit_value" value="{{ $indirect_costs->actual_profit_value }}"
                       placeholder=" قيمة الربح الفعلية..." readonly>
                @error('actual_profit_value')
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
    @php
        $user_id = Auth::user()->id;
        $manager = App\Models\projects::where('user_id', $user_id)->where('id', $project->id)->first();
    @endphp

    <div class="d-flex justify-content-center" style="gap: 1rem;">
        @if($project->status_id == 1)
            @can('اعتماد المدير المالي للتسعيرة')
                <a href="{{ route('project.sure', $project->id) }}" class="btn btn-success" id="sure"> اعتماد المدير المالي </a>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_modal_1">
                    عدم الاعتماد  
                </button>
            @endcan
            @if($manager)
                <a href="{{ route('project.repeat', $project->id) }}" class="btn btn-primary"> تكرار <i class="fa fa-repeat"></i></a>
                <button class="btn btn-secondary" disabled> في انتظار المدير المالي <i class="far fa-clock" aria-hidden="true"></i></button>
            @endif
            <a href="{{ route('project.pdf', $project->id) }}" class="btn btn-primary"> PDF <i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ route('back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($project->status_id == 2)
            @if($manager)
                <a href="{{ route('project.repeat', $project->id) }}" class="btn btn-primary"> تكرار <i class="fa fa-repeat"></i></a>
            @endif
            <button class="btn btn-danger" disabled> غير معتمد</button>
            <a href="{{ route('project.pdf', $project->id) }}" class="btn btn-primary"> PDF <i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ route('back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($project->status_id == 13)
            @if($manager)
                <a href="{{ route('project.repeat', $project->id) }}" class="btn btn-primary"> تكرار <i class="fa fa-repeat"></i></a>
            @endif
            <button class="btn btn-success" disabled> تم اعتماد المشروع </button>
            <a href="{{ route('project.pdf', $project->id) }}" class="btn btn-primary"> PDF <i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ route('back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($project->status_id == 3)
            @if($manager)
                <a href="{{ route('project.repeat', $project->id) }}" class="btn btn-primary"> تكرار <i class="fa fa-repeat"></i></a>
            @endif
            <button class="btn btn-dark" disabled> تم فتح المشروع </button>
            <a href="{{ route('project.pdf', $project->id) }}" class="btn btn-primary"> PDF <i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ route('back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($project->status_id == 6)
            @can('اعتماد المدير للتسعيرة')
                <a href="{{ route('price.sure', $project->id) }}" class="btn btn-success" id="sure"> اعتماد المدير </a>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_modal_1">
                    عدم الاعتماد
                </button>
            @endcan
            @if($manager)
                <a href="{{ route('project.repeat', $project->id) }}" class="btn btn-primary"> تكرار <i class="fa fa-repeat"></i></a>
                <button class="btn btn-secondary" disabled> في انتظار المدير <i class="far fa-clock" aria-hidden="true"></i></button>
            @endif
            <button class="btn btn-success" disabled> تم اعتماد المدير المالي</button>
            <a href="{{ route('project.pdf', $project->id) }}" class="btn btn-primary"> PDF <i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ route('back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($project->status_id == 7)
            @if($manager)
                <a href="{{ route('project.repeat', $project->id) }}" class="btn btn-primary"> تكرار <i class="fa fa-repeat"></i></a>
                <a href="{{ route('add.project.open', $project->id) }}" class="btn btn-secondary">  فتح مشروع  </a>
            @endif
            <button class="btn btn-success" disabled> تم اعتماد المدير </button>
            <a href="{{ route('project.pdf', $project->id) }}" class="btn btn-primary"> PDF <i class="fa fa-file-pdf-o"></i></a>
            <a href="{{ route('back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
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
