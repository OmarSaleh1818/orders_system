@extends('main_master')
@section('title')
    اضافة طلب صرف
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">طلبات الصرف</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ إضافة طلب صرف </span>
            </div>
        </div>

    </div>
@endsection

@section('content')

        <hr>
        <div class="row">
            <div class="col text-center">
                <h2> طلبات الصرف</h2>
            </div>
        </div>
        <br>
        <div class="d-flex justify-content-center" style="gap: 3rem;">
            <button class="btn btn-primary" id="toggleButton"> تحويل محلي</button>
            <button class="btn btn-secondary" id="toggleButton1"> تحويل دولي</button>
        </div>
        <br>
        <form method="post" action="{{ route('applicant.store') }}">
            @csrf
            <input type="hidden" name="transformation" value="1">
            <div id="formContainer" style="display: none;">
            <hr>
            <div class="row">
                <div class="col text-center">
                    <h2>  تحويل محلي</h2>
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
                        <label for="project_id">اختيار المشروع </label><span style="color: red;">  *</span>
                        <select name="project_id" class="form-control" id="project_name">
                            <option value="" selected="" disabled="">اختيار المشروع</option>
                            @foreach ($projects as $project)
                                @php
                                    $user = Auth::user()->name;
                                    $user_name = App\Models\project_users::where('user_name', $user)->where('project_id', $project->id)->first();
                                @endphp
                                @if($user_name)
                                    <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('project_id')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>رقم طلب الصرف</label><span style="color: red;">  *</span>
                        <input type="text" class="form-control" required name="order_number" id="order_number" readonly>
                        @error('order_number')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" id="section_name_div">
                        <label for="section_name">اسم القسم</label><span style="color: red;">  *</span>
                        <input type="text" name="section_name" class="form-control" id="section_name" readonly>
                        @error('section_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="step_name">اختر المرحلة</label><span style="color: red;">  *</span>
                        <select name="step_name" class="form-control" id="step_name">
                            <option value="" selected="" disabled=""> اختر المرحلة...</option>
                            <!-- Options for item_name will be populated dynamically with JavaScript -->
                        </select>
                        @error('step_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="item_name">اختر البند</label><span style="color: red;">  *</span>
                        <select name="item_name" class="form-control" id="item_name">
                            <option value="" selected="" disabled="">اختر البند...</option>
                            <!-- Options for item_name will be populated dynamically with JavaScript -->
                        </select>
                        @error('item_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="item_value">قيمة البند</label>
                        <input type="text" class="form-control" name="item_value" id="item_value" readonly>
                        @error('item_value')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="remaining_value"> المتبقي من قيمة البند </label>
                        <input type="text" class="form-control" name="remaining_value" id="remaining_value" readonly>
                        @error('remaining_value')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
{{--                <div class="col-md-6">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="remaining_value"> المتبقي من قيمة البند بعد الصرف </label>--}}
{{--                        <input type="text" class="form-control" name="remaining_value_after" id="remaining_value">--}}
{{--                        @error('remaining_value_after')--}}
{{--                        <span class="text-danger"> {{ $message }}</span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>المبلغ بالريال السعودي</label><span style="color: red;">  *</span>
                        <input type="text" class="form-control" required name="price" id="price" placeholder="المبلغ بالريال السعودي ..." oninput="validateNumber(this)" disabled>
                        @error('price')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اختيار مستوى الأولوية </label><span class="text-danger">*</span>
                        <div class="controls">
                            <select name="priority_level" class="form-control">
                                <option value="" selected="" disabled="">اختر مستوى الأولوية...</option>
                                <option value="مهم">مهم</option>
                                <option value="منخفض"> منخفض</option>
                                <option value="عاجل">عاجل</option>
                            </select>
                            @error('priority_level')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اسم المستفيد بالعربي</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="benefit_name" placeholder="اسم المستفيد...">
                        @error('bank_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اسم المصرف</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="bank_name" placeholder="اسم المصرف  ...">
                        @error('bank_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>رقم الحساب البنكي</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="account_number" placeholder="رقم الحساب البنكي ...">
                        @error('account_number')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>تاريخ نهاية العقد </label><span class="text-danger">*</span>
                        <input type="date" class="form-control" name="payment_date"
                               min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" id="dateInput1" required>
                        @error('payment_date')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="form-group">
                        <label for="order_name">البيان</label><span style="color: red;">  *</span>
                        <textarea id="description" name="description" required class="form-control" placeholder="البيان..."></textarea>
                    </div>
                </div>
            </div>
        </div>
            <br>

            <div class="d-flex justify-content-center" style="gap: 3rem;">
                <input type="submit" class="btn btn-info" value="ارسال الطلب">
            </div>
            <br>
        </div>
        </form>

        <form method="post" action="{{ route('applicant.international.store') }}">
            @csrf
            <input type="hidden" name="transformation" value="2">
            <div id="formContainer1" style="display: none;">
            <hr>
            <div class="row">
                <div class="col text-center">
                    <h2>  تحويل دولي</h2>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>التاريخ</label><span style="color: red;">  *</span>
                        <input type="date" class="form-control" id="dateInput2" required name="date">
                        @error('date')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="project_id">اختيار المشروع </label><span style="color: red;">  *</span>
                        <select name="project_id" class="form-control" id="project_name1">
                            <option value="" selected="" disabled="">اختيار المشروع</option>
                            @foreach ($projects as $project)
                                @php
                                    $user = Auth::user()->name;
                                    $user_name = App\Models\project_users::where('user_name', $user)->where('project_id', $project->id)->first();
                                @endphp
                                @if($user_name)
                                    <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('project_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>رقم طلب الصرف</label><span style="color: red;">  *</span>
                        <input type="text" class="form-control" required name="order_number" id="order_number1" readonly>
                        @error('order_number')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" id="section_name_div">
                        <label for="section_name">اسم القسم</label><span style="color: red;">  *</span>
                        <input type="text" name="section_name" class="form-control" id="section_name1" readonly>
                        @error('section_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="step_name">اختر المرحلة</label><span style="color: red;">  *</span>
                        <select name="step_name" class="form-control" id="step_name1">
                            <option value="" selected="" disabled=""> اختر المرحلة...</option>
                            <!-- Options for item_name will be populated dynamically with JavaScript -->
                        </select>
                        @error('step_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="item_name">اختر البند</label><span style="color: red;">  *</span>
                        <select name="item_name" class="form-control" id="item_name1">
                            <option value="" selected="" disabled="">اختر البند...</option>
                            <!-- Options for item_name will be populated dynamically with JavaScript -->
                        </select>
                        @error('item_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="item_value">قيمة البند</label>
                        <input type="text" class="form-control" name="item_value" id="item_value1" readonly>
                        @error('item_value')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="remaining_value"> المتبقي من قيمة البند </label>
                        <input type="text" class="form-control" name="remaining_value" id="remaining_value1" readonly>
                        @error('remaining_value')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
{{--                <div class="col-md-6">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="remaining_value"> المتبقي من قيمة البند بعد الصرف </label>--}}
{{--                        <input type="text" class="form-control" name="remaining_value_after" id="remaining_value" readonly>--}}
{{--                        @error('remaining_value_after')--}}
{{--                        <span class="text-danger"> {{ $message }}</span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>المبلغ بالريال السعودي</label><span style="color: red;">  *</span>
                        <input type="text" class="form-control" required name="price" id="price1" placeholder="المبلغ بالريال السعودي..." oninput="validateNumber(this)" disabled>
                        @error('price')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اختيار مستوى الاولوية </label><span class="text-danger">*</span>
                        <div class="controls">
                            <select name="priority_level" class="form-control">
                                <option value="" selected="" disabled="">اختر مستوى الأولوية...</option>
                                <option value="مهم">مهم</option>
                                <option value="منخفض"> منخفض</option>
                                <option value="عاجل">عاجل</option>
                            </select>
                            @error('priority_level')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اسم المستفيد بالعربي</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="benefit_name" required placeholder="اسم المستفيد بالعربي ...">
                        @error('benefit_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اسم المستفيد بالانجليزي</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="en_benefit_name" placeholder="اسم المستفيد بالإنجليزي...">
                        @error('en_benefit_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label> جنسية المستفيد </label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="benefit_nationality" placeholder=" جنسية المستفيد ...">
                        @error('benefit_nationality')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label> الدولة </label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="country" placeholder="الدولة ...">
                        @error('country')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>عملة التحويل  </label><span class="text-danger">*</span>
                        <div class="controls">
                            <select name="conversion_currency" class="form-control">
                                <option value="" selected="" disabled="">اختر عملة التحويل ...</option>
                                <option value="ريال سعودي">ريال سعودي</option>
                                <option value="دولار إمريكي"> دولار إمريكي</option>
                                <option value="دينار أردني">دينار أردني</option>
                                <option value="ليرة تركي">ليرة تركي</option>
                                <option value="درهم إماراتي">درهم إماراتي</option>
                                <option value="جنيه مصري">جنيه مصري</option>
                            </select>
                            @error('conversion_currency')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اسم المصرف</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="bank_name" placeholder="اسم  المصرف ...">
                        @error('bank_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>رقم الحساب البنكي</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="account_number" placeholder="رقم الحساب البنكي ...">
                        @error('account_number')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>تاريخ نهاية العقد </label><span class="text-danger">*</span>
                        <input type="date" class="form-control" name="payment_date"
                               min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" id="dateInput1" required>
                        @error('payment_date')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="order_name">البيان</label><span style="color: red;">  *</span>
                            <textarea id="description" name="description"  class="form-control" placeholder="البيان..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="d-flex justify-content-center" style="gap: 3rem;">
                <input type="submit" class="btn btn-info" value="ارسال الطلب">
            </div>
            <br>
        </div>

        </form>

    <script src="{{ asset('assets/js/add_order.js') }}"></script>

    <script>



    </script>
    <script>

    </script>
@endsection
