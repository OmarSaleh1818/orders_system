@extends('main_master')
@section('title')
    تعديل تسعيرة
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> تسعير المشاريع </h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ تعديل تسعيرة </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <form method="post" action="{{ route('project.update', $project->id) }}" id="myForm">
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
                    <input type="date" class="form-control" value="{{ $project->date }}" id="dateInput"
                           min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" required name="date">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم المشروع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="project_name"
                           value="{{ $project->project_name }}" placeholder="اسم المشروع...">
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
                           placeholder="رقم التسعيرة ..." value="{{ $project->price_number }}" readonly>
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
                <div class="items-container mt-5" id="stepitems{{ $step->id }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>اسم المرحلة</label><span style="color: red;"> *</span>
                                <input type="hidden" value="{{ $step->id }}" name="step_id[]">
                                <input type="text" class="form-control" required name="step_name[]" value="{{ $step->step_name }}" placeholder="اسم المرحلة...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="remove-step btn btn-danger ml-2" data-step="{{ $step->id }}">إزالة المرحلة</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h4>
                                <a href="javascript:void(0)" class="add-item float-right btn btn-primary" id="stepitemsclick,{{ $step->id }}" onclick="addItem({{ $step->id }})">أضف بند</a>
                            </h4>
                        </div>
                    </div>
                    @foreach($multi_project as $innerKey => $multi)
                        @if($multi->step_id == $step->id)
                            <div class="row item-row">
                                <input type="hidden" name="item_id[]" value="{{ $multi->id }}">
                                <input type="hidden" name="step_item_id[]" value="{{ $step->id }}">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>بند الصرف</label><span style="color: red;"> *</span>
                                        <select name="item_name[]" required class="form-control" onchange="toggleOtherOption(this)">
                                            <option value="" selected disabled>اختيار بند الصرف</option>
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
                                    <div class="form-group other-item-name" style="display:none;">
                                        <input type="text" class="form-control" name="other_item_name[]" placeholder="اسم البند الآخر...">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>قيمة البند</label><span class="text-danger"> *</span>
                                        <input type="text" class="form-control item-value" name="item_value[]" value="{{ $multi->item_value }}" required placeholder="قيمة البند..." oninput="validateNumber(this)">
                                    </div>
                                </div>
                                <!-- <div class="col-md-2">
                                    <div class="form-group">
                                        <br>
                                        <button type="button" class="remove-item btn btn-danger" data-item="{{ $multi->id }}">إزالة</button>
                                    </div>
                                    <hr>
                                </div> -->
                            </div>
                        @endif
                    @endforeach
                </div>
                <hr>
            @endforeach

            <!-- <div class="row">
                <div class="col-md-3">
                    
                </div>
                <div class="col-md-2">
                    <h4>
                        <a href="javascript:void(0)" class="add-more-step float-right btn btn-primary">أضف مرحلة</a>
                    </h4>
                </div>
            </div> -->
            <br>
            <div class="paste-new-forms">
                <!-- New steps will be dynamically added here -->
            </div>

            <!-- Hidden fields for tracking deletions -->
            <input type="hidden" name="deleted_steps" id="deleted_steps" value="">
            <input type="hidden" name="deleted_items" id="deleted_items" value="">
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
                    <input type="text" class="form-control" name="management" id="management" required
                           value="{{ $indirect_costs->management }}" placeholder=" المصروفات الإدارية..." oninput="validateNumber(this)">
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
            <button class="btn btn-danger" id="toggleButton"> إلغاء تكلفة التمويل</button>
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
                        <input type="text" class="form-control" name="monthly_benefit" id="monthly_benefit"
                               value="{{ $indirect_costs->monthly_benefit }}" placeholder="فائدة المرابحة الشهرية..." oninput="validateNumber(this)">
                        @error('monthly_benefit')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label> الفترة بالشهر </label><span style="color: red;"> *</span>
                        <input type="text" class="form-control" name="per_month" id="per_month"
                               value="{{ $indirect_costs->per_month }}" placeholder=" الفترة بالشهر..." oninput="validateNumber(this)">
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
                    <input type="text" class="form-control" name="target_profit_percentage" id="target_profit_percentage" required
                           value="{{ $indirect_costs->target_profit_percentage }}" placeholder=" نسبة الربح المستهدف..." oninput="validateNumber(this)">
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

    let stepCount = 0;
    let deletedSteps = [];
    let deletedItems = [];

    $(document).on('click', '.add-more-step', function () {
        stepCount++;
        let addStep = `
            <div class="items-container mt-5" id="stepitems${stepCount}">
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>اسم المرحلة</label><span style="color: red;"> *</span>
                            <input type="hidden" value="new" name="step_id[]">
                            <input type="text" class="form-control" required name="step_name[]" placeholder="اسم المرحلة...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="remove-step btn btn-danger ml-2" data-step="${stepCount}">إزالة المرحلة</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h4>
                            <a href="javascript:void(0)" class="add-item float-right btn btn-primary" id="stepitemsclick,${stepCount}" onclick="addItem(${stepCount})">أضف بند</a>
                        </h4>
                    </div>
                </div>
            </div>
        `;
        $('.paste-new-forms').append(addStep);
    });

    $(document).on('click', '.remove-step', function () {
        let stepId = $(this).data('step');
        if (stepId !== 'new') {
            deletedSteps.push(stepId);
            $('#deleted_steps').val(deletedSteps.join(','));
        }
        $(this).closest('.items-container').remove();
        stepCount--;
    });

    function addItem(stepId) {
        let itemId = 'new-' + Math.random().toString(36).substring(7);
        let rowToAdd = `
            <div class="row item-row">
                <input type="hidden" name="item_id[]" value="new">
                <input type="hidden" name="step_item_id[]" value="${stepId}">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>بند الصرف</label><span style="color: red;"> *</span>
                        <select name="item_name[]" required class="form-control" onchange="toggleOtherOption(this)">
                            <option value="" selected disabled>اختيار بند الصرف</option>
                            <option value="مدربين">مدربين</option>
                            <option value="مستشارين">مستشارين</option>
                            <option value="سكن">سكن</option>
                            <option value="طيران">طيران</option>
                            <option value="مطبوعات">مطبوعات</option>
                            <option value="انتدابات">انتدابات</option>
                            <option value="قاعات">قاعات</option>
                            <option value="مواصلات">مواصلات</option>
                            <option value="اختبارات">اختبارات</option>
                            <option value="تغطية إعلامية">تغطية إعلامية</option>
                            <option value="تصاميم">تصاميم</option>
                            <option value="منسقين">منسقين</option>
                            <option value="اعتمادات">اعتمادات</option>
                            <option value="اشتراكات تقنية">اشتراكات تقنية</option>
                            <option value="ميسر ورشة">ميسر ورشة</option>
                            <option value="مقدم">مقدم</option>
                            <option value="ترجمة">ترجمة</option>
                            <option value="شراء حقوق">شراء حقوق</option>
                            <option value="تسويق">تسويق</option>
                            <option value="هدايا">هدايا</option>
                            <option value="أخرى">أخرى</option>
                        </select>
                    </div>
                    <div class="form-group other-item-name" style="display:none;">
                        <input type="text" class="form-control" name="other_item_name[]" placeholder="اسم البند الآخر...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>قيمة البند</label><span class="text-danger"> *</span>
                        <input type="text" class="form-control item-value" name="item_value[]" required placeholder="قيمة البند..." oninput="validateNumber(this)">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <br>
                        <button type="button" class="remove-item btn btn-danger" data-item="${itemId}">إزالة</button>
                    </div>
                    <hr>
                </div>
            </div>
        `;
        $(`#stepitems${stepId}`).append(rowToAdd);
    }

    $(document).on('click', '.remove-item', function () {
        let itemId = $(this).data('item');
        if (itemId !== 'new') {
            deletedItems.push(itemId);
            $('#deleted_items').val(deletedItems.join(','));
        }
        $(this).closest('.row').remove();
    });

    function toggleOtherOption(selectElement) {
        let otherItemNameDiv = $(selectElement).closest('.col-md-3').find('.other-item-name');
        if (selectElement.value === 'أخرى') {
            otherItemNameDiv.show();
        } else {
            otherItemNameDiv.hide();
        }
    }

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

        // التكاليف الغير مباشرة

        // Wait for the DOM to load
        document.addEventListener('DOMContentLoaded', function() {
            // Get the input fields
            var totalInput = document.getElementById('total');
            var managementInput = document.getElementById('management');
            var indirectCostsInput = document.getElementById('indirect_costs');
            var totalCosts = document.getElementById('total_costs');
            // Add an event listener to the management input field
            managementInput.addEventListener('input', function() {
                // Get the values from the input fields
                var total = parseFloat(totalInput.value);
                var managementPercentage = parseFloat(managementInput.value) / 100;

                // Calculate the indirect_costs
                var indirectCosts = total * managementPercentage;

                // Check if the calculated value is a valid number
                if (isNaN(indirectCosts)) {
                    // Display an error message or handle the error case
                    indirectCostsInput.value = 'Invalid input';
                } else {
                    // Set the calculated value to the indirect_costs input field
                    indirectCostsInput.value = indirectCosts.toFixed(2);
                    totalCosts.value = (indirectCosts + total).toFixed(2);
                }
            });
        });



        // تكلفة التمويل
        document.addEventListener('DOMContentLoaded', function() {
            // Get the input fields
            var monthlyBenefitInput = document.getElementById('monthly_benefit');
            var perMonthInput = document.getElementById('per_month');
            var percentageTotalInput = document.getElementById('percentage_total');
            var benefitValueInput = document.getElementById('benefit_value');
            var totalProjectCostsInput = document.getElementById('total_project_costs');
            var totalCostsInput = document.getElementById('total_costs');
            var targetProfitPercentageInput = document.getElementById('target_profit_percentage');
            var beforeTaxInput = document.getElementById('before_tax');
            var valueTaxInput = document.getElementById('value_tax');
            var afterTaxInput = document.getElementById('after_tax');
            var actualProfitValueInput = document.getElementById('actual_profit_value');

            // Calculate values function
            function calculateValues() {
                var perMonth = parseFloat(perMonthInput.value) || 0;
                var monthlyBenefit = parseFloat(monthlyBenefitInput.value) || 0;
                var totalCosts = parseFloat(totalProjectCostsInput.value) || 0;
                var targetProfitPercentage = parseFloat(targetProfitPercentageInput.value) || 0;

                var percentageTotal = perMonth * (monthlyBenefit / 100);
                var benefitValue = parseFloat(totalCostsInput.value) * percentageTotal;
                var totalProjectCosts = parseFloat(totalCostsInput.value) + benefitValue;
                var actualProfitValue = totalProjectCosts * (targetProfitPercentage / 100);

                var beforeTax = totalProjectCosts + actualProfitValue;
                var valueTax = beforeTax * 0.15;
                var afterTax = beforeTax + valueTax;


                percentageTotalInput.value = percentageTotal.toFixed(2);
                benefitValueInput.value = benefitValue.toFixed(2);
                totalProjectCostsInput.value = totalProjectCosts.toFixed(2);
                beforeTaxInput.value = beforeTax.toFixed(2);
                valueTaxInput.value = valueTax.toFixed(2);
                afterTaxInput.value = afterTax.toFixed(2);
                actualProfitValueInput.value = actualProfitValue.toFixed(2);
            }

            // Add event listeners
            perMonthInput.addEventListener('input', calculateValues);
            monthlyBenefitInput.addEventListener('input', calculateValues);
            targetProfitPercentageInput.addEventListener('input', calculateValues);
            totalProjectCostsInput.addEventListener('input', calculateValues);
        });


        const toggleButton = document.getElementById('toggleButton');
        const formContainer = document.getElementById('formContainer');
        const inputs = formContainer.querySelectorAll('input[type="number"]:not(#total_project_costs)');
        let totalProjectCostsValue = 0; // Variable to store the total_project_costs value
        const totalCostsInput = document.getElementById('total_costs');
        const targetProfitPercentageInput = document.getElementById('target_profit_percentage');
        const beforeTaxInput = document.getElementById('before_tax');
        const valueTaxInput = document.getElementById('value_tax');
        const afterTaxInput = document.getElementById('after_tax');
        const actualProfitValueInput = document.getElementById('actual_profit_value');

        toggleButton.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent the default form submission behavior
            if (formContainer.style.display === 'none') {
                // Show the form
                formContainer.style.display = 'block';
                toggleButton.classList.remove('btn-primary'); // Remove btn-danger class
                toggleButton.classList.add('btn-danger'); // Add btn-primary class
                toggleButton.innerText = 'إلغاء تكلفة التمويل'; // Change button text
            } else {
                // Hide the form
                formContainer.style.display = 'none';
                toggleButton.classList.remove('btn-danger'); // Remove btn-primary class
                toggleButton.classList.add('btn-primary'); // Add btn-danger class
                toggleButton.innerText = 'تفعيل تكلفة التمويل'; // Change button text
                // Set total_project_costs to total_costs
                document.getElementById('total_project_costs').value = totalProjectCostsValue;
                // Reset other input values to empty string
                inputs.forEach(input => input.value = '');

                // Calculate values based on total_costs
                var totalCosts = parseFloat(totalCostsInput.value) || 0;
                var targetProfitPercentage = parseFloat(targetProfitPercentageInput.value) || 0;

                var actualProfitValue = totalCosts * (targetProfitPercentage / 100);
                var beforeTax = totalCosts + actualProfitValue;
                var valueTax = beforeTax * 0.15;
                var afterTax = beforeTax + valueTax;
                

                beforeTaxInput.value = beforeTax.toFixed(2);
                valueTaxInput.value = valueTax.toFixed(2);
                afterTaxInput.value = afterTax.toFixed(2);
                actualProfitValueInput.value = actualProfitValue.toFixed(2);
            }
        });

        // Save the value of total_project_costs before hiding the form
        document.getElementById('total_costs').addEventListener('input', (event) => {
            totalProjectCostsValue = event.target.value;
        });


</script>
    
@endsection
