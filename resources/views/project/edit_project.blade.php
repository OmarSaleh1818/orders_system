@extends('main_master')
@section('title')
    تعديل المشروع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">مدير المشروع</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ تعديل المشروع </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <form method="post" action="{{ route('project.update', $project->id) }}">
        @csrf
        <div class="row">
            @if($project->status_id == 2)
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="order_name">السبب من عدم اعتماد </label>
                            <textarea id="description" name="manager_reason"  class="form-control"  readonly>{{ $projectManager->manager_reason }}</textarea>
                        </div>
                    </div>
                </div>
            @endif
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
                    <input type="date" class="form-control" value="{{ $project->date }}" required name="date">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم المشروع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="project_name" value="{{ $project->project_name }}" placeholder="اسم المشروع...">
                    @error('project_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اختيار القسم </label><span class="text-danger">*</span>
                    <div class="controls">
                        <select name="section_name" class="form-control" id="section_name">
                            <option value="" selected="" disabled="">اختيار القسم </option>
                            @foreach($sections as $item)
                                <option value="{{ $item->section_name }}" {{ $item->section_name == $project->section_name
                                         ? 'selected' : ''}}>{{ $item->section_name }}</option>
                            @endforeach

                        </select>
                        @error('section_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>رقم التسعيرة</label><span style="color: red;"> *</span>
                    <input type="text" class="form-control" required name="price_number" id="priceNumberInput"
                           placeholder="رقم التسعيرة ..." value="{{ $project->price_number }}" readonly>
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
        @foreach($steps as $key => $step)
            <input type="hidden" name="step[]" value="{{$step->id }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اسم المرحلة</label><span style="color: red;">  *</span>
                        <input type="text" class="form-control" required name="step_name[]" value="{{ $step->step_name }}">
                        @error('step_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            @foreach($multi_project as $key => $multi)
                @if($multi->step_id == $step->id)
                    <input type="hidden" name="multi[]" value="{{$multi->id }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>بند الصرف</label><span style="color: red;">  *</span>
                                <input type="text" class="form-control" required name="item_name[]"  value="{{ $multi->item_name }}">
                                @error('item_name')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>قيمة البند</label><span class="text-danger">*</span>
                                <input type="text" class="form-control item-value" name="item_value[]" value="{{ $multi->item_value }}">
                                @error('item_value')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label> تاريخ الاستحقاق</label><span class="text-danger">*</span>
                                <input type="date" class="form-control item-value" name="due_date[]" value="{{ $multi->due_date }}">
                                @error('due_date')
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
                    <input type="text" class="form-control" required name="total" id="total" value="{{ $project->total }}" placeholder="مجموع التكاليف المباشرة..." readonly>
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
                           placeholder=" المصروفات الإدارية...">
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
                           placeholder="فائدة المرابحة الشهرية..." >
                    @error('monthly_benefit')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> الفترة بالشهر </label><span style="color: red;"> *</span>
                    <input type="text" class="form-control" name="per_month" id="per_month" value="{{ $indirect_costs->per_month }}"
                           placeholder=" الفترة بالشهر..." >
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
                           placeholder="  نسبة الربح الفعلية..." >
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
                        <textarea id="description" name="description"  class="form-control"
                                  placeholder="ملاحظات...">{{ $project->description }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="d-flex justify-content-center" style="gap: 1rem;">
            <input type="submit" class="btn btn-success" value=" حفظ و إرسال">
            <a href="{{ route('back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        </div>
        <br>
    </form>


    <script>
        // // Calculate total when an item_value input changes
        // $(document).on('input', '.item-value', function () {
        //     updateTotal();
        // });
        //
        // // Calculate total initially
        // updateTotal();
        //
        // function updateTotal() {
        //     var total = 0;
        //     $('.item-value').each(function () {
        //         var value = parseFloat($(this).val()) || 0;
        //         total += value;
        //     });
        //     $('#total').val(total);
        // }
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
