@extends('main_master')
@section('title')
    تعديل طلب صرف
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الموظف</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ تعديل طلب </span>
            </div>
        </div>

    </div>
@endsection

@section('content')

        <div class="row">
            @if($applicant->status_id == 2)
            <div class="col-md-12">
                <div class="form-group">
                    <div class="form-group">
                        <label for="order_name">السبب من عدم اعتماد المدير</label>
                        <textarea id="description" name="manager_reason"  class="form-control"  readonly>{{ $applicantManager->manager_reason }}</textarea>
                    </div>
                </div>
            </div>
            @elseif($applicant->status_id == 12)
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="order_name"> السبب من عدم اعتماد المدير المالي</label>
                            <textarea id="description" name="manager_reason"  class="form-control"  readonly>{{ $financeManager->finance_reason }}</textarea>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @if($applicant->transformation == 1)
            <hr>
            <div class="row">
                <div class="col text-center">
                    <h2>  تحويل محلي</h2>
                </div>
            </div>
            <br>
            <form method="post" action="{{ route('applicant.update', $applicant->id) }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>التاريخ</label><span style="color: red;">  *</span>
                            <input type="date" class="form-control" value="{{ $applicant->date }}" required name="date">
                            @error('date')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>رقم طلب الصرف </label><span style="color: red;">  *</span>
                            <input type="text" class="form-control" required name="order_number" readonly value="{{ $applicant->order_number }}">
                            @error('order_number')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="project_name"> المشروع </label><span style="color: red;">  *</span>
                            <input type="text" name="project_id" class="form-control" value="{{ $applicant['project']['project_name'] }}" readonly>
                            @error('project_id')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="section_name_div">
                            <label for="section_name"> القسم</label><span style="color: red;">  *</span>
                            <input type="text" name="section_name" class="form-control" id="section_name" value="{{ $applicant->section_name }}" readonly>
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
                            <select name="step_name" class="form-control" id="step_name" required>
                                <option value="{{ $applicant->step_name }}" selected=""> {{ $applicant->step_name }}</option>
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
                            <select name="item_name" class="form-control" id="item_name" required>
                                <option value="{{ $applicant->item_name }}" selected="">{{ $applicant->item_name }}</option>
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
                            <input type="text" class="form-control" name="item_value" value="{{ $applicant->item_value }}" id="item_value" readonly>
                            @error('item_value')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="remaining_value"> المتبقي من قيمة البند</label>
                            <input type="text" class="form-control" name="remaining_value" value="{{ $applicant->value }}" id="remaining_value" readonly>
                            @error('remaining_value')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="remaining_value"> المتبقي من قيمة البند بعد الصرف</label>
                            <input type="text" class="form-control" name="remaining_value_after" value="{{ $applicant->remaining_value_after }}" readonly>
                            @error('remaining_value_after')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>المبلغ بالريال السعودي </label><span style="color: red;">  *</span>
                            <input type="text" class="form-control" required name="price" id="price" value="{{ $applicant->price }}" placeholder="المبلغ...">
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
                                    <option value="" selected="" disabled="">اختيار مستوى الأولوية </option>
                                    <option value="مهم" @if($applicant->priority_level === 'مهم') selected @endif>مهم</option>
                                    <option value="منخفض" @if($applicant->priority_level === 'منخفض') selected @endif>منخفض</option>
                                    <option value="عاجل" @if($applicant->priority_level === 'عاجل') selected @endif>عاجل</option>
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
                            <input type="text" class="form-control" name="benefit_name"  value="{{ $applicant->benefit_name }}">
                            @error('benefit_name')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>اسم المصرف</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="bank_name" value="{{ $applicant->bank_name }}">
                            @error('bank_name')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>رقم الحساب البنكي</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="account_number" value="{{ $applicant->account_number }}">
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
                                   value="{{ $applicant->payment_date }}">
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
                                <label for="order_name">البيان</label>
                                <textarea id="description" name="description"  class="form-control" placeholder="البيان...">{{ $applicant->description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="d-flex justify-content-center" style="gap: 1rem;">
                    <input type="submit" class="btn btn-info" value=" حفظ وإرسال ">
                </div>
                <br>
            </form>
        @else

        @endif


        <script src="{{ asset('assets/js/add_order.js') }}"></script>

@endsection
