@extends('main_master')
@section('title')
     تكرار التسعيرة
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> تسعير المشاريع </h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ تكرار التسعيرة </span>
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
                    <input type="date" class="form-control" id="dateInput" value="{{ $project->date }}"
                           min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required name="date">
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
                    <label>اختيار القسم </label><span class="text-danger"> *</span>
                    <div class="controls">
                        <select name="section_name" class="form-control">
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
                           placeholder="رقم التسعيرة ..." value="{{ $formattedPriceNumber }}" readonly>
                    @error('price_number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
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
            @foreach($steps as $key => $step)
                @php
                $number_step = App\Models\MultiProject::where('project_id', $project->id)
                ->where('step_id', $step->id)->count();
                @endphp
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>اسم المرحلة</label><span style="color: red;">  *</span>
                            <input type="hidden" value="{{ $number_step }}" id="step{{ $key+1 }}" name="number_step[]">
                            <input type="text" class="form-control" required name="step_name[]"
                                   value="{{ $step->step_name }}" placeholder="اسم المرحلة...">
                        </div>
                    </div>
                </div>
                <div class="items-container mt-5" id="stepitems{{ $key+1 }}">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>
                                <a href="javascript:void(0)" class="add-item float-right btn btn-primary" id="stepitemsclick,{{ $key+1 }}" onclick="addItem({{ $key+1 }})">أضف بند</a>
                            </h4>
                        </div>
                    </div>
                    @foreach($multi_project as $innerKey  => $multi)
                        @if($multi->step_id == $step->id)
                            <div class="row" >
                                <div class="col-md-3" id="itemNameContainer">
                                    <div class="form-group">
                                        <label>بند الصرف</label><span style="color: red;"> *</span>
                                        <select name="item_name[]" class="form-control" id="travel_arriveVia" onchange="toggleOtherOption(this)">
                                            <option value="" selected="" disabled="">اختيار بند الصرف</option>
                                            <option value="مدربين" @if($multi->item_name === 'مدربين') selected @endif>مدربين</option>
                                            <option value="مستشارين" @if($multi->item_name === 'مستشارين') selected @endif>مستشارين</option>
                                            <option value="سكن" @if($multi->item_name === 'سكن') selected @endif>سكن</option>
                                            <option value="طيران" @if($multi->item_name === 'طيران') selected @endif>طيران</option>
                                            <option value="مطبوعات" @if($multi->item_name === 'مطبوعات') selected @endif>مطبوعات</option>
                                            <option value="انتدابات" @if($multi->item_name === 'انتدابات') selected @endif>انتدابات</option>
                                            <option value="قاعات" @if($multi->item_name === 'قاعات') selected @endif>قاعات</option>
                                            <option value="مواصلات" @if($multi->item_name === 'مواصلات') selected @endif>مواصلات</option>
                                            <option value="اختبارات" @if($multi->item_name === 'اختبارات') selected @endif>اختبارات</option>
                                            <option value="تغطية إعلامية" @if($multi->item_name === 'تغطية إعلامية') selected @endif>تغطية إعلامية</option>
                                            <option value="تصاميم" @if($multi->item_name === 'تصاميم') selected @endif>تصاميم</option>
                                            <option value="منسقين" @if($multi->item_name === 'منسقين') selected @endif>منسقين</option>
                                            <option value="اعتمادات" @if($multi->item_name === 'اعتمادات') selected @endif>اعتمادات</option>
                                            <option value="اشتراكات تقنية" @if($multi->item_name === 'اشتراكات تقنية') selected @endif>اشتراكات تقنية</option>
                                            <option value="ميسر ورشة" @if($multi->item_name === 'ميسر ورشة') selected @endif>ميسر ورشة</option>
                                            <option value="مقدم" @if($multi->item_name === 'مقدم') selected @endif>مقدم</option>
                                            <option value="ترجمة" @if($multi->item_name === 'ترجمة') selected @endif>ترجمة</option>
                                            <option value="شراء حقوق" @if($multi->item_name === 'شراء حقوق') selected @endif>شراء حقوق</option>
                                            <option value="تسويق" @if($multi->item_name === 'تسويق') selected @endif>تسويق</option>
                                            <option value="هدايا" @if($multi->item_name === 'هدايا') selected @endif>هدايا</option>
                                            <option value="{{ $multi->item_name }}" @if($multi->item_name === $multi->item_name) selected @endif>
                                                {{ $multi->item_name }}</option>
                                            <option value="أخرى">أخرى</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>قيمة البند</label><span class="text-danger"> *</span>
                                        <input type="number" class="form-control item-value" name="item_value[]"
                                               value="{{ $multi->item_value }}" placeholder="قيمة البند..." required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <br>
                                        <!-- Add a unique identifier for each remove button -->
                                        <button type="button" class="remove-btn btn btn-danger" data-step="{{ $key+1 }}" data-item="{{ $innerKey }}" onclick="removeItem(event)" id="btnremove{{ $key+1 }}_{{ $innerKey }}">إزالة</button>                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-4">

                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <hr>
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-3">
            </div>

            <div class="col-md-2">
                <h4>
                    <a href="javascript:void(0)" class="add-more-step float-right btn btn-primary">أضف مرحلة</a>
                </h4>
            </div>

        </div>
        <br>
        <div class="paste-new-forms">

        </div>

        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>مجموع التكاليف المباشرة</label><span style="color: red;">  *</span>
                    <input type="number" class="form-control" required name="total" id="total"
                           value="{{ $project->total }}" placeholder="مجموع التكاليف المباشرة..." readonly>
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
                    <input type="number" class="form-control" name="management" id="management" required
                           value="{{ $indirect_costs->management }}" placeholder=" المصروفات الإدارية...">
                    @error('management')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label> التكاليف الغير مباشرة </label><span style="color: red;">  *</span>
                    <input type="number" class="form-control" name="indirect_costs" id="indirect_costs" required readonly
                           value="{{ $indirect_costs->indirect_costs }}" placeholder="  التكاليف الغير مباشرة...">
                    @error('indirect_costs')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label> إجمالي التكاليف المباشرة والغير مباشرة</label><span style="color: red;">  *</span>
                    <input type="number" class="form-control" name="total_costs" id="total_costs" required readonly
                           value="{{ $indirect_costs->total_costs }}" placeholder="إجمالي التكاليف المباشرة والغير مباشرة...">
                    @error('total_costs')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-center">
            <button class="btn btn-danger" id="toggleButton"> تفعيل تكلفة التمويل</button>
        </div>
        <br>
        <div id="formContainer" style="display: block;">
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
                        <input type="number" class="form-control" name="monthly_benefit" id="monthly_benefit"
                               value="{{ $indirect_costs->monthly_benefit }}" placeholder="فائدة المرابحة الشهرية...">
                        @error('monthly_benefit')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label> الفترة بالشهر </label><span style="color: red;"> *</span>
                        <input type="number" class="form-control" name="per_month" id="per_month"
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
                        <label> إجمالي النسبة </label><span style="color: red;"> *</span>
                        <input type="number" class="form-control" name="percentage_total" id="percentage_total"
                               value="{{ $indirect_costs->percentage_total }}" placeholder="إجمالي النسبة..." readonly>
                        @error('percentage_total')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label> قيمة المرابحة </label><span style="color: red;"> *</span>
                        <input type="number" class="form-control" name="benefit_value" id="benefit_value"
                               value="{{ $indirect_costs->benefit_value }}" placeholder=" قيمة المرابحة..." readonly>
                        @error('benefit_value')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label> إجمالي تكاليف المشروع </label><span style="color: red;"> *</span>
                        <input type="hidden" name="total_project_costs_manual" id="total_project_costs_manual">
                        <input type="number" class="form-control" name="total_project_costs" id="total_project_costs"
                               value="{{ $indirect_costs->total_project_costs }}" placeholder="إجمالي تكاليف المشروع..." readonly>
                        @error('total_project_costs')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
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
                    <input type="number" class="form-control" name="target_profit_percentage" id="target_profit_percentage" required
                           value="{{ $indirect_costs->target_profit_percentage }}" placeholder=" نسبة الربح المستهدف...">
                    @error('target_profit_percentage')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> قيمة الربح الفعلية </label><span style="color: red;">  *</span>
                    <input type="number" class="form-control" name="actual_profit_value" id="actual_profit_value" required
                           value="{{ $indirect_costs->actual_profit_value }}" placeholder=" قيمة الربح الفعلية..." readonly>
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
                    <input type="number" class="form-control" name="before_tax" id="before_tax" required
                           value="{{ $indirect_costs->before_tax }}" placeholder="  قبل الضريبة..." readonly>
                    @error('before_tax')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label> ضريبة القيمة المضافة </label><span style="color: red;">  *</span>
                    <input type="number" class="form-control" name="value_tax" id="value_tax" required
                           value="{{ $indirect_costs->value_tax }}" placeholder="   ضريبة القيمة المضافة..." readonly>
                    @error('value_tax')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label> صافي قيمة المشروع بعد الضريبة </label><span style="color: red;">  *</span>
                    <input type="number" class="form-control" name="after_tax" id="after_tax" required
                           value="{{ $indirect_costs->after_tax }}" placeholder="  بعد الضريبة..." readonly>
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
                        <textarea id="description" name="description"  class="form-control" placeholder="ملاحظات...">{{ $project->description }}</textarea>
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
